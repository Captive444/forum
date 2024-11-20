<?php
require 'includes/db.php'; 
session_start();


if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: /'); 
    exit;
}


$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    if (isset($_POST['confirm_delete'])) {

     
       
        $delete_query = "DELETE FROM users WHERE id = '$user_id'";
     $res = mysqli_query($link, $delete_query) or die("Ошибка " . mysqli_error($link));
     if ($res) {
       
         session_destroy();
    
         header('Location: /');
         exit;
     }
    }
}
?>
