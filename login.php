
<?php
session_start();
require 'includes/db.php';
require 'func/func.php';



if (!empty($_POST['password']) and !empty($_POST['login'])) {
    $login = $_POST['login'];

     if (checkViolation($link, $login)) {
        echo "Этот аккаунт заблокирован.";
        die(); 
    }



    $query = "SELECT users.*, statuses.name as status FROM users 
              LEFT JOIN statuses ON users.role_id=statuses.id 
              WHERE users.username='$login'";
    $res = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($res);

    if (!empty($user)) {
        $hash = $user['password'];

        if (password_verify($_POST['password'], $hash)) {
            $_SESSION['auth'] = true;
            $_SESSION['username'] = $login;
            $_SESSION['id'] = $user['id'];
            $_SESSION['status'] = $user['status'];
            header("Location: index.php");
            die();
        } else {
            $_SESSION['auth'] = false;
            echo "Неверный логин или пароль";
        }
    }
    
}



?>






