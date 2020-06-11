-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2020 at 11:01 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `me_admin_menu`
--

CREATE TABLE `me_admin_menu` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE latin1_general_cs NOT NULL,
  `parent` smallint(6) NOT NULL,
  `link` varchar(25) COLLATE latin1_general_cs NOT NULL,
  `location` varchar(255) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `me_admin_menu`
--

INSERT INTO `me_admin_menu` (`id`, `name`, `parent`, `link`, `location`) VALUES
(1, 'Dashboard', 0, 'http://localhost:8080/por', 'Side Menu'),
(2, 'Projects', 0, 'http://localhost:8080/por', 'Side Menu');

-- --------------------------------------------------------

--
-- Table structure for table `me_category`
--

CREATE TABLE `me_category` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `slug` varchar(25) COLLATE latin1_general_cs NOT NULL,
  `description` text COLLATE latin1_general_cs NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `me_category`
--

INSERT INTO `me_category` (`id`, `name`, `slug`, `description`) VALUES
(39, 'php', 'php', ''),
(40, 'js', 'js', ''),
(41, 'angula', 'angula', ''),
(42, 'uncategorized', 'uncategorized', ''),
(43, 'programming', 'pro-dev', ''),
(44, 'web development', 'web-development', ''),
(47, 'test slug', 'test-slug', ''),
(48, 'test category', 'test-category', ''),
(49, 'bank application', 'bank-app', ''),
(50, 'new category', 'new-category', 'A short note bout the category.');

-- --------------------------------------------------------

--
-- Table structure for table `me_frontend_menu`
--

CREATE TABLE `me_frontend_menu` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE latin1_general_cs NOT NULL,
  `parent` smallint(6) NOT NULL,
  `link` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `location` varchar(25) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `me_frontend_menu`
--

INSERT INTO `me_frontend_menu` (`id`, `name`, `parent`, `link`, `location`) VALUES
(1, 'Home', 0, 'http://localhost/portfolio/home#', 'Top Menu'),
(2, 'Portfolio', 0, 'http://localhost/portfolio/home#portfolio', 'Top Menu'),
(3, 'Service', 0, 'http://localhost/portfolio/home#services', 'Top Menu'),
(5, 'About Me', 0, 'http://localhost/portfolio/home#about', 'Top Menu'),
(6, 'Contact Me', 0, 'http://localhost/portfolio/home#contact', 'Top Menu'),
(4, 'Pricing', 0, 'http://localhost/portfolio/home#pricing', 'Top Menu');

-- --------------------------------------------------------

--
-- Table structure for table `me_library`
--

CREATE TABLE `me_library` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `link` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `caption` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `altText` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `description` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `type` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `uploadedBy` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `uploadedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `me_library`
--

INSERT INTO `me_library` (`id`, `name`, `link`, `caption`, `altText`, `description`, `type`, `uploadedBy`, `uploadedOn`) VALUES
(94, 'Bobo GPU', 'uploads%5Cimages%5C%5Bbinemmanul.com%5D_57b846bbfcc124ba2a65f796283ea81f.png', NULL, NULL, NULL, 'image/png', 'Bin Emmanuel', '2020-06-04 10:07:03'),
(87, '', 'uploads%5Cimages%5C%5Bbinemmanul.com%5D_806f98d77f02957927d2ca43177a6a17.gif', NULL, NULL, '', 'image/gif', 'Bin Emmanuel', '2020-06-04 08:22:34'),
(91, '', 'uploads%5Cimages%5C%5Bbinemmanul.com%5D_87aa5a48f45f5639ec59536141233e83.png', NULL, NULL, '', 'image/png', 'Bin Emmanuel', '2020-06-04 09:59:39'),
(93, '', 'uploads%5Cimages%5C%5Bbinemmanul.com%5D_8628f770741496f8ed0d9faca508b281.png', NULL, NULL, '', 'image/png', 'Bin Emmanuel', '2020-06-04 10:06:54'),
(90, '', 'uploads%5Cimages%5C%5Bbinemmanul.com%5D_8be79c371dc3ce53c4c808a8f9ff1a9a.png', NULL, NULL, '', 'image/png', 'Bin Emmanuel', '2020-06-04 09:59:31'),
(95, '', 'uploads%5Cimages%5C%5Bbinemmanul.com%5D_0eeeb996e92a8809f0009055b7bffadd.jpg', NULL, NULL, '', 'image/jpg', 'Bin Emmanuel', '2020-06-04 10:07:12'),
(118, '', 'uploads%5Cimages%5C%5Bbinemmanul.com%5D_bd32d16d2dd61d5454b73724277b15ef.png', NULL, NULL, '', 'image/png', 'Bin Emmanuel', '2020-06-09 16:39:54'),
(119, '', 'uploads%5Cimages%5C%5Bbinemmanul.com%5D_2e0fe4ad150ec281ae2ec7a047fcdaa4.png', NULL, NULL, '', 'image/png', 'Bin Emmanuel', '2020-06-09 16:40:16'),
(120, '', 'uploads%5Cimages%5C%5Bbinemmanul.com%5D_87cdfc26a30023d014c7545e2e768015.png', NULL, NULL, '', 'image/png', 'Bin Emmanuel', '2020-06-09 16:40:26'),
(121, '', 'uploads%5Cimages%5C%5Bbinemmanul.com%5D_5db24e268730f9f4dab2aceac0f35d78.jpg', NULL, NULL, '', 'image/jpg', 'Bin Emmanuel', '2020-06-09 16:40:48'),
(122, '', 'uploads%5Cimages%5C%5Bbinemmanul.com%5D_d19f3ea091b370a1dccfae882f42df0d.jpg', NULL, NULL, '', 'image/jpg', 'Bin Emmanuel', '2020-06-09 16:41:35'),
(116, 'Name', 'uploads%5Cvideos%5C%5Bbinemmanul.com%5D_7f1532e55570f531e76a68a146ee71c9.mp4', NULL, 'Joker', 'Bea', 'video/mp4', 'Bin Emmanuel', '2020-06-04 10:20:44');

-- --------------------------------------------------------

--
-- Table structure for table `me_project`
--

CREATE TABLE `me_project` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `author` varchar(25) COLLATE latin1_general_cs NOT NULL,
  `title` varchar(150) COLLATE latin1_general_cs NOT NULL,
  `content` text COLLATE latin1_general_cs NOT NULL,
  `summary` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `featured_image` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `status` varchar(9) COLLATE latin1_general_cs NOT NULL DEFAULT 'published',
  `comment_status` varchar(7) COLLATE latin1_general_cs NOT NULL DEFAULT 'open',
  `comment_count` bigint(20) DEFAULT 0,
  `posted_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `me_project`
--

INSERT INTO `me_project` (`id`, `author`, `title`, `content`, `summary`, `featured_image`, `status`, `comment_status`, `comment_count`, `posted_on`) VALUES
(72, 'Bin Emmanuel', 'About Me', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor, magnam sit temporibus quos doloribus maxime in qui totam? Quibusdam voluptatem, ipsa eos, dignissimos expedita quasi nobis dolorum debitis tempora, doloribus possimus perspiciatis adipisci asperiores hic ad nisi! Ad atque aspernatur deleniti error dolores quasi omnis accusantium quibusdam dignissimos hic odio, illum maxime recusandae est mollitia magnam distinctio ullam? Provident dicta accusamus aperiam architecto veritatis aliquid veniam sed exercitationem quasi a perferendis tenetur laborum, quas reiciendis porro et recusandae, dignissimos debitis rem! Eum, mollitia, et voluptatem sunt autem excepturi officiis similique harum atque, dolorem doloribus laudantium vero fugit. Earum, quisquam laudantium?', NULL, 'http://localhost/portfolio/uploads\\images\\[binemmanul.com]_172c939664132b5ba80132aa6fabae1d.png', 'published', 'close', 0, '2020-05-31 14:35:11'),
(73, 'Bin Emmanuel', 'The project title', 'The project title', NULL, 'http://localhost/portfolio/views/starlyon/assets/img/BIn%20Emmanuel.jpg', 'published', 'open', 0, '2020-05-31 15:55:06'),
(83, 'Bin Emmanuel', 'New project in 2020', 'Some thing bout the project goes here.\r\nThis project was edited', NULL, 'http://localhost/portfolio/uploads\\images\\[binemmanul.com]_11c6828d3fc0cfbe908272f28fbe80d8.gif', 'published', 'close', 0, '2020-05-31 19:09:56'),
(84, 'Bin Emmanuel', 'New project in 2020', 'Some thing bout the project goes here.', NULL, 'http://localhost/portfolio/views/starlyon/assets/img/BIn%20Emmanuel.jpg', 'published', 'close', 0, '2020-05-31 19:10:31'),
(85, 'Bin Emmanuel', 'Me and Future Project', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor, magnam sit temporibus quos doloribus maxime in qui totam? Quibusdam voluptatem, ipsa eos, dignissimos expedita quasi nobis dolorum debitis tempora, doloribus possimus perspiciatis adipisci asperiores hic ad nisi', NULL, 'http://localhost/portfolio/uploads\\images\\[binemmanul.com]_172c939664132b5ba80132aa6fabae1d.png', 'published', 'close', 0, '2020-05-31 19:37:10'),
(92, 'Bin Emmanuel', 'My new project for 90', 'You have been hacked', NULL, 'http://localhost/portfolio/uploads/images/[binemmanul.com]_11c6828d3fc0cfbe908272f28fbe80d8.gif', 'published', 'close', 0, '2020-06-01 12:38:01');

-- --------------------------------------------------------

--
-- Table structure for table `me_project_category`
--

CREATE TABLE `me_project_category` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `project` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `me_project_category`
--

INSERT INTO `me_project_category` (`id`, `category`, `project`) VALUES
(8, 41, 72),
(12, 40, 72),
(16, 42, 84),
(30, 50, 92),
(31, 39, 92),
(43, 42, 83),
(46, 47, 85);

-- --------------------------------------------------------

--
-- Table structure for table `me_site_info`
--

CREATE TABLE `me_site_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE latin1_general_cs NOT NULL,
  `tagline` varchar(900) COLLATE latin1_general_cs NOT NULL,
  `address` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `email` varchar(100) COLLATE latin1_general_cs NOT NULL,
  `template` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `admin_template` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `default_user_role` varchar(100) COLLATE latin1_general_cs NOT NULL,
  `allow_new_reg` char(3) COLLATE latin1_general_cs NOT NULL DEFAULT 'No'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `me_site_info`
--

INSERT INTO `me_site_info` (`id`, `title`, `tagline`, `address`, `email`, `template`, `admin_template`, `default_user_role`, `allow_new_reg`) VALUES
(1, 'Bin Emmanuel', 'I\'m a Full Web Developer from Abuja, Nigeria. I build high performance, scalable, mobile responsive and secure Web Applications that moves businesses from no where to somewhere. From small business sites to a rich interactive web app, blogs and eCommerce. If you are looking for someone to help make your business go digital or an employer looking to hire or a developer who wants to outsource their project(s), then you are at the right place.', 'https://v2.binemmanuel.com', 'textme@binemmanuel.com', 'starlyon', '', 'subscriber', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `me_tag`
--

CREATE TABLE `me_tag` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `slug` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `description` text COLLATE latin1_general_cs NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `me_tag`
--

INSERT INTO `me_tag` (`id`, `name`, `slug`, `description`) VALUES
(1, 'Web Development', 'web-development', ''),
(2, 'Android App Developm', 'android-app-developm', ''),
(3, 'Game Development', 'game-development', '');

-- --------------------------------------------------------

--
-- Table structure for table `me_users`
--

CREATE TABLE `me_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `password` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `email` varchar(100) COLLATE latin1_general_cs NOT NULL,
  `userRole` varchar(15) COLLATE latin1_general_cs NOT NULL,
  `active` char(1) COLLATE latin1_general_cs NOT NULL DEFAULT '0',
  `token` char(10) COLLATE latin1_general_cs DEFAULT NULL,
  `resetToken` varchar(60) COLLATE latin1_general_cs DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `me_users`
--

INSERT INTO `me_users` (`id`, `username`, `password`, `email`, `userRole`, `active`, `token`, `resetToken`, `createdOn`) VALUES
(6, 'binemmanuel', '$2y$10$Y5nKYOlE4REhKTqOKmBw9O0jb/6NKZMgjZYaIlkiCChpj2FnRhiya', 'binemmanuel@mail.com', 'administrator', '1', '4083', NULL, '2019-02-15 09:07:32'),
(7, 'bobby', '$2y$10$MJwgfBY2vdljGhqdsDH3RehCK7JrEHfffhEjzj4X9TtxoI9mHvEGK', 'bobby@mail.com', 'administrator', '1', '1356', NULL, '2019-02-15 09:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `me_users_info`
--

CREATE TABLE `me_users_info` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `user_id` smallint(5) UNSIGNED NOT NULL,
  `full_name` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `website` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `profile_pic` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `bio` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `me_users_info`
--

INSERT INTO `me_users_info` (`id`, `user_id`, `full_name`, `website`, `profile_pic`, `bio`, `modified_on`) VALUES
(1, 6, 'Bin Emmanuel', 'http://facebook.com', '', 'My Bio', '2020-06-05 10:46:01'),
(2, 7, 'Bryan Bobby', 'https://binemmanuel.com/bobby', '', 'His Bio', '2020-06-05 11:26:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `me_admin_menu`
--
ALTER TABLE `me_admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `me_category`
--
ALTER TABLE `me_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `id` (`id`,`name`,`slug`);

--
-- Indexes for table `me_frontend_menu`
--
ALTER TABLE `me_frontend_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `me_library`
--
ALTER TABLE `me_library`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `me_project`
--
ALTER TABLE `me_project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `me_project_category`
--
ALTER TABLE `me_project_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `me_site_info`
--
ALTER TABLE `me_site_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `tagline` (`tagline`),
  ADD UNIQUE KEY `address` (`address`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `defualt_user_role` (`default_user_role`),
  ADD UNIQUE KEY `all_new_reg` (`allow_new_reg`);

--
-- Indexes for table `me_tag`
--
ALTER TABLE `me_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `me_users`
--
ALTER TABLE `me_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`),
  ADD UNIQUE KEY `resetToken` (`resetToken`);

--
-- Indexes for table `me_users_info`
--
ALTER TABLE `me_users_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `me_admin_menu`
--
ALTER TABLE `me_admin_menu`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `me_category`
--
ALTER TABLE `me_category`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `me_frontend_menu`
--
ALTER TABLE `me_frontend_menu`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `me_library`
--
ALTER TABLE `me_library`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `me_project`
--
ALTER TABLE `me_project`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `me_project_category`
--
ALTER TABLE `me_project_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `me_site_info`
--
ALTER TABLE `me_site_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `me_tag`
--
ALTER TABLE `me_tag`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `me_users`
--
ALTER TABLE `me_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `me_users_info`
--
ALTER TABLE `me_users_info`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
