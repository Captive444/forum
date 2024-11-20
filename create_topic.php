<?php 
require 'includes/db.php';

session_start();

if (isset($_SESSION['auth']) and $_SESSION['auth'] === true) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = $_SESSION['id']; 

        $query = "INSERT INTO topics_f (title, content, user_id, creation_date) VALUES ('$title', '$content', '$user_id', NOW())";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Тема успешно создана!']); 
        die();
    } 
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Вы не авторизованы.']); 
    die();
}

?>


