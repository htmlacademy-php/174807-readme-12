<?php
declare(strict_types=1);

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'helpers.php';
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'user-functions.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'init.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'models.php');

// Изначальные данные
$isAuth = rand(0, 1);
$userName = 'Павел';
$post = [];

$params = [
    'id' => intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)) ?? 0,
];

$resultPost = getPostDetails($link, $params['id']);
$resultHashtags = getPostHashtags($link, $params['id']);
$resultComments = getPostComments($link, $params['id']);

// проверка данных на ошибки
$mysql_error = getStringParams(
    $resultPost,
    $resultHashtags,
    $resultComments
);

// запрос данных о пользователе
if (!empty($resultPost)) {
    $userId = $resultPost[0]['user_id'];
    $resultUser = getUser($link, $userId)[0];
    $userSubscribers = getSubscribersAmount($link, $userId)[0];
    $userPosts = getPostsAmount($link, $userId)[0];
}

// Подготовка контента
if (empty($resultPost) || !$resultPost) {
    $error = mysqli_error($link);
    $content = include_template('error.php', ['error' => $error]);
} else {
    $likes = getLikes($link, $resultPost[0]['id']);
    $post = array_merge($resultPost[0], ...$likes);

    $content = include_template('post-details.php', [
        'post' => $post,
        'hashtags' => $resultHashtags,
        'comments' => $resultComments,
        'user' => $resultUser,
        'userPostsCount' => $userPosts['posts'],
        'userSubscribers' => $userSubscribers['subscribers'] ?? 0,
    ]);
}

print include_template('layout.php', [
    'pageTitle' => $pageTitle ?? '',
    'isAuth' => $isAuth,
    'userName' => $userName,
    'content' => $content
]);
