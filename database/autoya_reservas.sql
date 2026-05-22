-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2026 a las 02:47:58
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `autoya`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`) VALUES
(1, 'Toyota'),
(2, 'Kia'),
(3, 'Renault'),
(4, 'Mazda'),
(5, 'Hyundai'),
(6, 'Nissan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `marca_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `nombre`, `marca_id`) VALUES
(1, 'Corolla Cross', 1),
(2, 'Hilux', 1),
(3, 'Yaris', 1),
(4, 'Fortuner', 1),
(5, 'Prado', 1),
(6, 'K3', 2),
(7, 'Picanto', 2),
(8, 'Sportage', 2),
(9, 'Sonet', 2),
(10, 'Seltos', 2),
(11, 'Duster', 3),
(12, 'Logan', 3),
(13, 'Kwid', 3),
(14, 'Kardian', 3),
(15, 'Arkana', 3),
(16, 'CX-30', 4),
(17, 'Mazda 2', 4),
(18, 'Mazda 3', 4),
(19, 'CX-5', 4),
(20, 'BT-50', 4),
(21, 'Kona', 5),
(22, 'Tucson', 5),
(23, 'Accent', 5),
(24, 'Creta', 5),
(25, 'Santa Fe', 5),
(26, 'Sentra', 6),
(27, 'X-trail', 6),
(28, 'Versa', 6),
(29, 'Kicks', 6),
(30, 'Frontier', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `reserva_id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','confirmado','rechazado') DEFAULT 'pendiente',
  `metodo_pago` varchar(50) DEFAULT NULL,
  `fecha_pago` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `vehiculo_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `precio_total` decimal(10,2) DEFAULT NULL,
  `estado` enum('pendiente','confirmada','cancelada') DEFAULT 'pendiente',
  `numero_contrato` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `vehiculo_id`, `user_id`, `fecha_inicio`, `fecha_fin`, `precio_total`, `estado`, `numero_contrato`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-05-17', '2026-05-20', 1000000.00, 'confirmada', 'CTR-6a095643b1824', '2026-05-17 10:46:43', '2026-05-17 21:26:47'),
(2, 6, 1, '2026-05-21', '2026-05-23', 450000.00, 'confirmada', 'CTR-6a09eb95c3058', '2026-05-17 21:23:49', '2026-05-18 04:43:34'),
(3, 3, 1, '2026-05-20', '2026-05-25', 660000.00, 'cancelada', 'CTR-6a09ebc9e733b', '2026-05-17 21:24:41', '2026-05-17 21:28:16'),
(4, 5, 1, '2026-05-24', '2026-05-25', 700000.00, 'confirmada', 'CTR-6a09ec1617c08', '2026-05-17 21:25:58', '2026-05-17 21:27:19'),
(5, 7, 1, '2026-05-17', '2026-05-25', 1773000.00, 'confirmada', 'CTR-6a0a47fd6f66b', '2026-05-18 03:58:05', '2026-05-18 04:58:13'),
(6, 2, 1, '2026-05-18', '2026-05-19', 530000.00, 'pendiente', 'CTR-6a0a4c9a53cc3', '2026-05-18 04:17:46', '2026-05-18 04:17:46'),
(7, 1, 1, '2026-05-21', '2026-05-22', 500000.00, 'pendiente', 'CTR-6a0a51797840e', '2026-05-18 04:38:33', '2026-05-18 04:38:33'),
(8, 2, 1, '2026-05-21', '2026-05-23', 795000.00, 'pendiente', 'CTR-6a0a51f12d267', '2026-05-18 04:40:33', '2026-05-18 04:40:33'),
(9, 2, 1, '2026-05-20', '2026-05-20', 265000.00, 'pendiente', 'CTR-6a0a532dda9cb', '2026-05-18 04:45:49', '2026-05-18 04:45:49'),
(10, 3, 1, '2026-05-17', '2026-05-19', 330000.00, 'pendiente', 'CTR-6a0a542e731c5', '2026-05-18 04:50:06', '2026-05-18 04:50:06'),
(11, 5, 1, '2026-05-17', '2026-05-20', 1400000.00, 'confirmada', 'CTR-6a0a5478de9c3', '2026-05-18 04:51:20', '2026-05-18 04:59:17'),
(12, 6, 1, '2026-05-17', '2026-05-18', 300000.00, 'cancelada', 'CTR-6a0a578723e1e', '2026-05-18 05:04:23', '2026-05-18 05:45:44'),
(13, 4, 1, '2026-05-17', '2026-05-18', 190000.00, 'cancelada', 'CTR-6a0a580b36ae4', '2026-05-18 05:06:35', '2026-05-18 05:09:36'),
(14, 4, 1, '2026-05-17', '2026-05-20', 380000.00, 'cancelada', 'CTR-6a0a599eed382', '2026-05-18 05:13:18', '2026-05-18 05:23:09'),
(15, 4, 1, '2026-05-17', '2026-05-18', 190000.00, 'cancelada', 'CTR-6a0a5e9cb66f4', '2026-05-18 05:34:36', '2026-05-18 05:36:11'),
(16, 4, 1, '2026-05-17', '2026-05-18', 190000.00, 'cancelada', 'CTR-6a0a5f446ebb6', '2026-05-18 05:37:24', '2026-05-18 05:46:42'),
(17, 6, 1, '2026-05-17', '2026-05-19', 450000.00, 'pendiente', 'CTR-6a0a61540f836', '2026-05-18 05:46:12', '2026-05-18 05:46:12'),
(18, 4, 1, '2026-05-17', '2026-05-21', 475000.00, 'pendiente', 'CTR-6a0a618c2e74e', '2026-05-18 05:47:08', '2026-05-18 05:47:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `modelo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `nombre`, `modelo_id`) VALUES
(1, 'SUV', 1),
(2, 'Pick-up', 2),
(3, 'Hatchback', 3),
(4, 'SUV', 4),
(5, 'SUV', 5),
(6, 'Sedán', 6),
(7, 'Hatchback', 7),
(8, 'SUV', 8),
(9, 'SUV', 9),
(10, 'SUV', 10),
(11, 'SUV', 11),
(12, 'Sedán', 12),
(13, 'Hatchback', 13),
(14, 'SUV', 14),
(15, 'SUV', 15),
(16, 'SUV', 16),
(17, 'Sedán', 17),
(18, 'Sedán', 18),
(19, 'SUV', 19),
(20, 'Pick-up', 20),
(21, 'SUV', 21),
(22, 'SUV', 22),
(23, 'Sedán', 23),
(24, 'SUV', 24),
(25, 'SUV', 25),
(26, 'Sedán', 26),
(27, 'SUV', 27),
(28, 'Sedán', 28),
(29, 'SUV', 29),
(30, 'Pick-up', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','cliente') NOT NULL DEFAULT 'cliente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `cedula`, `nombre`, `email`, `telefono`, `password`, `rol`, `created_at`) VALUES
(1, '12345678', 'admin', 'admin@test.com', '3100001111', '1234567', 'admin', '2026-05-17 03:50:50'),
(2, '87654321', 'Cliente Demo', 'cliente@test.com', '3110000000', '1234567', 'cliente', '2026-05-17 03:50:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `marca_id` int(11) DEFAULT NULL,
  `modelo_id` int(11) DEFAULT NULL,
  `anio` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `tarifa_diaria` decimal(10,2) NOT NULL,
  `estado` enum('activo','inactivo','matto') DEFAULT 'activo',
  `ubicacion` enum('Barranquilla','Bogota','Medellin','Cali','Bucaramanga') DEFAULT 'Barranquilla',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `placa`, `marca_id`, `modelo_id`, `anio`, `tipo`, `tarifa_diaria`, `estado`, `ubicacion`, `created_at`, `updated_at`) VALUES
(1, 'HJK782', 5, 21, 2025, 'SUV', 250000.00, 'activo', 'Barranquilla', '2026-05-17 08:52:07', '2026-05-17 08:53:23'),
(2, 'AGH123', 1, 2, 2025, 'Pick-up', 265000.00, 'activo', 'Barranquilla', '2026-05-17 08:57:18', '2026-05-17 23:52:00'),
(3, 'RTY602', 2, 7, 2020, 'Hatchback', 110000.00, 'activo', 'Barranquilla', '2026-05-17 09:05:17', '2026-05-17 09:05:17'),
(4, 'ASG563', 3, 11, 2016, 'SUV', 95000.00, 'activo', 'Cali', '2026-05-17 09:10:03', '2026-05-17 22:44:46'),
(5, 'HDD233', 4, 16, 2026, 'SUV', 350000.00, 'activo', 'Barranquilla', '2026-05-17 09:14:20', '2026-05-17 09:14:20'),
(6, 'YAU353', 6, 26, 2017, 'Sedán', 150000.00, 'activo', 'Barranquilla', '2026-05-17 09:27:37', '2026-05-17 09:27:37'),
(7, 'HFD789', 1, 3, 2025, 'Hatchback', 197000.00, 'activo', 'Cali', '2026-05-17 23:33:22', '2026-05-17 23:33:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_imagenes`
--

CREATE TABLE `vehiculo_imagenes` (
  `id` int(11) NOT NULL,
  `vehiculo_id` int(11) DEFAULT NULL,
  `ruta` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo_imagenes`
--

INSERT INTO `vehiculo_imagenes` (`id`, `vehiculo_id`, `ruta`, `created_at`, `updated_at`) VALUES
(1, 1, 'vehiculos/voDwKzT5qVkxRCCvji7CpjC1WKUEVZPqiThpGAry.jpg', '2026-05-17 08:52:07', '2026-05-17 08:52:07'),
(2, 1, 'vehiculos/sI2wdEyw2lD0kInbmoNtm3dajWt1WS0jl2Zg1u3W.jpg', '2026-05-17 08:52:07', '2026-05-17 08:52:07'),
(3, 1, 'vehiculos/dqGcMBjTTxJ60N60MjhRksfjhmNnsuOb1Tyz1p4p.jpg', '2026-05-17 08:52:07', '2026-05-17 08:52:07'),
(4, 1, 'vehiculos/Xfwa3nPqhs4jLejzRuTwMdWf484zJGv933IYm1UF.jpg', '2026-05-17 08:52:07', '2026-05-17 08:52:07'),
(9, 2, 'vehiculos/gRwu1lZpqhFbqm6WBot82XBculBRYTREFznbsU9w.jpg', '2026-05-17 08:57:18', '2026-05-17 08:57:18'),
(10, 3, 'vehiculos/U207KGexXhqYH1Au5l2iAL8mYv5CDv7gO607ZWz2.png', '2026-05-17 09:05:17', '2026-05-17 09:05:17'),
(11, 3, 'vehiculos/r33s8l77A8R8TSCaucN3GKGaUeX1WSSF9H2SKZt0.png', '2026-05-17 09:05:17', '2026-05-17 09:05:17'),
(12, 3, 'vehiculos/q90mcFitaE5QLbMcY6EAI4ZhXgXmlk2fjN1DcAiK.png', '2026-05-17 09:05:17', '2026-05-17 09:05:17'),
(13, 3, 'vehiculos/pAeAU7yNK1e0bG3oI7zsvdPK9i5mO4jaibpFBQ9x.png', '2026-05-17 09:05:17', '2026-05-17 09:05:17'),
(14, 4, 'vehiculos/p5n3n7765tbyzNx5Ly8XYaJH7arnEWIHDzIlyIB6.png', '2026-05-17 09:10:03', '2026-05-17 09:10:03'),
(15, 4, 'vehiculos/BZypvg33hOD0RjYyNXAgmTauLOHxs0fETx45uAN7.png', '2026-05-17 09:10:03', '2026-05-17 09:10:03'),
(16, 4, 'vehiculos/KN6ijE9c0JLJJjJKHLHzVfg92s57ecxCW86BwryE.png', '2026-05-17 09:10:03', '2026-05-17 09:10:03'),
(17, 4, 'vehiculos/EuvkSm1gwFdWPPoNLKdRmalsku08FjgsrSuLpVzX.png', '2026-05-17 09:10:03', '2026-05-17 09:10:03'),
(21, 5, 'vehiculos/qRdejYu3YYbH4BMFDEptfnYUjkSbZKdeX5tTitif.png', '2026-05-17 09:14:20', '2026-05-17 09:14:20'),
(22, 5, 'vehiculos/6i8lbWfhzV1CSraA5KHUc6Y0spQaI1rLHWu9qOBo.png', '2026-05-17 09:20:14', '2026-05-17 09:20:14'),
(23, 5, 'vehiculos/AmBfh41twWx30CzzWmcLnwsc5gIphAcuE8UFGL0r.png', '2026-05-17 09:20:14', '2026-05-17 09:20:14'),
(26, 6, 'vehiculos/HqwlV7bfoLt8RKiF1tNkhVsyxegdHxonPuEiBKVZ.png', '2026-05-17 09:27:37', '2026-05-17 09:27:37'),
(27, 6, 'vehiculos/8GMAs6bPX8wie3r2w21dG3g1LnqzywABkxUbIAiz.png', '2026-05-17 09:27:37', '2026-05-17 09:27:37'),
(28, 6, 'vehiculos/UMLRLDTU0JayYG6NIbnRWv943ajrMBRMSCbTpMuc.png', '2026-05-17 09:27:55', '2026-05-17 09:27:55'),
(31, 6, 'vehiculos/DjWmq68FWhxBIPdfMD33pYHifOaY7DpQbo0YPmmQ.png', '2026-05-17 09:29:37', '2026-05-17 09:29:37'),
(32, 7, 'vehiculos/c8f6jUvZrSI3sfB3C0BMqoY8KJjZQybwodC4Qcrn.png', '2026-05-17 23:33:23', '2026-05-17 23:33:23'),
(33, 7, 'vehiculos/AUcGvY3TLdeVI1QrLx2Ww5AaWxraMcz5YgV0tSX3.png', '2026-05-17 23:33:23', '2026-05-17 23:33:23'),
(34, 7, 'vehiculos/FOW6IgmFfkOLAPk7tB9IXgYSYACtJ6xmUgOmObV6.png', '2026-05-17 23:33:23', '2026-05-17 23:33:23'),
(35, 7, 'vehiculos/LtWpJ2vQBuanr3E5YHPKKKw8yOxTBLdQsPFtuWr1.png', '2026-05-17 23:33:23', '2026-05-17 23:33:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marca_id` (`marca_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reserva_id` (`reserva_id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reservas_vehiculo` (`vehiculo_id`),
  ADD KEY `idx_reservas_fechas` (`fecha_inicio`,`fecha_fin`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modelo_id` (`modelo_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `placa` (`placa`),
  ADD KEY `marca_id` (`marca_id`),
  ADD KEY `modelo_id` (`modelo_id`),
  ADD KEY `idx_vehiculo_estado` (`estado`);

--
-- Indices de la tabla `vehiculo_imagenes`
--
ALTER TABLE `vehiculo_imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculo_id` (`vehiculo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `vehiculo_imagenes`
--
ALTER TABLE `vehiculo_imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `modelos_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`id`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD CONSTRAINT `tipos_ibfk_1` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`),
  ADD CONSTRAINT `vehiculos_ibfk_2` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`);

--
-- Filtros para la tabla `vehiculo_imagenes`
--
ALTER TABLE `vehiculo_imagenes`
  ADD CONSTRAINT `vehiculo_imagenes_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
