-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-04-2018 a las 14:48:39
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `herks`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `Administrador` (
  `nombreAdm` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `Administrador` (`nombreAdm`) VALUES
('admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concesionario`
--

CREATE TABLE `Concesionario` (
  `nombreCon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `concesionario`
--

INSERT INTO `Concesionario` (`nombreCon`) VALUES
('audi'),
('seat');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listaproductos`
--

CREATE TABLE `ListaProductos` (
  `producto_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `cantidad` smallint(6) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `listaproductos`
--

INSERT INTO `ListaProductos` (`producto_id`, `pedido_id`, `cantidad`, `estado`) VALUES
(1, 1, 10, 0),
(2, 1, 3, 1),
(4, 2, 5, 1),
(6, 2, 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `Pedido` (
  `pedido_id` int(11) NOT NULL,
  `nombreCon` varchar(15) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `Pedido` (`pedido_id`, `nombreCon`, `fecha`) VALUES
(1, 'seat', '2018-04-14 22:00:00'),
(2, 'audi', '2018-04-15 22:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `Producto` (
  `producto_id` int(11) NOT NULL,
  `nombrePro` varchar(15) DEFAULT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `caracteristicas` text,
  `precio` int(11) DEFAULT NULL,
  `disponible` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `Producto` (`producto_id`, `nombrePro`, `nombre`, `caracteristicas`, `precio`, `disponible`) VALUES
(1, 'prov', 'seat panda', 'gasolina', 8000, b'1'),
(2, 'prov', 'seat cebra', 'diesel', 9000, b'1'),
(3, 'prov', 'seat leon', 'gasolina', 7000, b'1'),
(4, 'prov2', 'audi panda', 'gasolina', 17000, b'1'),
(5, 'prov2', 'audi cebra', 'diesel', 19000, b'1'),
(6, 'prov2', 'audi leon', 'gasolina', 18000, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `Proveedor` (
  `nombrePro` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `Proveedor` (`nombrePro`) VALUES
('prov'),
('prov2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `Usuario` (
  `nombre` varchar(15) NOT NULL,
  `contrasena` varchar(15) NOT NULL,
  `tipo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `Usuario` (`nombre`, `contrasena`, `tipo`) VALUES
('admin', 'admin', 'administrator'),
('audi', 'audi', 'concessionaire'),
('prov', 'prov', 'provider'),
('prov2', 'prov2', 'provider'),
('seat', 'seat', 'concessionaire');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `Administrador`
  ADD PRIMARY KEY (`nombreAdm`);

--
-- Indices de la tabla `concesionario`
--
ALTER TABLE `Concesionario`
  ADD PRIMARY KEY (`nombreCon`);

--
-- Indices de la tabla `listaproductos`
--
ALTER TABLE `ListaProductos`
  ADD PRIMARY KEY (`pedido_id`,`producto_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `Pedido`
  ADD PRIMARY KEY (`pedido_id`),
  ADD KEY `nombreCon` (`nombreCon`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `Producto`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `nombrePro` (`nombrePro`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `Proveedor`
  ADD PRIMARY KEY (`nombrePro`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `Pedido`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `Producto`
  MODIFY `producto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `Administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`nombreAdm`) REFERENCES `Usuario` (`nombre`);

--
-- Filtros para la tabla `concesionario`
--
ALTER TABLE `Concesionario`
  ADD CONSTRAINT `concesionario_ibfk_1` FOREIGN KEY (`nombreCon`) REFERENCES `Usuario` (`nombre`);

--
-- Filtros para la tabla `listaproductos`
--
ALTER TABLE `ListaProductos`
  ADD CONSTRAINT `listaproductos_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `Producto` (`producto_id`),
  ADD CONSTRAINT `listaproductos_ibfk_2` FOREIGN KEY (`pedido_id`) REFERENCES `Pedido` (`pedido_id`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `Pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`nombreCon`) REFERENCES `Concesionario` (`nombreCon`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `Producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`nombrePro`) REFERENCES `Proveedor` (`nombrePro`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `Proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`nombrePro`) REFERENCES `Usuario` (`nombre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
