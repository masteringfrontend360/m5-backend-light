-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-10-2024 a las 16:30:18
-- Versión del servidor: 10.4.32-MariaDB-log
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eoi_preinscripciones`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AsignarPlazaPorPreinscripcion` (IN `preinscripcion_id` INT, IN `idioma_id` INT)   BEGIN
    DECLARE fin_prioridades INT DEFAULT 0;
    DECLARE grupo_id INT;
    DECLARE prioridad INT;
    DECLARE admitido INT DEFAULT 0;
    DECLARE num_reserva INT DEFAULT 1;

    -- Cursor para iterar sobre las prioridades de la preinscripción actual
    DECLARE cursor_prioridades CURSOR FOR
    SELECT pg.id_grupo, pg.prioridad
    FROM preinscripciones_grupos pg
    JOIN grupos g ON pg.id_grupo = g.id
    WHERE pg.id_preinscripcion = preinscripcion_id AND g.id_idioma = idioma_id
    ORDER BY pg.prioridad ASC;

    -- Manejador para cuando el cursor de prioridades llegue al final
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin_prioridades = 1;

    -- Abrir el cursor de prioridades
    OPEN cursor_prioridades;

    priority_loop: LOOP
        FETCH cursor_prioridades INTO grupo_id, prioridad;
        IF fin_prioridades = 1 THEN
            LEAVE priority_loop;
        END IF;

        -- Verificar disponibilidad de plazas en el grupo actual
        IF (SELECT num_plazas FROM grupos WHERE id = grupo_id) > 0 THEN
            -- Asignar la plaza y reducir el número de plazas
            UPDATE preinscripciones_grupos SET admitido = 1 
            WHERE id_preinscripcion = preinscripcion_id AND id_grupo = grupo_id;
            
            UPDATE grupos SET num_plazas = num_plazas - 1 
            WHERE id = grupo_id;

            SET admitido = 1;
            -- Salir del bucle de prioridad para esta preinscripción
            LEAVE priority_loop;
        END IF;
    END LOOP priority_loop;

    -- Cerrar el cursor de prioridades
    CLOSE cursor_prioridades;

    -- Si no fue admitido en ninguna prioridad, asignar un número de reserva
    IF admitido = 0 THEN
        UPDATE preinscripciones_grupos 
        SET num_reserva = num_reserva 
        WHERE id_preinscripcion = preinscripcion_id;
        SET num_reserva = num_reserva + 1;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AsignarPlazasPrincipal` (IN `idioma_id` INT)   BEGIN
    DECLARE id_sorteo INT;
    DECLARE fin INT DEFAULT 0;
    DECLARE preinscripcion_id INT;

    -- Cursor principal para iterar sobre cada preinscripción desde el ID sorteado
    DECLARE cursor_preinscripciones CURSOR FOR
    SELECT pc.id
    FROM preinscripciones_cabecera pc
    WHERE pc.id >= id_sorteo
    ORDER BY pc.id ASC;

    -- Manejador para cuando el cursor principal llegue al final
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = 1;

    -- Generar el número de sorteo y guardarlo en sorteo_log
    SET id_sorteo = (SELECT FLOOR(1 + RAND() * MAX(pc.id))
                     FROM preinscripciones_cabecera pc
                     JOIN preinscripciones_grupos pg ON pc.id = pg.id_preinscripcion
                     JOIN grupos g ON pg.id_grupo = g.id
                     WHERE g.id_idioma = idioma_id);
                     
    INSERT INTO sorteo_log (idioma_id, numero_sorteo) VALUES (idioma_id, id_sorteo);

    -- Abrir el cursor principal
    OPEN cursor_preinscripciones;

    read_loop: LOOP
        FETCH cursor_preinscripciones INTO preinscripcion_id;
        IF fin = 1 THEN
            LEAVE read_loop;
        END IF;

        -- Llamar al procedimiento secundario para procesar la preinscripción
        CALL AsignarPlazaPorPreinscripcion(preinscripcion_id, idioma_id);

    END LOOP read_loop;

    -- Cerrar el cursor principal
    CLOSE cursor_preinscripciones;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AsignarPlazasPrincipalCircular` (IN `idioma_id` INT)   BEGIN
    DECLARE id_sorteo INT;
    DECLARE preinscripcion_id INT;
    DECLARE fin INT DEFAULT 0;

    -- Generar el número de sorteo y guardarlo en sorteo_log
    SET id_sorteo = (SELECT FLOOR(1 + RAND() * MAX(pc.id))
                     FROM preinscripciones_cabecera pc
                     JOIN preinscripciones_grupos pg ON pc.id = pg.id_preinscripcion
                     JOIN grupos g ON pg.id_grupo = g.id
                     WHERE g.id_idioma = idioma_id);
                     
    INSERT INTO sorteo_log (idioma_id, numero_sorteo) VALUES (idioma_id, id_sorteo);

    -- Inicializar la preinscripción actual con el valor del sorteo
    SET preinscripcion_id = id_sorteo;

    -- Comenzar el ciclo repeat para asignar plazas
    REPEAT
        -- Intentar asignar plaza al preinscrito actual llamando al procedimiento secundario
        CALL AsignarPlazaPorPreinscripcion(preinscripcion_id, idioma_id);

        -- Obtener el siguiente ID de preinscripción
        SET preinscripcion_id = (SELECT MIN(id) FROM preinscripciones_cabecera WHERE id > preinscripcion_id);

        -- Si no hay más preinscripciones después del ID actual, volver al inicio
        IF preinscripcion_id IS NULL THEN
            SET preinscripcion_id = (SELECT MIN(id) FROM preinscripciones_cabecera);
        END IF;

        -- Marcar fin cuando volvemos al número de sorteo original
        IF preinscripcion_id = id_sorteo THEN
            SET fin = 1;
        END IF;

    UNTIL fin = 1
    END REPEAT;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` smallint(5) NOT NULL,
  `id_idioma` tinyint(3) NOT NULL,
  `id_nivel` tinyint(3) NOT NULL,
  `id_horario` tinyint(3) NOT NULL,
  `num_plazas` tinyint(3) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `id_idioma`, `id_nivel`, `id_horario`, `num_plazas`) VALUES
(1, 1, 1, 1, 5),
(2, 1, 1, 2, 5),
(3, 1, 1, 3, 5),
(4, 1, 1, 4, 5),
(5, 1, 2, 1, 5),
(6, 1, 2, 2, 5),
(7, 1, 2, 3, 5),
(8, 1, 3, 1, 5),
(9, 1, 3, 2, 5),
(10, 1, 3, 3, 5),
(11, 1, 4, 1, 5),
(12, 1, 4, 2, 5),
(13, 1, 4, 3, 5),
(14, 1, 5, 1, 5),
(15, 1, 5, 2, 5),
(16, 1, 6, 4, 5),
(17, 2, 1, 2, 5),
(18, 2, 1, 3, 5),
(19, 2, 1, 4, 5),
(20, 2, 2, 2, 5),
(21, 2, 2, 3, 5),
(22, 2, 3, 2, 5),
(23, 2, 4, 3, 5),
(24, 2, 4, 1, 5),
(25, 2, 5, 3, 5),
(26, 2, 6, 1, 5),
(27, 3, 1, 2, 5),
(28, 3, 1, 3, 5),
(29, 3, 1, 4, 5),
(30, 3, 2, 3, 5),
(31, 3, 2, 2, 5),
(32, 3, 3, 2, 5),
(33, 3, 4, 3, 5),
(34, 3, 4, 1, 5),
(35, 3, 5, 3, 5),
(36, 3, 6, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` tinyint(3) NOT NULL,
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `descripcion`) VALUES
(1, 'Lunes y miércoles de 16h a 18h'),
(2, 'Lunes y miércoles 19h a 21h'),
(3, 'Martes y jueves 16h a 18h'),
(4, 'Martes y jueves 19h a 21h');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idiomas`
--

CREATE TABLE `idiomas` (
  `id` tinyint(3) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `idiomas`
--

INSERT INTO `idiomas` (`id`, `nombre`) VALUES
(1, 'Inglés'),
(2, 'Francés'),
(3, 'Alemán');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `id` tinyint(3) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`id`, `nombre`) VALUES
(1, 'A1'),
(2, 'A2'),
(3, 'B1'),
(4, 'B2'),
(5, 'C1'),
(6, 'C2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preinscripciones_cabecera`
--

CREATE TABLE `preinscripciones_cabecera` (
  `id` int(10) NOT NULL,
  `id_preinscrito` int(10) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `preinscripciones_cabecera`
--

INSERT INTO `preinscripciones_cabecera` (`id`, `id_preinscrito`, `fecha`) VALUES
(1, 1, '2024-10-21 08:02:20'),
(2, 1, '2024-10-18 12:32:58'),
(3, 2, '2024-10-21 06:45:37'),
(4, 2, '2024-10-21 10:03:38'),
(5, 3, '2024-10-22 20:38:08'),
(6, 3, '2024-10-19 00:05:18'),
(7, 4, '2024-10-21 15:18:05'),
(8, 4, '2024-10-19 09:34:13'),
(9, 5, '2024-10-21 18:13:33'),
(10, 6, '2024-10-22 00:55:19'),
(11, 6, '2024-10-19 23:46:33'),
(12, 6, '2024-10-21 20:43:36'),
(13, 7, '2024-10-18 10:26:59'),
(14, 8, '2024-10-18 02:00:40'),
(15, 8, '2024-10-20 03:10:43'),
(16, 8, '2024-10-22 21:15:50'),
(17, 9, '2024-10-18 03:51:00'),
(18, 10, '2024-10-18 20:40:43'),
(19, 10, '2024-10-18 02:16:29'),
(20, 11, '2024-10-19 06:11:25'),
(21, 12, '2024-10-21 17:15:04'),
(22, 12, '2024-10-20 00:48:09'),
(23, 13, '2024-10-19 22:58:58'),
(24, 14, '2024-10-18 18:38:57'),
(25, 14, '2024-10-21 06:49:44'),
(26, 14, '2024-10-20 05:05:16'),
(27, 15, '2024-10-22 06:40:49'),
(28, 16, '2024-10-21 21:16:38'),
(29, 16, '2024-10-19 00:46:21'),
(30, 17, '2024-10-20 16:30:48'),
(31, 17, '2024-10-18 07:32:18'),
(32, 18, '2024-10-22 12:53:41'),
(33, 19, '2024-10-19 05:08:59'),
(34, 20, '2024-10-19 17:29:38'),
(35, 21, '2024-10-19 01:19:25'),
(36, 22, '2024-10-21 07:52:55'),
(37, 23, '2024-10-20 13:51:27'),
(38, 23, '2024-10-21 05:24:27'),
(39, 23, '2024-10-21 22:52:25'),
(40, 24, '2024-10-22 14:55:48'),
(41, 25, '2024-10-20 07:28:23'),
(42, 26, '2024-10-18 21:00:30'),
(43, 27, '2024-10-21 15:06:09'),
(44, 28, '2024-10-22 02:37:13'),
(45, 28, '2024-10-21 17:48:25'),
(46, 29, '2024-10-21 13:43:42'),
(47, 29, '2024-10-22 23:02:03'),
(48, 29, '2024-10-19 04:51:12'),
(49, 30, '2024-10-19 14:52:45'),
(50, 30, '2024-10-22 08:58:03'),
(51, 30, '2024-10-18 18:31:04'),
(52, 31, '2024-10-22 18:52:57'),
(53, 32, '2024-10-19 09:08:15'),
(54, 33, '2024-10-19 21:15:29'),
(55, 34, '2024-10-22 16:16:43'),
(56, 35, '2024-10-22 00:59:02'),
(57, 35, '2024-10-19 02:35:14'),
(58, 36, '2024-10-22 21:15:19'),
(59, 36, '2024-10-22 00:40:06'),
(60, 36, '2024-10-20 16:24:24'),
(61, 37, '2024-10-21 22:27:42'),
(62, 38, '2024-10-22 19:44:45'),
(63, 39, '2024-10-21 01:47:05'),
(64, 39, '2024-10-18 00:15:25'),
(65, 40, '2024-10-21 08:16:41'),
(66, 40, '2024-10-19 11:10:47'),
(67, 40, '2024-10-22 23:14:02'),
(68, 41, '2024-10-20 02:15:53'),
(69, 41, '2024-10-18 00:40:57'),
(70, 41, '2024-10-19 21:18:22'),
(71, 42, '2024-10-20 07:38:19'),
(72, 42, '2024-10-20 02:04:30'),
(73, 43, '2024-10-20 15:57:25'),
(74, 44, '2024-10-21 23:54:13'),
(75, 45, '2024-10-20 20:07:13'),
(76, 46, '2024-10-20 13:42:10'),
(77, 46, '2024-10-22 17:53:26'),
(78, 46, '2024-10-18 12:10:17'),
(79, 47, '2024-10-19 07:28:09'),
(80, 47, '2024-10-20 14:52:17'),
(81, 47, '2024-10-20 07:10:20'),
(82, 48, '2024-10-21 22:42:28'),
(83, 48, '2024-10-21 08:43:06'),
(84, 48, '2024-10-22 18:02:20'),
(85, 49, '2024-10-19 20:47:39'),
(86, 50, '2024-10-21 05:12:35'),
(87, 51, '2024-10-19 05:20:53'),
(88, 52, '2024-10-19 01:24:23'),
(89, 52, '2024-10-22 22:06:19'),
(90, 53, '2024-10-20 13:04:16'),
(91, 53, '2024-10-19 03:42:07'),
(92, 53, '2024-10-21 00:23:56'),
(93, 54, '2024-10-19 21:48:28'),
(94, 54, '2024-10-18 17:19:07'),
(95, 55, '2024-10-18 21:35:33'),
(96, 55, '2024-10-18 15:28:17'),
(97, 55, '2024-10-19 02:26:41'),
(98, 56, '2024-10-21 04:20:17'),
(99, 56, '2024-10-19 12:57:32'),
(100, 57, '2024-10-21 22:12:40'),
(101, 58, '2024-10-22 11:07:48'),
(102, 59, '2024-10-21 17:14:30'),
(103, 59, '2024-10-19 01:46:06'),
(104, 59, '2024-10-22 08:44:59'),
(105, 60, '2024-10-18 01:47:09'),
(106, 60, '2024-10-21 13:59:14'),
(107, 60, '2024-10-19 07:49:34'),
(108, 61, '2024-10-19 02:59:55'),
(109, 61, '2024-10-21 13:34:23'),
(110, 61, '2024-10-18 18:07:09'),
(111, 62, '2024-10-22 12:50:15'),
(112, 62, '2024-10-21 11:54:03'),
(113, 63, '2024-10-21 13:39:39'),
(114, 63, '2024-10-21 10:02:06'),
(115, 64, '2024-10-18 23:35:07'),
(116, 64, '2024-10-21 07:23:54'),
(117, 64, '2024-10-18 11:55:03'),
(118, 65, '2024-10-18 14:29:29'),
(119, 65, '2024-10-20 08:39:06'),
(120, 66, '2024-10-21 22:21:06'),
(121, 67, '2024-10-19 16:01:50'),
(122, 68, '2024-10-18 10:33:26'),
(123, 69, '2024-10-19 07:20:22'),
(124, 69, '2024-10-20 22:48:34'),
(125, 70, '2024-10-21 03:25:05'),
(126, 71, '2024-10-18 08:14:35'),
(127, 72, '2024-10-20 14:52:18'),
(128, 72, '2024-10-20 20:41:28'),
(129, 72, '2024-10-21 08:00:14'),
(130, 73, '2024-10-18 08:10:56'),
(131, 74, '2024-10-18 09:44:58'),
(132, 74, '2024-10-18 08:03:59'),
(133, 75, '2024-10-19 21:53:50'),
(134, 76, '2024-10-18 22:35:30'),
(135, 76, '2024-10-21 21:47:02'),
(136, 77, '2024-10-19 17:31:42'),
(137, 78, '2024-10-19 02:48:30'),
(138, 79, '2024-10-21 22:36:26'),
(139, 79, '2024-10-20 17:01:47'),
(140, 79, '2024-10-20 03:37:25'),
(141, 80, '2024-10-22 05:32:09'),
(142, 80, '2024-10-21 17:59:58'),
(143, 81, '2024-10-19 22:21:44'),
(144, 81, '2024-10-18 21:53:32'),
(145, 81, '2024-10-21 16:22:20'),
(146, 82, '2024-10-21 20:40:09'),
(147, 82, '2024-10-19 03:40:42'),
(148, 82, '2024-10-18 06:55:57'),
(149, 83, '2024-10-20 18:36:46'),
(150, 83, '2024-10-20 16:58:14'),
(151, 83, '2024-10-22 18:55:32'),
(152, 84, '2024-10-21 02:58:17'),
(153, 85, '2024-10-18 11:35:57'),
(154, 85, '2024-10-22 15:07:07'),
(155, 86, '2024-10-20 10:39:18'),
(156, 86, '2024-10-21 17:50:07'),
(157, 86, '2024-10-20 15:32:14'),
(158, 87, '2024-10-19 15:35:09'),
(159, 88, '2024-10-21 07:45:25'),
(160, 89, '2024-10-20 08:45:35'),
(161, 89, '2024-10-20 01:56:00'),
(162, 90, '2024-10-18 18:24:58'),
(163, 91, '2024-10-22 00:35:57'),
(164, 91, '2024-10-18 03:41:29'),
(165, 92, '2024-10-21 22:06:42'),
(166, 93, '2024-10-20 08:56:27'),
(167, 93, '2024-10-18 07:08:49'),
(168, 94, '2024-10-20 10:40:14'),
(169, 94, '2024-10-18 20:32:44'),
(170, 95, '2024-10-19 18:59:37'),
(171, 95, '2024-10-22 00:29:05'),
(172, 95, '2024-10-21 14:55:14'),
(173, 96, '2024-10-18 19:12:25'),
(174, 96, '2024-10-21 10:01:24'),
(175, 96, '2024-10-21 17:58:40'),
(176, 97, '2024-10-18 13:29:07'),
(177, 97, '2024-10-19 06:31:12'),
(178, 98, '2024-10-22 00:56:02'),
(179, 99, '2024-10-21 13:58:45'),
(180, 99, '2024-10-21 21:23:59'),
(181, 99, '2024-10-18 11:44:54'),
(182, 100, '2024-10-22 11:29:01'),
(183, 100, '2024-10-22 18:27:17'),
(184, 101, '2024-10-20 19:39:09'),
(185, 102, '2024-10-18 14:03:20'),
(186, 103, '2024-10-22 09:24:47'),
(187, 104, '2024-10-22 19:15:56'),
(188, 105, '2024-10-21 20:19:22'),
(189, 106, '2024-10-22 06:12:26'),
(190, 107, '2024-10-30 15:08:17'),
(193, 107, '2024-10-30 16:13:04'),
(194, 107, '2024-10-30 16:17:05'),
(195, 108, '2024-10-30 16:25:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preinscripciones_grupos`
--

CREATE TABLE `preinscripciones_grupos` (
  `id` int(10) NOT NULL,
  `id_preinscripcion` int(10) NOT NULL,
  `id_grupo` smallint(5) NOT NULL,
  `prioridad` tinyint(3) NOT NULL,
  `admitido` tinyint(3) NOT NULL DEFAULT 0,
  `num_reserva` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `preinscripciones_grupos`
--

INSERT INTO `preinscripciones_grupos` (`id`, `id_preinscripcion`, `id_grupo`, `prioridad`, `admitido`, `num_reserva`) VALUES
(1, 64, 16, 1, 0, NULL),
(2, 69, 26, 1, 0, NULL),
(3, 105, 24, 1, 0, NULL),
(4, 105, 23, 2, 0, NULL),
(5, 14, 5, 1, 0, NULL),
(6, 14, 6, 2, 0, NULL),
(7, 14, 7, 3, 0, NULL),
(8, 19, 31, 1, 0, NULL),
(9, 19, 30, 2, 0, NULL),
(10, 164, 17, 1, 0, NULL),
(11, 164, 18, 2, 0, NULL),
(12, 164, 19, 3, 0, NULL),
(13, 17, 34, 1, 0, NULL),
(14, 17, 33, 2, 0, NULL),
(15, 148, 8, 1, 0, NULL),
(16, 148, 9, 2, 0, NULL),
(17, 148, 10, 3, 0, NULL),
(18, 167, 16, 1, 0, NULL),
(19, 31, 32, 1, 0, NULL),
(20, 132, 36, 1, 0, NULL),
(21, 130, 22, 1, 0, NULL),
(22, 126, 20, 1, 0, NULL),
(23, 126, 21, 2, 0, NULL),
(24, 131, 32, 1, 0, NULL),
(25, 13, 35, 1, 0, NULL),
(26, 122, 22, 1, 0, NULL),
(27, 153, 26, 1, 0, NULL),
(28, 181, 20, 1, 0, NULL),
(29, 181, 21, 2, 0, NULL),
(30, 117, 35, 1, 0, NULL),
(31, 78, 8, 1, 0, NULL),
(32, 78, 9, 2, 0, NULL),
(33, 78, 10, 3, 0, NULL),
(34, 2, 34, 1, 0, NULL),
(35, 2, 33, 2, 0, NULL),
(36, 176, 26, 1, 0, NULL),
(37, 185, 26, 1, 0, NULL),
(38, 118, 11, 1, 0, NULL),
(39, 118, 12, 2, 0, NULL),
(40, 118, 13, 3, 0, NULL),
(41, 96, 1, 1, 0, NULL),
(42, 96, 2, 2, 0, NULL),
(43, 96, 3, 3, 0, NULL),
(44, 96, 4, 4, 0, NULL),
(45, 94, 34, 1, 0, NULL),
(46, 94, 33, 2, 0, NULL),
(47, 110, 1, 1, 0, NULL),
(48, 110, 2, 2, 0, NULL),
(49, 110, 3, 3, 0, NULL),
(50, 110, 4, 4, 0, NULL),
(51, 162, 17, 1, 0, NULL),
(52, 162, 18, 2, 0, NULL),
(53, 162, 19, 3, 0, NULL),
(54, 51, 22, 1, 0, NULL),
(55, 24, 35, 1, 0, NULL),
(56, 173, 34, 1, 0, NULL),
(57, 173, 33, 2, 0, NULL),
(58, 169, 25, 1, 0, NULL),
(59, 18, 20, 1, 0, NULL),
(60, 18, 21, 2, 0, NULL),
(61, 42, 16, 1, 0, NULL),
(62, 95, 20, 1, 0, NULL),
(63, 95, 21, 2, 0, NULL),
(64, 144, 22, 1, 0, NULL),
(65, 134, 17, 1, 0, NULL),
(66, 134, 18, 2, 0, NULL),
(67, 134, 19, 3, 0, NULL),
(68, 115, 5, 1, 0, NULL),
(69, 115, 6, 2, 0, NULL),
(70, 115, 7, 3, 0, NULL),
(71, 6, 26, 1, 0, NULL),
(72, 29, 35, 1, 0, NULL),
(73, 35, 26, 1, 0, NULL),
(74, 88, 36, 1, 0, NULL),
(75, 103, 5, 1, 0, NULL),
(76, 103, 6, 2, 0, NULL),
(77, 103, 7, 3, 0, NULL),
(78, 97, 20, 1, 0, NULL),
(79, 97, 21, 2, 0, NULL),
(80, 57, 26, 1, 0, NULL),
(81, 137, 17, 1, 0, NULL),
(82, 137, 18, 2, 0, NULL),
(83, 137, 19, 3, 0, NULL),
(84, 108, 14, 1, 0, NULL),
(85, 108, 15, 2, 0, NULL),
(86, 147, 16, 1, 0, NULL),
(87, 91, 34, 1, 0, NULL),
(88, 91, 33, 2, 0, NULL),
(89, 48, 22, 1, 0, NULL),
(90, 33, 5, 1, 0, NULL),
(91, 33, 6, 2, 0, NULL),
(92, 33, 7, 3, 0, NULL),
(93, 87, 20, 1, 0, NULL),
(94, 87, 21, 2, 0, NULL),
(95, 20, 1, 1, 0, NULL),
(96, 20, 2, 2, 0, NULL),
(97, 20, 3, 3, 0, NULL),
(98, 20, 4, 4, 0, NULL),
(99, 177, 16, 1, 0, NULL),
(100, 123, 35, 1, 0, NULL),
(101, 79, 20, 1, 0, NULL),
(102, 79, 21, 2, 0, NULL),
(103, 107, 25, 1, 0, NULL),
(104, 53, 17, 1, 0, NULL),
(105, 53, 18, 2, 0, NULL),
(106, 53, 19, 3, 0, NULL),
(107, 8, 22, 1, 0, NULL),
(108, 66, 14, 1, 0, NULL),
(109, 66, 15, 2, 0, NULL),
(110, 99, 8, 1, 0, NULL),
(111, 99, 9, 2, 0, NULL),
(112, 99, 10, 3, 0, NULL),
(113, 49, 35, 1, 0, NULL),
(114, 158, 5, 1, 0, NULL),
(115, 158, 6, 2, 0, NULL),
(116, 158, 7, 3, 0, NULL),
(117, 121, 36, 1, 0, NULL),
(118, 34, 16, 1, 0, NULL),
(119, 136, 11, 1, 0, NULL),
(120, 136, 12, 2, 0, NULL),
(121, 136, 13, 3, 0, NULL),
(122, 170, 35, 1, 0, NULL),
(123, 85, 24, 1, 0, NULL),
(124, 85, 23, 2, 0, NULL),
(125, 54, 17, 1, 0, NULL),
(126, 54, 18, 2, 0, NULL),
(127, 54, 19, 3, 0, NULL),
(128, 70, 24, 1, 0, NULL),
(129, 70, 23, 2, 0, NULL),
(130, 93, 26, 1, 0, NULL),
(131, 133, 35, 1, 0, NULL),
(132, 143, 1, 1, 0, NULL),
(133, 143, 2, 2, 0, NULL),
(134, 143, 3, 3, 0, NULL),
(135, 143, 4, 4, 0, NULL),
(136, 23, 34, 1, 0, NULL),
(137, 23, 33, 2, 0, NULL),
(138, 11, 24, 1, 0, NULL),
(139, 11, 23, 2, 0, NULL),
(140, 22, 11, 1, 0, NULL),
(141, 22, 12, 2, 0, NULL),
(142, 22, 13, 3, 0, NULL),
(143, 161, 31, 1, 0, NULL),
(144, 161, 30, 2, 0, NULL),
(145, 72, 14, 1, 0, NULL),
(146, 72, 15, 2, 0, NULL),
(147, 68, 20, 1, 0, NULL),
(148, 68, 21, 2, 0, NULL),
(149, 15, 25, 1, 0, NULL),
(150, 140, 36, 1, 0, NULL),
(151, 26, 8, 1, 0, NULL),
(152, 26, 9, 2, 0, NULL),
(153, 26, 10, 3, 0, NULL),
(154, 81, 26, 1, 0, NULL),
(155, 41, 32, 1, 0, NULL),
(156, 71, 16, 1, 0, NULL),
(157, 119, 26, 1, 0, NULL),
(158, 160, 25, 1, 0, NULL),
(159, 166, 31, 1, 0, NULL),
(160, 166, 30, 2, 0, NULL),
(161, 155, 34, 1, 0, NULL),
(162, 155, 33, 2, 0, NULL),
(163, 168, 11, 1, 0, NULL),
(164, 168, 12, 2, 0, NULL),
(165, 168, 13, 3, 0, NULL),
(166, 90, 32, 1, 0, NULL),
(167, 76, 14, 1, 0, NULL),
(168, 76, 15, 2, 0, NULL),
(169, 37, 11, 1, 0, NULL),
(170, 37, 12, 2, 0, NULL),
(171, 37, 13, 3, 0, NULL),
(172, 80, 32, 1, 0, NULL),
(173, 127, 17, 1, 0, NULL),
(174, 127, 18, 2, 0, NULL),
(175, 127, 19, 3, 0, NULL),
(176, 157, 36, 1, 0, NULL),
(177, 73, 34, 1, 0, NULL),
(178, 73, 33, 2, 0, NULL),
(179, 60, 25, 1, 0, NULL),
(180, 30, 8, 1, 0, NULL),
(181, 30, 9, 2, 0, NULL),
(182, 30, 10, 3, 0, NULL),
(183, 150, 11, 1, 0, NULL),
(184, 150, 12, 2, 0, NULL),
(185, 150, 13, 3, 0, NULL),
(186, 139, 26, 1, 0, NULL),
(187, 149, 32, 1, 0, NULL),
(188, 184, 11, 1, 0, NULL),
(189, 184, 12, 2, 0, NULL),
(190, 184, 13, 3, 0, NULL),
(191, 75, 17, 1, 0, NULL),
(192, 75, 18, 2, 0, NULL),
(193, 75, 19, 3, 0, NULL),
(194, 128, 26, 1, 0, NULL),
(195, 124, 27, 1, 0, NULL),
(196, 124, 28, 2, 0, NULL),
(197, 124, 29, 3, 0, NULL),
(198, 92, 25, 1, 0, NULL),
(199, 63, 1, 1, 0, NULL),
(200, 63, 2, 2, 0, NULL),
(201, 63, 3, 3, 0, NULL),
(202, 63, 4, 4, 0, NULL),
(203, 152, 22, 1, 0, NULL),
(204, 125, 31, 1, 0, NULL),
(205, 125, 30, 2, 0, NULL),
(206, 98, 35, 1, 0, NULL),
(207, 86, 31, 1, 0, NULL),
(208, 86, 30, 2, 0, NULL),
(209, 38, 31, 1, 0, NULL),
(210, 38, 30, 2, 0, NULL),
(211, 3, 8, 1, 0, NULL),
(212, 3, 9, 2, 0, NULL),
(213, 3, 10, 3, 0, NULL),
(214, 25, 25, 1, 0, NULL),
(215, 116, 24, 1, 0, NULL),
(216, 116, 23, 2, 0, NULL),
(217, 159, 24, 1, 0, NULL),
(218, 159, 23, 2, 0, NULL),
(219, 36, 35, 1, 0, NULL),
(220, 129, 16, 1, 0, NULL),
(221, 1, 20, 1, 0, NULL),
(222, 1, 21, 2, 0, NULL),
(223, 65, 20, 1, 0, NULL),
(224, 65, 21, 2, 0, NULL),
(225, 83, 11, 1, 0, NULL),
(226, 83, 12, 2, 0, NULL),
(227, 83, 13, 3, 0, NULL),
(228, 174, 32, 1, 0, NULL),
(229, 114, 20, 1, 0, NULL),
(230, 114, 21, 2, 0, NULL),
(231, 4, 36, 1, 0, NULL),
(232, 112, 34, 1, 0, NULL),
(233, 112, 33, 2, 0, NULL),
(234, 109, 20, 1, 0, NULL),
(235, 109, 21, 2, 0, NULL),
(236, 113, 1, 1, 0, NULL),
(237, 113, 2, 2, 0, NULL),
(238, 113, 3, 3, 0, NULL),
(239, 113, 4, 4, 0, NULL),
(240, 46, 27, 1, 0, NULL),
(241, 46, 28, 2, 0, NULL),
(242, 46, 29, 3, 0, NULL),
(243, 179, 16, 1, 0, NULL),
(244, 106, 22, 1, 0, NULL),
(245, 172, 11, 1, 0, NULL),
(246, 172, 12, 2, 0, NULL),
(247, 172, 13, 3, 0, NULL),
(248, 43, 16, 1, 0, NULL),
(249, 7, 22, 1, 0, NULL),
(250, 145, 31, 1, 0, NULL),
(251, 145, 30, 2, 0, NULL),
(252, 102, 1, 1, 0, NULL),
(253, 102, 2, 2, 0, NULL),
(254, 102, 3, 3, 0, NULL),
(255, 102, 4, 4, 0, NULL),
(256, 21, 16, 1, 0, NULL),
(257, 45, 22, 1, 0, NULL),
(258, 156, 35, 1, 0, NULL),
(259, 175, 14, 1, 0, NULL),
(260, 175, 15, 2, 0, NULL),
(261, 142, 27, 1, 0, NULL),
(262, 142, 28, 2, 0, NULL),
(263, 142, 29, 3, 0, NULL),
(264, 9, 32, 1, 0, NULL),
(265, 188, 1, 1, 0, NULL),
(266, 188, 2, 2, 0, NULL),
(267, 188, 3, 3, 0, NULL),
(268, 188, 4, 4, 0, NULL),
(269, 146, 26, 1, 0, NULL),
(270, 12, 14, 1, 0, NULL),
(271, 12, 15, 2, 0, NULL),
(272, 28, 17, 1, 0, NULL),
(273, 28, 18, 2, 0, NULL),
(274, 28, 19, 3, 0, NULL),
(275, 180, 36, 1, 0, NULL),
(276, 135, 31, 1, 0, NULL),
(277, 135, 30, 2, 0, NULL),
(278, 165, 34, 1, 0, NULL),
(279, 165, 33, 2, 0, NULL),
(280, 100, 36, 1, 0, NULL),
(281, 120, 36, 1, 0, NULL),
(282, 61, 26, 1, 0, NULL),
(283, 138, 17, 1, 0, NULL),
(284, 138, 18, 2, 0, NULL),
(285, 138, 19, 3, 0, NULL),
(286, 82, 27, 1, 0, NULL),
(287, 82, 28, 2, 0, NULL),
(288, 82, 29, 3, 0, NULL),
(289, 39, 17, 1, 0, NULL),
(290, 39, 18, 2, 0, NULL),
(291, 39, 19, 3, 0, NULL),
(292, 74, 14, 1, 0, NULL),
(293, 74, 15, 2, 0, NULL),
(294, 171, 35, 1, 0, NULL),
(295, 163, 5, 1, 0, NULL),
(296, 163, 6, 2, 0, NULL),
(297, 163, 7, 3, 0, NULL),
(298, 59, 22, 1, 0, NULL),
(299, 10, 26, 1, 0, NULL),
(300, 178, 35, 1, 0, NULL),
(301, 56, 1, 1, 0, NULL),
(302, 56, 2, 2, 0, NULL),
(303, 56, 3, 3, 0, NULL),
(304, 56, 4, 4, 0, NULL),
(305, 44, 24, 1, 0, NULL),
(306, 44, 23, 2, 0, NULL),
(307, 141, 25, 1, 0, NULL),
(308, 189, 8, 1, 0, NULL),
(309, 189, 9, 2, 0, NULL),
(310, 189, 10, 3, 0, NULL),
(311, 27, 31, 1, 0, NULL),
(312, 27, 30, 2, 0, NULL),
(313, 104, 20, 1, 0, NULL),
(314, 104, 21, 2, 0, NULL),
(315, 50, 31, 1, 0, NULL),
(316, 50, 30, 2, 0, NULL),
(317, 186, 5, 1, 0, NULL),
(318, 186, 6, 2, 0, NULL),
(319, 186, 7, 3, 0, NULL),
(320, 101, 35, 1, 0, NULL),
(321, 182, 17, 1, 0, NULL),
(322, 182, 18, 2, 0, NULL),
(323, 182, 19, 3, 0, NULL),
(324, 111, 8, 1, 0, NULL),
(325, 111, 9, 2, 0, NULL),
(326, 111, 10, 3, 0, NULL),
(327, 32, 8, 1, 0, NULL),
(328, 32, 9, 2, 0, NULL),
(329, 32, 10, 3, 0, NULL),
(330, 40, 20, 1, 0, NULL),
(331, 40, 21, 2, 0, NULL),
(332, 154, 31, 1, 0, NULL),
(333, 154, 30, 2, 0, NULL),
(334, 55, 17, 1, 0, NULL),
(335, 55, 18, 2, 0, NULL),
(336, 55, 19, 3, 0, NULL),
(337, 77, 22, 1, 0, NULL),
(338, 84, 31, 1, 0, NULL),
(339, 84, 30, 2, 0, NULL),
(340, 183, 8, 1, 0, NULL),
(341, 183, 9, 2, 0, NULL),
(342, 183, 10, 3, 0, NULL),
(343, 52, 25, 1, 0, NULL),
(344, 151, 36, 1, 0, NULL),
(345, 187, 35, 1, 0, NULL),
(346, 62, 27, 1, 0, NULL),
(347, 62, 28, 2, 0, NULL),
(348, 62, 29, 3, 0, NULL),
(349, 5, 11, 1, 0, NULL),
(350, 5, 12, 2, 0, NULL),
(351, 5, 13, 3, 0, NULL),
(352, 58, 36, 1, 0, NULL),
(353, 16, 35, 1, 0, NULL),
(354, 89, 26, 1, 0, NULL),
(355, 47, 1, 1, 0, NULL),
(356, 47, 2, 2, 0, NULL),
(357, 47, 3, 3, 0, NULL),
(358, 47, 4, 4, 0, NULL),
(359, 67, 36, 1, 0, NULL),
(364, 190, 1, 1, 0, NULL),
(365, 190, 2, 2, 0, NULL),
(366, 190, 3, 3, 0, NULL),
(367, 190, 4, 4, 0, NULL),
(372, 193, 17, 1, 0, NULL),
(373, 193, 18, 2, 0, NULL),
(374, 193, 19, 3, 0, NULL),
(375, 194, 32, 1, 0, NULL),
(376, 195, 5, 1, 0, NULL),
(377, 195, 6, 2, 0, NULL),
(378, 195, 7, 3, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preinscritos`
--

CREATE TABLE `preinscritos` (
  `id` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `preinscritos`
--

INSERT INTO `preinscritos` (`id`, `nombre`, `apellido`) VALUES
(1, 'Ana', 'Gómez'),
(2, 'María', 'López'),
(3, 'Ángel', 'Hernández'),
(4, 'Luís', 'Fernández'),
(5, 'Marta', 'Sánchez'),
(6, 'Sofía', 'Pérez'),
(7, 'Josefa', 'Hernández'),
(8, 'Antonio', 'Ramírez'),
(9, 'Ana', 'Torres'),
(10, 'Luz', 'Castillo'),
(11, 'Iñaki', 'Alonso'),
(12, 'Javier', 'Cruz'),
(13, 'Clara', 'Vargas'),
(14, 'Diego', 'Mendoza'),
(15, 'Rocío', 'Salazar'),
(16, 'Fatima', 'Benali'),
(17, 'Hassan', 'El Amrani'),
(18, 'Lucía', 'Márquez'),
(19, 'Pablo', 'Córdoba'),
(20, 'Jasmine', 'Rivera'),
(21, 'Luis', 'Diaz'),
(22, 'Carlos', 'Aguirre'),
(23, 'Renata', 'Rojas'),
(24, 'Fernando', 'Muñoz'),
(25, 'Salma', 'Haddad'),
(26, 'Ximena', 'Cruz'),
(27, 'Rafael', 'Pineda'),
(28, 'Nadia', 'Soto'),
(29, 'Jorge', 'Alvarez'),
(30, 'Martín', 'Cáceres'),
(31, 'Belén', 'Quintero'),
(32, 'Omar', 'Gharbi'),
(33, 'Patricia', 'Zavala'),
(34, 'Ramón', 'López'),
(35, 'Juliana', 'Medina'),
(36, 'Nicolas', 'Escobar'),
(37, 'Santiago', 'Valdés'),
(38, 'Valeria', 'Duran'),
(39, 'Mateo', 'Figueroa'),
(40, 'Marisol', 'Salinas'),
(41, 'Sofía', 'Rivas'),
(42, 'Emilio', 'Arce'),
(43, 'Ester', 'Bermúdez'),
(44, 'Vicente', 'Cortés'),
(45, 'Cristina', 'Reyes'),
(46, 'Álvaro', 'Sierra'),
(47, 'Fernando', 'Ceballos'),
(48, 'Aurora', 'Carrillo'),
(49, 'Estela', 'Villanueva'),
(50, 'Marco', 'Parra'),
(51, 'Leticia', 'Alarcón'),
(52, 'Hugo', 'Cabrera'),
(53, 'Florencia', 'Cáceres'),
(54, 'Carlos', 'Gutiérrez'),
(55, 'Verónica', 'Salazar'),
(56, 'José', 'Ramírez'),
(57, 'Julieta', 'Martínez'),
(58, 'Raúl', 'Sánchez'),
(59, 'Mireya', 'Pérez'),
(60, 'Ricardo', 'Hernández'),
(61, 'Patricia', 'Alonso'),
(62, 'Adrián', 'Cruz'),
(63, 'Sofía', 'Vega'),
(64, 'Marcos', 'Ríos'),
(65, 'Inés', 'Moreno'),
(66, 'Andrés', 'Cordero'),
(67, 'Lucía', 'Díaz'),
(68, 'Esteban', 'Castro'),
(69, 'Julián', 'Salinas'),
(70, 'Rafael', 'Mendoza'),
(71, 'Lucía', 'Morales'),
(72, 'Fernando', 'Alvarez'),
(73, 'Tania', 'González'),
(74, 'Elias', 'Pérez'),
(75, 'Claudia', 'Rivas'),
(76, 'Patricia', 'Reyes'),
(77, 'Gustavo', 'Torres'),
(78, 'Susana', 'Mora'),
(79, 'Mónica', 'Aguirre'),
(80, 'Santiago', 'Bravo'),
(81, 'Ana', 'Cárdenas'),
(82, 'Guillermo', 'Figueroa'),
(83, 'Victoria', 'Soto'),
(84, 'Rodolfo', 'Vargas'),
(85, 'Catalina', 'Silva'),
(86, 'Estela', 'Fernández'),
(87, 'Julio', 'Hidalgo'),
(88, 'Nicolás', 'Rosales'),
(89, 'Vanessa', 'Cortés'),
(90, 'Fernando', 'Pérez'),
(91, 'María', 'Arias'),
(92, 'Raúl', 'Vega'),
(93, 'Claudio', 'Bermúdez'),
(94, 'Cecilia', 'González'),
(95, 'Diego', 'Cifuentes'),
(96, 'José', 'Salas'),
(97, 'Mariana', 'Trujillo'),
(98, 'Rafael', 'Cano'),
(99, 'Nora', 'Coronado'),
(100, 'Alejandro', 'Jiménez'),
(101, 'Carmen', 'Peña'),
(102, 'Adriana', 'Vargas'),
(103, 'Samuel', 'Zamora'),
(104, 'Verónica', 'Pérez'),
(105, 'León', 'Aguirre'),
(106, 'Martín', 'Córdova'),
(107, 'Ana Delia', 'Campo'),
(108, 'Marta', 'Campo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preinscritos_private`
--

CREATE TABLE `preinscritos_private` (
  `id` int(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `preinscritos_private`
--

INSERT INTO `preinscritos_private` (`id`, `email`, `dni`, `fecha_nacimiento`, `password`) VALUES
(1, 'jose.gomez@example.com', '12345678A', '1990-05-14', '098f6bcd4621d373cade4e832627b4f6'),
(2, 'maria.lopez@example.com', '23456789B', '1985-08-20', '098f6bcd4621d373cade4e832627b4f6'),
(3, 'angel.hernandez@example.com', '34567890C', '1970-01-10', '098f6bcd4621d373cade4e832627b4f6'),
(4, 'luis.fernandez@example.com', 'Y1234567Z', '1983-11-05', '098f6bcd4621d373cade4e832627b4f6'),
(5, 'marta.sanchez@example.com', '45678901D', '1995-02-12', '098f6bcd4621d373cade4e832627b4f6'),
(6, 'sofia.perez@example.com', 'X1234567W', '2000-07-25', '098f6bcd4621d373cade4e832627b4f6'),
(7, 'josefa.hernandez@example.com', '56789012E', '1988-04-18', '098f6bcd4621d373cade4e832627b4f6'),
(8, 'esteban.ramirez@example.com', 'Z1234567V', '1992-09-15', '098f6bcd4621d373cade4e832627b4f6'),
(9, 'ana.torres@example.com', '67890123F', '1980-12-30', '098f6bcd4621d373cade4e832627b4f6'),
(10, 'luz.castillo@example.com', 'A1234567B', '1975-03-22', '098f6bcd4621d373cade4e832627b4f6'),
(11, 'inaki.alonso@example.com', '78901234G', '1987-06-09', '098f6bcd4621d373cade4e832627b4f6'),
(12, 'javier.cruz@example.com', 'Y2345678C', '1981-10-17', '098f6bcd4621d373cade4e832627b4f6'),
(13, 'clara.vargas@example.com', '89012345H', '1998-11-11', '098f6bcd4621d373cade4e832627b4f6'),
(14, 'diego.mendoza@example.com', 'X2345678D', '1978-01-05', '098f6bcd4621d373cade4e832627b4f6'),
(15, 'rocio.salazar@example.com', '90123456I', '1999-03-30', '098f6bcd4621d373cade4e832627b4f6'),
(16, 'fatima.benali@example.com', '12345678D', '1983-04-25', '098f6bcd4621d373cade4e832627b4f6'),
(17, 'hassan.elamrani@example.com', '23456789F', '1975-06-18', '098f6bcd4621d373cade4e832627b4f6'),
(18, 'lucia.marquez@example.com', '34567890G', '1994-02-01', '098f6bcd4621d373cade4e832627b4f6'),
(19, 'pablo.cordoba@example.com', '45678901H', '1988-07-22', '098f6bcd4621d373cade4e832627b4f6'),
(20, 'jasmine.rivera@example.com', '56789012I', '1992-08-14', '098f6bcd4621d373cade4e832627b4f6'),
(21, 'luis.diaz@example.com', '67890123J', '1980-12-15', '098f6bcd4621d373cade4e832627b4f6'),
(22, 'carlos.aguirre@example.com', '78901234K', '1972-03-10', '098f6bcd4621d373cade4e832627b4f6'),
(23, 'renata.rojas@example.com', '89012345L', '1986-05-28', '098f6bcd4621d373cade4e832627b4f6'),
(24, 'fernando.munoz@example.com', '90123456M', '1995-01-21', '098f6bcd4621d373cade4e832627b4f6'),
(25, 'salma.haddad@example.com', '12345679N', '1982-04-15', '098f6bcd4621d373cade4e832627b4f6'),
(26, 'ximena.cruz@example.com', '23456780O', '1989-06-30', '098f6bcd4621d373cade4e832627b4f6'),
(27, 'rafael.pineda@example.com', '34567891P', '1978-09-12', '098f6bcd4621d373cade4e832627b4f6'),
(28, 'nadia.soto@example.com', '45678902Q', '1984-11-05', '098f6bcd4621d373cade4e832627b4f6'),
(29, 'jorge.alvarez@example.com', '56789013R', '1991-08-28', '098f6bcd4621d373cade4e832627b4f6'),
(30, 'martin.caceres@example.com', '67890124S', '1976-07-20', '098f6bcd4621d373cade4e832627b4f6'),
(31, 'belen.quintero@example.com', '78901235T', '1987-10-10', '098f6bcd4621d373cade4e832627b4f6'),
(32, 'omar.gharbi@example.com', '89012346U', '1993-03-15', '098f6bcd4621d373cade4e832627b4f6'),
(33, 'patricia.zavala@example.com', '90123457V', '1996-12-01', '098f6bcd4621d373cade4e832627b4f6'),
(34, 'ramon.lopez@example.com', '12345680W', '1980-01-17', '098f6bcd4621d373cade4e832627b4f6'),
(35, 'juliana.medina@example.com', '23456781X', '1985-09-09', '098f6bcd4621d373cade4e832627b4f6'),
(36, 'nicolas.escobar@example.com', '34567892Y', '1999-04-11', '098f6bcd4621d373cade4e832627b4f6'),
(37, 'santiago.valdes@example.com', '45678903Z', '1973-08-21', '098f6bcd4621d373cade4e832627b4f6'),
(38, 'valeria.duran@example.com', '56789014A', '1981-11-30', '098f6bcd4621d373cade4e832627b4f6'),
(39, 'mateo.figueroa@example.com', '67890125B', '1990-06-03', '098f6bcd4621d373cade4e832627b4f6'),
(40, 'marisol.salinas@example.com', '78901236C', '1979-12-12', '098f6bcd4621d373cade4e832627b4f6'),
(41, 'sofia.rivas@example.com', '89012347D', '1988-07-15', '098f6bcd4621d373cade4e832627b4f6'),
(42, 'emilio.arce@example.com', '90123458E', '1994-10-10', '098f6bcd4621d373cade4e832627b4f6'),
(43, 'ester.bermudez@example.com', '12345681F', '1982-02-28', '098f6bcd4621d373cade4e832627b4f6'),
(44, 'vicente.cortes@example.com', '23456782G', '1975-03-18', '098f6bcd4621d373cade4e832627b4f6'),
(45, 'cristina.reyes@example.com', '34567893H', '1987-04-29', '098f6bcd4621d373cade4e832627b4f6'),
(46, 'alvaro.sierra@example.com', '45678904I', '1992-08-12', '098f6bcd4621d373cade4e832627b4f6'),
(47, 'fernando.ceballos@example.com', '56789015J', '1998-05-24', '098f6bcd4621d373cade4e832627b4f6'),
(48, 'aurora.carrillo@example.com', '67890126K', '1983-09-06', '098f6bcd4621d373cade4e832627b4f6'),
(49, 'estela.villanueva@example.com', '78901237L', '1986-06-16', '098f6bcd4621d373cade4e832627b4f6'),
(50, 'marco.parra@example.com', '90123459M', '1991-01-01', '098f6bcd4621d373cade4e832627b4f6'),
(51, 'leticia.alarcon@example.com', '12345682N', '1977-12-21', '098f6bcd4621d373cade4e832627b4f6'),
(52, 'hugo.cabrera@example.com', '23456783O', '1985-10-29', '098f6bcd4621d373cade4e832627b4f6'),
(53, 'florencia.caceres@example.com', '34567894P', '1994-02-14', '098f6bcd4621d373cade4e832627b4f6'),
(54, 'carlos.gutierrez@example.com', '12345678A', '1983-04-12', '098f6bcd4621d373cade4e832627b4f6'),
(55, 'veronica.salazar@example.com', '23456789B', '1979-05-22', '098f6bcd4621d373cade4e832627b4f6'),
(56, 'jose.ramirez@example.com', '34567890C', '1992-06-15', '098f6bcd4621d373cade4e832627b4f6'),
(57, 'julieta.martinez@example.com', 'Y1234567Z', '1990-12-01', '098f6bcd4621d373cade4e832627b4f6'),
(58, 'raul.sanchez@example.com', '45678901D', '1981-02-17', '098f6bcd4621d373cade4e832627b4f6'),
(59, 'mireya.perez@example.com', 'X1234567W', '1995-07-09', '098f6bcd4621d373cade4e832627b4f6'),
(60, 'ricardo.hernandez@example.com', '56789012E', '1988-10-24', '098f6bcd4621d373cade4e832627b4f6'),
(61, 'patricia.alonso@example.com', 'Z1234567V', '1975-11-30', '098f6bcd4621d373cade4e832627b4f6'),
(62, 'adrian.cruz@example.com', '67890123F', '1986-09-14', '098f6bcd4621d373cade4e832627b4f6'),
(63, 'sofia.vega@example.com', 'A1234567B', '1993-03-25', '098f6bcd4621d373cade4e832627b4f6'),
(64, 'marcos.rios@example.com', '78901234G', '1982-08-11', '098f6bcd4621d373cade4e832627b4f6'),
(65, 'ines.moreno@example.com', 'Y2345678C', '1994-01-20', '098f6bcd4621d373cade4e832627b4f6'),
(66, 'andres.cordero@example.com', '89012345H', '1985-06-05', '098f6bcd4621d373cade4e832627b4f6'),
(67, 'lucia.diaz@example.com', 'X2345678D', '1991-10-30', '098f6bcd4621d373cade4e832627b4f6'),
(68, 'esteban.castro@example.com', '90123456I', '1984-02-15', '098f6bcd4621d373cade4e832627b4f6'),
(69, 'julian.salinas@example.com', 'A2345678J', '1990-11-28', '098f6bcd4621d373cade4e832627b4f6'),
(70, 'rafael.mendoza@example.com', 'B1234567K', '1987-07-01', '098f6bcd4621d373cade4e832627b4f6'),
(71, 'lucia.morales@example.com', 'C2345678L', '1992-05-18', '098f6bcd4621d373cade4e832627b4f6'),
(72, 'fernando.alvarez@example.com', 'D3456789M', '1983-04-07', '098f6bcd4621d373cade4e832627b4f6'),
(73, 'tania.gonzalez@example.com', 'E4567890N', '1995-09-13', '098f6bcd4621d373cade4e832627b4f6'),
(74, 'elias.perez@example.com', 'F5678901O', '1988-03-22', '098f6bcd4621d373cade4e832627b4f6'),
(75, 'claudia.rivas@example.com', 'G6789012P', '1980-12-05', '098f6bcd4621d373cade4e832627b4f6'),
(76, 'patricia.reyes@example.com', 'H7890123Q', '1976-02-28', '098f6bcd4621d373cade4e832627b4f6'),
(77, 'gustavo.torres@example.com', 'I8901234R', '1984-01-15', '098f6bcd4621d373cade4e832627b4f6'),
(78, 'susana.mora@example.com', 'J9012345S', '1992-06-20', '098f6bcd4621d373cade4e832627b4f6'),
(79, 'monica.aguirre@example.com', 'K0123456T', '1979-08-29', '098f6bcd4621d373cade4e832627b4f6'),
(80, 'santiago.bravo@example.com', 'L1234567U', '1987-10-01', '098f6bcd4621d373cade4e832627b4f6'),
(81, 'ana.cardenas@example.com', 'M2345678V', '1994-03-11', '098f6bcd4621d373cade4e832627b4f6'),
(82, 'guillermo.figueroa@example.com', 'N3456789W', '1982-09-23', '098f6bcd4621d373cade4e832627b4f6'),
(83, 'victoria.soto@example.com', 'O4567890X', '1990-04-18', '098f6bcd4621d373cade4e832627b4f6'),
(84, 'rodolfo.vargas@example.com', 'P5678901Y', '1985-12-20', '098f6bcd4621d373cade4e832627b4f6'),
(85, 'catalina.silva@example.com', 'Q6789012Z', '1993-01-14', '098f6bcd4621d373cade4e832627b4f6'),
(86, 'estela.fernandez@example.com', 'R7890123A', '1981-11-08', '098f6bcd4621d373cade4e832627b4f6'),
(87, 'julio.hidalgo@example.com', 'S8901234B', '1990-06-27', '098f6bcd4621d373cade4e832627b4f6'),
(88, 'nicolas.rosales@example.com', 'T9012345C', '1986-03-30', '098f6bcd4621d373cade4e832627b4f6'),
(89, 'vanessa.cortes@example.com', 'U0123456D', '1992-02-14', '098f6bcd4621d373cade4e832627b4f6'),
(90, 'fernando.perez@example.com', 'V1234567E', '1984-12-11', '098f6bcd4621d373cade4e832627b4f6'),
(91, 'maria.arias@example.com', 'W2345678F', '1993-08-22', '098f6bcd4621d373cade4e832627b4f6'),
(92, 'raul.vega@example.com', 'X3456789G', '1989-05-05', '098f6bcd4621d373cade4e832627b4f6'),
(93, 'claudio.bermudez@example.com', 'Y4567890H', '1980-10-09', '098f6bcd4621d373cade4e832627b4f6'),
(94, 'cecilia.gonzalez@example.com', 'Z5678901I', '1991-07-07', '098f6bcd4621d373cade4e832627b4f6'),
(95, 'diego.cifuentes@example.com', 'A6789012J', '1982-03-18', '098f6bcd4621d373cade4e832627b4f6'),
(96, 'jose.salas@example.com', 'B7890123K', '1995-11-14', '098f6bcd4621d373cade4e832627b4f6'),
(97, 'mariana.trujillo@example.com', 'C8901234L', '1986-12-19', '098f6bcd4621d373cade4e832627b4f6'),
(98, 'rafael.cano@example.com', 'D9012345M', '1990-01-21', '098f6bcd4621d373cade4e832627b4f6'),
(99, 'nora.coronado@example.com', 'E0123456N', '1984-05-10', '098f6bcd4621d373cade4e832627b4f6'),
(100, 'alejandro.jimenez@example.com', 'F1234567O', '1988-09-30', '098f6bcd4621d373cade4e832627b4f6'),
(101, 'carmen.pena@example.com', 'G2345678P', '1979-02-15', '098f6bcd4621d373cade4e832627b4f6'),
(102, 'adriana.vargas@example.com', 'H3456789Q', '1993-08-08', '098f6bcd4621d373cade4e832627b4f6'),
(103, 'samuel.zamora@example.com', 'I4567890R', '1987-10-27', '098f6bcd4621d373cade4e832627b4f6'),
(104, 'veronica.perez@example.com', 'J5678901S', '1991-04-11', '098f6bcd4621d373cade4e832627b4f6'),
(105, 'leon.aguirre@example.com', 'K6789012T', '1982-01-03', '098f6bcd4621d373cade4e832627b4f6'),
(106, 'martin.cordova@example.com', 'L7890123U', '1989-03-28', '098f6bcd4621d373cade4e832627b4f6'),
(107, 'deliacampo@gmail.com', '25463193P', '1974-12-24', '276b6c4692e78d4799c12ada515bc3e4'),
(108, 'marta.campo@gmail.com', '25445707H', '1977-11-08', 'a763a66f984948ca463b081bf0f0e6d0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sorteo_log`
--

CREATE TABLE `sorteo_log` (
  `idioma_id` int(11) NOT NULL,
  `numero_sorteo` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_idioma` (`id_idioma`),
  ADD KEY `id_nivel` (`id_nivel`),
  ADD KEY `id_horario` (`id_horario`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preinscripciones_cabecera`
--
ALTER TABLE `preinscripciones_cabecera`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_preinscrito` (`id_preinscrito`);

--
-- Indices de la tabla `preinscripciones_grupos`
--
ALTER TABLE `preinscripciones_grupos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_preinscripcion_2` (`id_preinscripcion`,`id_grupo`),
  ADD KEY `id_preinscripcion` (`id_preinscripcion`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indices de la tabla `preinscritos`
--
ALTER TABLE `preinscritos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preinscritos_private`
--
ALTER TABLE `preinscritos_private`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sorteo_log`
--
ALTER TABLE `sorteo_log`
  ADD PRIMARY KEY (`idioma_id`,`fecha`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `preinscripciones_cabecera`
--
ALTER TABLE `preinscripciones_cabecera`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT de la tabla `preinscripciones_grupos`
--
ALTER TABLE `preinscripciones_grupos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=379;

--
-- AUTO_INCREMENT de la tabla `preinscritos`
--
ALTER TABLE `preinscritos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `preinscritos_private`
--
ALTER TABLE `preinscritos_private`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idiomas` (`id`),
  ADD CONSTRAINT `grupos_ibfk_2` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id`),
  ADD CONSTRAINT `grupos_ibfk_3` FOREIGN KEY (`id_horario`) REFERENCES `horarios` (`id`);

--
-- Filtros para la tabla `preinscripciones_cabecera`
--
ALTER TABLE `preinscripciones_cabecera`
  ADD CONSTRAINT `preinscripciones_cabecera_ibfk_1` FOREIGN KEY (`id_preinscrito`) REFERENCES `preinscritos` (`id`);

--
-- Filtros para la tabla `preinscripciones_grupos`
--
ALTER TABLE `preinscripciones_grupos`
  ADD CONSTRAINT `preinscripciones_grupos_ibfk_1` FOREIGN KEY (`id_preinscripcion`) REFERENCES `preinscripciones_cabecera` (`id`),
  ADD CONSTRAINT `preinscripciones_grupos_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`);

--
-- Filtros para la tabla `preinscritos_private`
--
ALTER TABLE `preinscritos_private`
  ADD CONSTRAINT `preinscritos_private_ibfk_1` FOREIGN KEY (`id`) REFERENCES `preinscritos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
