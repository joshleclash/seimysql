-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-02-2013 a las 14:10:49
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `uccmysql`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE IF NOT EXISTS `concepto` (
  `idConcepto` int(11) NOT NULL AUTO_INCREMENT,
  `nombreConcepto` varchar(20) DEFAULT NULL,
  `descripcionConcepto` text,
  `idMapaConceptual` int(11) DEFAULT NULL,
  PRIMARY KEY (`idConcepto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `idGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreGrupo` varchar(200) DEFAULT NULL,
  `descripcionGrupo` text,
  PRIMARY KEY (`idGrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupomapaconceptual`
--

CREATE TABLE IF NOT EXISTS `grupomapaconceptual` (
  `idGrupoMapaConceptual` int(11) DEFAULT NULL,
  `idGrupo` int(11) DEFAULT NULL,
  `idMapa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupousuario`
--

CREATE TABLE IF NOT EXISTS `grupousuario` (
  `idGrupoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idGrupoUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialjuego`
--

CREATE TABLE IF NOT EXISTS `historialjuego` (
  `idHistorialJuego` int(11) NOT NULL AUTO_INCREMENT,
  `respuestasAcertadas` varchar(20) DEFAULT NULL,
  `fechaRealizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `duracionReal` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idMapaConceptual` int(11) DEFAULT NULL,
  `idJuego` int(11) DEFAULT NULL,
  PRIMARY KEY (`idHistorialJuego`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialmapa`
--

CREATE TABLE IF NOT EXISTS `historialmapa` (
  `idHistorial` int(11) NOT NULL AUTO_INCREMENT,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `fechaLimite` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechaInicio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vigencia` int(11) DEFAULT NULL,
  `idMapaConceptual` int(11) DEFAULT NULL,
  PRIMARY KEY (`idHistorial`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juego`
--

CREATE TABLE IF NOT EXISTS `juego` (
  `idJuego` int(11) NOT NULL AUTO_INCREMENT,
  `nombreJuego` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idJuego`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegomapa`
--

CREATE TABLE IF NOT EXISTS `juegomapa` (
  `idJuegoMapa` int(1) NOT NULL AUTO_INCREMENT,
  `idMapaConceptual` int(11) DEFAULT NULL,
  `duracionJuego` varchar(20) DEFAULT NULL,
  `estadoJuego` enum('activo','inactivo') DEFAULT 'activo',
  `mostrarEstatus` enum('activo','inactivo') DEFAULT 'activo',
  PRIMARY KEY (`idJuegoMapa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapaconceptual`
--

CREATE TABLE IF NOT EXISTS `mapaconceptual` (
  `idMapaConceptual` int(11) NOT NULL AUTO_INCREMENT,
  `fechaLimite` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechaInicio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `duracionMapa` int(11) DEFAULT NULL,
  `estadoMapa` enum('activo','inactivo') DEFAULT NULL,
  `totalRelaciones` int(11) DEFAULT NULL,
  `totalConceptos` int(11) DEFAULT NULL,
  `nombreMapa` varchar(200) DEFAULT NULL,
  `idTipoMapa` varchar(20) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMapaConceptual`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapaconceptualtematica`
--

CREATE TABLE IF NOT EXISTS `mapaconceptualtematica` (
  `idTematica` int(11) NOT NULL DEFAULT '0',
  `idMapaConceptual` int(11) DEFAULT NULL,
  PRIMARY KEY (`idTematica`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `idPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `nombrePerfil` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idPerfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idPerfil`, `nombrePerfil`) VALUES
(1, 'Docente'),
(2, 'Estudiante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacion`
--

CREATE TABLE IF NOT EXISTS `relacion` (
  `idRelacion` int(11) NOT NULL AUTO_INCREMENT,
  `idConceptoHijo` int(11) DEFAULT NULL,
  `idConcepto` int(11) DEFAULT NULL,
  `nombreRelacion` varchar(200) DEFAULT NULL,
  `idMapaConceptual` int(11) DEFAULT NULL,
  PRIMARY KEY (`idRelacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultadopregunta`
--

CREATE TABLE IF NOT EXISTS `resultadopregunta` (
  `idResultadoPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `valoracionPregunta` varchar(20) DEFAULT NULL,
  `idConceptoHijo` int(11) DEFAULT NULL,
  `idConceto` int(11) DEFAULT NULL,
  `idMapaConceptual` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idResultadoPregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tematica`
--

CREATE TABLE IF NOT EXISTS `tematica` (
  `idTematica` int(11) NOT NULL AUTO_INCREMENT,
  `nombreTematica` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idTematica`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipomapa`
--

CREATE TABLE IF NOT EXISTS `tipomapa` (
  `idTipoMapa` int(11) NOT NULL AUTO_INCREMENT,
  `nombreTipoMapa` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idTipoMapa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idPerfil` int(11) DEFAULT NULL,
  `nombreUsuario` varchar(60) DEFAULT NULL,
  `apellidoUsuario` varchar(60) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `mail` varchar(30) DEFAULT NULL,
  `clave` varchar(20) DEFAULT NULL,
  `identificacion` int(15) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `usuario perfil` (`idPerfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `idPerfil`, `nombreUsuario`, `apellidoUsuario`, `celular`, `mail`, `clave`, `identificacion`) VALUES
(1, 1, 'Juan Pablo', 'Verano Russi', '3204796367', 'joshleclash@gmail.com', '123456', 1019002704);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
