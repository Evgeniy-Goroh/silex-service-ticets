-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 14 2018 г., 10:15
-- Версия сервера: 5.7.20-0ubuntu0.16.04.1
-- Версия PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db_tickets_silex`
--

-- --------------------------------------------------------

--
-- Структура таблицы `concert`
--

CREATE TABLE `concert` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `concert_date` date NOT NULL,
  `time_start` varchar(10) NOT NULL,
  `publish` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `concert`
--

INSERT INTO `concert` (`id`, `title`, `description`, `image`, `concert_date`, `time_start`, `publish`) VALUES
(1, 'концерт 1', 'здесь большое описание', '1.jpg', '2018-03-12', '20:00', '1'),
(2, 'концерт 2', 'здесь большое описание', '2.jpg', '2018-03-22', '20:00', '1'),
(3, 'концерт 3', 'здесь большое описание', '3.jpg', '2018-03-22', '20:00', '1'),
(11, 'концерт 4', 'описание концерт 4', '12.jpg', '2018-03-18', '06:06', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `concert_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_paid` enum('0','1') NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `concert_id`, `email`, `is_active`, `is_paid`, `created`, `total`) VALUES
(8, 3, 'qqq@aaa.kk', '0', '0', '2018-02-08 22:56:06', '40000.00'),
(15, 3, 'nnn@aaa.rr', '0', '0', '2018-02-09 11:30:59', '20000.00'),
(16, 3, 'test@ddd.dd', '1', '1', '2018-02-09 14:37:44', '8400.00'),
(108, 2, 'test1@twsta.ru', '0', '0', '2018-03-06 09:43:30', '7200.00'),
(111, 11, 'qwe@qwe.ru', '0', '0', '2018-03-06 10:02:11', '423100.00'),
(112, 11, 'qwe@qwe.ru', '0', '0', '2018-03-06 10:02:25', '6900.00'),
(118, 11, 'test@rwer.rt', '0', '0', '2018-03-06 10:07:27', '2300.00'),
(124, 11, 'qwe@qwe.ru', '0', '0', '2018-03-06 10:14:24', '2000.00'),
(125, 11, 'qwe@qwe.ru', '1', '0', '2018-03-06 10:15:41', '2000.00'),
(126, 2, 'tewst@qwedscc.ru', '1', '0', '2018-03-06 10:18:58', '7200.00');

-- --------------------------------------------------------

--
-- Структура таблицы `order_seats`
--

CREATE TABLE `order_seats` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `price_type` int(11) NOT NULL,
  `row` int(11) NOT NULL,
  `seat` int(11) NOT NULL,
  `crs` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_seats`
--

INSERT INTO `order_seats` (`id`, `order_id`, `price_type`, `row`, `seat`, `crs`, `price`) VALUES
(642, 124, 1, 1, 1, NULL, '1000.00'),
(643, 124, 1, 1, 20, NULL, '1000.00'),
(644, 125, 1, 1, 1, '11/1/1', '1000.00'),
(645, 125, 1, 1, 20, '11/1/20', '1000.00'),
(646, 126, 1, 1, 1, '2/1/1', '3000.00'),
(647, 126, 2, 6, 1, '2/6/1', '2700.00'),
(648, 126, 3, 15, 1, '2/15/1', '1500.00');

-- --------------------------------------------------------

--
-- Структура таблицы `price`
--

CREATE TABLE `price` (
  `id` int(11) NOT NULL,
  `price_type` int(11) NOT NULL,
  `concert_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `price`
--

INSERT INTO `price` (`id`, `price_type`, `concert_id`, `price`) VALUES
(1, 1, 2, '3000.00'),
(2, 2, 2, '2700.00'),
(3, 3, 2, '1500.00'),
(4, 1, 3, '5000.00'),
(5, 2, 3, '3300.00'),
(6, 3, 3, '2800.00'),
(7, 1, 11, '1000.00'),
(8, 2, 11, '2000.00'),
(9, 3, 11, '2300.00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(88) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `mail`, `role`, `created_at`, `image`) VALUES
(1, 'admin', '$2y$13$lf6KudfjMNDwH6tSxRq6J.FNbkRNZuZlhMpCQPPgeIF//BtzGZkwC', 'gorokh@retailcrm.ru', 'ROLE_ADMIN', 1379889332, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `concert`
--
ALTER TABLE `concert`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `concert_id` (`concert_id`),
  ADD KEY `created` (`created`);

--
-- Индексы таблицы `order_seats`
--
ALTER TABLE `order_seats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crs` (`crs`),
  ADD KEY `offer_id` (`order_id`),
  ADD KEY `price_type` (`price_type`);

--
-- Индексы таблицы `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `concert_id` (`concert_id`),
  ADD KEY `price_type` (`price_type`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `concert`
--
ALTER TABLE `concert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT для таблицы `order_seats`
--
ALTER TABLE `order_seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=649;
--
-- AUTO_INCREMENT для таблицы `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`concert_id`) REFERENCES `concert` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;