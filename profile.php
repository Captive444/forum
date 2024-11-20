<?php 
require 'includes/db.php';
   session_start(); 

   $profile = '';
   if (isset($_SESSION['auth']) and $_SESSION['auth'] === true) {
       $login = $_SESSION['username'];
       $status = $_SESSION['status'];
       $query = "SELECT * FROM users WHERE username = '$login'";
       $result = mysqli_query($link, $query);

       if ($user = mysqli_fetch_assoc($result)) {
           $profile .= '<div class="profile">';
           $profile .= '<h1>Профиль пользователя</h1>';
           $profile .= '<p>Имя: ' . htmlspecialchars($user['username']) . '</p>';
           $profile .= '<p>Email: ' . htmlspecialchars($user['email']) . '</p>';
           $profile .= '<p>Статус: ' .  $status . '</p>';
            if ($status === 'admin') {
            $profile .= '<p>Администратор</p>';
            $profile .= '<a href="admin.php">Панель администратора</a>';
        }
           $profile .= '<p>Дата регистрации: ' . htmlspecialchars($user['registration_date']) . '</p>';
           $profile .= '<a href="#" id="open-delete-profile">Удалить аккаунт</a>' . '<br>';
           $profile .= '<p class="hidden"><a  href="logout.php">Выход</a> </p>';
           $profile .= '</div>';
       } 
   }

   return $profile; 
   ?>

   
  