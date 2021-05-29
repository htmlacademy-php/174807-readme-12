<?php
declare(strict_types=1);

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'helpers.php';
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'user-functions.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'init.php');

$posts = [];
$content = '';
$pageTitle = 'readme: популярное';
$isAuth = rand(0, 1);
$userName = 'Павел';
$maxTextLength = 300;

$sqlContentTypes = 'SELECT type, icon FROM readme.content_type';
$resultContentTypes = mysqli_query($link, $sqlContentTypes);

$sqlPopularPosts = 'SELECT
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
                    ORDER BY p.views DESC
                    LIMIT 6;';
$resultPopularPosts = mysqli_query($link, $sqlPopularPosts);

$contentTypes = mysqli_fetch_all($resultContentTypes, MYSQLI_ASSOC);
$popularPosts = mysqli_fetch_all($resultPopularPosts, MYSQLI_ASSOC);

$avaliableContentTypes = [];

foreach ($contentTypes as $contentType):
    array_push($avaliableContentTypes, $contentType['icon']);
endforeach;

$selectedFilter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING);
$isExistingContentType = in_array($selectedFilter, $avaliableContentTypes);
$activeFilter = $isExistingContentType || $selectedFilter === 'all' ? $selectedFilter : null;

if (!$contentTypes || !$popularPosts || !$activeFilter) {
    $error = mysqli_error($link);
    $content = include_template('error.php', ['error' => $error]);
} else {
    $content = include_template('main.php', [
        'posts' => $popularPosts,
        'categories' => $contentTypes,
        'activeFilter' => $activeFilter,
        'maxTextLength' => $maxTextLength
    ]);
}

print include_template('layout.php', [
    'pageTitle' => $pageTitle,
    'isAuth' => $isAuth,
    'userName' => $userName,
    'maxTextLength' => $maxTextLength,
    'posts' => $popularPosts,
    'content' => $content
]);
