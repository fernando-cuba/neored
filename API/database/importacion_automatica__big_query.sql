-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `importacion_automatica__big_query`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs__upload_file`
--

CREATE TABLE `logs__upload_file` (
  `id__log` int NOT NULL,
  `size__log` double NOT NULL,
  `datetime_received__log` datetime DEFAULT CURRENT_TIMESTAMP,
  `datetime_processed__log` datetime DEFAULT CURRENT_TIMESTAMP,
  `state__log` varchar(15) DEFAULT 'FAILED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `logs__upload_file`
--
ALTER TABLE `logs__upload_file`
  ADD PRIMARY KEY (`id__log`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `logs__upload_file`
--
ALTER TABLE `logs__upload_file`
  MODIFY `id__log` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
