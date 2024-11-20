<?php

require 'includes/db.php';
require_once 'func/func.php'; 
session_start();

$reply_count = displayTopics($link);

return $reply_count;

?>