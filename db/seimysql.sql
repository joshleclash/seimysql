-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-04-2013 a las 22:09:45
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
  `nombre_concepto` varchar(20) NOT NULL,
  `texto_concepto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `concepto`
--

INSERT INTO `concepto` (`mapa_conceptual_id_mapa_conceptual`, `id_concepto`, `nombre_concepto`, `texto_concepto`) VALUES
(16, '1', 'raiz1', ''),
(16, '1.1', 'ceoncepto de relacio', ''),
(16, '1.2', 'concepto de relacion', ''),
(17, '1', 'raiz1', ''),
(17, '1.1', 'ceoncepto de relacio', ''),
(17, '1.2', 'concepto de relacion', ''),
(18, '1', 'raiz1', ''),
(18, '1.1', 'ceoncepto de relacio', ''),
(18, '1.2', 'concepto de relacion', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `id_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_grupo` text NOT NULL,
  `nombre_grupo` varchar(30) NOT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `descripcion_grupo`, `nombre_grupo`) VALUES
(1, 'Matematicas1', 'Grupo de matematicas creado pa'),
(2, 'Matematicas', 'Grupo de matematicas creado pa');

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
(18, 3),
(18, 4),
(18, 2);

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
(2, 121212);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juego_mapa`
--

CREATE TABLE IF NOT EXISTS `juego_mapa` (
  `mapa_conceptual_id_mapa_conceptual` int(11) NOT NULL,
  `juego_id_juego` int(11) NOT NULL,
  `duracion_juego` int(11) NOT NULL,
  `estado_juego_mapa` int(11) NOT NULL,
  `mostrar_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `mapa_conceptual`
--

INSERT INTO `mapa_conceptual` (`usuario_id_usuario`, `tipo_mapa_id_tipo_mapa`, `nombre_mapa`, `total_conceptos`, `total_relaciones`, `estado_mapa`, `duracion_mapa`, `fecha_inicio`, `fecha_limite`, `id_mapa_conceptual`) VALUES
(1019002704, 1, 'MapaGenericos', 3, 2, '0', 1, '2013-04-07 01:46:38', '2013-04-07 02:46:38', 16),
(1019002704, 1, 'MapasGenerico', 3, 2, '0', 1, '2013-04-07 01:48:35', '2013-04-07 02:48:35', 17),
(1019002704, 1, 'MapaGenerico', 3, 2, '1', 1, '2013-04-06 19:12:44', '2013-04-07 02:54:22', 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapa_conceptual_tematica`
--

CREATE TABLE IF NOT EXISTS `mapa_conceptual_tematica` (
  `tematica_id_tematica` int(11) NOT NULL AUTO_INCREMENT,
  `mapa_conceptual_id_mapa_conceptual` int(11) NOT NULL,
  PRIMARY KEY (`tematica_id_tematica`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `mapa_conceptual_tematica`
--

INSERT INTO `mapa_conceptual_tematica` (`tematica_id_tematica`, `mapa_conceptual_id_mapa_conceptual`) VALUES
(1, 6);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tematica`
--

INSERT INTO `tematica` (`nombre_tematica`, `id_tematica`) VALUES
('temporal', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_mapa`
--

CREATE TABLE IF NOT EXISTS `tipo_mapa` (
  `id_tipo_mapa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo_mapa` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_mapa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=123456790 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `perfil_id_perfil`, `nombre_usuario`, `apellido_usuario`, `clave`, `correo_usuario`) VALUES
(121212, 2, 'sada', 'asd', '121212', 'joshleclash@gmail.com'),
(2034523, 2, 'estudiante', 'apellidos estudiante', '2034523', 'estudiante@algo.com'),
(123456789, 2, 'estudiante', 'estudiante', '123456789', 'estudiante2@cosito.com'),
(1019002704, 1, 'admin', 'admin', '123456', 'joshleclash@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
