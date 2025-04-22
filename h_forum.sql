-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 22 2025 г., 14:11
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `h_forum`
--

-- --------------------------------------------------------

--
-- Структура таблицы `f_post`
--

CREATE TABLE `f_post` (
  `id` int(11) UNSIGNED NOT NULL,
  `topicId` int(11) UNSIGNED DEFAULT NULL,
  `userId` int(11) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL DEFAULT '',
  `dateCreate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `f_post`
--

INSERT INTO `f_post` (`id`, `topicId`, `userId`, `message`, `dateCreate`) VALUES
(27, 3, 0, '@', 1745313319),
(30, 4, 0, 'Ð° ', 1745313946),
(33, 1, 13, 'wdadas', 1745317425),
(35, 1, 13, 'uuytyjtyj', 1745317523),
(36, 5, 13, 'QQ', 1745317543),
(39, 2, 13, 'hi', 1745318485),
(43, 6, 13, 'Ð²Ñ†Ñ„Ð²Ñ„Ñ‹Ð²Ñ†', 1745321537);

-- --------------------------------------------------------

--
-- Структура таблицы `f_topic`
--

CREATE TABLE `f_topic` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `countMessages` int(11) DEFAULT NULL,
  `userId` int(11) UNSIGNED NOT NULL,
  `dateCreate` int(11) NOT NULL,
  `replyUserId` int(11) UNSIGNED DEFAULT NULL,
  `dateReply` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `f_topic`
--

INSERT INTO `f_topic` (`id`, `name`, `countMessages`, `userId`, `dateCreate`, `replyUserId`, `dateReply`) VALUES
(1, 'lol', 2, 13, 1745276639, 13, 1745317523),
(2, 'sddwads', 1, 13, 1745276650, 13, 1745318485),
(3, '75345', 1, 0, 1745313319, 0, 1745313319),
(4, 'Ð° Ð² Ñ‡ÐµÐ¼ Ð¿Ñ€Ð¾Ð±', 1, 0, 1745313946, NULL, NULL),
(5, 'iuy', 1, 13, 1745316744, 13, 1745317543),
(6, 'Ñ„ÑÑ„Ñ‹Ð²Ñ†Ð²Ñ„', 1, 13, 1745321537, NULL, NULL),
(7, 'wdadas', 0, 0, 1745323829, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `f_user`
--

CREATE TABLE `f_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `login` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `f_user`
--

INSERT INTO `f_user` (`id`, `login`, `email`, `password`, `name`, `surname`) VALUES
(0, 'admin', 'jiurteger@gmail.com', '$2y$10$GTnZdgED3VNXyu3ZwGF8DeZx03RirSP6n3x01KX5wC4Lc0gCA5roa', 'ya', 'horoshi'),
(13, 'demo', 'dadadfd@yahoo.com', '$2y$10$1Js2rcInZzXmAAA1jGQ0UuYpXXg81KY/B.IYl9LNhcvSXhBIq82ZS', 'sadad', 'sgsss'),
(14, 'dadadjk', 'dfwdad@gmail.com', '$2y$10$G78w.I8AdbtyLUWZc9wdkuhTRptxoJiZ9ojy05ulv3cBMqv4LCwLW', 'wdadad', 'dddd');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `f_post`
--
ALTER TABLE `f_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topicId` (`topicId`),
  ADD KEY `userId` (`userId`);

--
-- Индексы таблицы `f_topic`
--
ALTER TABLE `f_topic`
  ADD UNIQUE KEY `UNIQUE` (`id`) USING BTREE,
  ADD KEY `idx_userId` (`userId`),
  ADD KEY `idx_replyUserId` (`replyUserId`);

--
-- Индексы таблицы `f_user`
--
ALTER TABLE `f_user`
  ADD UNIQUE KEY `UNIQUE` (`id`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `f_post`
--
ALTER TABLE `f_post`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT для таблицы `f_topic`
--
ALTER TABLE `f_topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `f_post`
--
ALTER TABLE `f_post`
  ADD CONSTRAINT `f_post_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `f_user` (`id`);

--
-- Ограничения внешнего ключа таблицы `f_topic`
--
ALTER TABLE `f_topic`
  ADD CONSTRAINT `fk_replyUserId` FOREIGN KEY (`replyUserId`) REFERENCES `f_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId` FOREIGN KEY (`userId`) REFERENCES `f_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
