<?php
    require 'includes/db.php';
    session_start();

	if (!empty($_POST['login']) and !empty($_POST['password']) and !empty($_POST['email'])) {
		$login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		
		$query = "INSERT INTO users SET username='$login', password='$password',  email='$_POST[email]', role_id='1', registration_date=NOW(), violations='0'";
		mysqli_query($link, $query) or die(mysqli_error($link));

        $_SESSION['auth'] = true;
        $_SESSION['username'] = $login;
        $_SESSION['email'] = $_POST['email'];
        
        $id = mysqli_insert_id($link);
        $_SESSION['id'] = $id;
        header('Location: index.php');
        die();
	}
    else {
        header('Location: reg.php');
        die();
    }
?>


