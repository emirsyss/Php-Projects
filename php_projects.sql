-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 13 Oca 2024, 20:55:04
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `php_projects`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `chat_messages`
--

CREATE TABLE `chat_messages` (
  `message_id` int(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `sender_id` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `timestamp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `chat_messages`
--

INSERT INTO `chat_messages` (`message_id`, `sender`, `sender_id`, `message`, `timestamp`) VALUES
(460, 'emirsys', '8', 'SA', '13.01.2024 22:26:18'),
(461, 'ardasys', '4', 'as', '13.01.2024 22:26:23'),
(462, 'roselia software', '8', 'as', '13.01.2024 22:27:25'),
(463, 'roselia software', '8', 'asas', '13.01.2024 22:27:38'),
(464, 'roselia software', '8', 'sa', '13.01.2024 22:27:38'),
(465, 'roselia software', '8', 'sa', '13.01.2024 22:27:38'),
(466, 'roselia software', '8', 'sa', '13.01.2024 22:27:38'),
(467, 'roselia software', '8', 's', '13.01.2024 22:27:38'),
(468, 'roselia software', '8', 'as', '13.01.2024 22:27:39'),
(469, 'roselia software', '8', 'as', '13.01.2024 22:27:39'),
(470, 'roselia software', '8', 'asas', '13.01.2024 22:27:45'),
(471, 'ardasys', '4', '<x<zx<zxasf', '13.01.2024 22:28:01'),
(472, 'ardasys', '4', 'sadasd', '13.01.2024 22:28:03'),
(473, 'ardasys', '4', 'asd', '13.01.2024 22:28:03'),
(474, 'ardasys', '4', 'asd', '13.01.2024 22:28:03'),
(475, 'ardasys', '4', 'asd', '13.01.2024 22:28:03'),
(476, 'ardasys', '4', 'asd', '13.01.2024 22:28:04'),
(477, 'ardasys', '4', 'asd', '13.01.2024 22:28:04'),
(478, 'ardasys', '4', 'a', '13.01.2024 22:28:04'),
(479, 'ardasys', '4', 'sd', '13.01.2024 22:28:04'),
(480, 'ardasys', '4', 'asd', '13.01.2024 22:28:04');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `chat_user`
--

CREATE TABLE `chat_user` (
  `user_id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `chat_user`
--

INSERT INTO `chat_user` (`user_id`, `username`, `email`, `password`, `avatar`) VALUES
(4, 'ardasys', 'ardaisiklibusiness@gmail.com', 'a2d54ea3fcfe904da0f918f9ab77b0adf034e6b9c942e02a7ce1bbcc7afb9fa5', ''),
(8, 'roselia software', 'emirisiklibusiness@gmail.com', 'a2d54ea3fcfe904da0f918f9ab77b0adf034e6b9c942e02a7ce1bbcc7afb9fa5', '8.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mysql_user`
--

CREATE TABLE `mysql_user` (
  `user_id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `mysql_user`
--

INSERT INTO `mysql_user` (`user_id`, `username`, `password`, `email`) VALUES
(1, 'emirsys', 'a2d54ea3fcfe904da0f918f9ab77b0adf034e6b9c942e02a7ce1bbcc7afb9fa5', 'emirisiklibusiness@gmail.com');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Tablo için indeksler `chat_user`
--
ALTER TABLE `chat_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Tablo için indeksler `mysql_user`
--
ALTER TABLE `mysql_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `message_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=481;

--
-- Tablo için AUTO_INCREMENT değeri `chat_user`
--
ALTER TABLE `chat_user`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `mysql_user`
--
ALTER TABLE `mysql_user`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
