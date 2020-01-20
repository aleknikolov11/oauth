-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2020 at 11:07 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oauth`
--

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `client_id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `client_id` int(10) NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL DEFAULT 0,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(11) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `redirect` varchar(255) DEFAULT NULL,
  `personal_access_client` tinyint(1) DEFAULT NULL,
  `password_client` tinyint(1) DEFAULT NULL,
  `revoked` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, 1, 'client_name', '$2y$10$1gTRzMeo.5.9hb.BDBfrSuHrLGJELKqdV4AjZWZ4Iq1bSmyQb5Fam', '/', 1, 1, 0, '2020-01-11 19:06:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL DEFAULT 0,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE `oauth_scopes` (
  `id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oauth_scopes`
--

INSERT INTO `oauth_scopes` (`id`) VALUES
('read');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_users`
--

CREATE TABLE `oauth_users` (
  `id` int(11) NOT NULL,
  `username` varchar(320) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oauth_users`
--

INSERT INTO `oauth_users` (`id`, `username`, `password`, `first_name`, `last_name`) VALUES
(1, 'test_user', '$2y$10$Hr7ZFo4ANwVWV93XB8R42.Z/rS/awKJhH8UIXGMDtjaMjfDRl1fhq', 'First', 'Last');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CA42527CA76ED39519EB6921BDA26CCD` (`user_id`,`client_id`),
  ADD KEY `IDX_CA42527CA76ED395` (`user_id`),
  ADD KEY `IDX_CA42527C19EB6921` (`client_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BB493F83A76ED395` (`user_id`),
  ADD KEY `IDX_BB493F8319EB6921` (`client_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_13CE81015E237E06A76ED395BDA26CCD` (`name`,`user_id`),
  ADD KEY `IDX_13CE8101A76ED395` (`user_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5AB6872CCB2688BDA26CCD` (`access_token_id`);

--
-- Indexes for table `oauth_scopes`
--
ALTER TABLE `oauth_scopes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_users`
--
ALTER TABLE `oauth_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `UNIQ_93804FF8F85E0677` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_users`
--
ALTER TABLE `oauth_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
