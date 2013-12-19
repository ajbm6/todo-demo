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
        <form action="list.php" method="post">
            <div>
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" size="45"/>
                <input type="hidden" name="action" value="create"/>
                <button type="submit">send</button>
            </div>
        </form>

        <p>
            There are <strong><?php echo $count ?></strong> tasks.
        </p>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $todo) : ?>
                <tr>
                    <td class="center"><?php echo $todo['id'] ?></td>
                    <td>
                        <a href="todo.php?id=<?php echo $todo['id'] ?>">
                            <?php echo htmlspecialchars($todo['title']) ?>
                        </a>
                    </td>
                    <td class="center">
                    <?php if ($todo['is_done']) : ?>
                        <span class="done">done</span>
                    <?php else: ?>
                        <a href="list.php?action=close&amp;id=<?php echo $todo['id'] ?>">close</a>
                    <?php endif ?>
                    </td>
                    <td class="center">
                        <a href="list.php?action=delete&amp;id=<?php echo $todo['id'] ?>">delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div id="footer">
        (c) copyright - not sensio
    </div>
</div>
</body>
</html>
