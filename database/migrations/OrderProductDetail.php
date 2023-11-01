-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2023 at 10:19 PM
-- Server version: 8.0.35-0ubuntu0.22.04.1
-- PHP Version: 8.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `kikas_designs`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_product_details`
--

DROP TABLE IF EXISTS `order_product_details`;
CREATE TABLE `order_product_details` (
`id` bigint UNSIGNED NOT NULL,
`order_id` int NOT NULL,
`catalog_product_id` int NOT NULL,
`quantity` int DEFAULT NULL,
`unit_cost` decimal(12,4) DEFAULT '0.0000',
`unit_taxes` decimal(12,4) DEFAULT '0.0000',
`unit_profit` decimal(12,4) DEFAULT '0.0000',
`unit_price` decimal(12,4) DEFAULT '0.0000',
`unit_subtotal` decimal(12,4) DEFAULT '0.0000',
`cost` decimal(12,4) DEFAULT '0.0000',
`taxes` decimal(12,4) DEFAULT '0.0000',
`profit` decimal(12,4) DEFAULT '0.0000',
`price` decimal(12,4) DEFAULT '0.0000',
`subtotal` decimal(12,4) DEFAULT '0.0000',
`profit_margin` float(3,3) DEFAULT NULL,
`mfg_preview_image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
`mfg_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
`mfg_status` enum('not_needed','working','ready','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'not_needed',
`mfg_device_id` int DEFAULT NULL,
`mfg_status_ready_at` datetime DEFAULT NULL,
`mfg_status_ready_by` int DEFAULT NULL,
`mfg_media_id_needed` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'no',
`mfg_media_id_exists` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'no',
`mfg_media_id_exists_at` datetime DEFAULT NULL,
`created_by` int DEFAULT NULL,
`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_product_details`
--
ALTER TABLE `order_product_details`
ADD PRIMARY KEY (`id`),
ADD KEY `order_id` (`order_id`),
ADD KEY `catalog_product_id` (`catalog_product_id`),
ADD KEY `created_by` (`created_by`),
ADD KEY `created_at` (`created_at`),
ADD KEY `updated_at` (`updated_at`),
ADD KEY `mfg_media_id_exists_at` (`mfg_media_id_exists_at`),
ADD KEY `mfg_statys_ready_by` (`mfg_status_ready_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_product_details`
--
ALTER TABLE `order_product_details`
MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
