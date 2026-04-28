-- phpMyAdmin SQL Dump
-- version 5.2.2deb1+deb13u1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-04-2026 a las 06:28:29
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
(3, 'Ana García López', 'ana.garcia@email.com', 'Madrid', '2026-04-20 07:57:11'),
(4, 'Carlos Ruiz Pérez', 'carlos.ruiz@email.com', 'Barcelona', '2026-04-20 07:57:11'),
(5, 'María Fernández Silva', 'maria.fernandez@email.com', 'Valencia', '2026-04-20 07:57:11'),
(6, 'Pedro Sánchez Martín', 'pedro.sanchez@email.com', 'Sevilla', '2026-04-20 07:57:11'),
(7, 'Laura Martínez Gómez', 'laura.martinez@email.com', 'Zaragoza', '2026-04-20 07:57:11'),
(8, 'Diego López Rodríguez', 'diego.lopez@email.com', 'Bilbao', '2026-04-20 07:57:11'),
(9, 'Sofía Torres Vega', 'sofia.torres@email.com', 'Málaga', '2026-04-20 07:57:11'),
(10, 'Javier Morales Cano', 'javier.morales@email.com', 'Murcia', '2026-04-20 07:57:11'),
(11, 'Elena Díaz Ortega', 'elena.diaz@email.com', 'Palma de Mallorca', '2026-04-20 07:57:11'),
(12, 'Miguel Ángel Rubio', 'miguel.rubio@email.com', 'Las Palmas', '2026-04-20 07:57:11'),
(13, 'Patricia Gómez', 'patricia.gomez@email.com', 'Madrid', '2026-04-20 10:33:07'),
(18, 'Hugo López', 'hugo.lopez@email.com', 'Logroño', '2026-04-20 10:51:10'),
(19, 'Susana Rodríguez', 'susana.rodriguez@email.com', 'Lleida', '2026-04-20 11:56:24'),
(22, 'Elisa Campo', 'susana.campo@email.com', 'Lleida', '2026-04-20 11:59:34'),
(23, 'Elisa Campo', 'elisa.campo@email.com', 'Lleida', '2026-04-20 11:59:55'),
(24, 'Lola Martínez', 'lola.martinez@email.com', 'Sevilla', '2026-04-21 05:25:10'),
(25, 'Susana Pastor', 'susana.pastor@email.com', 'Salamanca', '2026-04-21 05:30:19'),
(26, 'Ricardo Benedí', 'ricardo.benedi@email.com', 'Salamanca', '2026-04-21 05:50:55'),
(27, 'Julio Royo', 'julio.royo@email.com', 'Madrid', '2026-04-21 06:13:51');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
