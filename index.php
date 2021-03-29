<?php
declare(strict_types=1);

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'helpers.php';
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'user-functions.php');

$pageTitle = 'readme: популярное';
$posts = [
    [
        'title' => 'Цитата',
        'type' => 'post-quote',
        'description' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'username' => 'Лариса',
        'avatar-url' => 'userpic-larisa-small.jpg'
    ],
    [
        'title' => 'Игра престолов',
        'type' => 'post-text',
        'description' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
        'username' => 'Владик',
        'avatar-url' => 'userpic.jpg'
    ],
    [
        'title' => 'Наконец, обработал фотки!',
        'type' => 'post-photo',
        'description' => 'rock-medium.jpg',
        'username' => 'Виктор',
        'avatar-url' => 'userpic-mark.jpg'
    ],
    [
        'title' => 'Моя мечта',
        'type' => 'post-photo',
        'description' => 'coast-medium.jpg',
        'username' => 'Лариса',
        'avatar-url' => 'userpic-larisa-small.jpg'
    ],
    [
        'title' => 'Лучшие курсы',
        'type' => 'post-link',
        'description' => 'www.htmlacademy.ru',
        'username' => 'Владик',
        'avatar-url' => 'userpic.jpg'
    ]
];
$isAuth = rand(0, 1);
$userName = 'Павел';
$maxTextLength = 300;
$content = include_template( 'main.php', [
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
