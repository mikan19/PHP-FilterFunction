CREATE DATABASE IF NOT EXISTS tq_filter;

USE tq_filter;

-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql
-- 生成日時: 2021 年 2 月 04 日 05:05
-- サーバのバージョン： 5.7.32-log
-- PHP のバージョン: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `tq_filter`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `pages`
--

CREATE TABLE `pages`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '管理番号',
    `name`       varchar(255) NOT NULL COMMENT 'メモ名',
    `contents`   text NOT NULL COMMENT 'メモ内容',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='カテゴリ情報';

--
-- テストデータ
--

INSERT INTO `pages`(`name`, `contents`, `created_at`) VALUES
('ナムルの作り方', '①もやしを茹でる②胡麻油、鶏ガラ、塩をもやしにかける', '2022-04-11 02:13:06'),
('ビビンバの作り方', '①米、野菜、肉などを盛り付ける②コチュジャンと蜂蜜を混ぜたソースをかける', '2022-04-12 02:13:00'),
('生ハムの作り方', '①塩漬けして水抜きする②塩を洗い乾燥させる③薄くきる', '2022-04-13 02:13:34'),
('ナムル', 'うまい', '2022-04-12 02:13:00'),
('ビビンバ', 'うまい', '2022-04-12 02:13:00'),
('生ハム', 'うまい', '2022-04-13 02:13:34'),
('餃子', 'うまい', '2022-04-13 02:13:00'),
('寿司', 'うまい', '2022-04-13 02:13:00'),
('ラーメン', 'うまい', '2022-04-13 02:13:34');

-- --------------------------------------------------------

