DROP DATABASE IF EXISTS readme;

CREATE DATABASE readme
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE readme;

CREATE TABLE users
(
    id                INT AUTO_INCREMENT PRIMARY KEY,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    login             VARCHAR(128) NOT NULL UNIQUE,
    email             VARCHAR(128) NOT NULL UNIQUE,
    password          CHAR(64)     NOT NULL,
    avatar            VARCHAR(128)
);

CREATE TABLE posts
(
    id              INT AUTO_INCREMENT PRIMARY KEY,
    date            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title           VARCHAR(128) NOT NULL,
    content         TEXT,
    author          VARCHAR(128) NOT NULL,
    views           INT,
    content_type_id INT          NOT NULL,
    tags            VARCHAR(128)
);

CREATE TABLE comments
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    date    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    text    TEXT,
    user_id INT NOT NULL,
    post_id INT
);

CREATE TABLE post_likes
(
    user_id INT NOT NULL,
    post_id INT NOT NULL
);

CREATE TABLE subscriptions
(
    user_id   INT NOT NULL,
    author_id INT NOT NULL
);

CREATE TABLE messages
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    date         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    message      TEXT NOT NULL,
    user_id      INT  NOT NULL,
    recipient_id INT  NOT NULL
);

CREATE TABLE tags
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT         NOT NULL,
    hashtag VARCHAR(32) NOT NULL UNIQUE
);

CREATE TABLE content_type
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(32) NOT NULL UNIQUE,
    icon VARCHAR(32)
);
