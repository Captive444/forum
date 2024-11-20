<?php
require 'includes/db.php';



$query = "DELETE FROM topics_f WHERE id = " . $_GET['id'];
mysqli_query($link, $query) or die(mysqli . mysqli_error($link));



header("Location: index.php");
die();
?>
