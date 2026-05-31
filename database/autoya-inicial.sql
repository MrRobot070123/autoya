-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2026 a las 21:15:31
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
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(6, 'Nissan'),
(7, 'Ford'),
(8, 'Subaru'),
(9, 'Volvo'),
(10, 'Chrysler');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_25_023654_add_rol_to_users_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `marca_id` int(11) DEFAULT NULL,
  `tipo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `nombre`, `marca_id`, `tipo_id`) VALUES
(1, 'Corolla Cross', 1, 4),
(2, 'Hilux', 1, 6),
(3, 'Yaris', 1, 1),
(4, 'Fortuner', 1, 3),
(5, 'Prado', 1, 3),
(6, 'K3', 2, 1),
(7, 'Picanto', 2, 2),
(8, 'Sportage', 2, 3),
(9, 'Sonet', 2, 3),
(10, 'Seltos', 2, 3),
(11, 'Duster', 3, 3),
(12, 'Logan', 3, 1),
(13, 'Kwid', 3, 2),
(14, 'Kardian', 3, 4),
(15, 'Arkana', 3, 4),
(16, 'CX-30', 4, 3),
(17, 'Mazda 2', 4, 1),
(18, 'Mazda 3', 4, 1),
(19, 'CX-5', 4, 3),
(20, 'BT-50', 4, 6),
(21, 'Kona', 5, 4),
(22, 'Tucson', 5, 3),
(23, 'Accent', 5, 1),
(24, 'Creta', 5, 3),
(25, 'Santa Fe', 5, 3),
(26, 'Sentra', 6, 1),
(27, 'X-trail', 6, 3),
(28, 'Versa', 6, 1),
(29, 'Kicks', 6, 4),
(30, 'Frontier', 6, 6),
(31, 'Explorer', 7, 3),
(32, 'V60', 9, 8),
(33, 'Outback', 8, 8),
(34, 'Carnival', 2, 9),
(35, 'Pacifica', 10, 9),
(36, 'Sienna', 1, 9),
(37, 'Ranger', 7, 6),
(38, 'Fiesta', 7, 2),
(39, 'Fusion', 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reserva_id` bigint(20) UNSIGNED NOT NULL,
  `numero_pago` varchar(50) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `estado` enum('pendiente','pagado','rechazado') DEFAULT 'pagado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('prueba@test.com', '$2y$12$sXNTKQfEJG/bscogRsBvbO.i.YWpcKGOBw2dV8bR49ykWaYFBms4S', '2026-05-22 06:43:25');

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
  `estado` enum('pendiente','confirmada','cancelada','pagada') DEFAULT 'pendiente',
  `numero_contrato` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` int(11) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `descripcion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `tipo`, `descripcion`) VALUES
(1, 'Sedan', 'Auto de tres volúmenes (motor, cabina y maletero separados). Elegante, estable en carretera y  ofrece cuatro puertas.'),
(2, 'Hatchback', 'Vehículo compacto de dos volúmenes. Tiene una puerta trasera (escotilla) que se levanta para acceder directamente al maletero integrado con la cabina.'),
(3, 'Suv', 'Vehículo alto, robusto y espacioso, con mayor altura libre al suelo. Combinn la comodidad de un auto familiar con capacidades off-road moderadas'),
(4, 'Crossover', 'Ofrece una postura de manejo más alta, ligero y enfocado en el uso urbano'),
(5, 'Coupé', 'Vehículo de diseño deportivo, con dos puertas laterales, cabina cerrada y una caída del techo más pronunciada'),
(6, 'Pick-up', 'Camioneta con una cabina cerrada para pasajeros y un área de carga abierta (platón) en la parte trasera, diseñada para trabajo pesado y terrenos difíciles'),
(7, 'Convertible', 'Techo retráctil (de lona o metal) que se puede plegar para conducir a cielo abierto'),
(8, 'Station Wagon', 'Tiene una carrocería extendida hacia atrás, ofreciendo un maletero mucho más amplio'),
(9, 'Minivan', 'Vehículo alto y espacioso diseñado para familias numerosas. Cuenta con puertas corredizas y capacidad para 7 u 8 pasajeros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cedula` bigint(15) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` bigint(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rol` varchar(255) NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `cedula`, `nombre`, `email`, `telefono`, `password`, `created_at`, `updated_at`, `rol`) VALUES
(1, 1042357733, 'prueba', 'prueba@test.com', 3100001111, '$2y$12$PajYa0NXoNeEYwND6/k.0OKsGPGlj6fGWUD2ePJ8Xcankri2oQx/G', '2026-05-21 05:36:33', '2026-05-21 05:36:33', 'cliente'),
(2, 145080390, 'Daniel Pacheco', 'daniel@gmail.com', 3202520210, '$2y$12$/JFuGsTVNzVXxFsLN4fCaOMi6gUR.HQ9temdz18ZUxwfHeUg5wK5m', '2026-05-21 07:27:11', '2026-05-21 07:27:11', 'admin'),
(3, 16408603, 'Julieta Ortiz', 'juortiz@test.com', 3025609010, '$2y$12$S4JroAudmixP/6HEw7eT0On.xHGKsj2l2351P1tCKVI63GzgJ63xO', '2026-05-25 09:19:33', '2026-05-25 09:19:33', 'cliente'),
(4, 22465118, 'Matias Flip', 'mflip@test.com', 325104563, '$2y$12$SsCUKI01FriC0qIf2A86MupCrLcQKkBRz6r7b1HEKMCatFWpZlJ5.', '2026-05-27 11:14:20', '2026-05-27 11:14:20', 'cliente'),
(5, 22465452, 'Lionel Messi', 'leo@test.com.co', 911254535, '$2y$12$q1UW3tQ0KprFK1fVp6/8f.W.zj4pwtA4N77wo798HiWpvcWLIXgQO', '2026-05-27 11:17:10', '2026-05-27 11:17:10', 'cliente'),
(6, 1231545, 'Neymar JR', 'ney@test.com.co', 302589620, '$2y$12$Yc4.uYuudSjXPn/3eskVBuKUSom/6JY4GPkXeecJf4scZJlom6.F.', '2026-05-27 11:24:48', '2026-05-27 11:24:48', 'cliente'),
(7, 12025301, 'Diego Armando', 'maradona@test.com', 30215209502, '$2y$12$Ty09NlvYnvl5rnTMJbjMpOUFp5SsYJsY2MXLOA7kFidJN7i7zqi6q', '2026-05-27 11:28:15', '2026-05-27 11:28:15', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `marca_id` int(11) DEFAULT NULL,
  `modelo_id` int(11) DEFAULT NULL,
  `tipo_id` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `tarifa_diaria` decimal(10,2) NOT NULL,
  `estado` enum('activo','inactivo','matto') NOT NULL DEFAULT 'activo',
  `ubicacion` enum('Barranquilla','Bogota','Medellin','Cali','Bucaramanga') NOT NULL DEFAULT 'Barranquilla',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `placa`, `marca_id`, `modelo_id`, `tipo_id`, `anio`, `tarifa_diaria`, `estado`, `ubicacion`, `created_at`, `updated_at`) VALUES
(1, 'HJK782', 5, 21, 4, 2025, 250000.00, 'activo', 'Barranquilla', '2026-05-17 08:52:07', '2026-05-18 08:46:36'),
(2, 'AGH123', 1, 2, 6, 2025, 265000.00, 'activo', 'Barranquilla', '2026-05-17 08:57:18', '2026-05-17 23:52:00'),
(3, 'RTY602', 2, 7, 2, 2020, 110000.00, 'activo', 'Barranquilla', '2026-05-17 09:05:17', '2026-05-17 09:05:17'),
(4, 'ASG563', 3, 11, 3, 2016, 95000.00, 'activo', 'Cali', '2026-05-17 09:10:03', '2026-05-17 22:44:46'),
(5, 'HDD233', 4, 16, 3, 2026, 350000.00, 'activo', 'Barranquilla', '2026-05-17 09:14:20', '2026-05-17 09:14:20'),
(6, 'YAU353', 6, 26, 1, 2017, 150000.00, 'activo', 'Barranquilla', '2026-05-17 09:27:37', '2026-05-17 09:27:37'),
(7, 'HFD789', 1, 3, 1, 2025, 197000.00, 'activo', 'Cali', '2026-05-17 23:33:22', '2026-05-17 23:33:22'),
(8, 'ASD286', 7, 31, 3, 2025, 350000.00, 'activo', 'Medellin', '2026-05-20 02:43:00', '2026-05-20 02:43:00');

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
(35, 7, 'vehiculos/LtWpJ2vQBuanr3E5YHPKKKw8yOxTBLdQsPFtuWr1.png', '2026-05-17 23:33:23', '2026-05-17 23:33:23'),
(36, 2, 'vehiculos/Xv7XyHyGaVg0GJba8Jvx8qTwPsRL6G0I21NatUw6.jpg', '2026-05-18 07:27:48', '2026-05-18 07:27:48'),
(37, 2, 'vehiculos/1G88uL1xWE2FtF0N4cymdzB9s2bfVj7DKJ5ZUd3c.jpg', '2026-05-18 07:27:48', '2026-05-18 07:27:48'),
(39, 2, 'vehiculos/FJKsDrzfCNR5JoZtJvxaZ2U1aiBGiqWmC4r7yEFn.jpg', '2026-05-18 07:29:22', '2026-05-18 07:29:22'),
(40, 8, 'vehiculos/pjac7ovf98Qw6gtwSUWUjApyCN4DudTXNNuvsCWJ.png', '2026-05-20 02:43:02', '2026-05-20 02:43:02'),
(41, 8, 'vehiculos/sDkBdztEwn7POesPzcfGjQvbiXOsRSwGJAHivhyq.png', '2026-05-20 02:43:02', '2026-05-20 02:43:02'),
(42, 8, 'vehiculos/5ANoxVJdKgA5oLaEOWl7sqlTowH683T9YCNWHQFm.png', '2026-05-20 02:43:02', '2026-05-20 02:43:02'),
(43, 8, 'vehiculos/MXUefxuLNjZTCO7E6uaFKGwqlhXwnLmSLRhMNvNv.png', '2026-05-20 02:43:02', '2026-05-20 02:43:02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marca_id` (`marca_id`),
  ADD KEY `tipo_id` (`tipo_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_pago` (`numero_pago`),
  ADD KEY `reserva_id` (`reserva_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reservas_vehiculo` (`vehiculo_id`),
  ADD KEY `idx_reservas_fechas` (`fecha_inicio`,`fecha_fin`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `placa` (`placa`),
  ADD KEY `marca_id` (`marca_id`),
  ADD KEY `modelo_id` (`modelo_id`),
  ADD KEY `idx_vehiculo_estado` (`estado`),
  ADD KEY `tipo_id` (`tipo_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `vehiculo_imagenes`
--
ALTER TABLE `vehiculo_imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `modelos_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `modelos_ibfk_2` FOREIGN KEY (`tipo_id`) REFERENCES `tipos` (`id`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`),
  ADD CONSTRAINT `vehiculos_ibfk_2` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`),
  ADD CONSTRAINT `vehiculos_ibfk_3` FOREIGN KEY (`tipo_id`) REFERENCES `tipos` (`id`);

--
-- Filtros para la tabla `vehiculo_imagenes`
--
ALTER TABLE `vehiculo_imagenes`
  ADD CONSTRAINT `vehiculo_imagenes_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
