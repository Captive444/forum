
<?php

require 'includes/db.php';


function getReplies($id) {
    $query = "SELECT COUNT(topic_id) AS reply_count FROM replies_f WHERE topic_id = $id";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $row = mysqli_fetch_assoc($res);
    return $row['reply_count'];
};

// все темы + админские действия
function displayTopics($link) {
    $query = "
        SELECT
            t.id, 
            t.title AS Тема, 
            COUNT(r.topic_id) AS Ответы, 
            u.username AS Автор,
            t.user_id AS topic_author_id
        FROM 
            topics_f t 
        LEFT JOIN 
            replies_f r ON t.id = r.topic_id
        LEFT JOIN
            users u ON t.user_id = u.id
        GROUP BY 
            t.id, t.title, u.username
        ORDER BY 
            t.title;
    ";

    $result = mysqli_query($link, $query) or die(mysqli_error($link));

  
    $currentUserId = $_SESSION['id'];
    $currentUserRole = $_SESSION['status'];

    $tableHTML = "<table>";
    $tableHTML .= "<thead><tr><th>Тема</th><th>Ответы</th><th>Автор</th>";
    if ($currentUserRole === 'admin' || $currentUserRole === 'Moderator') {
        $tableHTML .= "<th>Управление</th>";
    }
    $tableHTML .= "</tr></thead>";
    $tableHTML .= "<tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        $tableHTML .= "<tr>";
        $tableHTML .= "<td><a href='topic.php?id=" . $row['id'] . "'>" . $row['Тема'] . "</a></td>";
        $tableHTML .= "<td>" . $row['Ответы'] . "</td>";
        $tableHTML .= "<td>" . $row['Автор'] . "</td>";
        

        if ($currentUserRole === 'admin' || $currentUserRole === 'Moderator') {
            $tableHTML .= "<td>";
            // Доступно только админу и модератору
            if ($currentUserRole === 'admin' || ($currentUserRole === 'Moderator' && $row['topic_author_id'] !== $currentUserId)) {
                $tableHTML .= "<a href='delete_topic.php?id=" . $row['id'] . "' onclick='return confirm(\"Вы уверены, что хотите удалить тему?\")'>Удалить</a>";
                $tableHTML .= " | <a href='mark_as_violation.php?id=" . $row['topic_author_id'] . "' onclick='return confirm(\"Вы уверены, что хотите отметить тему как нарушение?\")'>Нарушение</a>"; // Новая ссылка
            }
            $tableHTML .= "</td>";
        }

        $tableHTML .= "</tr>";
    }

    $tableHTML .= "</tbody></table>";

    return $tableHTML;
}



// ИЗМЕНЕННЫЙ КОМЕНТЫ

function showTopics($link) {
    session_start();   
    $query = "
           SELECT 
            t.id, 
            t.title AS Тема, 
            t.content AS Текст, 
            u.username AS Автор,
            r.id AS reply_id,
            r.content AS Ответ,  
            r.creation_date AS Дата,
            r.user_id,
            ur.username AS АвторКомментария 
        FROM 
            topics_f t 
        LEFT JOIN 
            replies_f r ON t.id = r.topic_id
        LEFT JOIN
            users u ON t.user_id = u.id
        LEFT JOIN
            users ur ON r.user_id = ur.id  
        WHERE t.id = " . $_GET['id'] . "    
        ORDER BY 
            r.creation_date;
    ";

    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    $_SESSION['topic_id'] = $_GET['id'];
    $currentUserId = $_SESSION['id']; 
    $currentUserRole = $_SESSION['status']; 

    $content = "";
    $content .= "<div class='topic'>";

    $row = mysqli_fetch_assoc($result);
    $content .= "<h2>" . $row['Тема'] . "</h2>";
    $content .= "<p>" . $row['Текст'] . "</p>";

    $content .= "<h3>Комментарии:</h3>";

    if ($row) {
        do {
            $content .= "<div>";
            $content .= "<p>" . $row['Ответ'] . "</p>";  
            $content .= "<p>" . $row['Дата'] . "</p>";  
            $content .= "<p>" . 'Автор:' . $row['АвторКомментария'] . "</p>"; 
            
          
            if ($currentUserRole == 'admin' or $currentUserRole == 'Moderator' or $currentUserId == $row['user_id']) { 
                $content .= "<a href='delete_reply.php?id=" . $row['reply_id'] . "'>Удалить</a>" . " | ";
                $content .= "<a href='mark_as_violation.php?id=" . $row['user_id'] . "'>Забанить</a>";
            } 
            
            $content .= "</div>";
            $content .= "<hr>"; 
        } while ($row = mysqli_fetch_assoc($result));
    } else {
        $content .= "<p>Комментариев пока нет.</p>";
    }

    $content .= "<button type='button' onclick='showReplyForm(" . $row['id'] . ")'>Ответить</button>"; 
    $content .= "</div>";

    return $content;
}

// комментарии

function createReplies ($link, $topic_id, $user_id, $content) {

    $query = "INSERT INTO replies_f (topic_id, user_id, content, creation_date) VALUES ('$topic_id', '$user_id', '$content', NOW())";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

}

// проверка на нарушение

function checkViolation($link, $login) {

    $query = "SELECT ban_expires FROM users WHERE username = '$login'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $now = date('Y-m-d H:i:s');
    $row = mysqli_fetch_assoc($result);
     if ($row) {
        $ban_expires = $row['ban_expires'];
        $now = date('Y-m-d H:i:s');
        if ($ban_expires > $now) {
            return true; 
        }
    }
    return false; 
}


?>