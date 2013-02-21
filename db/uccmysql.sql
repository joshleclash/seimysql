-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-02-2013 a las 03:57:05
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
-- Estructura de tabla para la tabla `esudiantecurso`
--

CREATE TABLE IF NOT EXISTS `esudiantecurso` (
  `idEstudianteCurso` int(11) NOT NULL AUTO_INCREMENT,
  `idEstudiante` int(11) DEFAULT NULL,
  `idCurso` int(11) DEFAULT NULL,
  `smalldatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idUsuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEstudianteCurso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='EstudianteCurso para relacionar n cursos a n estudiantes' AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`idGrupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`idGrupo`, `dscGrupo`, `fechaCorte1`, `fechaCorte2`, `fechaCorte3`, `fechaInicio`, `fechaFinal`, `smalldatetime`, `observaciones`) VALUES
(3, 'kÃ±lkl', '2013-02-02 05:00:00', '2013-04-10 05:00:00', '2013-05-30 05:00:00', '2013-02-20 05:00:00', '2013-06-01 05:00:00', '2013-02-21 00:02:26', 'test'),
(4, 'Pruebas1', '2013-02-15 05:00:00', '2013-03-22 05:00:00', '2013-05-17 05:00:00', '2013-02-01 05:00:00', '2013-06-01 05:00:00', '2013-02-21 00:03:47', 'Esta es una prueba de creacion de un grupo donde los estudiantes deven quedar amarrados a este');

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

INSERT INTO `usuario` (`idUsuario`, `idPerfil`, `nombreUsuario`, `apellidoUsuario`, `celular`, `mail`, `clave`, `identificacion`) VALUES
(1, 1, 'Juan Pablo', 'Verano Russi', '3204796367', 'joshleclash@gmail.com', '1234567890', 1019002704),
(2, 2, 'Juan Camilo', 'Cruz', '3204796367', 'juan.verano@algo.com', 'h2c8wZmcVxS', 2147483647),
(3, 2, 'Juan Camilo', 'Cruz', '3204796367', 'joshleclash@gmail.com', 'ts7FKKMuKsY', 2147483647),
(4, 2, 'Juan Camilo', 'Cruz', '3204796367', 'joshleclash@gmail.com', '&LcnPN2qSsY', 2147483647),
(5, 2, 'Juan Camilo', 'Cruz', '3204796367', 'joshleclash@gmail.com', 'u&oRhNdtRQL', 2147483647),
(6, 2, 'Juan Camilo', 'Cruz', '3204796367', 'joshleclash@gmail.com', 'VrVON1Rl47b', 2147483647);

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
