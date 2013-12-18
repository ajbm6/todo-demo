<?php

include 'config.php';
include 'header.php';

$id = $request->query->getInt('id');
$result = mysql_query('SELECT * FROM todo WHERE id = '.$id);
$todo = mysql_fetch_assoc($result);

?>

<p>
    <strong>Id</strong>: <?php echo $todo['id'] ?><br/>
    <strong>Title</strong>: <?php echo $todo['title'] ?><br/>
    <strong>Status</strong>: <?php echo $todo['is_done'] ? 'done' : 'not finished' ?>
</p>

<?php include 'footer.php' ?>
