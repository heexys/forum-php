-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 11 2025 г., 00:14
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
(56, 12, 17, ':)', 1746915019),
(58, 13, 17, '(\"_\")', 1746915130);

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
(12, 'pan Buchta )', 1, 17, 1746915019, NULL, NULL),
(13, 'hi', 1, 17, 1746915036, 17, 1746915130);

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
(13, 'demo', 'dadadfd@yahoo.com', '$2y$10$1Js2rcInZzXmAAA1jGQ0UuYpXXg81KY/B.IYl9LNhcvSXhBIq82ZS', 'sadad', 'sgsss'),
(14, 'dadadjk', 'dfwdad@gmail.com', '$2y$10$G78w.I8AdbtyLUWZc9wdkuhTRptxoJiZ9ojy05ulv3cBMqv4LCwLW', 'wdadad', 'dddd'),
(15, 'jfbsd', 'qqwdada@gmail.com', '$2y$10$HBzjsOJDjD62eP3HhQZIIO/g1SgtfrBpu2NB4c6.mPYveXZwdi18G', 'awdadad', 'dwadawrada'),
(16, 'ayayayayaay', 'dawdadad@gmail.com', '$2y$10$WCr010R9XBiWt1cbBcAeg.98cwqh.4UGXX993UYJTBP8bZHauVZS.', 'sdadwasdadw', 'asdawtfafa'),
(17, 'heexys', 'jiurteger@gmail.com', '$2y$10$MzUulwD2Da6fcKc855lLqO/Xu.U1QeNiaMZWCMHuW7q4LNqelCMn.', 'sadad', 'sg');

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `f_topic`
--
ALTER TABLE `f_topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `f_user`
--
ALTER TABLE `f_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
