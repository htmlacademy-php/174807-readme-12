INSERT INTO readme.content_type (type, icon)
VALUES ('Текст', 'text'),
       ('Цитата', 'quote'),
       ('Картинка', 'photo'),
       ('Видео', 'video'),
       ('Ссылка', 'link');

INSERT INTO readme.users (login, email, password, avatar)
VALUES ('Лариса', 'lora_1987@gmail.com', 'lr1987lr', 'userpic-larisa-small.jpg'),
       ('Владик', 'vadik_xxx@gmail.com', 'xVaDik78', 'userpic.jpg'),
       ('Виктор', 'vik.tor@gmail.com', 'vt2000!', 'userpic-mark.jpg');

INSERT INTO readme.comments (text, user_id, post_id)
VALUES ('Клёвое фото, хочу туда', 1, 3),
       ('Пиши, как выйдет новый сезон, тоже очень жду', 3, 2);

INSERT INTO readme.posts (title, content, user_id, views, content_type_id)
VALUES ('Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 1, 8, 2),
       ('Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала!', 2, 10, 1),
       ('Наконец, обработал фотки!', 'rock-medium.jpg', 3, 32, 3),
       ('Моя мечта', 'coast-medium.jpg', 1, 12, 3),
       ('Лучшие курсы', 'www.htmlacademy.ru', 2, 1, 5);

# Получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента;
SELECT p.title, u.login, c.type, p.views
FROM readme.posts p
         INNER JOIN readme.users u ON p.user_id = u.id
         INNER JOIN readme.content_type c ON p.content_type_id = c.id
ORDER BY p.views DESC;

# Получить список комментариев для одного поста, в комментариях должен быть логин пользователя;
SELECT c.id, c.text, u.login
FROM readme.comments c
         INNER JOIN readme.users u ON c.user_id = u.id
         INNER JOIN readme.posts p ON c.post_id = p.id
WHERE c.post_id = 3;

# Получить список постов для конкретного пользователя;
SELECT p.id
FROM readme.posts p
WHERE user_id = 2;

# Добавить лайк к посту;
INSERT INTO readme.post_likes (user_id, post_id)
VALUES (1, 1);
