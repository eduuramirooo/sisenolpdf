-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2025 a las 12:41:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `docssisenol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parque`
--

CREATE TABLE `parque` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `identificador` varchar(50) NOT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `potencia_instalada` decimal(10,2) DEFAULT NULL COMMENT 'Potencia en kW o MW',
  `precio` decimal(12,2) DEFAULT NULL COMMENT 'Precio en euros (€)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `parque`
--

INSERT INTO `parque` (`id`, `nombre`, `identificador`, `ubicacion`, `potencia_instalada`, `precio`) VALUES
(1, 'Parque Solar Norte', 'PSN-001', 'Madrid', 450.50, 1250000.00),
(2, 'Parque Eólico Sur', 'PES-002', 'Sevilla', 320.00, 980000.00),
(3, 'Parque Hidráulico Este', 'PHE-003', 'Valencia', 600.75, 1500000.00),
(4, 'Parque Solar Oeste', 'PSO-004', 'Toledo', 410.30, 1100000.00),
(5, 'Parque Solar Central', 'PSC-005', 'Zaragoza', 500.00, 1345000.00),
(6, 'Parque Eólico Norte', 'PEN-006', 'Burgos', 375.00, 1000000.00),
(7, 'Parque Biomasa Sur', 'PBS-007', 'Granada', 290.00, 750000.00),
(8, 'Parque Híbrido Este', 'PHE-008', 'Alicante', 680.20, 1650000.00),
(9, 'Parque Minihidráulico', 'PMH-009', 'Cuenca', 120.00, 350000.00),
(10, 'Parque Fotovoltaico', 'PFV-010', 'Cádiz', 540.00, 1450000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `apellido2` varchar(30) NOT NULL,
  `NIF` varchar(9) NOT NULL,
  `municipio` varchar(40) NOT NULL,
  `direccion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `apellido2`, `NIF`, `municipio`, `direccion`) VALUES
(1, 'Luis', 'Pérez', '101', '12345678A', 'Madrid', 'Calle Mayor 1'),
(2, 'Ana', 'García', '102', '23456789B', 'Barcelona', 'Av. Diagonal 200'),
(3, 'Carlos', 'López', '103', '34567890C', 'Valencia', 'Calle Ruzafa 45'),
(4, 'Marta', 'Sánchez', '104', '45678901D', 'Sevilla', 'C/ Betis 12'),
(5, 'Javier', 'Martín', '105', '56789012E', 'Zaragoza', 'Camino del Vado 78'),
(6, 'Lucía', 'Fernández', '106', '67890123F', 'Bilbao', 'Plaza Circular 3'),
(7, 'Pedro', 'Torres', '107', '78901234G', 'Granada', 'Calle Recogidas 19'),
(8, 'Elena', 'Romero', '108', '89012345H', 'Toledo', 'Av. Europa 55'),
(9, 'Sergio', 'Ruiz', '109', '90123456I', 'Salamanca', 'C/ Compañía 8'),
(10, 'Clara', 'Jiménez', '110', '01234567J', 'León', 'Calle Ancha 15'),
(11, 'Diego', 'Gómez', '111', '11122333K', 'Córdoba', 'Av. América 20'),
(12, 'Laura', 'Navarro', '112', '22233444L', 'A Coruña', 'Rúa Real 101'),
(13, 'Adrián', 'Ortega', '113', '33344555M', 'Pamplona', 'Calle Estafeta 7'),
(14, 'Carmen', 'Morales', '114', '44455666N', 'Oviedo', 'C/ Uría 100'),
(15, 'Hugo', 'Alonso', '115', '55566777O', 'Santander', 'Av. Reina Victoria 9');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `parque`
--
ALTER TABLE `parque`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificador` (`identificador`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `parque`
--
ALTER TABLE `parque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
