-- phpMyAdmin SQL Dump
-- version 5.2.2deb1+deb13u1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-05-2026 a las 09:56:00
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
-- Base de datos: `gai_v1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aulas`
--

CREATE TABLE `aulas` (
  `id` smallint(6) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `capacidad` tinyint(4) NOT NULL COMMENT 'Capacidad física del aula: número máximo de personas que soporta',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `aulas`
--

INSERT INTO `aulas` (`id`, `nombre`, `capacidad`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Aula 1', 15, 1, '2026-05-04 10:20:16', '2026-05-04 10:20:16'),
(2, 'Aula 2', 15, 1, '2026-05-04 11:42:00', '2026-05-04 11:42:00'),
(3, 'Aula 3', 15, 1, '2026-05-04 11:42:00', '2026-05-04 11:42:00'),
(4, 'Aula 4', 15, 1, '2026-05-04 11:42:00', '2026-05-04 11:42:00'),
(5, 'Aula 5', 15, 1, '2026-05-04 11:42:00', '2026-05-04 11:42:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos_escolares`
--

CREATE TABLE `cursos_escolares` (
  `id` smallint(6) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='Restricciones lógicas:\n- Solo debería existir un curso escolar activo a la vez.\n- Esta validación debe controlarse desde la aplicación o lógica SQL adicional.\n';

--
-- Volcado de datos para la tabla `cursos_escolares`
--

INSERT INTO `cursos_escolares` (`id`, `nombre`, `fecha_inicio`, `fecha_fin`, `activo`, `created_at`, `updated_at`) VALUES
(1, '2026-2027', '2026-09-15', '2027-06-17', 1, '2026-05-04 11:23:23', '2026-05-04 11:23:23'),
(2, '2023-2024', '2023-09-15', '2024-06-15', 0, '2026-05-04 11:43:00', '2026-05-04 11:43:00'),
(3, '2024-2025', '2024-09-15', '2025-06-15', 0, '2026-05-04 11:43:00', '2026-05-04 11:43:00'),
(4, '2025-2026', '2025-09-15', '2026-06-15', 0, '2026-05-04 11:43:00', '2026-05-04 11:43:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `curso_id` smallint(6) NOT NULL,
  `idioma_id` tinyint(4) NOT NULL,
  `nivel_id` tinyint(4) NOT NULL,
  `aula_id` smallint(6) NOT NULL,
  `profesor_id` int(11) NOT NULL,
  `plazas_ofertadas` tinyint(4) NOT NULL COMMENT 'Plazas que se ofertan para este grupo; debe ser menor o igual que aulas.capacidad',
  `plazas_ocupadas` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Número de plazas ya ocupadas por matrículas',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `observaciones` varchar(255) DEFAULT NULL COMMENT 'Notas internas del grupo: incidencias, aclaraciones organizativas o particularidades no modeladas en otros campos',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='Restricciones lógicas:\n- No debe haber grupos duplicados funcionalmente para la misma combinación de curso, idioma, nivel y aula.\n- plazas_ofertadas debe ser menor o igual que aulas.capacidad.\n- plazas_ocupadas no debe ser mayor que plazas_ofertadas.\n- Las plazas disponibles se calculan en la aplicación como:\n  plazas_ofertadas - plazas_ocupadas.\n';

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `curso_id`, `idioma_id`, `nivel_id`, `aula_id`, `profesor_id`, `plazas_ofertadas`, `plazas_ocupadas`, `activo`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 15, 0, 1, NULL, '2026-05-04 11:26:24', '2026-05-04 11:26:24'),
(2, 1, 1, 3, 2, 2, 15, 0, 1, 'Inglés A2 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(3, 1, 2, 1, 2, 3, 15, 0, 1, 'Francés A1 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(4, 1, 2, 3, 3, 4, 15, 0, 1, 'Francés A2 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(5, 1, 3, 1, 3, 5, 15, 0, 1, 'Alemán A1 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(6, 1, 3, 3, 4, 7, 15, 0, 1, 'Alemán A2 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(7, 1, 4, 1, 4, 6, 15, 0, 1, 'Italiano A1 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(8, 1, 4, 3, 5, 7, 15, 0, 1, 'Italiano A2 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(9, 1, 1, 4, 2, 2, 15, 0, 1, 'Inglés B1 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(10, 1, 1, 5, 3, 4, 15, 0, 1, 'Inglés B2 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(11, 1, 2, 4, 4, 3, 15, 0, 1, 'Francés B1 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(12, 1, 2, 5, 5, 4, 15, 0, 1, 'Francés B2 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(13, 1, 1, 6, 1, 2, 15, 0, 1, 'Inglés C1 tarde', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(14, 1, 4, 4, 2, 6, 15, 0, 1, 'Italiano B1 mañana', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(15, 1, 4, 5, 3, 7, 15, 0, 1, 'Italiano B2 mañana', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(16, 1, 3, 4, 4, 5, 15, 0, 1, 'Alemán B1 mañana', '2026-05-04 12:00:00', '2026-05-04 12:00:00'),
(17, 1, 3, 5, 5, 7, 15, 0, 1, 'Alemán B2 mañana', '2026-05-04 12:00:00', '2026-05-04 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_horarios`
--

CREATE TABLE `grupo_horarios` (
  `id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  `dia_semana` tinyint(4) NOT NULL COMMENT '1=Lunes, 2=Martes, 3=Miércoles, 4=Jueves, 5=Viernes, 6=Sábado, 7=Domingo',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='Restricciones lógicas:\n- hora_fin debe ser mayor que hora_inicio.\n- No debe haber solapes de aula entre grupos activos en la misma franja horaria.\n- No debe haber solapes de profesor entre grupos activos en la misma franja horaria.\n- Estas validaciones deben controlarse desde la aplicación o con SQL específico.\n';

--
-- Volcado de datos para la tabla `grupo_horarios`
--

INSERT INTO `grupo_horarios` (`id`, `grupo_id`, `dia_semana`, `activo`, `hora_inicio`, `hora_fin`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '17:00:00', '19:00:00', '2026-05-04 11:28:13', '2026-05-04 11:28:13'),
(2, 1, 3, 1, '17:00:00', '19:00:00', '2026-05-04 11:28:13', '2026-05-04 11:28:13'),
(3, 2, 2, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(4, 2, 4, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(5, 3, 1, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(6, 3, 3, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(7, 4, 2, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(8, 4, 4, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(9, 5, 1, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(10, 5, 3, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(11, 6, 2, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(12, 6, 4, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(13, 7, 1, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(14, 7, 3, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(15, 8, 2, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(16, 8, 4, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(17, 9, 1, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(18, 9, 3, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(19, 10, 2, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(20, 10, 4, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(21, 11, 1, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(22, 11, 3, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(23, 12, 2, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(24, 12, 4, 1, '17:00:00', '19:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(25, 13, 1, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(26, 13, 3, 1, '19:00:00', '21:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(27, 14, 1, 1, '09:00:00', '11:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(28, 14, 3, 1, '09:00:00', '11:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(29, 15, 2, 1, '09:00:00', '11:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(30, 15, 4, 1, '09:00:00', '11:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(31, 16, 1, 1, '11:00:00', '13:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(32, 16, 3, 1, '11:00:00', '13:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(33, 17, 2, 1, '11:00:00', '13:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00'),
(34, 17, 4, 1, '11:00:00', '13:00:00', '2026-05-04 12:05:00', '2026-05-04 12:05:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idiomas`
--

CREATE TABLE `idiomas` (
  `id` tinyint(3) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `idiomas`
--

INSERT INTO `idiomas` (`id`, `nombre`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Inglés', 1, '2026-05-04 10:19:09', '2026-05-04 10:19:09'),
(2, 'Francés', 1, '2026-05-04 11:40:00', '2026-05-04 11:40:00'),
(3, 'Alemán', 1, '2026-05-04 11:40:00', '2026-05-04 11:40:00'),
(4, 'Italiano', 1, '2026-05-04 11:40:00', '2026-05-04 11:40:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idiomas_profesores`
--

CREATE TABLE `idiomas_profesores` (
  `idioma_id` tinyint(4) NOT NULL,
  `profesor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `idiomas_profesores`
--

INSERT INTO `idiomas_profesores` (`idioma_id`, `profesor_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(1, 4),
(2, 4),
(3, 5),
(4, 6),
(3, 7),
(4, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `id` tinyint(4) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `orden` tinyint(4) NOT NULL COMMENT 'Orden de visualización de los niveles, por ejemplo: A1=1, A2=2, B1=3, B2=4',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`id`, `nombre`, `orden`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'A1', 1, 1, '2026-05-04 11:19:14', '2026-05-04 11:19:14'),
(2, 'C2', 6, 1, '2026-05-04 11:20:13', '2026-05-04 11:20:13'),
(3, 'A2', 2, 1, '2026-05-04 11:20:13', '2026-05-04 11:20:13'),
(4, 'B1', 3, 1, '2026-05-04 11:20:13', '2026-05-04 11:20:13'),
(5, 'B2', 4, 1, '2026-05-04 11:20:13', '2026-05-04 11:20:13'),
(6, 'C1', 5, 1, '2026-05-04 11:20:13', '2026-05-04 11:20:13'),
(7, 'C3', 7, 1, '2026-05-04 11:32:11', '2026-05-04 11:32:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `wp_user_id` int(11) DEFAULT NULL COMMENT 'Opcional, si el profesor también es usuario de WordPress',
  `nombre` varchar(80) NOT NULL,
  `apellidos` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `wp_user_id`, `nombre`, `apellidos`, `email`, `telefono`, `activo`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Jhon', 'Doe', 'jhon.doe@email.com', '+34676426589', 1, '2026-05-04 10:24:46', '2026-05-04 10:24:46'),
(2, NULL, 'Emily', 'Thompson', 'emily.thompson@example.com', '+34660000002', 1, '2026-05-04 11:41:00', '2026-05-04 11:41:00'),
(3, NULL, 'Claire', 'Dubois', 'claire.dubois@example.com', '+34660000003', 1, '2026-05-04 11:41:00', '2026-05-04 11:41:00'),
(4, NULL, 'Marc', 'Lefèvre', 'marc.lefevre@example.com', '+34660000004', 1, '2026-05-04 11:41:00', '2026-05-04 11:41:00'),
(5, NULL, 'Hans', 'Müller', 'hans.mueller@example.com', '+34660000005', 1, '2026-05-04 11:41:00', '2026-05-04 11:41:00'),
(6, NULL, 'Giulia', 'Rossi', 'giulia.rossi@example.com', '+34660000006', 1, '2026-05-04 11:41:00', '2026-05-04 11:41:00'),
(7, NULL, 'Luca', 'Bianchi', 'luca.bianchi@example.com', '+34660000007', 1, '2026-05-04 11:41:00', '2026-05-04 11:41:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `cursos_escolares`
--
ALTER TABLE `cursos_escolares`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grupos_index_1` (`curso_id`),
  ADD KEY `grupos_index_2` (`idioma_id`),
  ADD KEY `grupos_index_3` (`nivel_id`),
  ADD KEY `grupos_index_4` (`aula_id`),
  ADD KEY `grupos_index_5` (`profesor_id`),
  ADD KEY `grupos_index_6` (`curso_id`,`idioma_id`,`nivel_id`,`aula_id`);

--
-- Indices de la tabla `grupo_horarios`
--
ALTER TABLE `grupo_horarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grupo_horarios_index_9` (`grupo_id`,`dia_semana`,`hora_inicio`),
  ADD KEY `grupo_horarios_index_7` (`grupo_id`),
  ADD KEY `grupo_horarios_index_8` (`dia_semana`,`hora_inicio`,`hora_fin`);

--
-- Indices de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `idiomas_profesores`
--
ALTER TABLE `idiomas_profesores`
  ADD PRIMARY KEY (`idioma_id`,`profesor_id`),
  ADD KEY `idiomas_profesores_index_0` (`profesor_id`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `wp_user_id` (`wp_user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cursos_escolares`
--
ALTER TABLE `cursos_escolares`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `grupo_horarios`
--
ALTER TABLE `grupo_horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos_escolares` (`id`),
  ADD CONSTRAINT `grupos_ibfk_2` FOREIGN KEY (`idioma_id`) REFERENCES `idiomas` (`id`),
  ADD CONSTRAINT `grupos_ibfk_3` FOREIGN KEY (`nivel_id`) REFERENCES `niveles` (`id`),
  ADD CONSTRAINT `grupos_ibfk_4` FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`),
  ADD CONSTRAINT `grupos_ibfk_5` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`);

--
-- Filtros para la tabla `grupo_horarios`
--
ALTER TABLE `grupo_horarios`
  ADD CONSTRAINT `grupo_horarios_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`);

--
-- Filtros para la tabla `idiomas_profesores`
--
ALTER TABLE `idiomas_profesores`
  ADD CONSTRAINT `idiomas_profesores_ibfk_1` FOREIGN KEY (`idioma_id`) REFERENCES `idiomas` (`id`),
  ADD CONSTRAINT `idiomas_profesores_ibfk_2` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
