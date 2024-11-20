<?php
require 'C:\OSPanel\domains\test2\includes\db.php'; 

$id = $_GET['id'];
$sql = "UPDATE users SET ban_expires = NULL WHERE id = $id";
mysqli_query($link, $sql) or die(mysqli_error($link));
  header('Location: /admin/admin.php'); 
    die();  

    ?>
