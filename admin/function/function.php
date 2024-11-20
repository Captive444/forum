<?php
include_once 'includes/db.php';
function getUserRole($userId) {
        global $link;
        $query = "SELECT u.username AS login, s.name AS role FROM users u LEFT JOIN statuses s ON u.role_id = s.id WHERE u.id = $userId";
        $result = mysqli_query($link, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['role'];
        }
        return false;
    }

 function listUsers($link) {
        
        echo '<a href="profile.php">Профиль</a>';
        echo '<a href="logout.php">Выход</a>'; 
        
        $sql = "SELECT u.username AS login, s.name AS role FROM users u LEFT JOIN statuses s ON u.role_id = s.id";
        $result = mysqli_query($link, $sql) or die(mysqli_error($link));

        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        echo '<table>';
        echo '<tr><th>' . 'login' . '</th><th>' . 'status' . '</th>' . '<th> ' . 'delete' . '</th>' . '<th>' . 'change status' . '</th>' . '</tr>';
        foreach ($data as $key => $value) {
            echo '<tr style="background-color: ' . ($value['role'] === 'admin' ? 'red' : 'green') . ';"><td>' . $value['login'] . '</td><td>' . $value['role'] . '</td><td>' . '<a href="delete.php?id=' . $value['id'] . '">delete</a>' . '</td><td>' . '<a href="change_status.php?id=' . $value['id'] . '">change status</a>' . '</td></tr>';
        }
        echo '</table>';

    }


// БАН ПОЛЬЗОВАТЕЛЯ

function banUser($user_id, $ban_duration_minutes) {
  global $link;

  $now = time();

  $ban_expires = date('Y-m-d H:i:s', strtotime("+$ban_duration_minutes minutes", $now));

  $sql = "UPDATE `users` SET `ban_expires` = ? WHERE `id` = ?";
  $stmt = $link->prepare($sql);
  $stmt->bind_param('si', $ban_expires, $user_id);

  if ($stmt->execute()) {
    return true;
  } else {
    echo "Ошибка при бане пользователя: " . $link->error;
    return false;
  }
}


// БАНН
function checkViolation($link, $login) {
    $query = "SELECT username, ban_expires FROM users WHERE username = '$login'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

  
    $now = date('Y-m-d H:i:s'); 

    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $ban_expires = $row['ban_expires'];
        
        if ($ban_expires > $now) { 
            return true; 
        }
    }
    return false; 
}
?>