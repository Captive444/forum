
<?php
require 'includes/db.php';

$id = $_GET['id'];
$sql = "DELETE FROM users WHERE id = $id";
$result = mysqli_query($link, $sql) or die(mysqli_error($link));
  header('Location: /admin/admin.php'); 
    die();  

    ?>

