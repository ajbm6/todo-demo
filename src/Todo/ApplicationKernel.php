<?php

namespace Todo;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ApplicationKernel implements HttpKernelInterface
{
    private $root;
    private $debug;
    private $options;
    private $container;

    /**
     * Constructor.
     *
     * @param string  $root    The absolute path to the root directory
     * @param boolean $debug   Whether or not the application is in debug mode
     * @param array   $options An array of options
     */
    public function __construct($root, $debug = true, array $options = array())
    {
        $this->root = $root;
        $this->debug = $debug;
        $this->options = array_merge(array(
            'container_class'   => 'TodoApplicationContainer',
            'kernel.debug'      => $this->debug,
            'kernel.root_dir'   => $this->root,
            'kernel.cache_dir'  => $this->root.'/cache',
            'kernel.config_dir' => $this->root.'/config',
            'kernel.views_dir'  => $this->root.'/views',
        ), $options);
    }

    /**
     * Handles the request.
     *
     * @param  Request  $request The request object
     * @param  int      $type    The request type (Master = 1 or Subrequest = 2)
     * @param  bool     $catch   Whether or not to catch exceptions
     * @return Response
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $container = $this->getContainer();

        return $container->get('http_kernel')->handle($request, $type, $catch);
    }

    /**
     * Terminates the request.
     *
     * @param Request  $request  The request
     * @param Response $response The response
     */
    public function terminate(Request $request, Response $response)
    {
        $this->container->get('http_kernel')->terminate($request, $response);
    }

    /**
     * Returns an instance of the application service container.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private function getContainer()
    {
        if ($this->container) {
            return $this->container;
        }

        $file = $this->getContainerFile();

        // Rebuild the container at every request if debug flag is true        
        if ($this->debug || !file_exists($file)) {
            $this->buildContainer();
        }

        require_once $file;

        $this->container = new $this->options['container_class']();

        return $this->container;
    }

    /**
     * Returns the absolute file path where the dumped container
     * class is supposed to be stored.
     *
     * @return string
     */
    private function getContainerFile()
    {
        return $this->options['kernel.cache_dir'].DIRECTORY_SEPARATOR.$this->options['container_class'].'.php';
    }

    /**
     * Builds the service container class.
     *
     */
    private function buildContainer()
    {
        $container = new ContainerBuilder();

        foreach ($this->options as $key => $value) {
            $container->setParameter($key, $value);
        }

        $this->loadContainerConfiguration($container);
        $this->dumpContainer($container);
    }

    /**
     * Loads the default configuration into the container builder.
     *
     * @param ContainerBuilder $container
     */
    private function loadContainerConfiguration(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator($this->options['kernel.config_dir']));
        $loader->load('services.yml');
    }

    /**
     * Dumps the container builder into a PHP class.
     *
     * @param ContainerBuilder $container
     */
    private function dumpContainer(ContainerBuilder $container)
    {
        // Don't forget to compile the container
        // to resolve parameters placeholders in
        // the dumped PHP container class.
        $container->compile();

        $dumper = new PhpDumper($container);
        $content = $dumper->dump(array('class' => $this->options['container_class']));

        file_put_contents($this->getContainerFile(), $content);
    }
} 
