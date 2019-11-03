-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-11-2019 a las 05:48:04
-- Versión del servidor: 5.7.21
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dssd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_videoconferencia`
--

DROP TABLE IF EXISTS `estado_videoconferencia`;
CREATE TABLE IF NOT EXISTS `estado_videoconferencia` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `estado` varchar(100) NOT NULL,
  `etapa` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_videoconferencia`
--

INSERT INTO `estado_videoconferencia` (`id`, `estado`, `etapa`) VALUES
(1, 'iniciada en termino', 'inicio'),
(2, 'iniciada con demora', 'inicio'),
(3, 'no iniciada', 'ninguna'),
(4, 'suspendida', 'inicio'),
(5, 'finalizada en termino', 'final'),
(6, 'finalizada con demora', 'final'),
(7, 'interrumpida por problema tecnico', 'final'),
(8, 'interrumpida por comportamiento del interno', 'final');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interno_unidad`
--

DROP TABLE IF EXISTS `interno_unidad`;
CREATE TABLE IF NOT EXISTS `interno_unidad` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `apellido` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `unidad` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interno_unidad_FK` (`unidad`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `interno_unidad`
--

INSERT INTO `interno_unidad` (`id`, `apellido`, `nombre`, `unidad`, `email`) VALUES
(1, 'Interno1', 'Interno1', 1, 'repint1@gmail.com'),
(2, 'Interno2', 'Interno2', 1, 'repint2@gmail.com'),
(3, 'Interno3', 'Interno3', 2, 'repint3@gmail.com'),
(4, 'Interno4', 'Interno4', 2, 'repint4@gmail.com'),
(5, 'Interno5', 'Interno5', 3, 'repint1@gmail.com'),
(6, 'Interno6', 'Interno6', 3, 'repint2@gmail.com'),
(7, 'Interno7', 'Interno7', 4, 'repint3@gmail.com'),
(8, 'Interno8', 'Interno8', 4, 'repint4@gmail.com'),
(9, 'Interno9', 'Interno9', 4, 'repint1@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes`
--

DROP TABLE IF EXISTS `participantes`;
CREATE TABLE IF NOT EXISTS `participantes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipo_participante_id` bigint(20) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `unidad` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `participante_videoconferencia_FK` (`tipo_participante_id`),
  KEY `indice_unidad` (`unidad`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `participantes`
--

INSERT INTO `participantes` (`id`, `tipo_participante_id`, `apellido`, `nombre`, `email`, `unidad`) VALUES
(1, 1, 'Interno1', 'Interno1', 'repint1@gmail.com', 1),
(2, 1, 'Interno2', 'Interno2', 'repint2@gmail.com', 1),
(3, 1, 'Interno3', 'Interno3', 'diegoprince08@hotmail.com', 2),
(4, 1, 'Interno4', 'Interno4', 'repint4@gmail.com', 2),
(5, 1, 'Interno5', 'Interno5', 'repint5@gmail.com', 3),
(6, 1, 'Interno6', 'Interno6', 'repint6@gmail.com', 3),
(7, 1, 'Interno7', 'Interno7', 'repint7@gmail.com', 4),
(8, 1, 'Interno8', 'Interno8', 'repint8@gmail.com', 4),
(9, 1, 'Interno9', 'Interno9', 'repint9@gmail.com', 4),
(10, 2, 'Abogado1', 'Abogado1', 'abg1@gmail.com', NULL),
(11, 2, 'Abogado2', 'Abogado2', 'abg2@gmail.com', NULL),
(12, 3, 'Juez1', 'Juez1', 'juez1@gmail.com', NULL),
(13, 3, 'Juez2', 'Juez2', 'juez2@gmail.com', NULL),
(14, 4, 'Procurador1', 'Procurador1', 'prc1@gmail.com', NULL),
(15, 4, 'Procurador2', 'Procurador2', 'prc2@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_videoconferencia`
--

DROP TABLE IF EXISTS `registro_videoconferencia`;
CREATE TABLE IF NOT EXISTS `registro_videoconferencia` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `estado_videoconferencia_id` bigint(20) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `videoconferencia_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `registro_videoconferencia_FK` (`estado_videoconferencia_id`),
  KEY `registro_videoconferencia_FK_1` (`videoconferencia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_participante`
--

DROP TABLE IF EXISTS `tipo_participante`;
CREATE TABLE IF NOT EXISTS `tipo_participante` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_participante`
--

INSERT INTO `tipo_participante` (`id`, `tipo`) VALUES
(1, 'interno'),
(2, 'abogado'),
(3, 'juez'),
(4, 'procurador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_videoconferencia`
--

DROP TABLE IF EXISTS `tipo_videoconferencia`;
CREATE TABLE IF NOT EXISTS `tipo_videoconferencia` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_videoconferencia`
--

INSERT INTO `tipo_videoconferencia` (`id`, `tipo`) VALUES
(1, 'comparendo'),
(2, 'entrevista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

DROP TABLE IF EXISTS `unidades`;
CREATE TABLE IF NOT EXISTS `unidades` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `numeroUnidad` bigint(20) NOT NULL,
  `coordenadas` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre`, `numeroUnidad`, `coordenadas`, `email`) VALUES
(1, 'Unidad 1', 1, '-34.99879, -58.04139', 'emailU1@mjus.gob.ar'),
(2, 'Unidad 2', 2, '-36.83867, -60.22645', 'emailU2@mjus.gob.ar'),
(3, 'Unidad 3', 3, '-33.35242, -60.19768', 'emailU3@mjus.gob.ar'),
(4, 'Unidad 4', 4, '-38.68651, -62.27582', 'emailU4@mjus.gob.ar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videoconferencias`
--

DROP TABLE IF EXISTS `videoconferencias`;
CREATE TABLE IF NOT EXISTS `videoconferencias` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `unidad_id` bigint(20) NOT NULL,
  `estado_id` bigint(20) NOT NULL,
  `tipo_id` bigint(20) NOT NULL,
  `nro_causa` varchar(100) NOT NULL,
  `motivo` varchar(100) DEFAULT NULL,
  `solicitante_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `videoconferencias_FK` (`tipo_id`),
  KEY `videoconferencias_FK_1` (`unidad_id`),
  KEY `videoconferencias_FK_2` (`estado_id`),
  KEY `videoconferencias_FK_3` (`solicitante_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videoconferencia_participante`
--

DROP TABLE IF EXISTS `videoconferencia_participante`;
CREATE TABLE IF NOT EXISTS `videoconferencia_participante` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `videoconferencia_id` bigint(20) NOT NULL,
  `participante_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idVideoConferencia` (`videoconferencia_id`),
  KEY `idParticipante` (`participante_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `interno_unidad`
--
ALTER TABLE `interno_unidad`
  ADD CONSTRAINT `interno_unidad_FK` FOREIGN KEY (`unidad`) REFERENCES `unidades` (`id`);

--
-- Filtros para la tabla `participantes`
--
ALTER TABLE `participantes`
  ADD CONSTRAINT `participante_videoconferencia_FK` FOREIGN KEY (`tipo_participante_id`) REFERENCES `tipo_participante` (`id`),
  ADD CONSTRAINT `participantes_ibfk_1` FOREIGN KEY (`unidad`) REFERENCES `unidades` (`id`);

--
-- Filtros para la tabla `registro_videoconferencia`
--
ALTER TABLE `registro_videoconferencia`
  ADD CONSTRAINT `registro_videoconferencia_FK` FOREIGN KEY (`estado_videoconferencia_id`) REFERENCES `estado_videoconferencia` (`id`),
  ADD CONSTRAINT `registro_videoconferencia_FK_1` FOREIGN KEY (`videoconferencia_id`) REFERENCES `videoconferencias` (`id`);

--
-- Filtros para la tabla `videoconferencias`
--
ALTER TABLE `videoconferencias`
  ADD CONSTRAINT `videoconferencias_FK` FOREIGN KEY (`tipo_id`) REFERENCES `tipo_videoconferencia` (`id`),
  ADD CONSTRAINT `videoconferencias_FK_1` FOREIGN KEY (`unidad_id`) REFERENCES `unidades` (`id`),
  ADD CONSTRAINT `videoconferencias_FK_2` FOREIGN KEY (`estado_id`) REFERENCES `estado_videoconferencia` (`id`),
  ADD CONSTRAINT `videoconferencias_FK_3` FOREIGN KEY (`solicitante_id`) REFERENCES `participantes` (`id`);

--
-- Filtros para la tabla `videoconferencia_participante`
--
ALTER TABLE `videoconferencia_participante`
  ADD CONSTRAINT `videoconferencia_participante_ibfk_1` FOREIGN KEY (`videoconferencia_id`) REFERENCES `videoconferencias` (`id`),
  ADD CONSTRAINT `videoconferencia_participante_ibfk_2` FOREIGN KEY (`participante_id`) REFERENCES `participantes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
