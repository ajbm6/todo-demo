<?php

include 'config.php';
include 'header.php';

use Symfony\Component\HttpFoundation\RedirectResponse;

$response = new RedirectResponse('list.php');
if ('create' === $request->request->get('action')) {
    $title = $request->request->get('title');
    $query = 'INSERT INTO todo (title) VALUES(\''. $title .'\');';
    mysql_query($query, $conn) or die('Unable to create new task : '. mysql_error());

    $response->send();
} else if ('close' === $request->query->get('action')) {
    $id = $request->query->getInt('id');
    $query = 'UPDATE todo SET is_done = 1 WHERE id = '. $id;
    mysql_query($query, $conn) or die('Unable to update existing task : '. mysql_error());

    $response->send();
} else if ('delete' === $request->query->get('action')) {
    $id = $request->query->getInt('id');
    $query = 'DELETE FROM todo WHERE id = '. $id;
    mysql_query($query, $conn) or die('Unable to delete existing task : '. mysql_error());

    $response->send();
}

?>
<form action="list.php" method="post">
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" size="45"/>
        <input type="hidden" name="action" value="create"/>
        <button type="submit">send</button>
    </div>
</form>

<?php

$result = mysql_query('SELECT COUNT(*) FROM todo', $conn);
$count  = current(mysql_fetch_row($result));

?>
<p>
    There are <strong><?php echo $count ?></strong> tasks.
</p>

<?php $result = mysql_query('SELECT * FROM todo', $conn) ?>

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
    <?php
        while ($todo = mysql_fetch_assoc($result)) {

            echo '<tr>';
            echo '  <td class="center">'. $todo['id'] .'</td>';
            echo '  <td><a href="todo.php?id='. $todo['id'] .'">'. $todo['title'] .'</a></td>';
            echo '  <td class="center">';

            if ($todo['is_done']) {
                echo '<span class="done">done</span>';
            } else {
                echo '<a href="list.php?action=close&amp;id='. $todo['id'] .'">close</a>';
            }

            echo '  </td>';
            echo '  <td class="center"><a href="list.php?action=delete&amp;id='. $todo['id'] .'">delete</a></td>';
            echo '</tr>';
        }
     ?>
    </tbody>
</table>

<?php include 'footer.php' ?>
