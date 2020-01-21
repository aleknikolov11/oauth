-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2020 at 11:07 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

--
-- Database: `oauth`
--

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) PRIMARY KEY NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `client_id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text,
  `revoked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `expires_at` datetime NOT NULL
);

CREATE INDEX `IDX_CA42527CA76ED39519EB6921BDA26CCD` ON oauth_access_tokens (`user_id`,`client_id`);
CREATE INDEX `IDX_CA42527CA76ED395` ON oauth_access_tokens (`user_id`);
CREATE INDEX `IDX_CA42527C19EB6921` ON oauth_access_tokens (`client_id`);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) PRIMARY KEY NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `client_id` int(10) NOT NULL,
  `scopes` text,
  `revoked` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` datetime DEFAULT NULL
);

CREATE INDEX `IDX_BB493F83A76ED395` ON oauth_auth_codes (`user_id`);
CREATE INDEX `IDX_BB493F8319EB6921` ON oauth_auth_codes (`client_id`);
-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `redirect` varchar(255) DEFAULT NULL,
  `personal_access_client` tinyint(1) DEFAULT NULL,
  `password_client` tinyint(1) DEFAULT NULL,
  `revoked` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
);

CREATE INDEX `IDX_13CE81015E237E06A76ED395BDA26CCD` ON oauth_clients (`name`,`user_id`);
CREATE INDEX `IDX_13CE8101A76ED395` ON oauth_clients (`user_id`);
--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`name`, `secret`, `redirect`, `personal_access_client`, `password_client`) VALUES
('client_name', '$2y$10$1gTRzMeo.5.9hb.BDBfrSuHrLGJELKqdV4AjZWZ4Iq1bSmyQb5Fam', '/', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) PRIMARY KEY NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` datetime NOT NULL
);

CREATE INDEX `IDX_5AB6872CCB2688BDA26CCD` ON oauth_refresh_tokens (`access_token_id`);
-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE `oauth_scopes` (
  `id` varchar(100) PRIMARY KEY NOT NULL
);

--
-- Dumping data for table `oauth_scopes`
--

INSERT INTO `oauth_scopes` (`id`) VALUES
('read');
INSERT INTO `oauth_scopes` (`id`) VALUES
('write');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_users`
--

CREATE TABLE `oauth_users` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `username` varchar(320) UNIQUE NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL
);

CREATE INDEX `UNIQ_93804FF8F85E0677` ON oauth_users (`username`);

--
-- Dumping data for table `oauth_users`
--

INSERT INTO `oauth_users` (`username`, `password`) VALUES
('test_user', '$2y$10$Hr7ZFo4ANwVWV93XB8R42.Z/rS/awKJhH8UIXGMDtjaMjfDRl1fhq');
INSERT INTO `oauth_users` (`username`, `password`) VALUES
('test_user2', '$2y$10$Hr7ZFo4ANwVWV93XB8R42.Z/rS/awKJhH8UIXGMDtjaMjfDRl1fhq');


