-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2013 a las 02:26:20
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
  `nombreConcepto` varchar(100) NOT NULL,
  `texttoConcepto` text NOT NULL,
  `idMapaConcetual` int(11) DEFAULT NULL,
  PRIMARY KEY (`idConcepto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `idGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `dscGrupo` varchar(200) DEFAULT NULL,
  `fechaCorte1` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechaCorte2` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fechaCorte3` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fechaInicio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fechaFinal` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `smalldatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `observaciones` text,
  `nombreGrupo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idGrupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `grupo`
--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupomapausuario`
--

CREATE TABLE IF NOT EXISTS `grupomapausuario` (
  `idMapaConceptual` int(11) DEFAULT NULL,
  `idGrupo` int(11) DEFAULT NULL,
  `idGrupoMapaConceptual` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idGrupoMapaConceptual`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupousuario`
--

CREATE TABLE IF NOT EXISTS `grupousuario` (
  `idGrupoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idGrupoUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiajuegorespuesta`
--

CREATE TABLE IF NOT EXISTS `historiajuegorespuesta` (
  `idHistoriaJuegoRespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `idJuego` int(11) DEFAULT NULL,
  `idMapaConceptual` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `duraccionReal` int(11) DEFAULT NULL,
  `fechaRealizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `respuestasAcertadas` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idHistoriaJuegoRespuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiamapaconceptual`
--

CREATE TABLE IF NOT EXISTS `historiamapaconceptual` (
  `idHistoriaMapaConceptual` int(11) NOT NULL AUTO_INCREMENT,
  `estadoMapa` varchar(20) DEFAULT NULL,
  `idMapaConceptual` int(11) DEFAULT NULL,
  `vigencia` varchar(20) DEFAULT NULL,
  `fechaInicio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechaLimite` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idHistoriaMapaConceptual`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juego`
--

CREATE TABLE IF NOT EXISTS `juego` (
  `idJuego` int(11) NOT NULL DEFAULT '0',
  `nombreJuego` int(11) DEFAULT NULL,
  PRIMARY KEY (`idJuego`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegomapa`
--

CREATE TABLE IF NOT EXISTS `juegomapa` (
  `idMapaConceptual` int(11) NOT NULL DEFAULT '0',
  `idJuego` int(11) DEFAULT NULL,
  `duracionJuego` int(11) DEFAULT NULL,
  `estadoJuego` int(11) DEFAULT '1',
  `mostrarEstatus` int(11) DEFAULT '0',
  PRIMARY KEY (`idMapaConceptual`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapaconceptual`
--

CREATE TABLE IF NOT EXISTS `mapaconceptual` (
  `idUsuario` int(11) DEFAULT NULL,
  `idTipoMapa` int(11) DEFAULT NULL,
  `nombreMapa` int(11) DEFAULT NULL,
  `totalConceptos` int(11) DEFAULT NULL,
  `totalRelaciones` int(11) DEFAULT NULL,
  `estadoMapa` varchar(20) DEFAULT NULL,
  `duracionMapa` int(11) DEFAULT NULL,
  `fechaInicio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechaLimite` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idMapaConceptual` int(11) NOT NULL AUTO_INCREMENT,
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
  `idMapaConceptual` int(11) DEFAULT NULL,
  `idConcepto` int(11) DEFAULT NULL,
  `idConceptoHijo` int(11) DEFAULT NULL,
  `nombreRelacion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultadopregunta`
--

CREATE TABLE IF NOT EXISTS `resultadopregunta` (
  `idUsuario` int(11) DEFAULT NULL,
  `idMapaConceptual` int(11) DEFAULT NULL,
  `idConcepto` int(11) DEFAULT NULL,
  `idConceptoHijo` varchar(70) DEFAULT NULL,
  `valoracionPregunta` int(11) DEFAULT NULL,
  `idResueltoPregunta` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idResueltoPregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tematica`
--

CREATE TABLE IF NOT EXISTS `tematica` (
  `idTematica` int(11) NOT NULL AUTO_INCREMENT,
  `nombreTematica` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`idTematica`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipomapa`
--

CREATE TABLE IF NOT EXISTS `tipomapa` (
  `idTipoMapa` int(11) NOT NULL AUTO_INCREMENT,
  `nombreTipoMapa` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idTipoMapa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idPerfil` int(11) DEFAULT '2',
  `nombreUsuario` varchar(60) DEFAULT NULL,
  `apellidoUsuario` varchar(60) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `mail` varchar(30) DEFAULT NULL,
  `clave` varchar(20) DEFAULT NULL,
  `identificacion` int(15) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `usuario perfil` (`idPerfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `usuario`
--



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
