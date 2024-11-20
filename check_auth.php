<?php
session_start();

echo json_encode(array(
    'auth' => isset($_SESSION['auth']) && $_SESSION['auth'] === true,
));
?>
