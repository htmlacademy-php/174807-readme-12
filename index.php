<?php
declare(strict_types=1);

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'helpers.php';
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'user-functions.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'init.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'models.php');

// Изначальные данные
$posts = [];
$content = '';
$pageTitle = 'readme: популярное';
$isAuth = rand(0, 1);
$userName = 'Павел';
$maxTextLength = 300;
$availableContentTypes = ['all'];
$postsLimit = 6;

// Параметры из строки запроса
$params = [
    'filter' => filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_NUMBER_INT) ?? 0,
];

// получаем данные
$resultContentTypes = getContentTypes($link);
$resultPopularPosts = getPopularPosts($link, $params, $postsLimit);


// Подготовка контента
if (!$resultContentTypes || !$resultPopularPosts) {
    $error = mysqli_error($link);
    $content = include_template('error.php', ['error' => $error]);
} else {
    $content = include_template('main.php', [
        'posts' => $resultPopularPosts,
        'categories' => $resultContentTypes,
        'activeFilter' => intval($params['filter']),
        'maxTextLength' => $maxTextLength
    ]);
}

print include_template('layout.php', [
    'pageTitle' => $pageTitle,
    'isAuth' => $isAuth,
    'userName' => $userName,
    'maxTextLength' => $maxTextLength,
    'posts' => $resultPopularPosts,
    'content' => $content
]);
