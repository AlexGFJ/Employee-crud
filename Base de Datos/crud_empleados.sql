-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 29-08-2024 a las 22:16:42
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crud_empleados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE IF NOT EXISTS `empleados` (
  `Id_empleado` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Direccion` varchar(50) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `email` varchar(70) NOT NULL,
  `Id_empresa` int NOT NULL,
  `Status` int NOT NULL,
  PRIMARY KEY (`Id_empleado`),
  KEY `Id_empresa` (`Id_empresa`),
  KEY `Status` (`Status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`Id_empleado`, `Nombre`, `Direccion`, `Telefono`, `email`, `Id_empresa`, `Status`) VALUES
(1, 'Empleado1', 'Direccion 1', '5555555555', 'correo@correo.com', 3, 0),
(2, 'Empleado 2', 'Direccion 2', '2222222222', 'prueba@prueba2.com', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `Id_empresa` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) NOT NULL,
  `Direccion` varchar(40) NOT NULL,
  PRIMARY KEY (`Id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`Id_empresa`, `Nombre`, `Direccion`) VALUES
(1, 'Empresa 1', 'CDMX'),
(2, 'Empresa 2', 'CDMX'),
(3, 'Empresa 3', 'CDMX'),
(4, 'Empresa 4', 'CDMX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `ID` int NOT NULL,
  `Descripcion` varchar(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`ID`, `Descripcion`) VALUES
(0, 'Activo'),
(1, 'inactivo');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`Id_empresa`) REFERENCES `empresa` (`Id_empresa`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`Status`) REFERENCES `status` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
