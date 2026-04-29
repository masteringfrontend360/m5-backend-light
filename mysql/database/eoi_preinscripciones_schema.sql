CREATE TABLE `grupos` (
  `id` smallint(5) PRIMARY KEY NOT NULL,
  `id_idioma` tinyint(3) NOT NULL,
  `id_nivel` tinyint(3) NOT NULL,
  `id_horario` tinyint(3) NOT NULL,
  `num_plazas` tinyint(3) NOT NULL DEFAULT 5
);

CREATE TABLE `horarios` (
  `id` tinyint(3) PRIMARY KEY NOT NULL,
  `descripcion` varchar(200) NOT NULL
);

CREATE TABLE `idiomas` (
  `id` tinyint(3) PRIMARY KEY NOT NULL,
  `nombre` varchar(50) NOT NULL
);

CREATE TABLE `niveles` (
  `id` tinyint(3) PRIMARY KEY NOT NULL,
  `nombre` varchar(20) NOT NULL
);

CREATE TABLE `preinscripciones_cabecera` (
  `id` int(10) PRIMARY KEY NOT NULL,
  `id_preinscrito` int(10) NOT NULL,
  `fecha` datetime NOT NULL
);

CREATE TABLE `preinscripciones_grupos` (
  `id` int(10) PRIMARY KEY NOT NULL,
  `id_preinscripcion` int(10) NOT NULL,
  `id_grupo` smallint(5) NOT NULL,
  `prioridad` tinyint(3) NOT NULL,
  `admitido` tinyint(3) NOT NULL DEFAULT 0,
  `num_reserva` int(11) DEFAULT null
);

CREATE TABLE `preinscritos` (
  `id` int(10) PRIMARY KEY NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL
);

CREATE TABLE `preinscritos_private` (
  `id` int(10) PRIMARY KEY NOT NULL,
  `email` varchar(100) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `password` varchar(255) NOT NULL
);

ALTER TABLE `grupos` ADD FOREIGN KEY (`id_idioma`) REFERENCES `idiomas` (`id`);

ALTER TABLE `grupos` ADD FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id`);

ALTER TABLE `grupos` ADD FOREIGN KEY (`id_horario`) REFERENCES `horarios` (`id`);

ALTER TABLE `preinscritos_private` ADD FOREIGN KEY (`id`) REFERENCES `preinscritos` (`id`);

ALTER TABLE `preinscripciones_cabecera` ADD FOREIGN KEY (`id_preinscrito`) REFERENCES `preinscritos` (`id`);

ALTER TABLE `preinscripciones_grupos` ADD FOREIGN KEY (`id_preinscripcion`) REFERENCES `preinscripciones_cabecera` (`id`);

ALTER TABLE `preinscripciones_grupos` ADD FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`);
