-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2025 at 06:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Fashion', 'ini adalah kategori fashion', '2025-07-15 20:17:06', '2025-07-15 20:17:06'),
(2, 'Elektronics', 'ini adalah kategori elektronik', '2025-07-15 20:17:34', '2025-07-15 20:17:34'),
(3, 'Footwear', 'Ini adalah kategori Footwear', '2025-07-15 20:17:53', '2025-07-15 20:17:53'),
(4, 'Accessoris', 'Ini adalah kategori Accessoris', '2025-07-15 20:18:15', '2025-07-15 20:18:15');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(11, '2014_10_12_000000_create_users_table', 1),
(12, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(13, '2019_08_19_000000_create_failed_jobs_table', 1),
(14, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(15, '2025_07_15_105647_create_categories_table', 1),
(16, '2025_07_15_105648_create_carts_table', 1),
(17, '2025_07_15_105648_create_products_table', 1),
(18, '2025_07_15_105649_create_orders_table', 1),
(19, '2025_07_15_105653_create_order_items_table', 1),
(20, '2025_07_15_164515_create_payments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `city`, `postal_code`, `payment_method`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 10765000.00, 'pending', '2025-07-15 20:11:13', '2025-07-15 20:11:13'),
(2, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 0.00, 'pending', '2025-07-15 20:13:20', '2025-07-15 20:13:20'),
(3, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 0.00, 'pending', '2025-07-15 20:14:01', '2025-07-15 20:14:01'),
(4, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 0.00, 'pending', '2025-07-15 20:14:29', '2025-07-15 20:14:29'),
(5, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 0.00, 'pending', '2025-07-15 20:14:59', '2025-07-15 20:14:59'),
(6, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 0.00, 'pending', '2025-07-15 20:15:09', '2025-07-15 20:15:09'),
(7, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 345000.00, 'pending', '2025-07-15 20:27:41', '2025-07-15 20:27:41'),
(8, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 270000.00, 'pending', '2025-07-15 20:30:43', '2025-07-15 20:30:43'),
(9, NULL, 'Auni Ulil Qisty', 'afyacraft@gmail.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 455000.00, 'pending', '2025-07-15 20:34:48', '2025-07-15 20:34:48'),
(10, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 350000.00, 'pending', '2025-07-15 20:47:28', '2025-07-15 20:47:28'),
(11, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 500000.00, 'pending', '2025-07-15 20:58:33', '2025-07-15 20:58:33'),
(12, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'e_wallet', 150000.00, 'pending', '2025-07-15 20:59:12', '2025-07-15 20:59:12'),
(13, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 150000.00, 'pending', '2025-07-15 21:05:41', '2025-07-15 21:05:41'),
(14, NULL, 'Auni Ulil Qisty', 'afya@example.com', '085889307500', 'jl.pringgondani no.22', 'Kota Jakarta Selatan', '12450', 'bank_transfer', 150000.00, 'pending', '2025-07-15 21:07:34', '2025-07-15 21:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `category_id`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Kaos Polos Hitam', 'Kaos katun nyaman dan adem', 75000.00, 20, 1, 'products/cZ6JwGL920R2Ku0k9fxlw1tRslVkGeqt053KUiAQ.jpg', '2025-07-15 20:20:33', '2025-07-15 20:20:33'),
(2, 'Sepatu Sneakers X', 'Sepatu ringan untuk aktivitas', 350000.00, 10, 3, 'products/Lr9Ja4yDpij2gFBe7WWCPruWa0WMn7zzXnf332ix.jpg', '2025-07-15 20:24:31', '2025-07-15 20:24:31'),
(3, 'Jam Tangan Classic', 'Jam tangan analog kulit asli', 150000.00, 15, 4, 'products/p1zxjn8kxg4OdNqZZM0hIwsgBhSomBwvC6kAHynK.jpg', '2025-07-15 20:25:17', '2025-07-15 20:25:17'),
(4, 'Hoodie Oversize', 'Hoodie bahan fleece tebal', 120000.00, 8, 2, 'products/H2IJMFnpfUL9dt0pm7llHiL1r5taxpGoJ7X4yeHZ.jpg', '2025-07-15 20:25:55', '2025-07-15 20:25:55'),
(5, 'Headphone Bass HD', 'Headphone suara jernih dan bass', 230000.00, 12, 2, 'products/fJIBduHMsIrw7pMx3jWS0zybDNfTZ4Oh3e36MTA1.jpg', '2025-07-15 20:26:30', '2025-07-15 20:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
