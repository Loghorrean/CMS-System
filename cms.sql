-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Сен 28 2020 г., 15:53
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `cat_id` int(3) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`cat_id`, `cat_title`) VALUES
(63, 'C++'),
(60, 'Java'),
(47, 'Javascript'),
(65, 'PHP');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author_id` int(3) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL DEFAULT 'Unapproved',
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author_id`, `comment_content`, `comment_status`, `comment_date`) VALUES
(1, 1, 7, 'Debilizm', 'Unapproved', '2020-09-18'),
(11, 1, 7, 'tfgh', 'Unapproved', '2020-09-13');

-- --------------------------------------------------------

--
-- Структура таблицы `modified_comments`
--

CREATE TABLE `modified_comments` (
  `modified_comment_id` int(3) NOT NULL,
  `comment_id` int(3) NOT NULL,
  `modified_by` int(3) NOT NULL,
  `modified_when` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author_id` int(3) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text DEFAULT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) DEFAULT NULL,
  `post_comment_count` int(3) NOT NULL DEFAULT 0,
  `post_status` varchar(255) NOT NULL DEFAULT 'Denied',
  `view_count` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author_id`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `view_count`) VALUES
(1, 63, 'Trying to make my own CMS with PHP', 7, '2020-09-10', 'php_image.png', 'This is a test message, don\'t reply to it', 'loghorrean, php, js', 11, 'published', 18),
(15, 63, 'Trying to make my own CMS with PHP', 7, '2020-09-11', '8fdf4356708151c3bc4b6fae0e2b12e1.png', '&lt;p&gt;redggrtghh&lt;/p&gt;', 'loghorrean, php, js', 0, 'published', 0),
(17, 60, 'Python', 7, '2020-09-11', 'python-ve-u16-title-900x300.jpg', '<p>Here is some content about Django</p>', 'python, django', 0, 'published', 0),
(18, 47, 'Trying to make my own CMS with PHP', 7, '2020-09-12', 'python-ve-u16-title-900x300.jpg', '<p>dfd</p>', '<p>dfd</p>', 0, 'published', 0),
(19, 47, 'Trying to make my own CMS with PHP', 7, '2020-09-12', 'bootstrap_image.jpg', '<p>fgfgh</p>', '<p>fgfgh</p>', 0, 'published', 0),
(21, 60, 'Trying to make my own CMS with PHP', 7, '2020-09-12', 'bootstrap_image.jpg', '<p>awda</p>', '<p>awda</p>', 0, 'published', 0),
(26, 63, 'OOP', 7, '2020-09-18', 'php_image.png', 'Making my crud OOP', 'php, selenium', 0, 'Published', 0),
(27, 63, 'OOP', 7, '2020-09-18', 'php_image.png', 'Making my crud OOP', 'php, selenium', 0, 'Published', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) DEFAULT NULL,
  `user_lastname` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text DEFAULT NULL,
  `user_role` varchar(255) NOT NULL,
  `randSalt` varchar(255) NOT NULL,
  `cookie` varchar(255) DEFAULT NULL,
  `confirmation` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `randSalt`, `cookie`, `confirmation`) VALUES
(7, 'Loghorrean', '6c07b2f543d1058c8f9fc293fa1be429', 'Daniil', 'Sotnikov', 'flar78@yandex.ru', '', 'admin', '%&h&9mDD', ',R6a4WcZ', 0),
(21, 'warden', '8ca8e2c3a3d148b5a4b441bc9f81d9c1', '', '', 'flar78@yandex.ru', '', 'subscriber', ';W$B!-T6', NULL, 0),
(24, 'Daniil', '97ea37bfd399f75b2bc9c7d0ee16a870', 'Ilya', 'Sotnikov', 'flar78@yandex.ru', '', 'modifier', '(HYnDyK+', NULL, 0),
(54, 'Loghorrean2', '2d8c199cc677b89fa63e3f1f2ffd18a5', NULL, NULL, 'loghorrean74@gmail.com', NULL, 'Subscriber', '^wfH6}ID', NULL, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_title` (`cat_title`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_post_id` (`comment_post_id`),
  ADD KEY `comment_author_id` (`comment_author_id`);

--
-- Индексы таблицы `modified_comments`
--
ALTER TABLE `modified_comments`
  ADD PRIMARY KEY (`modified_comment_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_category_id` (`post_category_id`),
  ADD KEY `post_author_id` (`post_author_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT для таблицы `modified_comments`
--
ALTER TABLE `modified_comments`
  MODIFY `modified_comment_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`comment_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`comment_author_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_category_id`) REFERENCES `category` (`cat_id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`post_author_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
