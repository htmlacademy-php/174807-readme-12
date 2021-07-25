<?php
/**
 *
 * Функция для получения данных с возможностью использования
 * запросов с подготовленными выражениями
 *
 * @param mysqli $link
 * @param string $sql
 * @param array  $sql_params
 *
 * @return array|string
 * @throws Exception
 */
function getSqlData(
    mysqli $link,
    string $sql,
    array $sql_params = []
)
{
    $stmt = db_get_prepare_stmt($link, $sql, $sql_params);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        return mysqli_error($link);
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Получение видов контента
 *
 * @param mysqli $link Объект mysql
 *
 * @return array|string Ассоциативный массив с данными
 * @throws Exception    Сообщение об ошибке
 */
function getContentTypes(mysqli $link)
{
    $sqlContentTypes = 'SELECT type, icon, id FROM readme.content_type';

    return getSqlData($link, $sqlContentTypes);
}

/**
 * Получение популярных постов
 *
 * @param mysqli $link      Объект mysql
 * @param array  $params    ассоциативный массив с параметрами поиска:
 *                          - filter      активный фильтр
 *                          - sort        тип сортировки
 *                          - direction   направление сортировки
 * @param int    $limit     лимит получаемых постов
 *
 * @return  array|string    ассоциативный массив с данными
 * @throws Exception        или сообщение об ошибке
 */
function getPopularPosts(mysqli $link, array $params, int $limit)
{
    $sql =
        'SELECT
            p.id,
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
        WHERE ? > 0 AND content_type_id = ?
           OR
              ? = 0 AND content_type_id > 0 LIMIT ' . $limit;

    return getSqlData($link, $sql, [
        $params['filter'],
        $params['filter'],
        $params['filter']
    ]);
}

/**
 * Получение деталей поста
 *
 * @param mysqli $link   Объект mysql
 * @param int    $postId id поста
 *
 * @return array|string
 * @throws Exception
 */
function getPostDetails (
    mysqli $link,
    int $postId
) {
    $sql =
        'SELECT
            p.id,
            p.date,
            p.title,
            p.content,
            p.user_id,
            p.views, p.user_id,
            c.icon
        FROM readme.posts p
        JOIN readme.users u ON p.user_id = u.id
        JOIN readme.content_type c ON p.content_type_id = c.id
        WHERE p.id = ?';

    return getSqlData($link, $sql, [$postId]);
}

/**
 * Получения количества лайков к посту
 * @param mysqli $link      Объект mysql
 * @param int $post_id      id поста
 *
 * @return array|string
 */
function getLikes(
    mysqli $link,
    int $post_id
) {
    $sql = 'SELECT COUNT(pl.user_id) AS likes
            FROM readme.post_likes pl
            JOIN readme.posts p ON pl.post_id = p.id
            WHERE p.id = ?';

    return getSqlData($link, $sql, [$post_id]);
}

/**
 * Получени информации о пользователе
 * @param mysqli $link
 * @param int $user_id
 *
 * @return array|string
 */
function getUser(
    mysqli $link,
    int $user_id
) {
    $sql =
        'SELECT u.registration_date, u.avatar, u.login
        FROM readme.users u
        WHERE id = ?';

    return getSqlData($link, $sql, [$user_id]);
}

/**
 * Получения информации о количестве подписчиков
 * @param mysqli $link
 * @param int $user_id
 *
 * @return array|string
 */
function getSubscribersAmount(
    mysqli $link,
    int $user_id
) {
    $sql =
        'SELECT COUNT(author_id) subscribers
        FROM readme.subscriptions s
        WHERE author_id = ?';

    return getSqlData($link, $sql, [$user_id]);
}

/**
 * Получение информации о количестве постов у пользователя
 * @param mysqli $link
 * @param int $user_id
 *
 * @return array|string
 */
function getPostsAmount (
    mysqli $link,
    int $user_id
) {
    $sql =
        'SELECT COUNT(id) AS posts
        FROM readme.posts
        WHERE user_id = ?';

    return getSqlData($link, $sql, [$user_id]);
}

/**
 * Получение хэштегов к посту
 * @param mysqli $link
 * @param int $post_id
 *
 * @return array|string
 */
function getPostHashtags(
    mysqli $link,
    int $post_id
) {
    $sql = 'SELECT h.id, h.post_id, h.hashtag
            FROM readme.hash_tags h
            JOIN readme.posts p on p.id = h.post_id
            WHERE post_id = ?';

    return getSqlData($link, $sql, [$post_id]);
}

/**
 * Функция для получения комментариев поста из базы данных
 * @param mysqli $link      Объект mysql
 * @param int $post_id      id поста
 *
 * @return array|string
 */
function getPostComments (
    mysqli $link,
    int $post_id
) {
    $sql =
        'SELECT
            c.id, c.date, c.text, c.user_id, u.login, u.avatar
        FROM readme.comments c
        JOIN readme.users u ON c.user_id = u.id
        JOIN readme.posts p ON c.post_id = p.id
        WHERE post_id = ?';

    return getSqlData($link, $sql, [$post_id]);
}
