-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2025 a las 16:23:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `estuvest2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`) VALUES
(007);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administra`
--

CREATE TABLE `administra` (
  `id_admin` tinyint(3) UNSIGNED NOT NULL,
  `id_publicacion` tinyint(3) UNSIGNED NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE `asignatura` (
  `id_asignatura` tinyint(3) UNSIGNED NOT NULL,
  `id_centro_estudio` tinyint(3) UNSIGNED NOT NULL,
  `nombre_asignatura` varchar(100) NOT NULL,
  `anio` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`id_asignatura`, `id_centro_estudio`, `nombre_asignatura`, `anio`) VALUES
(4, 3, 'CRR', 2018),
(5, 7, 'Anatomía', 2014),
(6, 4, 'Prehistoria', 2020),
(13, 7, 'Histología', 2023),
(14, 4, 'Edad de Bronce', 2025),
(15, 5, 'Sistemas', 2020),
(16, 10, 'Plástica', 1478);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro`
--

CREATE TABLE `centro` (
  `id_centro` tinyint(3) UNSIGNED NOT NULL,
  `nombre_centro` varchar(100) NOT NULL,
  `ciudad` varchar(30) NOT NULL,
  `tipo` enum('instituto','universidad','otros') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `centro`
--

INSERT INTO `centro` (`id_centro`, `nombre_centro`, `ciudad`, `tipo`) VALUES
(1, 'UCM', 'Madrid', 'universidad'),
(2, 'Bohio', 'Cartagena', 'instituto'),
(3, 'María Moliner', 'Segovia', 'instituto'),
(4, 'UMU', 'Murcia', 'universidad'),
(5, 'UVA', 'Valladolid', 'universidad'),
(8, 'UPCT', 'Cartagena', 'universidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id_comentario` tinyint(3) UNSIGNED NOT NULL,
  `id_autor` tinyint(3) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL,
  `id_publicacion` tinyint(3) UNSIGNED NOT NULL,
  `texto` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`id_comentario`, `id_autor`, `fecha`, `id_publicacion`, `texto`) VALUES
(1, 9, '2025-05-28 17:40:35', 6, 'probando'),
(2, 9, '2025-05-28 17:42:35', 6, 'probando de nuevo'),
(3, 9, '2025-05-28 18:02:25', 7, 'tocoto'),
(4, 9, '2025-06-01 01:02:37', 8, 'Vaya mierda de apuntes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudio`
--

CREATE TABLE `estudio` (
  `id_estudio` tinyint(3) UNSIGNED NOT NULL,
  `nombre_estudio` varchar(100) NOT NULL,
  `nivel` enum('grado medio','grado superior','grado universitario','master','otro','bachillerato','ESO') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudio`
--

INSERT INTO `estudio` (`id_estudio`, `nombre_estudio`, `nivel`) VALUES
(6, 'Ambientales', 'grado superior'),
(7, 'Historia', 'grado universitario'),
(8, 'DAW', 'grado superior'),
(10, 'Veterinaria', 'grado universitario'),
(11, 'CyTA', 'grado universitario'),
(12, 'Adiministración', 'grado medio'),
(13, 'Magisterio', 'grado universitario'),
(14, 'Matemáticas', 'grado universitario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestiona`
--

CREATE TABLE `gestiona` (
  `id_usuario` tinyint(4) UNSIGNED NOT NULL,
  `id_admin` tinyint(4) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incluye`
--

CREATE TABLE `incluye` (
  `id_relacion` tinyint(3) UNSIGNED NOT NULL,
  `id_centro` tinyint(3) UNSIGNED NOT NULL,
  `id_estudio` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `incluye`
--

INSERT INTO `incluye` (`id_relacion`, `id_centro`, `id_estudio`) VALUES
(3, 2, 6),
(4, 1, 7),
(5, 3, 8),
(7, 4, 10),
(8, 1, 11),
(9, 2, 12),
(10, 5, 13),
(11, 5, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `id_publicacion` tinyint(3) UNSIGNED NOT NULL,
  `archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `puntuacion` int(11) NOT NULL DEFAULT 0,
  `votos` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `descargas` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `id_autor` tinyint(4) UNSIGNED NOT NULL,
  `id_asignatura` tinyint(3) UNSIGNED NOT NULL,
  `id_estudio` tinyint(3) UNSIGNED NOT NULL,
  `publicado` tinyint(1) NOT NULL DEFAULT 0,
  `titulo` varchar(150) NOT NULL,
  `curso` smallint(5) UNSIGNED NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`id_publicacion`, `archivo`, `puntuacion`, `votos`, `descargas`, `id_autor`, `id_asignatura`, `id_estudio`, `publicado`, `titulo`, `curso`, `fecha`) VALUES
(5, '../archivos/6836332c2998e_mayo 2025-contrato laboral.pdf', 0, 0, 0, 9, 6, 7, 1, 'Tema 1', 2020, '2025-05-27'),
(6, '../archivos/68370d279fb7d_HojaDeSeguimientoSemanal (4)_signed_SIGNED.pdf', 2, 1, 0, 9, 6, 7, 1, 'vinagre', 2020, '2025-05-28'),
(7, '../archivos/6837330abb03f_68370d279fb7d_HojaDeSeguimientoSemanal (4)_signed_SIGNED (2).pdf', 3, 1, 0, 11, 4, 6, 1, 'test 1', 2015, '2025-05-28'),
(8, '../archivos/683b89ee2a12a_CV-JorgeAgrazSanz.pdf', 0, 0, 0, 9, 4, 6, 1, 'blablabla', 2020, '2025-06-01');

--
-- Disparadores `publicacion`
--
DELIMITER $$
CREATE TRIGGER `before_delete_publicacion` BEFORE DELETE ON `publicacion` FOR EACH ROW BEGIN
  INSERT INTO publicacion_aux (
    id_publicacion, archivo, puntuacion, votos, descagas, id_autor,
    id_asignatura, id_estudio, titulo, curso, fecha, fecha_borrado
  )
  VALUES (
    OLD.id_publicacion, OLD.archivo, OLD.puntuacion, OLD.votos, OLD.descargas, OLD.id_autor,
    OLD.id_asignatura, OLD.id_estudio, OLD.titulo, OLD.curso, OLD.fecha, UNIX_TIMESTAMP()
  );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion_aux`
--

CREATE TABLE `publicacion_aux` (
  `id_publicacion` tinyint(3) UNSIGNED NOT NULL,
  `archivo` varchar(250) NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `votos` int(11) NOT NULL,
  `descagas` int(11) NOT NULL,
  `id_autor` tinyint(4) UNSIGNED NOT NULL,
  `id_asignatura` tinyint(3) UNSIGNED NOT NULL,
  `id_estudio` tinyint(3) UNSIGNED NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `curso` smallint(6) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_borrado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supervisa`
--

CREATE TABLE `supervisa` (
  `id_admin` tinyint(3) UNSIGNED NOT NULL,
  `id_comentario` tinyint(3) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` tinyint(10) UNSIGNED NOT NULL,
  `nick` varchar(20) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `rol` enum('admin','usuario_registrado') NOT NULL DEFAULT 'usuario_registrado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nick`, `contrasenia`, `nombre`, `apellidos`, `mail`, `rol`) VALUES
(7, 'ale', '$2y$10$B4pQYoch8rjSWfR5p9m91uAoZWsqHJQWV6taGgFshiaYch0zOWZO6', 'Jorge', 'Agraz San', 'j.agraz@hotmail.com', 'admin'),
(9, 'futal', '$2y$10$.VW0nrNiGGy.CqGbBlEiOO3v2bLxWVnMWJP7Y/XjQawQ2JzwRcZGm', 'Fulano', 'De Tal', 'fulanodetal@gmail.com', 'usuario_registrado'),
(10, 'mimiguel', '$2y$10$Wwi0enyy3J62EThGwtbwLeG0.BUmZokZiGzZJoYFSlkuQoZ1OFheu', 'Miguel', 'Migueloncio', 'migueloncio@gmail.com', 'usuario_registrado'),
(11, 'juanito', '$2y$10$2.4Q2hUMALkcOa7JEmkG0.vht2O0KJsXB5N5pIxbB4Q/o74BZjIMi', 'Juan', 'Perez', 'sdg@fwf.fw', 'usuario_registrado');

--
-- Disparadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `after_delete_usuario` AFTER DELETE ON `usuario` FOR EACH ROW BEGIN
  DECLARE v_ciudad VARCHAR(100);
  DECLARE v_estudios VARCHAR(100);
  DECLARE v_fecha_alta DATE;

  -- Obtenemos los datos de usuario_registrado asociados
  SELECT ciudad, estudios, fecha_alta
  INTO v_ciudad, v_estudios, v_fecha_alta
  FROM usuario_registrado
  WHERE id = OLD.id;

  -- Insertamos en usuario_aux
  INSERT INTO usuario_aux (
    id, nick, contrasenia, nombre, apellidos, mail, rol,
    ciudad, estudios, fecha_alta, fecha_eliminacion
  )
  VALUES (
    OLD.id, OLD.nick, OLD.contrasenia, OLD.nombre, OLD.apellidos, OLD.mail, OLD.rol,
    v_ciudad, v_estudios, v_fecha_alta, NOW()
  );

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_aux`
--

CREATE TABLE `usuario_aux` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `nick` varchar(20) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `ciudad` varchar(20) NOT NULL,
  `estudios` varchar(100) NOT NULL,
  `fecha_alta` date NOT NULL,
  `fecha_delete` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_registrado`
--

CREATE TABLE `usuario_registrado` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `ciudad` varchar(20) NOT NULL,
  `estudios` varchar(100) NOT NULL,
  `fecha_alta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_registrado`
--

INSERT INTO `usuario_registrado` (`id`, `ciudad`, `estudios`, `fecha_alta`) VALUES
(9, 'Cartagena', 'grado superior', '2025-04-08 09:39:11'),
(10, 'Segovia', 'grado superior', '2025-05-19 12:37:59'),
(11, 'Segovia', 'grado medio', '2025-05-28 17:59:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos`
--

CREATE TABLE `votos` (
  `id_voto` int(11) NOT NULL,
  `id_publicacion` tinyint(10) UNSIGNED NOT NULL,
  `id_usuario` tinyint(10) UNSIGNED NOT NULL,
  `puntuacion` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `votos`
--

INSERT INTO `votos` (`id_voto`, `id_publicacion`, `id_usuario`, `puntuacion`) VALUES
(2, 6, 7, 2),
(3, 7, 9, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD KEY `fk_admin` (`id`);

--
-- Indices de la tabla `administra`
--
ALTER TABLE `administra`
  ADD PRIMARY KEY (`id_admin`,`id_publicacion`),
  ADD KEY `fk_publi` (`id_publicacion`);

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`id_asignatura`) USING BTREE,
  ADD KEY `fk_relacion` (`id_centro_estudio`);

--
-- Indices de la tabla `centro`
--
ALTER TABLE `centro`
  ADD PRIMARY KEY (`id_centro`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id_comentario`,`id_autor`),
  ADD KEY `id_autor` (`id_autor`),
  ADD KEY `id_publicacion` (`id_publicacion`);

--
-- Indices de la tabla `estudio`
--
ALTER TABLE `estudio`
  ADD PRIMARY KEY (`id_estudio`);

--
-- Indices de la tabla `gestiona`
--
ALTER TABLE `gestiona`
  ADD PRIMARY KEY (`id_usuario`,`id_admin`),
  ADD KEY `fk_gestor` (`id_admin`);

--
-- Indices de la tabla `incluye`
--
ALTER TABLE `incluye`
  ADD PRIMARY KEY (`id_relacion`),
  ADD KEY `idx_id_centro` (`id_centro`),
  ADD KEY `fk_id_estudio` (`id_estudio`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`id_publicacion`),
  ADD KEY `fk_autor` (`id_autor`),
  ADD KEY `fk_asignatura` (`id_asignatura`),
  ADD KEY `publicacion_ibfk_1` (`id_estudio`);

--
-- Indices de la tabla `publicacion_aux`
--
ALTER TABLE `publicacion_aux`
  ADD PRIMARY KEY (`id_publicacion`),
  ADD KEY `fk_autor_aux` (`id_autor`),
  ADD KEY `fk_asignatura_aux` (`id_asignatura`),
  ADD KEY `fk_estudio_aux` (`id_estudio`);

--
-- Indices de la tabla `supervisa`
--
ALTER TABLE `supervisa`
  ADD PRIMARY KEY (`id_admin`,`id_comentario`),
  ADD KEY `id_comentario` (`id_comentario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nick` (`nick`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Indices de la tabla `usuario_aux`
--
ALTER TABLE `usuario_aux`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `usuario_registrado`
--
ALTER TABLE `usuario_registrado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id_voto`),
  ADD KEY `fk_publicacion` (`id_publicacion`),
  ADD KEY `fk_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `id_asignatura` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `centro`
--
ALTER TABLE `centro`
  MODIFY `id_centro` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id_comentario` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estudio`
--
ALTER TABLE `estudio`
  MODIFY `id_estudio` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `incluye`
--
ALTER TABLE `incluye`
  MODIFY `id_relacion` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `id_publicacion` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` tinyint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `votos`
--
ALTER TABLE `votos`
  MODIFY `id_voto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `administra`
--
ALTER TABLE `administra`
  ADD CONSTRAINT `fk_admin_publi` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_publi` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id_publicacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD CONSTRAINT `fk_relacion` FOREIGN KEY (`id_centro_estudio`) REFERENCES `incluye` (`id_relacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `usuario_registrado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id_publicacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gestiona`
--
ALTER TABLE `gestiona`
  ADD CONSTRAINT `fk_gestor` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usu` FOREIGN KEY (`id_usuario`) REFERENCES `usuario_registrado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `incluye`
--
ALTER TABLE `incluye`
  ADD CONSTRAINT `fk_id_estudio` FOREIGN KEY (`id_estudio`) REFERENCES `estudio` (`id_estudio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `fk_asignatura` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id_asignatura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_autor` FOREIGN KEY (`id_autor`) REFERENCES `usuario_registrado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`id_estudio`) REFERENCES `estudio` (`id_estudio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicacion_aux`
--
ALTER TABLE `publicacion_aux`
  ADD CONSTRAINT `fk_asignatura_aux` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id_asignatura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_autor_aux` FOREIGN KEY (`id_autor`) REFERENCES `usuario_registrado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estudio_aux` FOREIGN KEY (`id_estudio`) REFERENCES `estudio` (`id_estudio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `supervisa`
--
ALTER TABLE `supervisa`
  ADD CONSTRAINT `supervisa_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `supervisa_ibfk_2` FOREIGN KEY (`id_comentario`) REFERENCES `comentario` (`id_comentario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_registrado`
--
ALTER TABLE `usuario_registrado`
  ADD CONSTRAINT `fk_usuario_registrado` FOREIGN KEY (`id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `fk_publicacion` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id_publicacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
