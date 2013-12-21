The Todo Application
====================

This is the final Todo application at the end of the
legacy codebase refactoring using the Symfony2
components and Twig.

Install
-------

Use Composer to install third party dependencies.

```shell
> php composer.phar install
```

Run the `legacy/install.php` script to build the default
MySQL database with some fixtures.

Configuration
-------------

Database settings can be configured in the `config/parameters.yml` file.

```yml
# config/parameters.yml
parameters

    # Database Settings
    database_name: training_todo
    database_host: localhost
    database_user: root
    database_pass: null
    database_port: 3306
```

SensioLabsInsight
-----------------

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d074a349-4cb4-48e8-8816-6f59f4c33d9a/mini.png)](https://insight.sensiolabs.com/projects/d074a349-4cb4-48e8-8816-6f59f4c33d9a)

Check the analysis status on SensioLabsInsight at the following url:

https://insight.sensiolabs.com/projects/d074a349-4cb4-48e8-8816-6f59f4c33d9a
