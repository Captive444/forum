<?php
session_start(); 
require_once 'includes/db.php'; 



    if (isset($_SESSION['status']) and ($_SESSION['status'] == 'admin' or $_SESSION['status'] == 'Moderator')) {
        $reply_id = $_GET['id'];


      
        $query2 = "SELECT user_id FROM replies_f WHERE id = '$reply_id'";
        $result2 = mysqli_query($link, $query2) or die("Ошибка " . mysqli_error($link));
        $row2 = mysqli_fetch_assoc($result2);
        $user_id = $row2['user_id'];

        
       
        $query = "DELETE FROM replies_f WHERE replies_f.id = $reply_id";
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

       
        $query3 = "SELECT violations FROM users WHERE id = '$user_id'";
        $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
        $row3 = mysqli_fetch_assoc($result3);
        $currentViolations = $row3['violations'];
        $newViolations = $currentViolations + 1;

   
        $sql = "UPDATE users SET violations = '$newViolations' WHERE id = '$user_id'";
        $res4 = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));

        if ($result and $result2 and $result3 and $res4) {
  
            header("Location: {$_SERVER['HTTP_REFERER']}"); 
            exit();
        } else {
            echo "Ошибка при удалении комментария.";
        }
    } else {
        echo "У вас нет прав для выполнения этого действия.";
    }

?>
