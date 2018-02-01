-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 01 2018 г., 14:44
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
  `image` varchar(255) NOT NULL,
  `concert_date` date NOT NULL,
  `time_start` varchar(10) NOT NULL,
  `publish` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `concert`
--

INSERT INTO `concert` (`id`, `title`, `description`, `image`, `concert_date`, `time_start`, `publish`) VALUES
(1, 'концерт 1', 'здесь большое описание', '1.jpg', '2018-02-01', '20:00', '0'),
(2, 'концерт 2', 'здесь большое описание', '2.jpg', '2018-02-02', '20:00', '0'),
(3, 'концерт 3', 'здесь большое описание', '3.jpg', '2018-02-03', '20:00', '0');

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
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `concert_id`, `email`, `is_active`, `is_paid`, `created`, `total`) VALUES
(2, 2, 'qqq@qqq.qqq', '1', '1', '2018-02-08 22:56:06', '0.00'),
(3, 2, 'qqq@wsasa.a', '1', '0', '2018-02-08 22:56:06', '0.00'),
(4, 2, 'aaa@zxc.asd', '1', '1', '2018-02-08 22:56:06', '0.00'),
(5, 2, 'qqq@aaa.kk', '0', '0', '2018-02-08 22:56:06', '11400.00'),
(6, 2, 'qq@qqq.qq', '1', '0', '2018-02-08 22:56:06', '24000.00'),
(7, 2, 'www@qqq.ll', '1', '0', '2018-02-08 22:56:06', '15000.00'),
(8, 3, 'qqq@aaa.kk', '1', '0', '2018-02-08 22:56:06', '40000.00'),
(12, 2, 'qqq@qqq.com', '1', '1', '2018-02-08 22:56:06', '9000.00'),
(15, 3, 'nnn@aaa.rr', '0', '0', '2018-02-09 11:30:59', '20000.00'),
(16, 3, 'test@ddd.dd', '1', '1', '2018-02-09 14:37:44', '8400.00'),
(17, 2, 'test@ddd.dd', '1', '0', '2018-02-09 15:12:17', '4500.00');

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
(1, 1, 2, 7, 11, '2/7/11', '0.00'),
(2, 1, 2, 7, 12, NULL, '0.00'),
(3, 2, 3, 12, 7, NULL, '0.00'),
(4, 2, 3, 12, 8, NULL, '0.00'),
(5, 2, 3, 12, 9, NULL, '0.00'),
(6, 2, 3, 12, 10, NULL, '0.00'),
(7, 2, 3, 12, 11, NULL, '0.00'),
(8, 2, 3, 12, 12, NULL, '0.00'),
(9, 3, 1, 1, 1, '2/1/1', '0.00'),
(10, 4, 3, 11, 1, NULL, '0.00'),
(11, 5, 1, 5, 19, NULL, '3000.00'),
(12, 5, 1, 5, 20, NULL, '3000.00'),
(13, 5, 2, 6, 19, NULL, '2700.00'),
(14, 5, 2, 6, 20, NULL, '2700.00'),
(15, 6, 1, 1, 19, '2/1/19', '3000.00'),
(16, 6, 1, 1, 20, '2/1/20', '3000.00'),
(17, 6, 1, 2, 19, '2/2/19', '3000.00'),
(18, 6, 1, 2, 20, '2/2/20', '3000.00'),
(19, 6, 1, 3, 19, '2/3/19', '3000.00'),
(20, 6, 1, 3, 20, '2/3/20', '3000.00'),
(21, 6, 1, 4, 19, '2/4/19', '3000.00'),
(22, 6, 1, 4, 20, '2/4/20', '3000.00'),
(23, 7, 3, 15, 11, '2/15/11', '1500.00'),
(24, 7, 3, 15, 12, '2/15/12', '1500.00'),
(25, 7, 3, 15, 13, '2/15/13', '1500.00'),
(26, 7, 3, 15, 14, '2/15/14', '1500.00'),
(27, 7, 3, 15, 15, '2/15/15', '1500.00'),
(28, 7, 3, 15, 16, '2/15/16', '1500.00'),
(29, 7, 3, 15, 17, '2/15/17', '1500.00'),
(30, 7, 3, 15, 18, '2/15/18', '1500.00'),
(31, 7, 3, 15, 19, '2/15/19', '1500.00'),
(32, 7, 3, 15, 20, '2/15/20', '1500.00'),
(33, 8, 1, 1, 1, '3/1/1', '5000.00'),
(34, 8, 1, 1, 2, '3/1/2', '5000.00'),
(35, 8, 1, 1, 3, '3/1/3', '5000.00'),
(36, 8, 1, 1, 4, '3/1/4', '5000.00'),
(37, 8, 1, 1, 5, '3/1/5', '5000.00'),
(38, 8, 2, 10, 10, '3/10/10', '3300.00'),
(39, 8, 2, 10, 11, '3/10/11', '3300.00'),
(40, 8, 3, 15, 1, '3/15/1', '2800.00'),
(41, 8, 3, 15, 2, '3/15/2', '2800.00'),
(42, 8, 3, 15, 3, '3/15/3', '2800.00'),
(46, 12, 1, 1, 16, NULL, '3000.00'),
(47, 12, 1, 1, 17, NULL, '3000.00'),
(48, 12, 1, 1, 18, NULL, '3000.00'),
(53, 15, 1, 1, 6, NULL, '5000.00'),
(54, 15, 1, 1, 7, NULL, '5000.00'),
(55, 15, 1, 2, 6, NULL, '5000.00'),
(56, 15, 1, 2, 7, NULL, '5000.00'),
(57, 16, 3, 11, 9, '3/11/9', '2800.00'),
(58, 16, 3, 11, 10, '3/11/10', '2800.00'),
(59, 16, 3, 11, 11, '3/11/11', '2800.00'),
(60, 17, 3, 11, 11, '2/11/11', '1500.00'),
(61, 17, 3, 11, 12, '2/11/12', '1500.00'),
(62, 17, 3, 11, 13, '2/11/13', '1500.00');

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
(6, 3, 3, '2800.00');

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
(1, 'admin', 'password', 'gorokh@retailcrm.ru', 'ROLE_ADMIN', 1379889332, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT для таблицы `order_seats`
--
ALTER TABLE `order_seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT для таблицы `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
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