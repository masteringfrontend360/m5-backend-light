-- phpMyAdmin SQL Dump
-- version 5.2.2deb1+deb13u1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-04-2026 a las 06:33:52
-- Versión del servidor: 11.8.6-MariaDB-0+deb13u1 from Debian
-- Versión de PHP: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `curso_mysql`
--

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `email`, `ciudad`, `created_at`) VALUES
(1, 'Juan Pérez', 'juan.perez@example.com', 'Madrid', '2026-04-20 08:06:06'),
(2, 'Ana García', 'ana.garcia@example.com', 'Barcelona', '2026-04-20 08:06:06'),
(3, 'Luis Martínez', 'luis.martinez@example.com', 'Valencia', '2026-04-20 08:06:06'),
(4, 'María López', 'maria.lopez@example.com', 'Sevilla', '2026-04-20 08:06:06'),
(5, 'Carlos Sánchez', 'carlos.sanchez@example.com', 'Bilbao', '2026-04-20 08:06:06'),
(6, 'Lucía Fernández', 'lucia.fernandez@example.com', 'Zaragoza', '2026-04-20 08:06:06'),
(7, 'Javier Gómez', 'javier.gomez@example.com', 'Málaga', '2026-04-20 08:06:06'),
(8, 'Elena Díaz', 'elena.diaz@example.com', 'Murcia', '2026-04-20 08:06:06'),
(9, 'Pablo Ruiz', 'pablo.ruiz@example.com', 'Palma', '2026-04-20 08:06:06'),
(10, 'Sara Torres', 'sara.torres@example.com', 'Alicante', '2026-04-20 08:06:06'),
(11, 'Miguel Navarro', 'miguel.navarro@example.com', 'Córdoba', '2026-04-20 08:06:06'),
(12, 'Laura Romero', 'laura.romero@example.com', 'Valladolid', '2026-04-20 08:06:06'),
(13, 'David Castro', 'david.castro@example.com', 'Vigo', '2026-04-20 08:06:06'),
(14, 'Carmen Ortega', 'carmen.ortega@example.com', 'Gijón', '2026-04-20 08:06:06'),
(15, 'Raúl Delgado', 'raul.delgado@example.com', 'Granada', '2026-04-20 08:06:06'),
(16, 'Patricia Molina', 'patricia.molina@example.com', 'Santander', '2026-04-20 08:06:06'),
(17, 'Alberto Ortiz', 'alberto.ortiz@example.com', 'Pamplona', '2026-04-20 08:06:06'),
(18, 'Natalia Vega', 'natalia.vega@example.com', 'Logroño', '2026-04-20 08:06:06'),
(19, 'Sergio Herrera', 'sergio.herrera@example.com', 'Salamanca', '2026-04-20 08:06:06'),
(20, 'Cristina Ramos', 'cristina.ramos@example.com', 'Toledo', '2026-04-20 08:06:06'),
(21, 'Ana', 'avallejorivera360@gmail.com', 'zaragoza', '2026-04-20 10:01:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
