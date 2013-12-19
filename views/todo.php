<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Todo Application</title>
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo $request->getBasePath() ?>/style.css"/>
</head>
<body>
<div id="container">
    <h1><a href="list.php">My Todos List</a></h1>
    <div id="content">

        <p>
            <strong>Id</strong>: <?php echo $todo['id'] ?><br/>
            <strong>Title</strong>: <?php echo htmlspecialchars($todo['title']) ?><br/>
            <strong>Status</strong>: <?php echo $todo['is_done'] ? 'done' : 'not finished' ?>
        </p>

    </div>
    <div id="footer">
        (c) copyright - not sensio
    </div>
</div>
</body>
</html>
