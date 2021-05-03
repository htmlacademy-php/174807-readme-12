USE readme;

INSERT INTO content_type (type, icon)
VALUES ('Текст', 'text'),
       ('Цитата', 'quote'),
       ('Картинка', 'photo'),
       ('Видео', 'video'),
       ('Ссылка', 'link');

INSERT INTO users (registration_date, login, email, password, avatar)
VALUES ('2020-09-04 15:00:00', 'migration', 'mkarim0@squidoo.com', 'B4AIqJplJh',
        'https://robohash.org/eaidvoluptate.png?size=50x50&set=set1'),
       ('2021-01-16 19:25:40', 'zerotolerance', 'dcastagnasso1@google.co.uk', 'QtpwcvnuKji',
        'https://robohash.org/corruptitemporaquia.png?size=50x50&set=set1'),
       ('2020-06-26 10:02:53', 'workforce', 'isalway2@is.gd', 's4HjodCK',
        'https://robohash.org/eaeiusest.png?size=50x50&set=set1');

INSERT INTO comments (date, text, user_id, post_id) VALUES ();

