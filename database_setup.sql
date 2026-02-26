-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 09:48 AM
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
-- Database: `squirrels`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_level` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `admin_level`) VALUES
(1, 'David', '$argon2id$v=19$m=65536,t=4,p=1$aGVLQ2hCc3lYYmRaSGhHNA$LKnhJkOzu81ZU6Zr0GLFhBLWsFpUk3J6wSNdnn9qJvI', 100);

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  `public` tinyint(4) NOT NULL DEFAULT 1,
  `name` varchar(50) NOT NULL,
  `science_name` varchar(50) NOT NULL,
  `min_age` int(3) NOT NULL,
  `max_age` int(3) NOT NULL,
  `image` varchar(25) NOT NULL,
  `type` int(11) NOT NULL,
  `length_unit` int(11) NOT NULL,
  `weight_unit` int(11) NOT NULL,
  `length_min` int(11) NOT NULL,
  `length_max` int(11) NOT NULL,
  `weight_min` int(11) NOT NULL,
  `weight_max` int(11) NOT NULL,
  `phase_family_title` varchar(100) NOT NULL,
  `phase_family_text` text NOT NULL,
  `phase_baby_title` varchar(100) NOT NULL,
  `phase_baby_text` text NOT NULL,
  `phase_leaving_title` varchar(100) NOT NULL,
  `phase_leaving_text` text NOT NULL,
  `phase_independent_title` varchar(100) NOT NULL,
  `phase_independent_text` text NOT NULL,
  `color` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `created`, `public`, `name`, `science_name`, `min_age`, `max_age`, `image`, `type`, `length_unit`, `weight_unit`, `length_min`, `length_max`, `weight_min`, `weight_max`, `phase_family_title`, `phase_family_text`, `phase_baby_title`, `phase_baby_text`, `phase_leaving_title`, `phase_leaving_text`, `phase_independent_title`, `phase_independent_text`, `color`) VALUES
(1, '2026-02-19', 1, 'Eastern Gray Squirrel', 'Sciurus carolinensis', 6, 12, 's1image.jpg', 1, 1, 2, 48, 51, 400, 600, 'These squirrels are born in leafy nests.', 'Eastern Gray Squirrels are born in leafy nests or tree hollows, typically in litters of 2-4. Mothers are solely responsible for care, nursing the young for up to 10 weeks. This highly adaptable species is diurnal and lives in both wild forests and urban parks.', 'Newborns are blind and hairless.', 'Newborns are blind and hairless. Eyes open at about 4 weeks, and fur develops soon after. Babies begin to explore the nest by 6 weeks, remaining under the mother\'s care as they transition to solscience_name food.', 'Around 12 weeks, juveniles begin to leave the nest.', 'At around 10-12 weeks, juveniles begin to leave the nest, practicing climbing and foraging skills under maternal supervision. Nest-leaving juveniles may remain near their natal area, with gradual reduction of dependency.', 'After 12 weeks, young squirrels are fully independent.', 'By 12 weeks, young squirrels are fully independent and establish their own territories. Adults are solitary, caching food throughout the year and communicating via tail flicking and vocalizations.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `animal_colors`
--

CREATE TABLE `animal_colors` (
  `id` int(11) NOT NULL,
  `color_name` text NOT NULL,
  `color_code` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animal_colors`
--

INSERT INTO `animal_colors` (`id`, `color_name`, `color_code`) VALUES
(1, 'orange', '#df7717'),
(2, 'yellow', '#df9a17'),
(3, 'red', '#df7717'),
(4, 'gray', '#928e85');

-- --------------------------------------------------------

--
-- Table structure for table `animal_countries`
--

CREATE TABLE `animal_countries` (
  `animal_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `animal_families`
--

CREATE TABLE `animal_families` (
  `animal_id` int(11) NOT NULL,
  `family_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `animal_types`
--

CREATE TABLE `animal_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animal_types`
--

INSERT INTO `animal_types` (`id`, `type_name`) VALUES
(1, 'adult'),
(2, 'teenager'),
(3, 'kid');

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL,
  `key_name` varchar(25) NOT NULL,
  `encrypted_password` varchar(255) NOT NULL,
  `required_auth` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `key_name`, `encrypted_password`, `required_auth`) VALUES
(1, 'default', '$argon2id$v=19$m=65536,t=4,p=1$d2lPbmtpL3N5WkNSdUpkcg$RvEnl2QRJE89KE4VJhvgT/8FCUAeC7TTiKZ7/rQQHjc', 100);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`) VALUES
(1, 'United States'),
(2, 'Canada'),
(3, 'United Kingdom'),
(4, 'Ireland'),
(5, 'Italy'),
(6, 'Denmark');

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE `families` (
  `id` int(11) NOT NULL,
  `animal_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `families`
--

INSERT INTO `families` (`id`, `animal_name`) VALUES
(1, 'Fox Squirrel (Sciurus niger)'),
(2, 'Western Gray Squirrel (Sciurus griseus)'),
(3, 'American Red Squirrel (Tamiasciurus hudsonicus)');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(25) NOT NULL,
  `unit_short_name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`, `unit_short_name`) VALUES
(1, 'centimeter', 'cm'),
(2, 'grams', 'g'),
(3, 'meters', 'm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_animals_types` (`type`),
  ADD KEY `fk_animals_colors` (`color`),
  ADD KEY `fk_animals_weight_units` (`weight_unit`),
  ADD KEY `fk_animals_length_units` (`length_unit`);

--
-- Indexes for table `animal_colors`
--
ALTER TABLE `animal_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `animal_countries`
--
ALTER TABLE `animal_countries`
  ADD PRIMARY KEY (`animal_id`,`country_id`),
  ADD KEY `fk_animal_countries_country` (`country_id`);

--
-- Indexes for table `animal_families`
--
ALTER TABLE `animal_families`
  ADD PRIMARY KEY (`animal_id`,`family_id`),
  ADD KEY `fk_animal_families_families` (`family_id`);

--
-- Indexes for table `animal_types`
--
ALTER TABLE `animal_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `families`
--
ALTER TABLE `families`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `animal_colors`
--
ALTER TABLE `animal_colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `animal_types`
--
ALTER TABLE `animal_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `families`
--
ALTER TABLE `families`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `fk_animals_colors` FOREIGN KEY (`color`) REFERENCES `animal_colors` (`id`),
  ADD CONSTRAINT `fk_animals_length_units` FOREIGN KEY (`length_unit`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `fk_animals_types` FOREIGN KEY (`type`) REFERENCES `animal_types` (`id`),
  ADD CONSTRAINT `fk_animals_weight_units` FOREIGN KEY (`weight_unit`) REFERENCES `units` (`id`);

--
-- Constraints for table `animal_countries`
--
ALTER TABLE `animal_countries`
  ADD CONSTRAINT `fk_animal_countries_animal` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_animal_countries_country` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `animal_families`
--
ALTER TABLE `animal_families`
  ADD CONSTRAINT `fk_animal_families_animal` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_animal_families_families` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
