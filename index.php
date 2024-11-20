<?php
session_start();
require 'includes/db.php';


$url = $_SERVER['REQUEST_URI'];


$page = [
    'title' => 'Главная страница',
    'content' => '',
    'profile' => ''
];

// ..........

if (preg_match('#^/admin\.php(\?.*)?$#', $url) or preg_match('#^/admin(.*)$#', $url) ) {
    $page['title'] = 'Админ-панель';
   

    if ($_SESSION['status'] == 'admin') { 
        include 'admin/admin.php'; 
        exit; 
    } else {

        header('Location: /'); 
        exit;
    }
}

// 

        $page['profile'] = include 'profile.php';



switch (true) {
    case preg_match('#^/topic\.php\?id=\d+$#', $url):
        $page['title'] = 'Тема';
        $page['content'] = include 'topic.php';
        break;
    case preg_match('#^/login\.php$#', $url):
        $page['title'] = 'Вход';
        $page['content'] = include 'login.php';

        break;
    case preg_match('#^/logout\.php$#', $url):
        $page['title'] = 'Выход';
        $page['content'] = include 'reg/logout.php';
        break;
    case preg_match('#^/reg\.php$#', $url):
        $page['title'] = 'Регистрация';
        $page['content'] = include 'reg/reg.php';
        break;
    case preg_match('#^/delete_profile\.php$#', $url):
        $page['title'] = 'Удалить профиль';
        $page['content'] = include 'delete_profile.php';
        break;
    case preg_match('#^/reply\.php$#', $url):
        $page['title'] = 'Ответ';
        $page['content'] = include 'reply.php';
        break;
    case preg_match('#^/create_topic\.php$#', $url):
        $page['title'] = 'Создать тему';
        $page['content'] = include 'create_topic.php';
        break;
    case preg_match('#^/delete_topic\.php(\?.*)?$#', $url):
        $page['title'] = 'Удалить тему';
        $page['content'] = include 'delete_topic.php';
        break;
    case preg_match('#^/delete_reply\.php(\?.*)?$#', $url):
        $page['title'] = 'Удалить ответ';
        $page['content'] = include 'delete_reply.php';
        break;
    case preg_match('#^/mark_as_violation\.php(\?.*)?$#', $url):
        $page['title'] = 'Отметить как нарушение';
        $page['content'] = include 'admin/mark_as_violation.php';
        break;
    default:
        $page['title'] = 'Главная страница';
        $page['content'] = include 'all.php';
        break;
}


$layout = file_get_contents('layout.php');
if ($layout === false) {
    die('Не удалось прочитать файл layout.php');
}


$layout = str_replace('{{ title }}', $page['title'], $layout);
$layout = str_replace('{{ content }}', $page['content'], $layout);
$layout = str_replace('{{ profile }}', $page['profile'], $layout);

echo $layout;
?>
