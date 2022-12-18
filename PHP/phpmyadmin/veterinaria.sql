-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-12-2022 a las 17:05:11
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `veterinaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `dniCli` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `nombreCli` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
  `apellidoCli` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
  `passwordCli` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
  `emailCli` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_producto`
--

CREATE TABLE `cliente_producto` (
  `dniCli` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `idProducto` int(254) NOT NULL,
  `idRec` int(254) NOT NULL,
  `cantidad` int(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `idFact` int(254) NOT NULL,
  `fechaFact` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--

CREATE TABLE `mascota` (
  `idMasc` int(254) NOT NULL,
  `dniCli` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `dniVet` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `tipoAnimal` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
  `sexo` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(254) NOT NULL,
  `tipoProducto` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `nombrePro` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
  `stock` int(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo`
--

CREATE TABLE `recibo` (
  `idRec` int(254) NOT NULL,
  `fechaRec` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `precioRec` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `tipoPro` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento`
--

CREATE TABLE `tratamiento` (
  `idTrata` int(100) NOT NULL,
  `tipoTrata` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
  `precioTrata` float DEFAULT NULL,
  `fechaTrata` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trata_masc`
--

CREATE TABLE `trata_masc` (
  `idMasc` int(254) NOT NULL,
  `idTrata` int(100) NOT NULL,
  `idFact` int(254) NOT NULL,
  `observacion` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veterinario`
--

CREATE TABLE `veterinario` (
  `dniVet` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `nombreVet` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
  `numVet` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
  `passwordVet` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
  `emailVet` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`dniCli`);

--
-- Indices de la tabla `cliente_producto`
--
ALTER TABLE `cliente_producto`
  ADD PRIMARY KEY (`dniCli`,`idProducto`,`idRec`),
  ADD KEY `cliente_producto_ibfk_2` (`idProducto`),
  ADD KEY `cliente_producto_ibfk_3` (`idRec`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`idFact`);

--
-- Indices de la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD PRIMARY KEY (`idMasc`),
  ADD KEY `FK_dniCli` (`dniCli`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `FK_tipoPro` (`tipoProducto`);

--
-- Indices de la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD PRIMARY KEY (`idRec`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`tipoPro`);

--
-- Indices de la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD PRIMARY KEY (`idTrata`);

--
-- Indices de la tabla `trata_masc`
--
ALTER TABLE `trata_masc`
  ADD PRIMARY KEY (`idMasc`,`idTrata`,`idFact`),
  ADD KEY `FK_idTrata` (`idTrata`),
  ADD KEY `FK_idFact` (`idFact`);

--
-- Indices de la tabla `veterinario`
--
ALTER TABLE `veterinario`
  ADD PRIMARY KEY (`dniVet`(8));

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `idFact` int(254) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `idMasc` int(254) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` int(254) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recibo`
--
ALTER TABLE `recibo`
  MODIFY `idRec` int(254) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  MODIFY `idTrata` int(100) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente_producto`
--
ALTER TABLE `cliente_producto`
  ADD CONSTRAINT `cliente_producto_ibfk_1` FOREIGN KEY (`dniCli`) REFERENCES `cliente` (`dniCli`),
  ADD CONSTRAINT `cliente_producto_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`),
  ADD CONSTRAINT `cliente_producto_ibfk_3` FOREIGN KEY (`idRec`) REFERENCES `recibo` (`idRec`);

--
-- Filtros para la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD CONSTRAINT `FK_dniCli` FOREIGN KEY (`dniCli`) REFERENCES `cliente` (`dniCli`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_tipoPro` FOREIGN KEY (`tipoProducto`) REFERENCES `tipo` (`tipoPro`);

--
-- Filtros para la tabla `trata_masc`
--
ALTER TABLE `trata_masc`
  ADD CONSTRAINT `FK_idFact` FOREIGN KEY (`idFact`) REFERENCES `factura` (`idFact`),
  ADD CONSTRAINT `FK_idMasc` FOREIGN KEY (`idMasc`) REFERENCES `mascota` (`idMasc`),
  ADD CONSTRAINT `FK_idTrata` FOREIGN KEY (`idTrata`) REFERENCES `tratamiento` (`idTrata`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
