<?php
require 'includes/db.php';
session_start();


function banUser($link, $user_id, $ban_duration_minutes) {
  $now = time();
  $ban_expires = date('Y-m-d H:i:s', strtotime("+$ban_duration_minutes minutes", $now));


  $sql = "SELECT violations FROM users WHERE id = '$user_id'";
  $result = mysqli_query($link, $sql) or die(mysqli_error($link));
  $row = mysqli_fetch_assoc($result);
  $currentViolations = $row['violations'];


  $newViolations = $currentViolations + 1;

  
  $sql = "UPDATE users SET ban_expires = '$ban_expires', violations = '$newViolations' WHERE id = '$user_id'";
  mysqli_query($link, $sql) or die(mysqli_error($link)); 
}

if(isset($_GET['id'])) {
  $user_id_to_ban = $_GET['id']; 
  banUser($link, $user_id_to_ban, 1440);
  header('Location: index.php');
  exit();
} else {
  echo "Ошибка: не передан ID пользователя"; 
  exit();
}

?>

