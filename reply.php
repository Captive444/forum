
<?php

require_once 'func/func.php';
session_start();

if (isset($_POST['content'])) {
    $topic_id = $_SESSION['topic_id'];
    $user_id = $_SESSION['id'];
    $_SESSION['ban'] = $user_id;
    $content = $_POST['content'];
    createReplies($link, $topic_id, $user_id, $content);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}


?>
