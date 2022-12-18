-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2022 a las 02:33:35
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`dniCli`, `nombreCli`, `apellidoCli`, `passwordCli`, `emailCli`) VALUES
('11111111A', 'Jorge', 'Ramón', 'cajal', 'a@a.a'),
('1234567A', 'adolfo', 'aubergeno', NULL, 'aaa@bb.cc'),
('1234567B', 'eberencio', 'facherez', 'a', 'aa@aa.aa');

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

--
-- Volcado de datos para la tabla `cliente_producto`
--

INSERT INTO `cliente_producto` (`dniCli`, `idProducto`, `cantidad`) VALUES
('1234567A', 4, 123456);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `idFact` int(254) NOT NULL,
  /*`idTarea` int(254) DEFAULT NULL,*/
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

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `tipoProducto`, `nombrePro`, `stock`) VALUES
(1, 'tipo1', 'galletas', 26),
(2, 'tipo1', 'galletas sabor carne roja', 44),
(3, 'tipo1', 'galletas sabor pescado', 57),
(4, 'tipo2', 'vacuna A', 12),
(6, 'tipo2', 'vacuna 11A3', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo`
--

CREATE TABLE `recibo` (
  `idRec` int(254) NOT NULL,
  /*`dniCliente` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `idProducto` int(254) NOT NULL,
 */
   `fechaRec` varchar(100) COLLATE utf16_spanish_ci NOT NULL
   `precioRec` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `recibo`
--

INSERT INTO `recibo` (`idRec`, `dniCliente`, `idProducto`, `fechaRec`, `precioRec`) VALUES
(1, '1234567A', 3, '18.18.18', 1234),
(2, '1234567A', 1, '07.12.22', 165.5),
(3, '1234567A', 1, '07.12.22', 165.5),
(4, '1234567A', 1, '07.12.22', 165.5),
(5, '1234567A', 1, '07.12.22', 165.5),
(6, '1234567A', 1, '2345t', 123),
(7, '1234567A', 1, '123456', 23),
(8, '1234567A', 1, '07.12.22', 165.5),
(9, '1234567A', 1, '07.12.22', 165.5),
(10, '1234567A', 1, '07.12.22', 165.5),
(11, '1234567A', 1, '07.12.22', 165.5),
(12, '1234567B', 1, '07.12.22', 66.2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--
/*
CREATE TABLE `tarea` (
  `tipoTarea` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `idMasc` int(254) NOT NULL,
  `precio` float NOT NULL,
  `idTarea` int(254) NOT NULL,
  `idFact` int(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;
*/
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `tipoPro` varchar(100) COLLATE utf16_spanish_ci NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`tipoPro`, `precio`) VALUES
('tipo1', 33.1),
('tipo2', 12.33);

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


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento`
--

CREATE TABLE `tratamiento` (
  `idTrata` int(100) COLLATE utf16_spanish_ci NOT NULL,
  `tipoTrata` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
  `precioTrata` float COLLATE utf16_spanish_ci DEFAULT NULL,
  `fechaTrata` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento`
--

CREATE TABLE `trata_masc` (
  `idMasc` int(254) COLLATE utf16_spanish_ci NOT NULL,
  `idTrata` int(100) COLLATE utf16_spanish_ci NOT NULL,
  `idFact` int(254) COLLATE utf16_spanish_ci NOT NULL,
  `observacion` varchar(100) COLLATE utf16_spanish_ci DEFAULT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;


--
-- Índices para tablas volcadas
--
--
-- Indices de la tabla `trata_masc`
--
ALTER TABLE `trata_masc`
    ADD PRIMARY KEY (`dniCli`);
    ADD PRIMARY KEY (`idTrata`);
    ADD PRIMARY KEY (`idFact`);
    ADD KEY `FK_dniCli` (`dniCli`);
    ADD KEY `FK_idTrata` (`idTrata`);
    ADD KEY `idFact` (`idFact`);
    MODIFY `dniCli` int(254) NOT NULL AUTO_INCREMENT;
    MODIFY `idTrata` int(100) NOT NULL AUTO_INCREMENT;
    MODIFY `idFact` int(254) NOT NULL AUTO_INCREMENT;   


    
--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`dniCli`);

--
-- Indices de la tabla `cliente_producto`
--
ALTER TABLE `cliente_producto`
    ADD PRIMARY KEY (`dniCli`,`idProducto`, `idFact`),
    ADD KEY `FK_dniCli` (`dniCli`),
    ADD KEY `FK_idProducto` (`idProducto`),
    ADD KEY `FK_idFact` (`idFact`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`idFact`);
 /* ADD KEY `FK_idTarea` (`idTarea`);*/

--
-- Indices de la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD PRIMARY KEY (`idMasc`),
  ADD KEY `FK_dniCli` (`dniCli`),
  ADD KEY `FK_dniVet` (`dniVet`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `FK_tipoProducto` (`tipoProducto`);

--
-- Indices de la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD PRIMARY KEY (`idRec`);
  /*ADD KEY `FK_dniCliente` (`dniCliente`),
  ADD KEY `FK_idProducto` (`idProducto`);*/

--
-- Indices de la tabla `tarea`
--
/*
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`idTarea`),
  ADD KEY `FK_idMasc` (`idMasc`),
  ADD KEY `FK_idFact` (`idFact`);
*/
--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`tipoPro`);

--
-- Indices de la tabla `veterinario`
--
ALTER TABLE `veterinario`
  ADD PRIMARY KEY (`dniVet`);

--
-- AUTO_INCREMENT de las tablas volcadas
--
ALTER TABLE `tratamiento`
    ADD PRIMARY KEY (`idTrata`);
    MODIFY `idTrata` int(100) NOT NULL AUTO_INCREMENT;
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
  MODIFY `idProducto` int(254) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `recibo`
--
ALTER TABLE `recibo`
  MODIFY `idRec` int(254) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `idTarea` int(254) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente_producto`
--
ALTER TABLE `cliente_producto`
    ADD CONSTRAINT `cliente_producto_ibfk_1` FOREIGN KEY (`dniCli`) REFERENCES `cliente` (`dniCli`),
    ADD CONSTRAINT `cliente_producto_ibfk_2` FOREIGN KEY (`idRec`) REFERENCES `recibo` (`idRec`),
    ADD CONSTRAINT `cliente_producto_ibfk_3` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `factura`
--
/*
ALTER TABLE `factura`
  ADD CONSTRAINT `FK_idTarea` FOREIGN KEY (`idTarea`) REFERENCES `tarea` (`idTarea`) ON DELETE CASCADE ON UPDATE CASCADE;
*/
--
-- Filtros para la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD CONSTRAINT `FK_dniCli` FOREIGN KEY (`dniCli`) REFERENCES `cliente` (`dniCli`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_dniVet` FOREIGN KEY (`dniVet`) REFERENCES `veterinario` (`dniVet`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_tipoPro` FOREIGN KEY (`tipoProducto`) REFERENCES `tipo` (`tipoPro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `trata_masc`
  ADD CONSTRAINT `FK_idMasc` FOREIGN KEY (`idMasc`) REFERENCES `mascota` (`idMasc`) ON DELETE CASCADE ON UPDATE CASCADE;
 ADD CONSTRAINT `FK_idTrata` FOREIGN KEY (`idTrata`) REFERENCES `tratamiento` (`idTrata`)ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_idFact` FOREIGN KEY (`idFact`) REFERENCES `factura` (`idFact`)ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Filtros para la tabla `recibo`
--
/*
ALTER TABLE `recibo`
  ADD CONSTRAINT `recibo_ibfk_1` FOREIGN KEY (`dniCliente`) REFERENCES `cliente` (`dniCli`),
  ADD CONSTRAINT `recibo_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);
*/
--
-- Filtros para la tabla `tarea`
--
/*
ALTER TABLE `tarea`
  ADD CONSTRAINT `FK_idMasc` FOREIGN KEY (`idMasc`) REFERENCES `mascota` (`idMasc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tarea_ibfk_1` FOREIGN KEY (`idFact`) REFERENCES `factura` (`idFact`);
COMMIT;
*/
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
