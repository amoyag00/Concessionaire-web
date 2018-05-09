-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2018 a las 15:47:04
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
(1, 1, 1, 0),
(2, 1, 3, 1),
(2, 13, 4, 0),
(22, 13, 4, 0),
(2, 16, 3, 0),
(3, 16, 2, 1);

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
(13, 'audi', '2018-05-03 23:25:14'),
(16, 'audi', '2018-05-05 13:15:01');

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
(6, 'prov2', 'audi leon', 'gasolina', 18000, b'1'),
(9, 'prov', 'a', 'a', 1, b'1'),
(10, 'prov2', 'nuevoNombre', 'nuevas caracteristicas', 50, b'1'),
(11, 'prov', 'nombreProduct', 'estas son las caracteristicas del producto nombreProducto', 5, b'1'),
(12, 'prov2', 'nombre', 'estas son las caracteristicas del segundo producto', 3, b'0'),
(22, 'prov', 'a', 'a', 1, b'1'),
(29, 'prov', 'a', 'a', 1, b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `Usuario` (
  `nombre` varchar(15) NOT NULL,
  `contrasena` varchar(15) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `logged` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `Usuario` (`nombre`, `contrasena`, `tipo`, `logged`) VALUES
('admin', 'admin', 'administrator', 0),
('audi', 'audi', 'concessionaire', 0),
('prov', 'prov', 'provider', 0),
('prov2', 'prov2', 'provider', 0),
('seat', 'seat', 'concessionaire', 0);

--
-- Índices para tablas volcadas
--

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
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `Producto`
  MODIFY `producto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `listaproductos`
--
ALTER TABLE `ListaProductos`
  ADD CONSTRAINT `listaproductos_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `Producto` (`producto_id`),
  ADD CONSTRAINT `listaproductos_ibfk_2` FOREIGN KEY (`pedido_id`) REFERENCES `Pedido` (`pedido_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `Pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`nombreCon`) REFERENCES `Usuario` (`nombre`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `Producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`nombrePro`) REFERENCES `Usuario` (`nombre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
