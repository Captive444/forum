<?php

require 'C:\OSPanel\domains\test2\includes\db.php'; 
  
    $id = $_GET['id'];
 
    $query = "SELECT u.username AS login, s.name AS role FROM users u LEFT JOIN statuses s ON u.role_id = s.id WHERE u.id=$id";
  
  
    $res = mysqli_query($link, $query) or die("Ошибка MySQLi: " . mysqli_error($link));;
    
    $row = mysqli_fetch_assoc($res);
    
    $role_id = $row['role'];
  
    if ($role_id === 'Moderator') {
    $new_role_id = '1'; 
    $query = "UPDATE users SET role_id=$new_role_id WHERE users.id=$id";
    mysqli_query($link, $query) or die(mysqli_error($link)); 
     header('Location: /admin/admin.php'); 
    die();    
        
    }
    elseif ($role_id === 'user') {
      $new_role_id = '3'; 
        $query = "UPDATE users SET role_id=$new_role_id WHERE users.id=$id";
        mysqli_query($link, $query) or die(mysqli_error($link)); 
       header('Location: /admin/admin.php'); 
        die();
    }


?>