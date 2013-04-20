-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-04-2013 a las 22:27:39
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `seimysql`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE IF NOT EXISTS `concepto` (
  `mapa_conceptual_id_mapa_conceptual` int(11) NOT NULL,
  `id_concepto` varchar(11) NOT NULL,
  `nombre_concepto` varchar(500) NOT NULL,
  `texto_concepto` varchar(20) DEFAULT '""'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `concepto`
--

INSERT INTO `concepto` (`mapa_conceptual_id_mapa_conceptual`, `id_concepto`, `nombre_concepto`, `texto_concepto`) VALUES
(53, '1', 'TEST1', ''),
(53, '1.1', 'Concepto', ''),
(53, '1.2', 'Concepto', ''),
(54, '1', 'TEST1', ''),
(54, '1.1', 'Concepto', ''),
(54, '1.1.1', 'Concept', ''),
(54, '1.2', 'Concepto', ''),
(54, '1.2.1', 'test concept', ''),
(55, '1', 'TEST1', ''),
(55, '1.1', 'Concepto', ''),
(55, '1.2', ' uodate', ''),
(56, '1', 'TEST2', ''),
(56, '1.1', 'Concepto1', ''),
(56, '1.2', 'Concepto2', ''),
(56, '1.3', 'Concepto3', ''),
(56, '1.3.1', 'CONCEPTO', ''),
(56, '1.3.2', 'PRUEBA CONCEPTO', ''),
(57, '1', 'TEST2', ''),
(57, '1.1', 'Concepto1TEST', ''),
(57, '1.2', 'Concepto2', ''),
(57, '1.3', 'Concepto3', ''),
(58, '1', 'TEST1', ''),
(58, '1.1', 'Concepto', ''),
(58, '1.2', ' uodate', ''),
(58, '1.2.1', 'Otro Concepto', ''),
(59, '1', 'TEST1', ''),
(59, '1.1', 'Concepto', ''),
(59, '1.2', ' uodate', ''),
(59, '1.2.1', 'Otro Concepto', ''),
(60, '1', 'TEST1', ''),
(60, '1.1', 'Concepto', ''),
(60, '1.2', ' uodate', ''),
(60, '1.2.1', 'Otro Concepto', ''),
(61, '1', 'TEST1', ''),
(61, '1.1', 'Concepto', ''),
(61, '1.2', ' uodate', ''),
(61, '1.2.1', 'Otro Concepto', ''),
(62, '1', 'TEST1', ''),
(62, '1.1', 'Concepto', ''),
(62, '1.2', ' uodate', ''),
(62, '1.2.1', 'Otro Concepto', ''),
(63, '1', 'TEST1', ''),
(63, '1.1', 'Concepto', ''),
(63, '1.2', ' uodate', ''),
(63, '1.2.1', 'Otro Concepto', ''),
(64, '1', 'TEST1', ''),
(64, '1.1', 'Concepto', ''),
(64, '1.2', ' uodate', ''),
(64, '1.2.1', 'Otro Concepto', ''),
(65, '1', 'TEST1', ''),
(65, '1.1', 'Concepto', ''),
(65, '1.2', ' uodate', ''),
(65, '1.2.1', 'Otro Concepto', ''),
(66, '1', 'TEST1', ''),
(66, '1.1', 'Concepto', ''),
(66, '1.2', ' uodate', ''),
(66, '1.2.1', 'Otro Concepto', ''),
(67, '1', 'TEST1', ''),
(67, '1.1', 'Concepto', ''),
(67, '1.2', ' uodate', ''),
(67, '1.2.1', 'Otro Concepto', ''),
(68, '1', 'TEST', ''),
(68, '1.1', 'Concepto', ''),
(69, '1.1', 'TEST', ''),
(70, '1', 'TEST', ''),
(71, '1', 'TEST', ''),
(72, '1', 'TEST', ''),
(73, '1', 'TEST', ''),
(76, '1', 'TEST', ''),
(76, '1', 'TEST', ''),
(76, '1', 'TEST', ''),
(77, '1', 'TEST', ''),
(77, '1.1', 'Concepto', ''),
(77, '1.1.1', 'concepto2', ''),
(78, '1', 'TEST', ''),
(78, '1.1', 'Concepto', ''),
(78, '1.1.1', 'concepto2', ''),
(79, '1', 'TEST', ''),
(79, '1.1', 'Concepto', ''),
(79, '1.1.1', 'concepto2', ''),
(80, '1', 'TEST', ''),
(80, '1.1', 'Concepto1', ''),
(80, '1.1.1', 'Concepto 1.1', ''),
(80, '1.2', '[Concepto]', ''),
(81, '1', 'TEST', ''),
(81, '1.1', 'Concepto1', ''),
(81, '1.2', 'COncepto2', ''),
(81, '1.2.1', '[Concepto]', ''),
(82, '1', 'TEST', ''),
(82, '1.1', 'Concepto1', ''),
(82, '1.2', 'COncepto2', ''),
(82, '1.2.1', '[Concepto]', ''),
(85, '1', 'TEST', ''),
(85, '1.1', 'Concepto1', ''),
(85, '1.2', 'COncepto2', ''),
(85, '1.2.1', '[Concepto]', ''),
(86, '1', 'TESTMAPA', ''),
(86, '1.1', '[Concepto]', ''),
(86, '1.2', '[Concepto]', ''),
(86, '1.2.1', '[Concepto]', ''),
(86, '1.2.2', '[Concepto]', ''),
(86, '1.3', '[Concepto]', ''),
(87, '1', 'MAPA', ''),
(87, '1.1', '[Concepto]', ''),
(87, '1.2', '[Concepto]', ''),
(87, '1.3', '[Concepto]', ''),
(87, '1.4', '[Concepto]', ''),
(87, '1.4.1', '[Concepto]', ''),
(88, '1', 'MAPA', ''),
(88, '1.1', '[Concepto]', ''),
(88, '1.2', '[Concepto]', ''),
(88, '1.3', '[Concepto]', ''),
(88, '1.4', '[Concepto]', ''),
(88, '1.4.1', '[Concepto]', ''),
(89, '1', 'MAPA', ''),
(89, '1.1', '[Concepto]', ''),
(89, '1.2', '[Concepto]', ''),
(89, '1.3', '[Concepto]', ''),
(89, '1.4', '[Concepto]', ''),
(89, '1.4.1', '[Concepto]', ''),
(90, '1', 'MAPA', ''),
(90, '1.1', '[Concepto]', ''),
(90, '1.2', '[Concepto]', ''),
(90, '1.3', '[Concepto]', ''),
(90, '1.4', '[Concepto]', ''),
(90, '1.4.1', '[Concepto]', ''),
(91, '1', 'MAPA', ''),
(91, '1.1', '[Concepto]', ''),
(91, '1.2', '[Concepto]', ''),
(91, '1.3', '[Concepto]', ''),
(91, '1.4', '[Concepto]', ''),
(91, '1.4.1', '[Concepto]', ''),
(92, '1', 'MAPA', ''),
(92, '1.1', '[Concepto]', ''),
(92, '1.1.1', '[Concepto]', ''),
(92, '1.1.2', '[Concepto]', ''),
(92, '1.2', '[Concepto]', ''),
(92, '1.3', '[Concepto]', ''),
(92, '1.4', '[Concepto]', ''),
(93, '1', 'MAPA', ''),
(93, '1.1', '[Concepto]', ''),
(93, '1.1.1', '[Concepto]', ''),
(93, '1.2', '[Concepto]', ''),
(93, '1.3', '[Concepto]', ''),
(93, '1.4', '[Concepto]', ''),
(94, '1', 'MAPA', ''),
(94, '1.1', '[Concepto]', ''),
(94, '1.1.1', '[Concepto]', ''),
(94, '1.2', '[Concepto]', ''),
(94, '1.3', '[Concepto]', ''),
(94, '1.4', '[Concepto]', ''),
(95, '1', 'OTRO', ''),
(95, '1.1', '[Concepto]', ''),
(95, '1.1.1', '[Concepto]', ''),
(95, '1.2', '[Concepto]', ''),
(95, '1.2.1', '[Concepto]', ''),
(96, '1', 'OTRO', ''),
(96, '1.1', '[Concepto]', ''),
(96, '1.1.1', '[Concepto]', ''),
(96, '1.2', '[Concepto]', ''),
(96, '1.2.1', '[Concepto]', ''),
(97, '1', 'OTRO', ''),
(97, '1.1', '[Concepto]', ''),
(97, '1.1.1', '[Concepto]', ''),
(97, '1.2', '[Concepto]', ''),
(97, '1.2.1', '[Concepto]', ''),
(98, '1', 'OTRO', ''),
(98, '1.1', '[Concepto]', ''),
(98, '1.1.1', '[Concepto]', ''),
(98, '1.2', '[Concepto]', ''),
(98, '1.2.1', '[Concepto]', ''),
(99, '1', 'OTRO', ''),
(99, '1.1', '[Concepto]', ''),
(99, '1.1.1', '[Concepto]', ''),
(99, '1.2', '[Concepto]', ''),
(99, '1.2.1', '[Concepto]', ''),
(100, '1', 'OTRO', ''),
(100, '1.1', '[Concepto]', ''),
(100, '1.1.1', '[Concepto]', ''),
(100, '1.2', '[Concepto]', ''),
(101, '1', 'OTRO', ''),
(101, '1.1', '[Concepto]', ''),
(101, '1.1.1', '[Concepto]', ''),
(101, '1.1.2', '[Concepto]', ''),
(101, '1.2', '[Concepto]', ''),
(101, '1.2.1', '[Concepto]', ''),
(102, '1', 'JUEGORAIZ', ''),
(102, '1.1', '[Concepto]', ''),
(102, '1.1.1', '[Concepto]', ''),
(102, '1.1.2', '[Concepto]', ''),
(102, '1.2', '[Concepto]', ''),
(102, '1.2.1', '[Concepto]', ''),
(102, '1.2.2', '[Concepto]', ''),
(102, '1.3', '[Concepto]', ''),
(102, '1.3.1', '[Concepto]', ''),
(102, '1.3.2', '[Concepto]', ''),
(102, '1.4', '[Concepto]', ''),
(102, '1.5', '[Concepto]', ''),
(102, '1.5.1', '[Concepto]', ''),
(102, '1.5.2', '[Concepto]', ''),
(102, '1.6', '[Concepto]', ''),
(102, '1.7', '[Concepto]', ''),
(102, '1.7.1', '[Concepto]', ''),
(102, '1.7.2', '[Concepto]', ''),
(102, '1.8', '[Concepto]', ''),
(102, '1.8.1', '[Concepto]', ''),
(102, '1.8.2', '[Concepto]', ''),
(102, '1.9', '[Concepto]', ''),
(102, '1.9.1', '[Concepto]', ''),
(102, '1.9.2', '[Concepto]', ''),
(103, '1', 'BETOCABECERA', ''),
(103, '1.1', 'concepto', ''),
(103, '1.2', 'concepto', ''),
(103, '1.3', 'concepto', ''),
(103, '1.4', 'concepto', ''),
(103, '1.5', 'concepto', ''),
(103, '1.5.1', '[Concepto]', ''),
(104, '1', 'BETOCABECERA', ''),
(104, '1.1', 'concepto', ''),
(104, '1.2', 'concepto', ''),
(104, '1.3', 'concepto', ''),
(104, '1.4', 'concepto', ''),
(104, '1.5', 'concepto', ''),
(104, '1.5.1', '[Concepto]', ''),
(106, '1', 'BETOCABECERA', ''),
(106, '1.1', 'concepto', ''),
(106, '1.2', 'concepto', ''),
(106, '1.3', 'concepto', ''),
(106, '1.4', 'concepto', ''),
(106, '1.5', 'concepto', ''),
(106, '1.5.1', '[Concepto]', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `id_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_grupo` text NOT NULL,
  `nombre_grupo` varchar(30) NOT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `descripcion_grupo`, `nombre_grupo`) VALUES
(1, 'Matematicas1', 'Grupo de matematicas creado pa'),
(2, 'Matematicas', 'Grupo de matematicas creado pa'),
(3, 'Matematicas', 'Grupo de matemaricas prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_mapa_conceptual`
--

CREATE TABLE IF NOT EXISTS `grupo_mapa_conceptual` (
  `mapa_conceptual_id_mapa` int(11) NOT NULL,
  `grupo_id_grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grupo_mapa_conceptual`
--

INSERT INTO `grupo_mapa_conceptual` (`mapa_conceptual_id_mapa`, `grupo_id_grupo`) VALUES
(18, 4),
(18, 2),
(106, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_usuario`
--

CREATE TABLE IF NOT EXISTS `grupo_usuario` (
  `grupo_id_grupo` int(11) NOT NULL,
  `usuario_id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grupo_usuario`
--

INSERT INTO `grupo_usuario` (`grupo_id_grupo`, `usuario_id_usuario`) VALUES
(2, 1019002704),
(3, 1019002704),
(4, 1019002704),
(2, 2034523),
(2, 123456789),
(2, 121212),
(3, 123456),
(3, 121212),
(3, 131313);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_juego_respuesta`
--

CREATE TABLE IF NOT EXISTS `historial_juego_respuesta` (
  `juego_mapa_juego_id_juego` int(11) NOT NULL,
  `juego_mapa_mapa_conceptual_id_mapa_conceptual` int(11) NOT NULL,
  `usuario_id_usuario` int(11) NOT NULL,
  `duracion_real` int(11) NOT NULL,
  `fecha_realizacion` date NOT NULL,
  `respuestas_acertadas` varchar(20) DEFAULT NULL,
  `id_historial_juego_respuesta` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_historial_juego_respuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_mapa_conceptual`
--

CREATE TABLE IF NOT EXISTS `historial_mapa_conceptual` (
  `mapa_conceptual_id_mapa_conceptual` int(11) NOT NULL,
  `vigencia` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_limite` date NOT NULL,
  `id_historial_mapa_conceptual` int(11) NOT NULL AUTO_INCREMENT,
  `estado_mp` varchar(20) NOT NULL,
  PRIMARY KEY (`id_historial_mapa_conceptual`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juego`
--

CREATE TABLE IF NOT EXISTS `juego` (
  `id_juego` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_juego` varchar(30) NOT NULL,
  PRIMARY KEY (`id_juego`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `juego`
--

INSERT INTO `juego` (`id_juego`, `nombre_juego`) VALUES
(1, 'StandAlone'),
(2, 'Sopa Letras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juego_mapa`
--

CREATE TABLE IF NOT EXISTS `juego_mapa` (
  `mapa_conceptual_id_mapa_conceptual` int(11) NOT NULL,
  `juego_id_juego` int(11) NOT NULL,
  `duracion_juego` int(11) NOT NULL,
  `estado_juego_mapa` int(11) NOT NULL,
  `mostrar_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `juego_mapa`
--

INSERT INTO `juego_mapa` (`mapa_conceptual_id_mapa_conceptual`, `juego_id_juego`, `duracion_juego`, `estado_juego_mapa`, `mostrar_status`) VALUES
(106, 2, 30, 1, 1),
(106, 1, 30, 1, 1),
(1, 1, 1, 1, 1),
(0, 1, 120, 1, 1),
(0, 2, 120, 1, 1),
(1, 1, 1, 1, 1),
(0, 1, 120, 1, 1),
(0, 2, 120, 1, 1),
(1, 1, 1, 1, 1),
(0, 1, 120, 1, 1),
(0, 2, 120, 1, 1),
(1, 1, 1, 1, 1),
(0, 1, 120, 1, 1),
(0, 2, 120, 1, 1),
(1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapa_conceptual`
--

CREATE TABLE IF NOT EXISTS `mapa_conceptual` (
  `usuario_id_usuario` int(11) NOT NULL,
  `tipo_mapa_id_tipo_mapa` int(11) NOT NULL,
  `nombre_mapa` varchar(30) NOT NULL,
  `total_conceptos` int(11) NOT NULL,
  `total_relaciones` int(11) NOT NULL,
  `estado_mapa` varchar(20) NOT NULL,
  `duracion_mapa` int(11) NOT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_limite` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_mapa_conceptual` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_mapa_conceptual`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

--
-- Volcado de datos para la tabla `mapa_conceptual`
--

INSERT INTO `mapa_conceptual` (`usuario_id_usuario`, `tipo_mapa_id_tipo_mapa`, `nombre_mapa`, `total_conceptos`, `total_relaciones`, `estado_mapa`, `duracion_mapa`, `fecha_inicio`, `fecha_limite`, `id_mapa_conceptual`) VALUES
(123456, 1, 'MAPAPRUEBA', 6, 5, '0', 1, '2013-04-20 15:56:52', '2013-04-20 16:56:52', 87),
(123456, 1, 'MAPAPRUEBA', 6, 5, '0', 1, '2013-04-20 15:57:13', '2013-04-20 16:57:13', 88),
(123456, 1, 'MAPAPRUEBA', 6, 5, '0', 1, '2013-04-20 16:00:46', '2013-04-20 17:00:46', 89),
(123456, 1, 'MAPAPRUEBA', 6, 5, '0', 1, '2013-04-20 16:01:45', '2013-04-20 17:01:45', 90),
(123456, 1, 'MAPAPRUEBA', 8, 7, '0', 1, '2013-04-20 16:28:15', '2013-04-20 17:28:15', 94),
(123456, 1, 'mierda', 8, 7, '0', 1, '2013-04-20 16:37:45', '2013-04-20 17:37:45', 95),
(123456, 1, 'mierda', 8, 7, '0', 1, '2013-04-20 16:39:51', '2013-04-20 17:39:51', 96),
(123456, 1, 'mierda', 8, 7, '0', 1, '2013-04-20 16:40:41', '2013-04-20 17:40:41', 97),
(123456, 1, 'mierda', 8, 7, '0', 1, '2013-04-20 16:41:24', '2013-04-20 17:41:24', 98),
(123456, 1, 'mierda', 8, 7, '1', 1, '2013-04-20 16:52:15', '2013-04-20 17:47:49', 101),
(123456, 1, 'JUEGO', 24, 23, '1', 1, '2013-04-20 19:56:20', '2013-04-20 18:33:02', 102),
(123456, 1, 'BETO', 7, 6, '1', 120, '2013-04-20 20:10:44', '2013-04-25 20:10:10', 106);

--
-- Disparadores `mapa_conceptual`
--
DROP TRIGGER IF EXISTS `CreateJuegoMapa`;
DELIMITER //
CREATE TRIGGER `CreateJuegoMapa` BEFORE INSERT ON `mapa_conceptual`
 FOR EACH ROW BEGIN
    INSERT INTO juego_mapa SET mapa_conceptual_id_mapa_conceptual = NEW.id_mapa_conceptual,
                               juego_id_juego = 1,
                               duracion_juego = NEW.duracion_mapa,
                               estado_juego_mapa=1;
    INSERT INTO juego_mapa SET mapa_conceptual_id_mapa_conceptual= NEW.id_mapa_conceptual,
                               juego_id_juego = 2,
                               duracion_juego = NEW.duracion_mapa,
                               estado_juego_mapa=1;
                                                             
                              
  END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `games`;
DELIMITER //
CREATE TRIGGER `games` AFTER INSERT ON `mapa_conceptual`
 FOR EACH ROW BEGIN
    INSERT INTO seimysql.juego_mapa
              (mapa_conceptual_id_mapa_conceptual, juego_id_juego, duracion_juego, estado_juego_mapa, mostrar_status) 
              VALUES (1, 1, 1, 1, 1);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapa_conceptual_tematica`
--

CREATE TABLE IF NOT EXISTS `mapa_conceptual_tematica` (
  `tematica_id_tematica` varchar(11) NOT NULL,
  `mapa_conceptual_id_mapa_conceptual` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mapa_conceptual_tematica`
--

INSERT INTO `mapa_conceptual_tematica` (`tematica_id_tematica`, `mapa_conceptual_id_mapa_conceptual`) VALUES
('0', '51'),
('1', '53'),
('2', '94'),
('1', '98'),
('1', '97'),
('1', '99'),
('1', '100'),
('1', '101'),
('1', '102'),
('2', '103'),
('2', '104'),
('2', '106');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_perfil` varchar(30) NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombre_perfil`) VALUES
(1, 'Docente'),
(2, 'Estudiante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacion`
--

CREATE TABLE IF NOT EXISTS `relacion` (
  `concepto_mapa_conceptual_id_mapa_conceptual` int(11) NOT NULL,
  `concepto_id_concepto` varchar(70) NOT NULL,
  `id_concepto_hijo` varchar(70) NOT NULL,
  `nombre_relacion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `relacion`
--

INSERT INTO `relacion` (`concepto_mapa_conceptual_id_mapa_conceptual`, `concepto_id_concepto`, `id_concepto_hijo`, `nombre_relacion`) VALUES
(53, '1', '1.1', 'relacion'),
(53, '1', '1.2', 'relacion'),
(54, '1', '1.1', 'relacion'),
(54, '1.1', '1.1.1', 'Otra relacion'),
(54, '1', '1.2', 'relacion'),
(54, '1.2', '1.2.1', 'Otra'),
(55, '1', '1.1', 'relacion de prueba'),
(55, '1', '1.2', 'relacion de prueba2'),
(56, '1', '1.1', 'relacion1'),
(56, '1', '1.2', 'relacion1'),
(56, '1', '1.3', 'relacion3'),
(56, '1.3', '1.3.1', 'OTRA'),
(56, '1.3', '1.3.2', 'TEST'),
(57, '1', '1.1', 'relacion1'),
(57, '1', '1.2', 'relacion1'),
(57, '1', '1.3', 'relacion3'),
(59, '1', '1', '1'),
(59, '1', '1', '1'),
(62, '1', '1', '1'),
(62, '1', '1', '1'),
(66, '', '', ''),
(66, '', '', ''),
(66, '', '', ''),
(66, '', '', ''),
(67, '1', '1', ''),
(67, '1.1', '1.1', 'relacion de prueba'),
(67, '1.2', '1.2', 'relacion de prueba2'),
(67, '1.2.1', '1.2.1', 'Otra Relacion'),
(68, '1', '1.1', 'relacion'),
(79, '1', '1.1', 'relacion'),
(79, '1.1', '1.1.1', 'relacion2'),
(80, '1', '1.1', 'Relacion1'),
(80, '1.1', '1.1.1', 'Relacion 1.1'),
(80, '1', '1.2', 'Relacion2'),
(90, '1', '1.1', 'Relacion'),
(90, '1', '1.2', 'Relacion'),
(90, '1', '1.3', 'Relacion'),
(90, '1', '1.4', 'Relacion'),
(90, '1.4', '1.4.1', 'Relacion'),
(91, '1', '1.1', 'Relacion'),
(91, '1', '1.2', 'Relacion'),
(91, '1', '1.3', 'Relacion'),
(91, '1', '1.4', 'Relacion'),
(91, '1.4', '1.4.1', 'Relacion'),
(92, '1', '1.1', 'Relacion'),
(92, '1.1', '1.1.1', '[Relacion]'),
(92, '1.1', '1.1.2', '[Relacion]'),
(92, '1', '1.2', 'Relacion'),
(92, '1', '1.3', 'Relacion'),
(92, '1', '1.4', 'Relacion'),
(93, '1', '1.1', 'Relacion'),
(93, '1.1', '1.1.1', '[Relacion]'),
(93, '1', '1.2', 'Relacion'),
(93, '1', '1.3', 'Relacion'),
(93, '1', '1.4', 'Relacion'),
(94, '1', '1.1', 'Relacion'),
(94, '1.1', '1.1.1', '[Relacion]'),
(94, '1', '1.2', 'Relacion'),
(94, '1', '1.3', 'Relacion'),
(94, '1', '1.4', 'Relacion'),
(95, '1', '1.1', 'ash'),
(95, '1.1', '1.1.1', '[Relacion]'),
(95, '1', '1.2', '[Relacion]'),
(95, '1.2', '1.2.1', '[Relacion]'),
(96, '1', '1.1', 'ash'),
(96, '1.1', '1.1.1', '[Relacion]'),
(96, '1', '1.2', '[Relacion]'),
(96, '1.2', '1.2.1', '[Relacion]'),
(97, '1', '1.1', 'ash'),
(97, '1.1', '1.1.1', '[Relacion]'),
(97, '1', '1.2', '[Relacion]'),
(97, '1.2', '1.2.1', '[Relacion]'),
(98, '1', '1.1', 'ash'),
(98, '1.1', '1.1.1', '[Relacion]'),
(98, '1', '1.2', '[Relacion]'),
(98, '1.2', '1.2.1', '[Relacion]'),
(99, '1', '1.1', 'ash'),
(99, '1.1', '1.1.1', '[Relacion]'),
(99, '1', '1.2', '[Relacion]'),
(99, '1.2', '1.2.1', '[Relacion]'),
(100, '1', '1.1', 'ash'),
(100, '1.1', '1.2', '[Relacion]'),
(100, '1', '1.1.1', '[Relacion]'),
(101, '1', '1.1', 'ash'),
(101, '1.1', '1.1.1', '[Relacion]'),
(101, '1.1', '1.1.2', '[Relacion]'),
(101, '1', '1.2', '[Relacion]'),
(101, '1.2', '1.2.1', '[Relacion]'),
(102, '1', '1.1', '[Relacion]'),
(102, '1.1', '1.1.1', '[Relacion]'),
(102, '1.1', '1.1.2', '[Relacion]'),
(102, '1', '1.2', '[Relacion]'),
(102, '1.2', '1.2.1', '[Relacion]'),
(102, '1.2', '1.2.2', '[Relacion]'),
(102, '1', '1.3', '[Relacion]'),
(102, '1.3', '1.3.1', '[Relacion]'),
(102, '1.3', '1.3.2', '[Relacion]'),
(102, '1', '1.4', '[Relacion]'),
(102, '1', '1.5', '[Relacion]'),
(102, '1.5', '1.5.1', '[Relacion]'),
(102, '1.5', '1.5.2', '[Relacion]'),
(102, '1', '1.6', '[Relacion]'),
(102, '1', '1.7', '[Relacion]'),
(102, '1.7', '1.7.1', '[Relacion]'),
(102, '1.7', '1.7.2', '[Relacion]'),
(102, '1', '1.8', '[Relacion]'),
(102, '1.8', '1.8.1', '[Relacion]'),
(102, '1.8', '1.8.2', '[Relacion]'),
(102, '1', '1.9', '[Relacion]'),
(102, '1.9', '1.9.1', '[Relacion]'),
(102, '1.9', '1.9.2', '[Relacion]'),
(103, '1', '1.1', 'este'),
(103, '1', '1.2', 'este'),
(103, '1', '1.3', 'este'),
(103, '1', '1.4', 'este'),
(103, '1', '1.5', 'este'),
(103, '1.5', '1.5.1', '[Relacion]'),
(104, '1', '1.1', 'este'),
(104, '1', '1.2', 'este'),
(104, '1', '1.3', 'este'),
(104, '1', '1.4', 'este'),
(104, '1', '1.5', 'este'),
(104, '1.5', '1.5.1', '[Relacion]'),
(106, '1', '1.1', 'este'),
(106, '1', '1.2', 'este'),
(106, '1', '1.3', 'este'),
(106, '1', '1.4', 'este'),
(106, '1', '1.5', 'este'),
(106, '1.5', '1.5.1', '[Relacion]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado_pregunta`
--

CREATE TABLE IF NOT EXISTS `resultado_pregunta` (
  `usuario_id_usuario` int(11) NOT NULL,
  `relacion_concepto_mapa_conceptual_id_mapa_conceptual` int(11) NOT NULL,
  `relacion_concepto_id_concepto` varchar(70) NOT NULL,
  `relacion_id_concepto_hijo` varchar(70) NOT NULL,
  `valoracion_pregunta` varchar(20) NOT NULL,
  `id_resultado_pregunta` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_resultado_pregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tematica`
--

CREATE TABLE IF NOT EXISTS `tematica` (
  `nombre_tematica` varchar(50) DEFAULT NULL,
  `id_tematica` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_tematica`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tematica`
--

INSERT INTO `tematica` (`nombre_tematica`, `id_tematica`) VALUES
('temporal', 1),
('Matematicas', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_mapa`
--

CREATE TABLE IF NOT EXISTS `tipo_mapa` (
  `id_tipo_mapa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo_mapa` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_mapa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tipo_mapa`
--

INSERT INTO `tipo_mapa` (`id_tipo_mapa`, `nombre_tipo_mapa`) VALUES
(1, 'Jerarquico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `perfil_id_perfil` int(11) NOT NULL,
  `nombre_usuario` varchar(20) NOT NULL,
  `apellido_usuario` varchar(20) NOT NULL,
  `clave` varchar(20) NOT NULL,
  `correo_usuario` varchar(50) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1234568 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `perfil_id_perfil`, `nombre_usuario`, `apellido_usuario`, `clave`, `correo_usuario`) VALUES
(121212, 2, 'Usuario ', 'Prueba', '121212', 'prueba@usuario.com'),
(123456, 1, 'admin', 'admin', '123456', 'joshleclash@gmail.com'),
(131313, 2, 'Usuario dos', 'Pruebas dos', '131313', 'purbasdos@algo.com'),
(1234567, 2, 'estudiante', 'estudiante', '1234567', 'estudiante2@cosito.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
