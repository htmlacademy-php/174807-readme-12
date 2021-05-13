<?php
declare(strict_types=1);

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'helpers.php';
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'user-functions.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'init.php');

$posts = [];
$content = '';

if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
} else {
    $sql = "SELECT
                p.title,
                u.login as username,
                c.type,
                c.icon,
                p.views,
                p.content,
                u.avatar as avatar_url
            FROM readme.posts p
                INNER JOIN readme.users u ON p.user_id = u.id
                INNER JOIN readme.content_type c ON p.content_type_id = c.id
            ORDER BY p.views DESC";
    $result = mysqli_query($link, $sql);

    if ($result) {
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($link);
        $content = include_template('error.php', ['error' => $error]);
    }
}

$pageTitle = 'readme: популярное';
//$posts = [
//    [
//        'title' => 'Цитата',
//        'type' => 'post-quote',
//        'description' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
//        'username' => 'Лариса',
//        'avatar-url' => 'userpic-larisa-small.jpg'
//    ],
//    [
//        'title' => 'Игра престолов',
//        'type' => 'post-text',
//        'description' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
//        'username' => 'Владик',
//        'avatar-url' => 'userpic.jpg'
//    ],
//    [
//        'title' => 'Наконец, обработал фотки!',
//        'type' => 'post-photo',
//        'description' => 'rock-medium.jpg',
//        'username' => 'Виктор',
//        'avatar-url' => 'userpic-mark.jpg'
//    ],
//    [
//        'title' => 'Моя мечта',
//        'type' => 'post-photo',
//        'description' => 'coast-medium.jpg',
//        'username' => 'Лариса',
//        'avatar-url' => 'userpic-larisa-small.jpg'
//    ],
//    [
//        'title' => 'Лучшие курсы',
//        'type' => 'post-link',
//        'description' => 'www.htmlacademy.ru',
//        'username' => 'Владик',
//        'avatar-url' => 'userpic.jpg'
//    ]
//];
$isAuth = rand(0, 1);
$userName = 'Павел';
$maxTextLength = 300;
$content = include_template('main.php', [
    'posts' => $posts,
    'maxTextLength' => $maxTextLength
]);

print include_template('layout.php', [
    'pageTitle' => $pageTitle,
    'isAuth' => $isAuth,
    'userName' => $userName,
    'maxTextLength' => $maxTextLength,
    'posts' => $posts,
    'content' => $content
]);
