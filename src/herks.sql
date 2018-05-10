-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 10, 2018 at 05:38 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `herks`
--

-- --------------------------------------------------------

--
-- Table structure for table `ListaProductos`
--

CREATE TABLE `ListaProductos` (
  `producto_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `cantidad` smallint(6) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ListaProductos`
--

INSERT INTO `ListaProductos` (`producto_id`, `pedido_id`, `cantidad`, `estado`) VALUES
(1, 1, 6, 0),
(2, 1, 3, 1),
(2, 13, 4, 0),
(2, 16, 3, 0),
(3, 16, 2, 1),
(1, 17, 9, 1),
(2, 17, 8, 0),
(2, 18, 7, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `mensaje_id` int(11) NOT NULL,
  `name` varchar(15) DEFAULT NULL,
  `email` varchar(35) DEFAULT NULL,
  `consulta` text,
  `leido` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`mensaje_id`, `name`, `email`, `consulta`) VALUES
(1, 'borrar', 'borrar', 'Acaba conmigo por favor'),
(2, 'otro', 'otro@gmail', 'Soy otra persona'),
(4, 'fill', 'fill', 'Prueba para rellenar la tabla'),
(5, 'fill', 'fill', 'Prueba para rellenar la tabla'),
(6, 'fill', 'fill', 'Prueba para rellenar la tabla'),
(7, 'fill', 'fill', 'Prueba para rellenar la tabla'),
(8, 'fill', 'fill', 'Prueba para rellenar la tabla'),
(9, 'fill', 'fill', 'Prueba para rellenar la tabla'),
(10, 'fill', 'fill', 'Prueba para rellenar la tabla');


-- --------------------------------------------------------
--
-- Table structure for table `Pedido`
--

CREATE TABLE `Pedido` (
  `pedido_id` int(11) NOT NULL,
  `nombreCon` varchar(15) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Pedido`
--

INSERT INTO `Pedido` (`pedido_id`, `nombreCon`, `fecha`) VALUES
(1, 'seat', '2018-04-14 22:00:00'),
(13, 'audi', '2018-05-03 23:25:14'),
(16, 'audi', '2018-05-05 13:15:01'),
(17, 'prov', '2018-05-09 08:51:07'),
(18, 'prov', '2018-05-09 08:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `Producto`
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
-- Dumping data for table `Producto`
--

INSERT INTO `Producto` (`producto_id`, `nombrePro`, `nombre`, `caracteristicas`, `precio`, `disponible`) VALUES
(1, 'prov', 'seat panda', 'gasolina', 8000, b'1'),
(2, 'prov', 'seat cebra', 'diesel', 9000, b'1'),
(3, 'prov', 'seat leon', 'gasolina', 7000, b'1'),
(4, 'prov2', 'audi panda', 'gasolina', 17000, b'1'),
(5, 'prov2', 'audi cebra', 'diesel', 19000, b'1'),
(6, 'prov2', 'audi leon', 'gasolina', 18000, b'1'),
(30, 'prov', 'seat ibiza', 'barato', 7000, b'0'),
(31, 'prov2', 'mitsubisi space star', '80CV', 12000, b'0'),
(32, 'prov', 'audi a1', '95CV gasolina', 18125, b'0'),
(33, 'prov2', 'audi R8', '540CV gasolina', 168000, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `Usuario`
--

CREATE TABLE `Usuario` (
  `nombre` varchar(15) NOT NULL,
  `contrasena` varchar(15) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `logged` int(11) NOT NULL DEFAULT '0',
  `bloqueado` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Usuario`
--

INSERT INTO `Usuario` (`nombre`, `contrasena`, `tipo`, `logged`) VALUES
('admin', 'admin', 'administrator', 0, 0),
('audi', 'audi', 'concessionaire', 0, 0),
('prov', 'prov', 'provider', 0, 0),
('prov2', 'prov2', 'provider', 0, 1),
('seat', 'seat', 'concessionaire', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`mensaje_id`);


--
-- Indexes for table `ListaProductos`
--
ALTER TABLE `ListaProductos`
  ADD PRIMARY KEY (`pedido_id`,`producto_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indexes for table `Pedido`
--
ALTER TABLE `Pedido`
  ADD PRIMARY KEY (`pedido_id`),
  ADD KEY `nombreCon` (`nombreCon`);

--
-- Indexes for table `Producto`
--
ALTER TABLE `Producto`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `nombrePro` (`nombrePro`);

--
-- Indexes for table `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`nombre`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `mensaje_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

--
-- AUTO_INCREMENT for table `Pedido`
--
ALTER TABLE `Pedido`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `Producto`
--
ALTER TABLE `Producto`
  MODIFY `producto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ListaProductos`
--
ALTER TABLE `ListaProductos`
  ADD CONSTRAINT `listaproductos_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `Producto` (`producto_id`),
  ADD CONSTRAINT `listaproductos_ibfk_2` FOREIGN KEY (`pedido_id`) REFERENCES `Pedido` (`pedido_id`) ON DELETE CASCADE;

--
-- Constraints for table `Pedido`
--
ALTER TABLE `Pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`nombreCon`) REFERENCES `Usuario` (`nombre`);

--
-- Constraints for table `Producto`
--
ALTER TABLE `Producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`nombrePro`) REFERENCES `Usuario` (`nombre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
