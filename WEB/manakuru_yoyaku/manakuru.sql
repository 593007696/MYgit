-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2020-10-01 04:42:45
-- サーバのバージョン： 10.4.13-MariaDB
-- PHP のバージョン: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `manakuru`
--
CREATE DATABASE IF NOT EXISTS `manakuru` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `manakuru`;

-- --------------------------------------------------------

--
-- テーブルの構造 `m_calendar`
--

CREATE TABLE `m_calendar` (
  `store_id` int(24) NOT NULL,
  `year` int(5) NOT NULL,
  `month` int(2) NOT NULL,
  `day` int(2) NOT NULL,
  `holiday_flg` tinyint(1) DEFAULT 0 COMMENT '0:営業 1:休日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `m_calendar`
--

INSERT INTO `m_calendar` (`store_id`, `year`, `month`, `day`, `holiday_flg`) VALUES
(1, 2020, 1, 1, 0),
(1, 2020, 1, 2, 0),
(1, 2020, 1, 3, 0),
(1, 2020, 1, 4, 1),
(1, 2020, 1, 5, 1),
(1, 2020, 1, 6, 0),
(1, 2020, 1, 7, 0),
(1, 2020, 1, 8, 0),
(1, 2020, 1, 9, 0),
(1, 2020, 1, 10, 0),
(1, 2020, 1, 11, 1),
(1, 2020, 1, 12, 1),
(1, 2020, 1, 13, 0),
(1, 2020, 1, 14, 0),
(1, 2020, 1, 15, 0),
(1, 2020, 1, 16, 0),
(1, 2020, 1, 17, 0),
(1, 2020, 1, 18, 1),
(1, 2020, 1, 19, 1),
(1, 2020, 1, 20, 0),
(1, 2020, 1, 21, 0),
(1, 2020, 1, 22, 0),
(1, 2020, 1, 23, 0),
(1, 2020, 1, 24, 0),
(1, 2020, 1, 25, 1),
(1, 2020, 1, 26, 1),
(1, 2020, 1, 27, 0),
(1, 2020, 1, 28, 0),
(1, 2020, 1, 29, 0),
(1, 2020, 1, 30, 0),
(1, 2020, 1, 31, 0),
(1, 2020, 2, 1, 1),
(1, 2020, 2, 2, 1),
(1, 2020, 2, 3, 0),
(1, 2020, 2, 4, 0),
(1, 2020, 2, 5, 0),
(1, 2020, 2, 6, 0),
(1, 2020, 2, 7, 0),
(1, 2020, 2, 8, 1),
(1, 2020, 2, 9, 1),
(1, 2020, 2, 10, 0),
(1, 2020, 2, 11, 0),
(1, 2020, 2, 12, 0),
(1, 2020, 2, 13, 0),
(1, 2020, 2, 14, 0),
(1, 2020, 2, 15, 1),
(1, 2020, 2, 16, 1),
(1, 2020, 2, 17, 0),
(1, 2020, 2, 18, 0),
(1, 2020, 2, 19, 0),
(1, 2020, 2, 20, 0),
(1, 2020, 2, 21, 0),
(1, 2020, 2, 22, 1),
(1, 2020, 2, 23, 1),
(1, 2020, 2, 24, 0),
(1, 2020, 2, 25, 0),
(1, 2020, 2, 26, 0),
(1, 2020, 2, 27, 0),
(1, 2020, 2, 28, 0),
(1, 2020, 2, 29, 1),
(1, 2020, 3, 1, 1),
(1, 2020, 3, 2, 0),
(1, 2020, 3, 3, 0),
(1, 2020, 3, 4, 0),
(1, 2020, 3, 5, 0),
(1, 2020, 3, 6, 0),
(1, 2020, 3, 7, 1),
(1, 2020, 3, 8, 1),
(1, 2020, 3, 9, 0),
(1, 2020, 3, 10, 0),
(1, 2020, 3, 11, 0),
(1, 2020, 3, 12, 0),
(1, 2020, 3, 13, 0),
(1, 2020, 3, 14, 1),
(1, 2020, 3, 15, 1),
(1, 2020, 3, 16, 0),
(1, 2020, 3, 17, 0),
(1, 2020, 3, 18, 0),
(1, 2020, 3, 19, 0),
(1, 2020, 3, 20, 0),
(1, 2020, 3, 21, 1),
(1, 2020, 3, 22, 1),
(1, 2020, 3, 23, 0),
(1, 2020, 3, 24, 0),
(1, 2020, 3, 25, 0),
(1, 2020, 3, 26, 0),
(1, 2020, 3, 27, 0),
(1, 2020, 3, 28, 1),
(1, 2020, 3, 29, 1),
(1, 2020, 3, 30, 0),
(1, 2020, 3, 31, 0),
(1, 2020, 4, 1, 0),
(1, 2020, 4, 2, 0),
(1, 2020, 4, 3, 0),
(1, 2020, 4, 4, 1),
(1, 2020, 4, 5, 1),
(1, 2020, 4, 6, 0),
(1, 2020, 4, 7, 0),
(1, 2020, 4, 8, 0),
(1, 2020, 4, 9, 0),
(1, 2020, 4, 10, 0),
(1, 2020, 4, 11, 1),
(1, 2020, 4, 12, 1),
(1, 2020, 4, 13, 0),
(1, 2020, 4, 14, 0),
(1, 2020, 4, 15, 0),
(1, 2020, 4, 16, 0),
(1, 2020, 4, 17, 0),
(1, 2020, 4, 18, 1),
(1, 2020, 4, 19, 1),
(1, 2020, 4, 20, 0),
(1, 2020, 4, 21, 0),
(1, 2020, 4, 22, 0),
(1, 2020, 4, 23, 0),
(1, 2020, 4, 24, 0),
(1, 2020, 4, 25, 1),
(1, 2020, 4, 26, 1),
(1, 2020, 4, 27, 0),
(1, 2020, 4, 28, 0),
(1, 2020, 4, 29, 0),
(1, 2020, 4, 30, 0),
(1, 2020, 5, 1, 0),
(1, 2020, 5, 2, 1),
(1, 2020, 5, 3, 1),
(1, 2020, 5, 4, 0),
(1, 2020, 5, 5, 0),
(1, 2020, 5, 6, 0),
(1, 2020, 5, 7, 0),
(1, 2020, 5, 8, 0),
(1, 2020, 5, 9, 1),
(1, 2020, 5, 10, 1),
(1, 2020, 5, 11, 0),
(1, 2020, 5, 12, 0),
(1, 2020, 5, 13, 0),
(1, 2020, 5, 14, 0),
(1, 2020, 5, 15, 0),
(1, 2020, 5, 16, 1),
(1, 2020, 5, 17, 1),
(1, 2020, 5, 18, 0),
(1, 2020, 5, 19, 0),
(1, 2020, 5, 20, 0),
(1, 2020, 5, 21, 0),
(1, 2020, 5, 22, 0),
(1, 2020, 5, 23, 1),
(1, 2020, 5, 24, 1),
(1, 2020, 5, 25, 0),
(1, 2020, 5, 26, 0),
(1, 2020, 5, 27, 0),
(1, 2020, 5, 28, 0),
(1, 2020, 5, 29, 0),
(1, 2020, 5, 30, 1),
(1, 2020, 5, 31, 1),
(1, 2020, 6, 1, 0),
(1, 2020, 6, 2, 0),
(1, 2020, 6, 3, 0),
(1, 2020, 6, 4, 0),
(1, 2020, 6, 5, 0),
(1, 2020, 6, 6, 1),
(1, 2020, 6, 7, 1),
(1, 2020, 6, 8, 0),
(1, 2020, 6, 9, 0),
(1, 2020, 6, 10, 0),
(1, 2020, 6, 11, 0),
(1, 2020, 6, 12, 0),
(1, 2020, 6, 13, 1),
(1, 2020, 6, 14, 1),
(1, 2020, 6, 15, 0),
(1, 2020, 6, 16, 0),
(1, 2020, 6, 17, 0),
(1, 2020, 6, 18, 0),
(1, 2020, 6, 19, 0),
(1, 2020, 6, 20, 1),
(1, 2020, 6, 21, 1),
(1, 2020, 6, 22, 0),
(1, 2020, 6, 23, 0),
(1, 2020, 6, 24, 0),
(1, 2020, 6, 25, 0),
(1, 2020, 6, 26, 0),
(1, 2020, 6, 27, 1),
(1, 2020, 6, 28, 1),
(1, 2020, 6, 29, 0),
(1, 2020, 6, 30, 0),
(1, 2020, 7, 1, 0),
(1, 2020, 7, 2, 0),
(1, 2020, 7, 3, 0),
(1, 2020, 7, 4, 1),
(1, 2020, 7, 5, 1),
(1, 2020, 7, 6, 0),
(1, 2020, 7, 7, 0),
(1, 2020, 7, 8, 0),
(1, 2020, 7, 9, 0),
(1, 2020, 7, 10, 0),
(1, 2020, 7, 11, 1),
(1, 2020, 7, 12, 1),
(1, 2020, 7, 13, 0),
(1, 2020, 7, 14, 0),
(1, 2020, 7, 15, 0),
(1, 2020, 7, 16, 0),
(1, 2020, 7, 17, 0),
(1, 2020, 7, 18, 1),
(1, 2020, 7, 19, 1),
(1, 2020, 7, 20, 0),
(1, 2020, 7, 21, 0),
(1, 2020, 7, 22, 0),
(1, 2020, 7, 23, 0),
(1, 2020, 7, 24, 0),
(1, 2020, 7, 25, 1),
(1, 2020, 7, 26, 1),
(1, 2020, 7, 27, 0),
(1, 2020, 7, 28, 0),
(1, 2020, 7, 29, 0),
(1, 2020, 7, 30, 0),
(1, 2020, 7, 31, 0),
(1, 2020, 8, 1, 1),
(1, 2020, 8, 2, 1),
(1, 2020, 8, 3, 0),
(1, 2020, 8, 4, 0),
(1, 2020, 8, 5, 0),
(1, 2020, 8, 6, 0),
(1, 2020, 8, 7, 0),
(1, 2020, 8, 8, 1),
(1, 2020, 8, 9, 1),
(1, 2020, 8, 10, 0),
(1, 2020, 8, 11, 0),
(1, 2020, 8, 12, 0),
(1, 2020, 8, 13, 0),
(1, 2020, 8, 14, 0),
(1, 2020, 8, 15, 1),
(1, 2020, 8, 16, 1),
(1, 2020, 8, 17, 0),
(1, 2020, 8, 18, 0),
(1, 2020, 8, 19, 0),
(1, 2020, 8, 20, 0),
(1, 2020, 8, 21, 0),
(1, 2020, 8, 22, 1),
(1, 2020, 8, 23, 1),
(1, 2020, 8, 24, 0),
(1, 2020, 8, 25, 0),
(1, 2020, 8, 26, 0),
(1, 2020, 8, 27, 0),
(1, 2020, 8, 28, 0),
(1, 2020, 8, 29, 1),
(1, 2020, 8, 30, 1),
(1, 2020, 8, 31, 0),
(1, 2020, 9, 1, 0),
(1, 2020, 9, 2, 0),
(1, 2020, 9, 3, 0),
(1, 2020, 9, 4, 0),
(1, 2020, 9, 5, 1),
(1, 2020, 9, 6, 1),
(1, 2020, 9, 7, 0),
(1, 2020, 9, 8, 0),
(1, 2020, 9, 9, 0),
(1, 2020, 9, 10, 0),
(1, 2020, 9, 11, 0),
(1, 2020, 9, 12, 1),
(1, 2020, 9, 13, 1),
(1, 2020, 9, 14, 0),
(1, 2020, 9, 15, 0),
(1, 2020, 9, 16, 0),
(1, 2020, 9, 17, 0),
(1, 2020, 9, 18, 0),
(1, 2020, 9, 19, 1),
(1, 2020, 9, 20, 1),
(1, 2020, 9, 21, 0),
(1, 2020, 9, 22, 0),
(1, 2020, 9, 23, 0),
(1, 2020, 9, 24, 0),
(1, 2020, 9, 25, 0),
(1, 2020, 9, 26, 1),
(1, 2020, 9, 27, 1),
(1, 2020, 9, 28, 0),
(1, 2020, 9, 29, 0),
(1, 2020, 9, 30, 0),
(1, 2020, 10, 1, 0),
(1, 2020, 10, 2, 0),
(1, 2020, 10, 3, 1),
(1, 2020, 10, 4, 1),
(1, 2020, 10, 5, 0),
(1, 2020, 10, 6, 0),
(1, 2020, 10, 7, 0),
(1, 2020, 10, 8, 0),
(1, 2020, 10, 9, 0),
(1, 2020, 10, 10, 1),
(1, 2020, 10, 11, 1),
(1, 2020, 10, 12, 0),
(1, 2020, 10, 13, 0),
(1, 2020, 10, 14, 0),
(1, 2020, 10, 15, 0),
(1, 2020, 10, 16, 0),
(1, 2020, 10, 17, 1),
(1, 2020, 10, 18, 1),
(1, 2020, 10, 19, 0),
(1, 2020, 10, 20, 0),
(1, 2020, 10, 21, 0),
(1, 2020, 10, 22, 0),
(1, 2020, 10, 23, 0),
(1, 2020, 10, 24, 1),
(1, 2020, 10, 25, 1),
(1, 2020, 10, 26, 0),
(1, 2020, 10, 27, 0),
(1, 2020, 10, 28, 0),
(1, 2020, 10, 29, 0),
(1, 2020, 10, 30, 0),
(1, 2020, 10, 31, 1),
(1, 2020, 11, 1, 1),
(1, 2020, 11, 2, 0),
(1, 2020, 11, 3, 0),
(1, 2020, 11, 4, 0),
(1, 2020, 11, 5, 0),
(1, 2020, 11, 6, 0),
(1, 2020, 11, 7, 1),
(1, 2020, 11, 8, 1),
(1, 2020, 11, 9, 0),
(1, 2020, 11, 10, 0),
(1, 2020, 11, 11, 0),
(1, 2020, 11, 12, 0),
(1, 2020, 11, 13, 0),
(1, 2020, 11, 14, 1),
(1, 2020, 11, 15, 1),
(1, 2020, 11, 16, 0),
(1, 2020, 11, 17, 0),
(1, 2020, 11, 18, 0),
(1, 2020, 11, 19, 0),
(1, 2020, 11, 20, 0),
(1, 2020, 11, 21, 1),
(1, 2020, 11, 22, 1),
(1, 2020, 11, 23, 0),
(1, 2020, 11, 24, 0),
(1, 2020, 11, 25, 0),
(1, 2020, 11, 26, 0),
(1, 2020, 11, 27, 0),
(1, 2020, 11, 28, 1),
(1, 2020, 11, 29, 1),
(1, 2020, 11, 30, 0),
(1, 2020, 12, 1, 0),
(1, 2020, 12, 2, 0),
(1, 2020, 12, 3, 0),
(1, 2020, 12, 4, 0),
(1, 2020, 12, 5, 1),
(1, 2020, 12, 6, 1),
(1, 2020, 12, 7, 0),
(1, 2020, 12, 8, 0),
(1, 2020, 12, 9, 0),
(1, 2020, 12, 10, 0),
(1, 2020, 12, 11, 0),
(1, 2020, 12, 12, 1),
(1, 2020, 12, 13, 1),
(1, 2020, 12, 14, 0),
(1, 2020, 12, 15, 0),
(1, 2020, 12, 16, 0),
(1, 2020, 12, 17, 0),
(1, 2020, 12, 18, 0),
(1, 2020, 12, 19, 1),
(1, 2020, 12, 20, 1),
(1, 2020, 12, 21, 0),
(1, 2020, 12, 22, 0),
(1, 2020, 12, 23, 0),
(1, 2020, 12, 24, 0),
(1, 2020, 12, 25, 0),
(1, 2020, 12, 26, 1),
(1, 2020, 12, 27, 1),
(1, 2020, 12, 28, 0),
(1, 2020, 12, 29, 0),
(1, 2020, 12, 30, 0),
(1, 2020, 12, 31, 0),
(1, 2021, 1, 1, 0),
(1, 2021, 1, 2, 1),
(1, 2021, 1, 3, 1),
(1, 2021, 1, 4, 0),
(1, 2021, 1, 5, 0),
(1, 2021, 1, 6, 0),
(1, 2021, 1, 7, 0),
(1, 2021, 1, 8, 0),
(1, 2021, 1, 9, 1),
(1, 2021, 1, 10, 1),
(1, 2021, 1, 11, 0),
(1, 2021, 1, 12, 0),
(1, 2021, 1, 13, 0),
(1, 2021, 1, 14, 0),
(1, 2021, 1, 15, 0),
(1, 2021, 1, 16, 1),
(1, 2021, 1, 17, 1),
(1, 2021, 1, 18, 0),
(1, 2021, 1, 19, 0),
(1, 2021, 1, 20, 0),
(1, 2021, 1, 21, 0),
(1, 2021, 1, 22, 0),
(1, 2021, 1, 23, 1),
(1, 2021, 1, 24, 1),
(1, 2021, 1, 25, 0),
(1, 2021, 1, 26, 0),
(1, 2021, 1, 27, 0),
(1, 2021, 1, 28, 0),
(1, 2021, 1, 29, 0),
(1, 2021, 1, 30, 1),
(1, 2021, 1, 31, 1),
(1, 2021, 2, 1, 0),
(1, 2021, 2, 2, 0),
(1, 2021, 2, 3, 0),
(1, 2021, 2, 4, 0),
(1, 2021, 2, 5, 0),
(1, 2021, 2, 6, 1),
(1, 2021, 2, 7, 1),
(1, 2021, 2, 8, 0),
(1, 2021, 2, 9, 0),
(1, 2021, 2, 10, 0),
(1, 2021, 2, 11, 0),
(1, 2021, 2, 12, 0),
(1, 2021, 2, 13, 1),
(1, 2021, 2, 14, 1),
(1, 2021, 2, 15, 0),
(1, 2021, 2, 16, 0),
(1, 2021, 2, 17, 0),
(1, 2021, 2, 18, 0),
(1, 2021, 2, 19, 0),
(1, 2021, 2, 20, 1),
(1, 2021, 2, 21, 1),
(1, 2021, 2, 22, 0),
(1, 2021, 2, 23, 0),
(1, 2021, 2, 24, 0),
(1, 2021, 2, 25, 0),
(1, 2021, 2, 26, 0),
(1, 2021, 2, 27, 1),
(1, 2021, 2, 28, 1),
(1, 2021, 3, 1, 0),
(1, 2021, 3, 2, 0),
(1, 2021, 3, 3, 0),
(1, 2021, 3, 4, 0),
(1, 2021, 3, 5, 0),
(1, 2021, 3, 6, 1),
(1, 2021, 3, 7, 1),
(1, 2021, 3, 8, 0),
(1, 2021, 3, 9, 0),
(1, 2021, 3, 10, 0),
(1, 2021, 3, 11, 0),
(1, 2021, 3, 12, 0),
(1, 2021, 3, 13, 1),
(1, 2021, 3, 14, 1),
(1, 2021, 3, 15, 0),
(1, 2021, 3, 16, 0),
(1, 2021, 3, 17, 0),
(1, 2021, 3, 18, 0),
(1, 2021, 3, 19, 0),
(1, 2021, 3, 20, 1),
(1, 2021, 3, 21, 1),
(1, 2021, 3, 22, 0),
(1, 2021, 3, 23, 0),
(1, 2021, 3, 24, 0),
(1, 2021, 3, 25, 0),
(1, 2021, 3, 26, 0),
(1, 2021, 3, 27, 1),
(1, 2021, 3, 28, 1),
(1, 2021, 3, 29, 0),
(1, 2021, 3, 30, 0),
(1, 2021, 3, 31, 0),
(1, 2021, 4, 1, 0),
(1, 2021, 4, 2, 0),
(1, 2021, 4, 3, 1),
(1, 2021, 4, 4, 1),
(1, 2021, 4, 5, 0),
(1, 2021, 4, 6, 0),
(1, 2021, 4, 7, 0),
(1, 2021, 4, 8, 0),
(1, 2021, 4, 9, 0),
(1, 2021, 4, 10, 1),
(1, 2021, 4, 11, 1),
(1, 2021, 4, 12, 0),
(1, 2021, 4, 13, 0),
(1, 2021, 4, 14, 0),
(1, 2021, 4, 15, 0),
(1, 2021, 4, 16, 0),
(1, 2021, 4, 17, 1),
(1, 2021, 4, 18, 1),
(1, 2021, 4, 19, 0),
(1, 2021, 4, 20, 0),
(1, 2021, 4, 21, 0),
(1, 2021, 4, 22, 0),
(1, 2021, 4, 23, 0),
(1, 2021, 4, 24, 1),
(1, 2021, 4, 25, 1),
(1, 2021, 4, 26, 0),
(1, 2021, 4, 27, 0),
(1, 2021, 4, 28, 0),
(1, 2021, 4, 29, 0),
(1, 2021, 4, 30, 0),
(1, 2021, 5, 1, 1),
(1, 2021, 5, 2, 1),
(1, 2021, 5, 3, 0),
(1, 2021, 5, 4, 0),
(1, 2021, 5, 5, 0),
(1, 2021, 5, 6, 0),
(1, 2021, 5, 7, 0),
(1, 2021, 5, 8, 1),
(1, 2021, 5, 9, 1),
(1, 2021, 5, 10, 0),
(1, 2021, 5, 11, 0),
(1, 2021, 5, 12, 0),
(1, 2021, 5, 13, 0),
(1, 2021, 5, 14, 0),
(1, 2021, 5, 15, 1),
(1, 2021, 5, 16, 1),
(1, 2021, 5, 17, 0),
(1, 2021, 5, 18, 0),
(1, 2021, 5, 19, 0),
(1, 2021, 5, 20, 0),
(1, 2021, 5, 21, 0),
(1, 2021, 5, 22, 1),
(1, 2021, 5, 23, 1),
(1, 2021, 5, 24, 0),
(1, 2021, 5, 25, 0),
(1, 2021, 5, 26, 0),
(1, 2021, 5, 27, 0),
(1, 2021, 5, 28, 0),
(1, 2021, 5, 29, 1),
(1, 2021, 5, 30, 1),
(1, 2021, 5, 31, 0),
(1, 2021, 6, 1, 0),
(1, 2021, 6, 2, 0),
(1, 2021, 6, 3, 0),
(1, 2021, 6, 4, 0),
(1, 2021, 6, 5, 1),
(1, 2021, 6, 6, 1),
(1, 2021, 6, 7, 0),
(1, 2021, 6, 8, 0),
(1, 2021, 6, 9, 0),
(1, 2021, 6, 10, 0),
(1, 2021, 6, 11, 0),
(1, 2021, 6, 12, 1),
(1, 2021, 6, 13, 1),
(1, 2021, 6, 14, 0),
(1, 2021, 6, 15, 0),
(1, 2021, 6, 16, 0),
(1, 2021, 6, 17, 0),
(1, 2021, 6, 18, 0),
(1, 2021, 6, 19, 1),
(1, 2021, 6, 20, 1),
(1, 2021, 6, 21, 0),
(1, 2021, 6, 22, 0),
(1, 2021, 6, 23, 0),
(1, 2021, 6, 24, 0),
(1, 2021, 6, 25, 0),
(1, 2021, 6, 26, 1),
(1, 2021, 6, 27, 1),
(1, 2021, 6, 28, 0),
(1, 2021, 6, 29, 0),
(1, 2021, 6, 30, 0),
(1, 2021, 7, 1, 0),
(1, 2021, 7, 2, 0),
(1, 2021, 7, 3, 1),
(1, 2021, 7, 4, 1),
(1, 2021, 7, 5, 0),
(1, 2021, 7, 6, 0),
(1, 2021, 7, 7, 0),
(1, 2021, 7, 8, 0),
(1, 2021, 7, 9, 0),
(1, 2021, 7, 10, 1),
(1, 2021, 7, 11, 1),
(1, 2021, 7, 12, 0),
(1, 2021, 7, 13, 0),
(1, 2021, 7, 14, 0),
(1, 2021, 7, 15, 0),
(1, 2021, 7, 16, 0),
(1, 2021, 7, 17, 1),
(1, 2021, 7, 18, 1),
(1, 2021, 7, 19, 0),
(1, 2021, 7, 20, 0),
(1, 2021, 7, 21, 0),
(1, 2021, 7, 22, 0),
(1, 2021, 7, 23, 0),
(1, 2021, 7, 24, 1),
(1, 2021, 7, 25, 1),
(1, 2021, 7, 26, 0),
(1, 2021, 7, 27, 0),
(1, 2021, 7, 28, 0),
(1, 2021, 7, 29, 0),
(1, 2021, 7, 30, 0),
(1, 2021, 7, 31, 1),
(1, 2021, 8, 1, 1),
(1, 2021, 8, 2, 0),
(1, 2021, 8, 3, 0),
(1, 2021, 8, 4, 0),
(1, 2021, 8, 5, 0),
(1, 2021, 8, 6, 0),
(1, 2021, 8, 7, 1),
(1, 2021, 8, 8, 1),
(1, 2021, 8, 9, 0),
(1, 2021, 8, 10, 0),
(1, 2021, 8, 11, 0),
(1, 2021, 8, 12, 0),
(1, 2021, 8, 13, 0),
(1, 2021, 8, 14, 1),
(1, 2021, 8, 15, 1),
(1, 2021, 8, 16, 0),
(1, 2021, 8, 17, 0),
(1, 2021, 8, 18, 0),
(1, 2021, 8, 19, 0),
(1, 2021, 8, 20, 0),
(1, 2021, 8, 21, 1),
(1, 2021, 8, 22, 1),
(1, 2021, 8, 23, 0),
(1, 2021, 8, 24, 0),
(1, 2021, 8, 25, 0),
(1, 2021, 8, 26, 0),
(1, 2021, 8, 27, 0),
(1, 2021, 8, 28, 1),
(1, 2021, 8, 29, 1),
(1, 2021, 8, 30, 0),
(1, 2021, 8, 31, 0),
(1, 2021, 9, 1, 0),
(1, 2021, 9, 2, 0),
(1, 2021, 9, 3, 0),
(1, 2021, 9, 4, 1),
(1, 2021, 9, 5, 1),
(1, 2021, 9, 6, 0),
(1, 2021, 9, 7, 0),
(1, 2021, 9, 8, 0),
(1, 2021, 9, 9, 0),
(1, 2021, 9, 10, 0),
(1, 2021, 9, 11, 1),
(1, 2021, 9, 12, 1),
(1, 2021, 9, 13, 0),
(1, 2021, 9, 14, 0),
(1, 2021, 9, 15, 0),
(1, 2021, 9, 16, 0),
(1, 2021, 9, 17, 0),
(1, 2021, 9, 18, 1),
(1, 2021, 9, 19, 1),
(1, 2021, 9, 20, 0),
(1, 2021, 9, 21, 0),
(1, 2021, 9, 22, 0),
(1, 2021, 9, 23, 0),
(1, 2021, 9, 24, 0),
(1, 2021, 9, 25, 1),
(1, 2021, 9, 26, 1),
(1, 2021, 9, 27, 0),
(1, 2021, 9, 28, 0),
(1, 2021, 9, 29, 0),
(1, 2021, 9, 30, 0),
(1, 2021, 10, 1, 0),
(1, 2021, 10, 2, 1),
(1, 2021, 10, 3, 1),
(1, 2021, 10, 4, 0),
(1, 2021, 10, 5, 0),
(1, 2021, 10, 6, 0),
(1, 2021, 10, 7, 0),
(1, 2021, 10, 8, 0),
(1, 2021, 10, 9, 1),
(1, 2021, 10, 10, 1),
(1, 2021, 10, 11, 0),
(1, 2021, 10, 12, 0),
(1, 2021, 10, 13, 0),
(1, 2021, 10, 14, 0),
(1, 2021, 10, 15, 0),
(1, 2021, 10, 16, 1),
(1, 2021, 10, 17, 1),
(1, 2021, 10, 18, 0),
(1, 2021, 10, 19, 0),
(1, 2021, 10, 20, 0),
(1, 2021, 10, 21, 0),
(1, 2021, 10, 22, 0),
(1, 2021, 10, 23, 1),
(1, 2021, 10, 24, 1),
(1, 2021, 10, 25, 0),
(1, 2021, 10, 26, 0),
(1, 2021, 10, 27, 0),
(1, 2021, 10, 28, 0),
(1, 2021, 10, 29, 0),
(1, 2021, 10, 30, 1),
(1, 2021, 10, 31, 1),
(1, 2021, 11, 1, 0),
(1, 2021, 11, 2, 0),
(1, 2021, 11, 3, 0),
(1, 2021, 11, 4, 0),
(1, 2021, 11, 5, 0),
(1, 2021, 11, 6, 1),
(1, 2021, 11, 7, 1),
(1, 2021, 11, 8, 0),
(1, 2021, 11, 9, 0),
(1, 2021, 11, 10, 0),
(1, 2021, 11, 11, 0),
(1, 2021, 11, 12, 0),
(1, 2021, 11, 13, 1),
(1, 2021, 11, 14, 1),
(1, 2021, 11, 15, 0),
(1, 2021, 11, 16, 0),
(1, 2021, 11, 17, 0),
(1, 2021, 11, 18, 0),
(1, 2021, 11, 19, 0),
(1, 2021, 11, 20, 1),
(1, 2021, 11, 21, 1),
(1, 2021, 11, 22, 0),
(1, 2021, 11, 23, 0),
(1, 2021, 11, 24, 0),
(1, 2021, 11, 25, 0),
(1, 2021, 11, 26, 0),
(1, 2021, 11, 27, 1),
(1, 2021, 11, 28, 1),
(1, 2021, 11, 29, 0),
(1, 2021, 11, 30, 0),
(1, 2021, 12, 1, 0),
(1, 2021, 12, 2, 0),
(1, 2021, 12, 3, 0),
(1, 2021, 12, 4, 1),
(1, 2021, 12, 5, 1),
(1, 2021, 12, 6, 0),
(1, 2021, 12, 7, 0),
(1, 2021, 12, 8, 0),
(1, 2021, 12, 9, 0),
(1, 2021, 12, 10, 0),
(1, 2021, 12, 11, 1),
(1, 2021, 12, 12, 1),
(1, 2021, 12, 13, 0),
(1, 2021, 12, 14, 0),
(1, 2021, 12, 15, 0),
(1, 2021, 12, 16, 0),
(1, 2021, 12, 17, 0),
(1, 2021, 12, 18, 1),
(1, 2021, 12, 19, 1),
(1, 2021, 12, 20, 0),
(1, 2021, 12, 21, 0),
(1, 2021, 12, 22, 0),
(1, 2021, 12, 23, 0),
(1, 2021, 12, 24, 0),
(1, 2021, 12, 25, 1),
(1, 2021, 12, 26, 1),
(1, 2021, 12, 27, 0),
(1, 2021, 12, 28, 0),
(1, 2021, 12, 29, 0),
(1, 2021, 12, 30, 0),
(1, 2021, 12, 31, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `m_member`
--

CREATE TABLE `m_member` (
  `store_id` int(2) NOT NULL,
  `member_id` char(10) NOT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `sei` varchar(20) DEFAULT NULL,
  `mei` varchar(20) DEFAULT NULL,
  `gender` int(1) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `zipcode1` char(3) DEFAULT NULL,
  `zipcode2` char(4) DEFAULT NULL,
  `prefectures` varchar(10) DEFAULT NULL,
  `ward` varchar(10) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `tel` varchar(13) DEFAULT NULL,
  `job` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `withdrawal_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `m_room`
--

CREATE TABLE `m_room` (
  `store_id` int(2) NOT NULL COMMENT '店舗番号',
  `room_id` int(2) NOT NULL COMMENT '部屋番号',
  `room_name` varchar(50) NOT NULL COMMENT '部屋名',
  `seat` tinyint(2) UNSIGNED NOT NULL COMMENT '席',
  `loan` tinyint(1) NOT NULL COMMENT '貸出可否',
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `m_room`
--

INSERT INTO `m_room` (`store_id`, `room_id`, `room_name`, `seat`, `loan`, `updated_date`) VALUES
(1, 1, '亜', 1, 1, '2020-09-30 07:27:50'),
(1, 2, '伊', 4, 1, '2020-09-30 07:38:58');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_service`
--

CREATE TABLE `m_service` (
  `store_id` int(2) NOT NULL COMMENT '店舗ID',
  `service_id` int(3) NOT NULL COMMENT 'サービスID',
  `service_name` varchar(50) DEFAULT NULL COMMENT 'サービス名(大項目)',
  `service_title` varchar(50) DEFAULT NULL COMMENT '講座名/職種',
  `service_time` int(5) DEFAULT NULL COMMENT '時間',
  `service_flg` tinyint(1) NOT NULL DEFAULT 0,
  `yoyaku_flg` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1:予約可 0:予約なし',
  `open_flg` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状態フラグ 開始:1 停止:0',
  `frequency` int(7) DEFAULT NULL COMMENT 'コマ数',
  `month` varchar(10) NOT NULL COMMENT '月数',
  `max_cnt` int(20) NOT NULL,
  `target` varchar(20) DEFAULT NULL COMMENT '対象者',
  `overview` text DEFAULT NULL COMMENT '概要',
  `price` int(7) NOT NULL COMMENT '料金',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '登録日時',
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `m_service_detail`
--

CREATE TABLE `m_service_detail` (
  `store_id` int(2) NOT NULL COMMENT '店舗ID',
  `service_id` int(3) NOT NULL COMMENT 'サービスID',
  `no` int(3) NOT NULL COMMENT '回数',
  `service_detail_name` varchar(30) NOT NULL COMMENT '講座名/職種',
  `service_detail_content` text NOT NULL COMMENT '内容',
  `service_detail_time` int(4) NOT NULL COMMENT '時間(分)',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '登録日時',
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `m_store`
--

CREATE TABLE `m_store` (
  `store_id` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT '店舗番号',
  `store_name` varchar(20) NOT NULL COMMENT '店舗名',
  `store_nearest_station` varchar(20) NOT NULL COMMENT '最寄駅',
  `zipcode1` char(3) NOT NULL COMMENT '郵便番号上三位',
  `zipcode2` char(4) NOT NULL COMMENT '郵便番号下四位',
  `prefectures` varchar(10) NOT NULL COMMENT '都道府県',
  `ward` varchar(10) NOT NULL COMMENT '区/市/町/村',
  `address` varchar(100) NOT NULL COMMENT '住所',
  `store_telephone_number` varchar(12) NOT NULL COMMENT '電話番号',
  `store_fax_number` varchar(12) DEFAULT NULL COMMENT 'FAX',
  `store_url` text NOT NULL COMMENT 'グーグルマップ',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '登録日時',
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `m_store`
--

INSERT INTO `m_store` (`store_id`, `store_name`, `store_nearest_station`, `zipcode1`, `zipcode2`, `prefectures`, `ward`, `address`, `store_telephone_number`, `store_fax_number`, `store_url`, `created_date`, `updated_date`) VALUES
(01, 'まなクル矢切店', '矢切駅', '271', '0097', '千葉県', '松戸市栗山', '31-1栗山平城苑ビル３階', '1234567890', '1234567890', '                                https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3237.7673486081094!2d139.8970675146558!3d35.75652268017681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188585537c1197%3A0xe21e6ebe904e7e88!2z44G-44Gq44Kv44Or!5e0!3m2!1sja!2sjp!4v1594002920679!5m2!1sja!2sjp\r\n                                ', '2020-07-08 02:43:26', '2020-09-10 06:30:21'),
(02, 'まなクル矢切店', '11', '1', '1', '111', '1', '1', '11111111111', '11111111111', '', '2020-09-30 00:49:54', '2020-09-30 07:50:48');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_systemuser`
--

CREATE TABLE `m_systemuser` (
  `staff_id` varchar(50) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `gender` int(1) NOT NULL COMMENT '1:男性 2:女性 3:その他',
  `birthday` date NOT NULL,
  `age` int(3) NOT NULL,
  `date_company` date NOT NULL,
  `syozoku_store_id` int(2) NOT NULL,
  `type_employment` int(1) NOT NULL COMMENT '1:社員 2:パート 3:その他',
  `role` int(1) NOT NULL COMMENT '1:管理者 2:講師 3:受付 9:その他',
  `teacher` tinyint(1) NOT NULL COMMENT '0:講師不可 1:講師可',
  `zipcode1` char(3) NOT NULL,
  `zipcode2` char(4) NOT NULL,
  `prefectures` varchar(10) NOT NULL,
  `ward` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `tel` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `delete_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `m_systemuser`
--

INSERT INTO `m_systemuser` (`staff_id`, `last_name`, `first_name`, `gender`, `birthday`, `age`, `date_company`, `syozoku_store_id`, `type_employment`, `role`, `teacher`, `zipcode1`, `zipcode2`, `prefectures`, `ward`, `address`, `tel`, `email`, `password`, `create_date`, `update_date`, `delete_date`) VALUES
('SE000', '茉奈', '久瑠', 9, '2020-04-01', 0, '2020-04-01', 1, 1, 1, 1, '271', '0097', '千葉県', '松戸市', '栗山 ３１－１ 栗山平城苑ビル３階', '0473825521', 'manakuru@j-tec-cor.net', '$2y$10$Qd4qWS5zzvOBjCBmweext.QZUYVlNRS6pKTXmuL0OCvjxW1jbLjTC', '2020-08-03 09:45:30', '2020-09-29 16:14:19', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_member_service`
--

CREATE TABLE `t_member_service` (
  `store_id` int(2) NOT NULL COMMENT '店舗マスタより取得',
  `service_start_id` int(4) NOT NULL,
  `member_id` char(10) NOT NULL COMMENT '会員様のID',
  `attendance_date` date NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `t_member_service_detail`
--

CREATE TABLE `t_member_service_detail` (
  `store_id` int(2) NOT NULL,
  `service_start_id` int(4) NOT NULL,
  `service_nth_detail` int(4) NOT NULL,
  `service_nth_detail_sub` int(3) NOT NULL,
  `member_id` char(10) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `yoyaku_flg` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:予約なし 1:予約あり',
  `attend_flg` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0:欠席 1:出席',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `t_service_set`
--

CREATE TABLE `t_service_set` (
  `store_id` int(2) NOT NULL COMMENT '店舗番号',
  `service_start_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'サービス開始ID',
  `start_day` date NOT NULL COMMENT 'サービス開始日',
  `end_day` date NOT NULL COMMENT 'サービス終了日',
  `service_id` int(3) NOT NULL COMMENT 'サービスID',
  `service_reserve_flag` tinyint(1) NOT NULL COMMENT '予約フラグ',
  `start_time_base` time NOT NULL COMMENT '開始時間（基本）',
  `end_time_base` time NOT NULL COMMENT '終了時間（基本）',
  `room_id` int(2) NOT NULL,
  `teacher_base` varchar(50) NOT NULL COMMENT '講師（基本）',
  `note` text NOT NULL COMMENT '備考',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '登録日時',
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `t_service_set_detail`
--

CREATE TABLE `t_service_set_detail` (
  `store_id` int(2) NOT NULL COMMENT '店舗番号',
  `service_start_id` int(4) NOT NULL COMMENT 'サービス開始ID',
  `service_nth` int(4) NOT NULL COMMENT 'サービス回',
  `service_nth_sub` int(3) NOT NULL COMMENT '行う回数',
  `service_day_detail` date NOT NULL COMMENT 'サービス実施日',
  `start_time_detail` time NOT NULL COMMENT '開始時間（詳細）',
  `end_time_detail` time NOT NULL COMMENT '終了時間（詳細）',
  `room_id` int(2) NOT NULL,
  `teacher_detail` varchar(50) NOT NULL COMMENT '講師（詳細）',
  `note` text NOT NULL COMMENT '備考',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '登録日時',
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `m_calendar`
--
ALTER TABLE `m_calendar`
  ADD PRIMARY KEY (`store_id`,`year`,`month`,`day`);

--
-- テーブルのインデックス `m_member`
--
ALTER TABLE `m_member`
  ADD PRIMARY KEY (`store_id`,`member_id`);

--
-- テーブルのインデックス `m_room`
--
ALTER TABLE `m_room`
  ADD PRIMARY KEY (`store_id`,`room_id`) USING BTREE;

--
-- テーブルのインデックス `m_service`
--
ALTER TABLE `m_service`
  ADD PRIMARY KEY (`store_id`,`service_id`);

--
-- テーブルのインデックス `m_service_detail`
--
ALTER TABLE `m_service_detail`
  ADD PRIMARY KEY (`service_id`);

--
-- テーブルのインデックス `m_store`
--
ALTER TABLE `m_store`
  ADD PRIMARY KEY (`store_id`);

--
-- テーブルのインデックス `m_systemuser`
--
ALTER TABLE `m_systemuser`
  ADD PRIMARY KEY (`staff_id`);

--
-- テーブルのインデックス `t_member_service`
--
ALTER TABLE `t_member_service`
  ADD PRIMARY KEY (`member_id`,`service_start_id`,`store_id`);

--
-- テーブルのインデックス `t_member_service_detail`
--
ALTER TABLE `t_member_service_detail`
  ADD PRIMARY KEY (`store_id`,`service_start_id`,`service_nth_detail`,`service_nth_detail_sub`);

--
-- テーブルのインデックス `t_service_set`
--
ALTER TABLE `t_service_set`
  ADD PRIMARY KEY (`store_id`,`service_start_id`);

--
-- テーブルのインデックス `t_service_set_detail`
--
ALTER TABLE `t_service_set_detail`
  ADD PRIMARY KEY (`store_id`,`service_start_id`,`service_nth`,`service_nth_sub`);
--
-- データベース: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin DEFAULT NULL,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `settings_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `template_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- テーブルのデータのダンプ `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"manakuru\",\"table\":\"m_member\"},{\"db\":\"manakuru\",\"table\":\"m_room\"},{\"db\":\"manakuru\",\"table\":\"m_service\"},{\"db\":\"manakuru\",\"table\":\"m_service_detail\"},{\"db\":\"manakuru\",\"table\":\"t_service_set_detail\"},{\"db\":\"manakuru\",\"table\":\"t_service_set\"},{\"db\":\"manakuru\",\"table\":\"t_member_service_detail\"},{\"db\":\"manakuru\",\"table\":\"t_member_service\"},{\"db\":\"manakuru\",\"table\":\"m_systemuser\"},{\"db\":\"manakuru\",\"table\":\"m_store\"}]');

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- テーブルのデータのダンプ `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'manakuru', 'm_member', '{\"sorted_col\":\"`m_member`.`withdrawal_date`  ASC\"}', '2020-09-29 00:53:27'),
('root', 'manakuru', 'm_service', '{\"sorted_col\":\"`m_service`.`store_id` ASC\"}', '2020-09-09 01:05:40'),
('root', 'manakuru', 't_member_service_detail', '[]', '2020-09-14 07:48:34'),
('root', 'manakuru', 't_service_set_detail', '{\"sorted_col\":\"`t_service_set_detail`.`start_time_detail`  ASC\"}', '2020-09-15 07:50:39');

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin DEFAULT NULL,
  `data_sql` longtext COLLATE utf8_bin DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- テーブルのデータのダンプ `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2020-10-01 02:40:07', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"ja\"}');

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- テーブルの構造 `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- テーブルのインデックス `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- テーブルのインデックス `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- テーブルのインデックス `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- テーブルのインデックス `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- テーブルのインデックス `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- テーブルのインデックス `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- テーブルのインデックス `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- テーブルのインデックス `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- テーブルのインデックス `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- テーブルのインデックス `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- テーブルのインデックス `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- テーブルのインデックス `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- テーブルのインデックス `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- テーブルのインデックス `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- テーブルのインデックス `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- テーブルのインデックス `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- テーブルのインデックス `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- データベース: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
