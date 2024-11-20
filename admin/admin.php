<?php 
// session_start(); 
require 'C:\OSPanel\domains\test2\includes\db.php'; 
require 'function/function.php';


?>

<!DOCTYPE html>
<html>
<head>
    <title>Админ-панель</title>
</head>
<body>

    <h1>Админ-панель</h1>

    <h2>Пользователи</h2>
    <?php
    $sql = "SELECT * FROM users";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));

    echo '<table>';
    echo '<tr><th>Login</th><th>Status</th><th>Change Status</th></tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        $status = ($row['role_id'] == 3) ? 'Модератор' : 'Пользователь'; 
        $bgColor = ($row['role_id'] == 3) ? 'yellow' : 'green';

        echo "<tr style='background-color: $bgColor;'>";
        echo "<td>{$row['username']}</td>";
        echo "<td>$status</td>";
        echo "<td><a href='/admin/change_status.php?id={$row['id']}'>Изменить статус</a></td>";
        echo "</tr>";
    }
    echo '</table>';


    ?>

    <h2>Заблокированные пользователи</h2>


    <?php
    $bgColor2 = 'red';
   $now = date('Y-m-d H:i:s');

$sql = "SELECT id, username, ban_expires, violations FROM users WHERE ban_expires > '$now'";
$result = mysqli_query($link, $sql) or die(mysqli_error($link));      

echo '<table>';
echo '<tr><th>Login</th><th>Ban duration</th><th>count of violations</th><th>Change Status</th><th>delete account</th></tr>';
while ($row = mysqli_fetch_assoc($result)) { 
    echo "<tr style='background-color: $bgColor2;'>";
    echo "<td>{$row['username']}</td>";
    echo "<td>{$row['ban_expires']}</td>";
    echo "<td>{$row['violations']}</td>";
    echo "<td><a href='delete_ban.php?id={$row['id']}'>Снять бан</a></td>";
    echo "<td><a href='delete.php?id={$row['id']}'>Удалить</a></td>";
    echo "</tr>"; 
}
echo '</table>'; 
    ?>
    <h2>Комментарии</h2>


</body>
</html>
    
        