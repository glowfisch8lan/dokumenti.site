-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: h008383856.mysql
-- Время создания: Май 28 2021 г., 07:57
-- Версия сервера: 5.6.41-84.1
-- Версия PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `h008383856_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `feedback_request`
--

CREATE TABLE `feedback_request` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `phone` text NOT NULL,
  `timestamp` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1614496247),
('m210228_070939_system_users', 1614496249),
('m210228_071022_system_users_groups', 1614496250),
('m210228_071234_system_settings', 1614496400),
('m210308_072810_users_balance', 1615188757),
('m210308_073906_system_groups', 1615188757),
('m210308_074230_users_orders', NULL),
('m210308_074305_system_files', NULL),
('m210309_015554_system_history', 1615255231),
('m210309_020206_system_transactions', 1615255656),
('m210309_044254_alter_system_transactions', 1615265162);

-- --------------------------------------------------------

--
-- Структура таблицы `system_files`
--

CREATE TABLE `system_files` (
  `id` int(11) NOT NULL,
  `filename` text NOT NULL COMMENT 'Имя файла',
  `uuid` text NOT NULL COMMENT 'UUID файла',
  `tag` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `timestamp` int(255) DEFAULT NULL COMMENT 'Дата загрузки файла'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица, хранящая информацию о загруженных файлах';

--
-- Дамп данных таблицы `system_files`
--

INSERT INTO `system_files` (`id`, `filename`, `uuid`, `tag`, `user_id`, `timestamp`) VALUES
(43, 'file6057e3fd8efcd700b2809141dfe5deeb88c08aa21b3ff.docx', 'file6057e3fd8efcd700b2809141dfe5deeb88c08aa21b3ff', 'file6057e3fd8e15e27646057e3fd8e166', 1, 1616372733);

-- --------------------------------------------------------

--
-- Структура таблицы `system_files_info`
--

CREATE TABLE `system_files_info` (
  `id` int(11) NOT NULL,
  `files_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `extension` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `system_files_info`
--

INSERT INTO `system_files_info` (`id`, `files_id`, `name`, `description`, `extension`) VALUES
(7, 43, 'Конфедициальное соглашение.docx', 'Описание файла', 'docx');

-- --------------------------------------------------------

--
-- Структура таблицы `system_groups`
--

CREATE TABLE `system_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `permissions` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `system_groups`
--

INSERT INTO `system_groups` (`id`, `name`, `description`, `permissions`) VALUES
(1, 'Администратор', 'Администраторы системы', '[\"viewSystem\",\"createOrder\",\"viewStorage\",\"viewOrders\",\"deleteOrders\",\"viewAllOrders\",\"modifyUserOrders\",\"viewUsers\",\"loginByUser\",\"loginByUser\",\"viewGroups\",\"viewSettings\"]'),
(2, 'Пользователи', 'Пользователи', '[\"viewSystem\",\"createOrder\",\"viewStorage\",\"viewOrders\"]'),
(3, 'Адвокаты', 'Адвокаты', '[\"viewSystem\",\"viewOrders\",\"viewAllOrders\",\"modifyUserOrders\"]');

-- --------------------------------------------------------

--
-- Структура таблицы `system_history`
--

CREATE TABLE `system_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` float NOT NULL COMMENT 'Сумма',
  `description` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `system_history`
--

INSERT INTO `system_history` (`id`, `user_id`, `amount`, `description`, `status`, `created_at`, `updated_at`, `transaction_id`) VALUES
(250, 1, 1000, 'Инициализация транзакции', 2, 1615881309, 1615881309, 143),
(251, 1, 1000, 'Инициализация транзакции', 2, 1615881320, 1615881320, 144),
(252, 1, 1000, 'Инициализация транзакции', 2, 1615881343, 1615881343, 145),
(253, 1, 1000, 'Инициализация транзакции', 2, 1615881396, 1615881396, 146),
(254, 1, 1000, 'Инициализация транзакции', 2, 1615881409, 1615881409, 147),
(255, 1, 1000, 'Инициализация транзакции', 2, 1615881411, 1615881411, 148),
(256, 1, 1000, 'Инициализация транзакции', 2, 1615881413, 1615881413, 149),
(257, 1, 1000, 'Инициализация транзакции', 2, 1615881414, 1615881414, 150),
(258, 1, 1000, 'Инициализация транзакции', 2, 1615881543, 1615881543, 151),
(259, 1, 1000, 'Инициализация транзакции', 2, 1615881550, 1615881550, 152),
(260, 1, 1000, 'Инициализация транзакции', 2, 1615881558, 1615881558, 153),
(261, 1, 1000, 'Инициализация транзакции', 2, 1615881569, 1615881569, 154),
(262, 1, 1000, 'Инициализация транзакции', 2, 1615881584, 1615881584, 155),
(263, 1, 1000, 'Инициализация транзакции', 2, 1615881590, 1615881590, 156),
(264, 1, 1000, 'Инициализация транзакции', 2, 1615881596, 1615881596, 157),
(265, 1, 1000, 'Инициализация транзакции', 2, 1615881601, 1615881601, 158),
(266, 1, 1000, 'Инициализация транзакции', 2, 1615881609, 1615881609, 159),
(267, 1, 1000, 'Инициализация транзакции', 2, 1615881621, 1615881621, 160),
(268, 1, 1000, 'Инициализация транзакции', 2, 1615881623, 1615881623, 161),
(269, 1, 1000, 'Инициализация транзакции', 2, 1615881632, 1615881632, 162),
(270, 1, 1000, 'Инициализация транзакции', 2, 1615881636, 1615881636, 163),
(271, 1, 1000, 'Инициализация транзакции', 2, 1615881638, 1615881638, 164),
(272, 1, 1000, 'Инициализация транзакции', 2, 1615881640, 1615881640, 165),
(273, 1, 1000, 'Инициализация транзакции', 2, 1615881647, 1615881647, 166),
(274, 1, 1000, 'Инициализация транзакции', 2, 1615881670, 1615881670, 167),
(275, 1, 1000, 'Инициализация транзакции', 2, 1615881752, 1615881752, 168),
(276, 1, 1000, 'Инициализация транзакции', 2, 1615881774, 1615881774, 169),
(277, 1, 1000, 'Инициализация транзакции', 2, 1615881908, 1615881908, 170),
(278, 1, 1000, 'Инициализация транзакции', 2, 1615881911, 1615881911, 171),
(279, 1, 1000, 'Инициализация транзакции', 2, 1615881946, 1615881946, 172),
(280, 1, 1000, 'Инициализация транзакции', 2, 1615881951, 1615881951, 173),
(281, 1, 1000, 'Инициализация транзакции', 2, 1615882016, 1615882016, 174),
(282, 1, 1000, 'Инициализация транзакции', 2, 1615882044, 1615882044, 175),
(283, 1, 1000, 'Инициализация транзакции', 2, 1615882569, 1615882569, 176),
(284, 1, 1000, 'Инициализация транзакции', 2, 1615882967, 1615882967, NULL),
(285, 1, 1000, 'Инициализация транзакции', 2, 1615882974, 1615882974, 177),
(286, 1, 400, 'Инициализация транзакции', 2, 1615883285, 1615883285, 178),
(287, 1, 400, 'Инициализация транзакции', 2, 1615883831, 1615883831, 179),
(288, 1, 400, 'Пополнение баланса', 1, 1615883846, 1615883846, 179),
(290, 29, 1000, 'Инициализация транзакции', 2, 1615884585, 1615884585, 180),
(291, 29, 1000, 'Пополнение баланса', 3, 1615884598, 1615884598, 180),
(292, 1, 400, 'Пополнение баланса', 1, 1615885389, 1615885389, 178),
(294, 1, 1000, 'Пополнение баланса', 1, 1615885433, 1615885433, 177),
(296, 1, 10000, 'Оплата заказа #73', 4, 1615887946, 1615887946, NULL),
(297, 1, 10000, 'Оплата заказа #72', 4, 1615887997, 1615887997, NULL),
(298, 1, 10000, 'Оплата заказа #71', 4, 1615888062, 1615888062, NULL),
(299, 1, 10000, 'Оплата заказа #70', 4, 1615888065, 1615888065, NULL),
(300, 1, 10000, 'Оплата заказа #68', 4, 1615888068, 1615888068, NULL),
(301, 1, 10000, 'Оплата заказа #69', 4, 1615888071, 1615888071, NULL),
(302, 1, 10000, 'Оплата заказа #66', 4, 1615888075, 1615888075, NULL),
(303, 1, 4800, 'Оплата заказа #67', 4, 1615888078, 1615888078, NULL),
(304, 1, 10000, 'Оплата заказа #64', 4, 1615888081, 1615888081, NULL),
(305, 1, 10000, 'Оплата заказа #65', 4, 1615888098, 1615888098, NULL),
(306, 1, 10000, 'Оплата заказа #63', 4, 1615888139, 1615888139, NULL),
(307, 1, 4000, 'Оплата заказа #62', 4, 1615888172, 1615888172, NULL),
(308, 1, 4000, 'Оплата заказа #55', 4, 1615888180, 1615888180, NULL),
(309, 1, 10000, 'Оплата заказа #56', 4, 1615888187, 1615888187, NULL),
(310, 31, 5000, 'Инициализация транзакции', 2, 1615961848, 1615961848, 181),
(311, 31, 5000, 'Пополнение баланса', 1, 1615961876, 1615961876, 181),
(313, 31, 20000, 'Инициализация транзакции', 2, 1615961894, 1615961894, 182),
(314, 31, 10000, 'Инициализация транзакции', 2, 1615961926, 1615961926, 183),
(315, 31, 10000, 'Пополнение баланса', 1, 1615961938, 1615961938, 183),
(317, 31, 10000, 'Оплата заказа #74', 4, 1615961947, 1615961947, NULL),
(318, 31, 1000, 'Инициализация транзакции', 2, 1615962024, 1615962024, 184),
(319, 31, 1000, 'Пополнение баланса', 1, 1615962036, 1615962036, 184),
(321, 31, 1000, 'Инициализация транзакции', 2, 1615962050, 1615962050, 185),
(322, 31, 1000, 'Пополнение баланса', 1, 1615962062, 1615962062, 185),
(324, 31, 1720, 'Инициализация транзакции', 2, 1615962085, 1615962085, 186),
(325, 31, 1720, 'Пополнение баланса', 1, 1615962097, 1615962097, 186),
(327, 1, 10000, 'Оплата заказа #91', 4, 1615965503, 1615965503, NULL),
(328, 31, 2300, 'Инициализация транзакции', 2, 1615968227, 1615968227, 187),
(329, 31, 2300, 'Пополнение баланса', 1, 1615968240, 1615968240, 187),
(331, 31, 2100, 'Инициализация транзакции', 2, 1615968250, 1615968250, 188),
(332, 31, 2100, 'Пополнение баланса', 1, 1615968264, 1615968264, 188),
(334, 31, 10000, 'Оплата заказа #94', 4, 1615968268, 1615968268, NULL),
(335, 1, 10000, 'Оплата заказа #92', 4, 1615968917, 1615968917, NULL),
(336, 1, 4000, 'Оплата заказа #93', 4, 1616123187, 1616123187, NULL),
(337, 1, 4000, 'Оплата заказа #93', 4, 1616123195, 1616123195, NULL),
(338, 1, 4000, 'Оплата заказа #93', 4, 1616123693, 1616123693, NULL),
(339, 1, 4000, 'Оплата заказа #93', 4, 1616123706, 1616123706, NULL),
(340, 1, 4000, 'Оплата заказа #93', 4, 1616123725, 1616123725, NULL),
(341, 1, 4000, 'Оплата заказа #93', 4, 1616123735, 1616123735, NULL),
(342, 1, 10000, 'Оплата заказа #95', 4, 1616123797, 1616123797, NULL),
(343, 30, 4000, 'Инициализация транзакции', 2, 1616240818, 1616240818, 189),
(344, 30, 4000, 'Пополнение баланса', 1, 1616240839, 1616240839, 189),
(346, 30, 4000, 'Оплата заказа #96', 4, 1616240850, 1616240850, NULL),
(347, 1, 10000, 'Оплата заказа #100', 4, 1616378615, 1616378615, NULL),
(348, 1, 13000, 'Оплата заказа #105', 4, 1616378660, 1616378660, NULL),
(349, 31, 10000, 'Инициализация транзакции', 2, 1616442051, 1616442051, 190),
(350, 31, 10000, 'Пополнение баланса', 1, 1616442064, 1616442064, 190),
(352, 31, 5000, 'Инициализация транзакции', 2, 1616566299, 1616566299, 191),
(353, 31, 5000, 'Пополнение баланса', 1, 1616566330, 1616566330, 191);

-- --------------------------------------------------------

--
-- Структура таблицы `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `value`, `user_id`, `description`) VALUES
(1, 'system.cache.status', 'false', NULL, 'Кеширование данных'),
(2, 'system.signup.group.default', '2', NULL, 'Группа по-умолчанию при регистрации новых пользователей'),
(3, 'system.orders.sitetype.landingpage', '10 000', NULL, 'Цена за Landing-page'),
(4, 'system.orders.sitetype.catalog', '13 000', NULL, 'Цена за Интернет-каталог'),
(5, 'system.orders.sitetype.magazine', '21 700', NULL, 'Цена за Интернет-магазин'),
(6, 'system.orders.sitetype.service', '21 700', NULL, 'Цена за Интернет-сервис'),
(7, 'system.orders.sitetype.other', '> 3 000', NULL, 'Цена при условии \"Другое\"');

-- --------------------------------------------------------

--
-- Структура таблицы `system_transactions`
--

CREATE TABLE `system_transactions` (
  `id` int(11) NOT NULL,
  `tb_payment_id` int(11) DEFAULT NULL,
  `tb_card_id` int(11) DEFAULT NULL,
  `tb_pan` varchar(16) DEFAULT NULL,
  `tb_exp_date` varchar(4) DEFAULT NULL,
  `tb_token` text,
  `tb_amount` float DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `system_transactions`
--

INSERT INTO `system_transactions` (`id`, `tb_payment_id`, `tb_card_id`, `tb_pan`, `tb_exp_date`, `tb_token`, `tb_amount`, `created_at`, `updated_at`, `status`, `user_id`) VALUES
(83, 488899016, 43352846, '430000******0777', '1122', '6f5f33481835aaddb84e064aa38a0ec61a0c33aeefade99b9e3c03d8d47b5f84', 50, 1615357463, 1615357473, 2, 1),
(84, 488900633, 43352846, '430000******0777', '1122', '0703b191a2b7151f18582b11fcc8d496d634e6a3b88c19c8ad4a5710f008fc7e', 50, 1615357532, 1615357541, 2, 1),
(85, NULL, NULL, NULL, NULL, NULL, NULL, 1615363358, 1615363358, 0, NULL),
(86, NULL, NULL, NULL, NULL, NULL, NULL, 1615363422, 1615363422, 0, NULL),
(87, 489058507, 43352846, '430000******0777', '1122', '622a21b40f5ee8499133b3197560a279b5c3ff77eb7868027d419ef8ea6b6a32', 100, 1615363498, 1615363505, 2, 1),
(88, 489066596, 43352846, '430000******0777', '1122', '84ff6cff3c5253636d6d4074b30a478b930a1a6484f371b399e13d5c21192fbf', 1000, 1615363765, 1615363775, 2, NULL),
(89, 490067803, 43352846, '430000******0777', '1122', 'af12bc34e530e90f84959145a8fb49b91da0374f688973278d9e0d4d7f0372fe', 25000, 1615397058, 1615397079, 2, NULL),
(90, 490069088, 43456643, '500000******0009', '1122', 'b12af8cfb100e9a62d7cad06a4067caabcb07e2496aea07d5974472ddf7ab4af', 16000, 1615397100, 1615397128, 7, NULL),
(91, NULL, NULL, NULL, NULL, NULL, NULL, 1615426112, 1615426112, 0, 1),
(92, NULL, NULL, NULL, NULL, NULL, NULL, 1615516854, 1615516854, 0, 1),
(93, 492117142, 43352846, '430000******0777', '1122', '2432cd71a9b86d07fbbc75d10dfff11ac55fbd4c82d0cac2ed561cf6c74d230f', 300000, 1615516855, 1615516881, 1, 1),
(94, 492119130, 43352846, '430000******0777', '1122', 'dc65410c1d5a36aeec868992b38ea0da467580b9bb3897bd7a76099dd3389a9b', 3000, 1615517022, 1615517030, 2, 1),
(95, 492431862, 43352846, '430000******0777', '1122', 'cf0fc6ffe85d67fe3edd6ec5a92f14371b4e6039bd5656a9638b2588d2415fb3', 5000, 1615535997, 1615536075, 2, NULL),
(96, 492436503, 43352846, '430000******0777', '1122', '79e76c4b860a4eab7623b3ce12c978922866d1338b9afdd544464a843584e5c5', 5000, 1615536228, 1615536234, 2, NULL),
(97, 492563931, 43352846, '430000******0777', '1122', '135d089b3fa10013e735dd0eb8c649b4096f0a5ab2af82a345e4952f038aceeb', 4000, 1615542395, 1615542501, 2, 28),
(98, NULL, NULL, NULL, NULL, NULL, NULL, 1615542395, 1615542395, 0, 28),
(99, 492569473, 43352846, '430000******0777', '1122', 'd7e7576a044543f50b7260aa21d86aed40a8a3945612bae98564cc4fe1e367d7', 3000, 1615542720, 1615542771, 2, 28),
(100, NULL, NULL, NULL, NULL, NULL, NULL, 1615542720, 1615542720, 0, 28),
(101, NULL, NULL, NULL, NULL, NULL, NULL, 1615542784, 1615542784, 0, 28),
(102, NULL, NULL, NULL, NULL, NULL, NULL, 1615542790, 1615542790, 0, 28),
(103, NULL, NULL, NULL, NULL, NULL, NULL, 1615542796, 1615542796, 0, 28),
(104, 492570865, 43352846, '430000******0777', '1122', '9a15a1365c3ab0304397b04044170757a5c994d90db5f2ac8f2229eaad48ea1b', 1800, 1615542809, 1615542838, 2, 28),
(105, 492586106, 43352846, '430000******0777', '1122', '5feaa77191ca4cfc9d4c5337dcbfa013de7434161916b5596108cb61cf5852d2', 4000, 1615543627, 1615543670, 2, 29),
(106, 492851588, 43352846, '430000******0777', '1122', '170a39fe0c42b564b00e8fbc19cc14fa60171a62198ed9ecbf20287525faccdb', 4000, 1615556563, 1615556587, 2, 29),
(107, NULL, NULL, NULL, NULL, NULL, NULL, 1615617691, 1615617691, 0, 1),
(108, NULL, NULL, NULL, NULL, NULL, NULL, 1615617711, 1615617711, 0, 1),
(109, NULL, NULL, NULL, NULL, NULL, NULL, 1615617716, 1615617716, 0, 1),
(110, NULL, NULL, NULL, NULL, NULL, NULL, 1615617909, 1615617909, 0, 1),
(111, NULL, NULL, NULL, NULL, NULL, NULL, 1615618004, 1615618004, 0, 1),
(112, NULL, NULL, NULL, NULL, NULL, NULL, 1615618020, 1615618020, 0, 1),
(113, NULL, NULL, NULL, NULL, NULL, NULL, 1615618031, 1615618031, 0, 1),
(114, NULL, NULL, NULL, NULL, NULL, NULL, 1615618043, 1615618043, 0, 1),
(115, NULL, NULL, NULL, NULL, NULL, NULL, 1615618174, 1615618174, 0, 1),
(116, NULL, NULL, NULL, NULL, NULL, NULL, 1615878774, 1615878774, 0, 31),
(117, NULL, NULL, NULL, NULL, NULL, NULL, 1615878833, 1615878833, 0, 31),
(118, NULL, NULL, NULL, NULL, NULL, NULL, 1615879126, 1615879126, 0, 1),
(119, NULL, NULL, NULL, NULL, NULL, NULL, 1615879126, 1615879126, 0, 1),
(120, NULL, NULL, NULL, NULL, NULL, NULL, 1615879186, 1615879186, 0, 1),
(121, NULL, NULL, NULL, NULL, NULL, NULL, 1615880020, 1615880020, 0, 1),
(122, NULL, NULL, NULL, NULL, NULL, NULL, 1615880035, 1615880035, 0, 1),
(123, NULL, NULL, NULL, NULL, NULL, NULL, 1615880399, 1615880399, 0, 1),
(124, NULL, NULL, NULL, NULL, NULL, NULL, 1615880417, 1615880417, 0, 1),
(125, NULL, NULL, NULL, NULL, NULL, NULL, 1615880423, 1615880423, 0, 1),
(126, NULL, NULL, NULL, NULL, NULL, NULL, 1615880443, 1615880443, 0, 1),
(127, NULL, NULL, NULL, NULL, NULL, NULL, 1615880448, 1615880448, 0, 1),
(128, NULL, NULL, NULL, NULL, NULL, NULL, 1615880462, 1615880462, 0, 1),
(129, NULL, NULL, NULL, NULL, NULL, NULL, 1615880464, 1615880464, 0, 1),
(130, NULL, NULL, NULL, NULL, NULL, NULL, 1615880469, 1615880469, 0, 1),
(131, NULL, NULL, NULL, NULL, NULL, NULL, 1615880473, 1615880473, 0, 1),
(132, NULL, NULL, NULL, NULL, NULL, NULL, 1615880672, 1615880672, 0, 1),
(133, NULL, NULL, NULL, NULL, NULL, NULL, 1615880686, 1615880686, 0, 1),
(134, NULL, NULL, NULL, NULL, NULL, NULL, 1615880701, 1615880701, 0, 1),
(135, NULL, NULL, NULL, NULL, NULL, NULL, 1615880715, 1615880715, 0, 1),
(136, NULL, NULL, NULL, NULL, NULL, NULL, 1615880730, 1615880730, 0, 1),
(137, NULL, NULL, NULL, NULL, NULL, NULL, 1615880735, 1615880735, 0, 1),
(138, NULL, NULL, NULL, NULL, NULL, NULL, 1615880757, 1615880757, 0, 1),
(139, NULL, NULL, NULL, NULL, NULL, NULL, 1615880776, 1615880776, 0, 1),
(140, NULL, NULL, NULL, NULL, NULL, NULL, 1615880798, 1615880798, 0, 1),
(141, NULL, NULL, NULL, NULL, NULL, NULL, 1615880810, 1615880810, 0, 1),
(142, NULL, NULL, NULL, NULL, NULL, NULL, 1615881286, 1615881286, 0, 1),
(143, NULL, NULL, NULL, NULL, NULL, NULL, 1615881309, 1615881309, 0, 1),
(144, NULL, NULL, NULL, NULL, NULL, NULL, 1615881320, 1615881320, 0, 1),
(145, NULL, NULL, NULL, NULL, NULL, NULL, 1615881343, 1615881343, 0, 1),
(146, NULL, NULL, NULL, NULL, NULL, NULL, 1615881396, 1615881396, 0, 1),
(147, NULL, NULL, NULL, NULL, NULL, NULL, 1615881409, 1615881409, 0, 1),
(148, NULL, NULL, NULL, NULL, NULL, NULL, 1615881411, 1615881411, 0, 1),
(149, NULL, NULL, NULL, NULL, NULL, NULL, 1615881413, 1615881413, 0, 1),
(150, NULL, NULL, NULL, NULL, NULL, NULL, 1615881414, 1615881414, 0, 1),
(151, NULL, NULL, NULL, NULL, NULL, NULL, 1615881543, 1615881543, 0, 1),
(152, NULL, NULL, NULL, NULL, NULL, NULL, 1615881550, 1615881550, 0, 1),
(153, NULL, NULL, NULL, NULL, NULL, NULL, 1615881558, 1615881558, 0, 1),
(154, NULL, NULL, NULL, NULL, NULL, NULL, 1615881569, 1615881569, 0, 1),
(155, NULL, NULL, NULL, NULL, NULL, NULL, 1615881584, 1615881584, 0, 1),
(156, NULL, NULL, NULL, NULL, NULL, NULL, 1615881590, 1615881590, 0, 1),
(157, NULL, NULL, NULL, NULL, NULL, NULL, 1615881596, 1615881596, 0, 1),
(158, NULL, NULL, NULL, NULL, NULL, NULL, 1615881601, 1615881601, 0, 1),
(159, NULL, NULL, NULL, NULL, NULL, NULL, 1615881609, 1615881609, 0, 1),
(160, NULL, NULL, NULL, NULL, NULL, NULL, 1615881621, 1615881621, 0, 1),
(161, NULL, NULL, NULL, NULL, NULL, NULL, 1615881623, 1615881623, 0, 1),
(162, NULL, NULL, NULL, NULL, NULL, NULL, 1615881632, 1615881632, 0, 1),
(163, NULL, NULL, NULL, NULL, NULL, NULL, 1615881636, 1615881636, 0, 1),
(164, NULL, NULL, NULL, NULL, NULL, NULL, 1615881638, 1615881638, 0, 1),
(165, NULL, NULL, NULL, NULL, NULL, NULL, 1615881640, 1615881640, 0, 1),
(166, NULL, NULL, NULL, NULL, NULL, NULL, 1615881647, 1615881647, 0, 1),
(167, NULL, NULL, NULL, NULL, NULL, NULL, 1615881670, 1615881670, 0, 1),
(168, NULL, NULL, NULL, NULL, NULL, NULL, 1615881752, 1615881752, 0, 1),
(169, NULL, NULL, NULL, NULL, NULL, NULL, 1615881774, 1615881774, 0, 1),
(170, NULL, NULL, NULL, NULL, NULL, NULL, 1615881908, 1615881908, 0, 1),
(171, NULL, NULL, NULL, NULL, NULL, NULL, 1615881911, 1615881911, 0, 1),
(172, NULL, NULL, NULL, NULL, NULL, NULL, 1615881946, 1615881946, 0, 1),
(173, NULL, NULL, NULL, NULL, NULL, NULL, 1615881951, 1615881951, 0, 1),
(174, NULL, NULL, NULL, NULL, NULL, NULL, 1615882016, 1615882016, 0, 1),
(175, NULL, NULL, NULL, NULL, NULL, NULL, 1615882044, 1615882044, 0, 1),
(176, NULL, NULL, NULL, NULL, NULL, NULL, 1615882569, 1615882569, 0, 1),
(177, 497231218, 43352846, '430000******0777', '1122', '38264e64cd5c1210a54a98e1eb008225daa56e02aa2870855b68573d7d3e47ef', 1000, 1615882974, 1615885433, 2, 1),
(178, 497236835, 43352846, '430000******0777', '1122', '03e35b460fb42930afd2a4ad04061b69872dd570d14557586d29bb9fdb56e892', 400, 1615883285, 1615885389, 2, 1),
(179, 497246819, 43352846, '430000******0777', '1122', 'a4ce2805cf80b680898e2d5a568b1b70ffe39556817809769b6fbc0e1744f765', 400, 1615883831, 1615883846, 2, 1),
(180, 497260799, 43456643, '500000******0009', '1122', '5fb48ffa09e7a8075d5086746b748047332f88903b0e83a0a5db87ed44494bc9', 1000, 1615884585, 1615884598, 7, 29),
(181, 498533810, 43352846, '430000******0777', '1122', '03616960b1cac8532f6d50a1a7b345eefd26cc0bd2e5b432e7320ce65a9b8d29', 5000, 1615961848, 1615961876, 2, 31),
(182, NULL, NULL, NULL, NULL, NULL, NULL, 1615961894, 1615961894, 0, 31),
(183, 498535142, 43352846, '430000******0777', '1122', 'de0ab6b13c6920e4cc5ed35f8000ae78243c8587b95fd61087972f4516a7df83', 10000, 1615961926, 1615961938, 2, 31),
(184, 498536842, 43352846, '430000******0777', '1122', 'fd807c2690a8cb09024458bcd5ca9ce0c44ecae12964ec0e46a33d292e6cf84d', 1000, 1615962024, 1615962036, 2, 31),
(185, 498537291, 43352846, '430000******0777', '1122', 'eb020cd5834532fc112735bc32cc5aad340c01ccad51a2a0a04eba4c5cc43774', 1000, 1615962050, 1615962062, 2, 31),
(186, 498537860, 43352846, '430000******0777', '1122', 'c651bc1e3051ca400aa13599b1f625a644cdbba88ec8c149d16836fbe4b740ee', 1720, 1615962085, 1615962097, 2, 31),
(187, 498639806, 43352846, '430000******0777', '1122', '84c79569aadc282b6be7993562a01b1b2f349c260805274a0baecaf53325b9ab', 2300, 1615968227, 1615968240, 2, 31),
(188, 498640176, 43352846, '430000******0777', '1122', '168f48f8fe49b54a02ab8e6b523848e96d8a6cf8c592d60154ee1084b2de4d22', 2100, 1615968250, 1615968264, 2, 31),
(189, 502052251, 43352846, '430000******0777', '1122', '4d9f4b5135f250b33cdc03c931e9ef718958326330570eb7a21f6efdf23c54d6', 4000, 1616240818, 1616240839, 2, 30),
(190, 504669553, 43352846, '430000******0777', '1122', '892a44fb2b937ed4b7d8af6aecca76c7ca2c5740cb6a1ec685cf88dc4ebd37b2', 10000, 1616442051, 1616442064, 2, 31),
(191, 506292509, 43352846, '430000******0777', '1122', '04d2bf6667e041b3559486d28ad6e3453d8d7c1b568c1e47ee91631d84d17dc5', 5000, 1616566299, 1616566330, 2, 31);

-- --------------------------------------------------------

--
-- Структура таблицы `system_users`
--

CREATE TABLE `system_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` text,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `system_users`
--

INSERT INTO `system_users` (`id`, `username`, `name`, `password`, `phone`, `email`) VALUES
(1, 'admin@dokumenti.site', 'Администратор', '$2y$13$srKMjyd5c.Z3QHdZd/.RXO7soqZ/ZQ4651XmcVSZ97tvxJYiUVPxi', NULL, 'admin@dokumenti.site'),
(28, 'adminsmm@webrazavr.ru ', 'Юлия', '$2y$13$MnVzXRIXFi6Y2Kwy05H47u.Go0wJUkFO3c3GFbZt55dGhgleHKTbS', '89097588075', 'adminsmm@webrazavr.ru '),
(29, 'sveta.zborovskaya@gmail.com', 'Светлана', '$2y$13$C/1V85Z/hpnrxkJdl4kEveKkeyLFiNEnVO71mCxjxJr.tSYoM1V9W', '89289362119', 'sveta.zborovskaya@gmail.com'),
(30, 'djasfun@gmail.com', 'Кирилл', '$2y$13$qIrY.13wZ4nuC9J4VcfFw.v/f/RaFbnpNYqKKUcbrXVc2qdWvWZ7C', '+7(950)784-24-83', 'djasfun@gmail.com'),
(31, 'elpars@icloud.com', 'Kirill', '$2y$13$1iictM1sIiUQ1CNkWWvLDeUSGrYAz4SMl1S46B2FB0FqPgGePWIU6', '+7(965)211-12-22', 'elpars@icloud.com'),
(37, 'advose@gmail.com', 'Сергей', '$2y$13$u9SrzJRKhbmgEfRkNVURRe0X1UM2rE.zqgeZVSD2bcO.AWuhrvw5K', '+7(904)010-40-06', '');

-- --------------------------------------------------------

--
-- Структура таблицы `system_users_groups`
--

CREATE TABLE `system_users_groups` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `system_users_groups`
--

INSERT INTO `system_users_groups` (`user_id`, `group_id`) VALUES
(1, 1),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(37, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `users_balance`
--

CREATE TABLE `users_balance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `value` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_balance`
--

INSERT INTO `users_balance` (`id`, `user_id`, `value`) VALUES
(101, 1, 39600),
(113, 28, 0),
(114, 29, 0),
(115, 30, 0),
(116, 31, 18120),
(122, 37, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users_orders`
--

CREATE TABLE `users_orders` (
  `id` int(11) NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sitetype` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Оплачен: 1, Не \r\nоплачено: 0',
  `comment` text,
  `locking` int(11) DEFAULT NULL COMMENT 'Блокировка за пользователем',
  `stage` int(11) DEFAULT NULL COMMENT 'Стадия выполнения заказа: 0 - В работе, 1 - Выполнено',
  `tag` varchar(255) DEFAULT NULL COMMENT 'Тег для файлового хранилища',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `payment_type` tinyint(3) NOT NULL,
  `coast` text NOT NULL COMMENT 'Стоимость проекта'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `feedback_request`
--
ALTER TABLE `feedback_request`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `system_files`
--
ALTER TABLE `system_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `system_files_info`
--
ALTER TABLE `system_files_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_id` (`files_id`);

--
-- Индексы таблицы `system_groups`
--
ALTER TABLE `system_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `system_history`
--
ALTER TABLE `system_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_transaction_fk` (`transaction_id`);

--
-- Индексы таблицы `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `system_transactions`
--
ALTER TABLE `system_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_user_fk` (`user_id`);

--
-- Индексы таблицы `system_users`
--
ALTER TABLE `system_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`username`);

--
-- Индексы таблицы `system_users_groups`
--
ALTER TABLE `system_users_groups`
  ADD UNIQUE KEY `system_users_groups_full_index` (`group_id`,`user_id`),
  ADD KEY `system_users_groups_user_index` (`user_id`),
  ADD KEY `system_users_groups_group_index` (`group_id`);

--
-- Индексы таблицы `users_balance`
--
ALTER TABLE `users_balance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user_id`);

--
-- Индексы таблицы `users_orders`
--
ALTER TABLE `users_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `locking` (`locking`),
  ADD KEY `orders_transaction_fk` (`transaction_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `feedback_request`
--
ALTER TABLE `feedback_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `system_files`
--
ALTER TABLE `system_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT для таблицы `system_files_info`
--
ALTER TABLE `system_files_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `system_groups`
--
ALTER TABLE `system_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `system_history`
--
ALTER TABLE `system_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;

--
-- AUTO_INCREMENT для таблицы `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `system_transactions`
--
ALTER TABLE `system_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT для таблицы `system_users`
--
ALTER TABLE `system_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT для таблицы `users_balance`
--
ALTER TABLE `users_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT для таблицы `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `system_files`
--
ALTER TABLE `system_files`
  ADD CONSTRAINT `system_files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `system_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `system_files_info`
--
ALTER TABLE `system_files_info`
  ADD CONSTRAINT `system_files_info_ibfk_1` FOREIGN KEY (`files_id`) REFERENCES `system_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `system_history`
--
ALTER TABLE `system_history`
  ADD CONSTRAINT `history_transaction_fk` FOREIGN KEY (`transaction_id`) REFERENCES `system_transactions` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `system_transactions`
--
ALTER TABLE `system_transactions`
  ADD CONSTRAINT `transaction_user_fk` FOREIGN KEY (`user_id`) REFERENCES `system_users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `system_users_groups`
--
ALTER TABLE `system_users_groups`
  ADD CONSTRAINT `system_users_groups_group` FOREIGN KEY (`group_id`) REFERENCES `system_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `system_users_groups_user` FOREIGN KEY (`user_id`) REFERENCES `system_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_balance`
--
ALTER TABLE `users_balance`
  ADD CONSTRAINT `users_balance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `system_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_balance_user_` FOREIGN KEY (`user_id`) REFERENCES `system_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_orders`
--
ALTER TABLE `users_orders`
  ADD CONSTRAINT `orders_transaction_fk` FOREIGN KEY (`transaction_id`) REFERENCES `system_transactions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `system_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_orders_ibfk_2` FOREIGN KEY (`locking`) REFERENCES `system_users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
