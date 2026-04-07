-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-04-2026 a las 17:45:57
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
-- Base de datos: `easymove`
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
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comparaciones`
--

CREATE TABLE `comparaciones` (
  `id_comparacion` int(10) UNSIGNED NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(10) UNSIGNED DEFAULT NULL,
  `id_ubicacion` int(10) UNSIGNED NOT NULL,
  `id_tipo_servicio` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comparaciones`
--

INSERT INTO `comparaciones` (`id_comparacion`, `fecha`, `id_usuario`, `id_ubicacion`, `id_tipo_servicio`, `created_at`, `updated_at`) VALUES
(1, '2026-04-07 12:59:27', NULL, 11, 1, '2026-04-07 12:59:27', '2026-04-07 12:59:27'),
(2, '2026-04-07 12:59:59', NULL, 12, 1, '2026-04-07 12:59:59', '2026-04-07 12:59:59'),
(3, '2026-04-07 13:00:02', NULL, 13, 1, '2026-04-07 13:00:02', '2026-04-07 13:00:02'),
(4, '2026-04-07 13:00:07', NULL, 1, 1, '2026-04-07 13:00:07', '2026-04-07 13:00:07'),
(5, '2026-04-07 13:00:10', NULL, 2, 1, '2026-04-07 13:00:10', '2026-04-07 13:00:10'),
(6, '2026-04-07 13:00:12', NULL, 4, 1, '2026-04-07 13:00:12', '2026-04-07 13:00:12'),
(7, '2026-04-07 13:00:15', NULL, 13, 1, '2026-04-07 13:00:15', '2026-04-07 13:00:15'),
(8, '2026-04-07 13:00:24', NULL, 13, 2, '2026-04-07 13:00:24', '2026-04-07 13:00:24'),
(9, '2026-04-07 13:00:27', NULL, 13, 2, '2026-04-07 13:00:27', '2026-04-07 13:00:27'),
(10, '2026-04-07 13:00:31', NULL, 13, 3, '2026-04-07 13:00:31', '2026-04-07 13:00:31'),
(11, '2026-04-07 13:01:13', NULL, 1, 1, '2026-04-07 13:01:13', '2026-04-07 13:01:13'),
(13, '2026-04-07 13:04:34', NULL, 1, 1, '2026-04-07 13:04:34', '2026-04-07 13:04:34'),
(14, '2026-04-07 13:07:18', NULL, 1, 1, '2026-04-07 13:07:18', '2026-04-07 13:07:18'),
(20, '2026-04-07 13:14:26', NULL, 11, 1, '2026-04-07 13:14:26', '2026-04-07 13:14:26'),
(22, '2026-04-07 13:17:57', NULL, 11, 1, '2026-04-07 13:17:57', '2026-04-07 13:17:57'),
(28, '2026-04-07 13:37:39', NULL, 11, 1, '2026-04-07 13:37:39', '2026-04-07 13:37:39'),
(31, '2026-04-07 13:44:21', 1, 11, 1, '2026-04-07 13:44:21', '2026-04-07 13:44:21'),
(32, '2026-04-07 13:44:31', 1, 13, 1, '2026-04-07 13:44:31', '2026-04-07 13:44:31'),
(33, '2026-04-07 13:44:33', 1, 11, 1, '2026-04-07 13:44:33', '2026-04-07 13:44:33'),
(34, '2026-04-07 13:44:35', 1, 11, 2, '2026-04-07 13:44:35', '2026-04-07 13:44:35'),
(35, '2026-04-07 13:44:38', 1, 11, 3, '2026-04-07 13:44:38', '2026-04-07 13:44:38'),
(36, '2026-04-07 13:44:40', 1, 1, 3, '2026-04-07 13:44:40', '2026-04-07 13:44:40'),
(37, '2026-04-07 13:44:43', 1, 1, 2, '2026-04-07 13:44:43', '2026-04-07 13:44:43'),
(38, '2026-04-07 13:44:45', 1, 1, 3, '2026-04-07 13:44:45', '2026-04-07 13:44:45'),
(39, '2026-04-07 13:44:50', 1, 11, 1, '2026-04-07 13:44:50', '2026-04-07 13:44:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comparacion_tarifas`
--

CREATE TABLE `comparacion_tarifas` (
  `id_comparacion_tarifa` int(10) UNSIGNED NOT NULL,
  `id_comparacion` int(10) UNSIGNED NOT NULL,
  `id_tarifa` int(10) UNSIGNED NOT NULL,
  `posicion_resultado` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comparacion_tarifas`
--

INSERT INTO `comparacion_tarifas` (`id_comparacion_tarifa`, `id_comparacion`, `id_tarifa`, `posicion_resultado`, `created_at`, `updated_at`) VALUES
(1, 14, 4, 1, '2026-04-07 13:07:18', '2026-04-07 13:07:18'),
(2, 14, 1, 2, '2026-04-07 13:07:18', '2026-04-07 13:07:18'),
(3, 20, 4, 1, '2026-04-07 13:14:26', '2026-04-07 13:14:26'),
(4, 20, 1, 2, '2026-04-07 13:14:26', '2026-04-07 13:14:26'),
(5, 22, 4, 1, '2026-04-07 13:17:57', '2026-04-07 13:17:57'),
(6, 22, 1, 2, '2026-04-07 13:17:57', '2026-04-07 13:17:57'),
(7, 28, 4, 1, '2026-04-07 13:37:39', '2026-04-07 13:37:39'),
(8, 28, 1, 2, '2026-04-07 13:37:39', '2026-04-07 13:37:39'),
(9, 31, 4, 1, '2026-04-07 13:44:21', '2026-04-07 13:44:21'),
(10, 31, 1, 2, '2026-04-07 13:44:21', '2026-04-07 13:44:21'),
(11, 31, 5, 3, '2026-04-07 13:44:21', '2026-04-07 13:44:21'),
(12, 31, 3, 4, '2026-04-07 13:44:21', '2026-04-07 13:44:21'),
(13, 31, 2, 5, '2026-04-07 13:44:21', '2026-04-07 13:44:21'),
(14, 33, 4, 1, '2026-04-07 13:44:33', '2026-04-07 13:44:33'),
(15, 33, 1, 2, '2026-04-07 13:44:33', '2026-04-07 13:44:33'),
(16, 33, 5, 3, '2026-04-07 13:44:33', '2026-04-07 13:44:33'),
(17, 33, 3, 4, '2026-04-07 13:44:33', '2026-04-07 13:44:33'),
(18, 33, 2, 5, '2026-04-07 13:44:33', '2026-04-07 13:44:33'),
(19, 36, 8, 1, '2026-04-07 13:44:40', '2026-04-07 13:44:40'),
(20, 36, 9, 2, '2026-04-07 13:44:40', '2026-04-07 13:44:40'),
(21, 37, 6, 1, '2026-04-07 13:44:43', '2026-04-07 13:44:43'),
(22, 37, 7, 2, '2026-04-07 13:44:43', '2026-04-07 13:44:43'),
(23, 38, 8, 1, '2026-04-07 13:44:45', '2026-04-07 13:44:45'),
(24, 38, 9, 2, '2026-04-07 13:44:45', '2026-04-07 13:44:45'),
(25, 39, 4, 1, '2026-04-07 13:44:50', '2026-04-07 13:44:50'),
(26, 39, 1, 2, '2026-04-07 13:44:50', '2026-04-07 13:44:50'),
(27, 39, 5, 3, '2026-04-07 13:44:50', '2026-04-07 13:44:50'),
(28, 39, 3, 4, '2026-04-07 13:44:50', '2026-04-07 13:44:50'),
(29, 39, 2, 5, '2026-04-07 13:44:50', '2026-04-07 13:44:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidad`
--

CREATE TABLE `disponibilidad` (
  `id_disponibilidad` int(10) UNSIGNED NOT NULL,
  `id_tarifa` int(10) UNSIGNED NOT NULL,
  `id_ubicacion` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `disponibilidad`
--

INSERT INTO `disponibilidad` (`id_disponibilidad`, `id_tarifa`, `id_ubicacion`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(2, 1, 2, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(3, 1, 3, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(4, 1, 4, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(5, 1, 5, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(6, 2, 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(7, 2, 2, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(8, 2, 3, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(9, 3, 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(10, 3, 2, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(11, 3, 3, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(12, 3, 4, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(13, 4, 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(14, 4, 2, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(15, 4, 3, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(16, 4, 4, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(17, 4, 5, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(18, 5, 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(19, 5, 2, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(20, 5, 3, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(21, 1, 11, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(22, 2, 11, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(23, 3, 11, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(24, 4, 11, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(25, 5, 11, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(26, 1, 12, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(27, 3, 12, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(28, 4, 12, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(29, 6, 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(30, 6, 2, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(31, 6, 3, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(32, 6, 4, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(33, 6, 5, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(34, 7, 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(35, 7, 2, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(36, 7, 3, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(37, 8, 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(38, 8, 2, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(39, 8, 3, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(40, 8, 4, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(41, 9, 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(42, 9, 2, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(43, 9, 3, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(44, 9, 4, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(45, 9, 5, '2026-02-13 18:10:31', '2026-02-13 18:10:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `web` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `tipo_proveedor` enum('telefonica','luz','gas','mixto') NOT NULL,
  `api_disponible` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `web`, `logo`, `tipo_proveedor`, `api_disponible`, `created_at`, `updated_at`) VALUES
(1, 'Endesa', 'https://www.endesa.es', 'https://logo.clearbit.com/endesa.es', 'luz', 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(2, 'Iberdrola', 'https://www.iberdrola.es', 'https://logo.clearbit.com/iberdrola.es', 'luz', 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(3, 'EDF', 'https://www.edf.es', 'https://logo.clearbit.com/edf.es', 'luz', 0, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(4, 'Naturgy', 'https://www.naturgy.es', 'https://logo.clearbit.com/naturgy.es', 'gas', 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(5, 'Telefonica', 'https://www.telefonica.es', 'https://logo.clearbit.com/telefonica.es', 'telefonica', 1, '2026-02-13 18:10:31', '2026-02-13 23:30:23'),
(6, 'Vodafone', 'https://www.vodafone.es', 'https://logo.clearbit.com/vodafone.es', 'telefonica', 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(10) UNSIGNED NOT NULL,
  `nombre_servicio` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_tipo_servicio` int(10) UNSIGNED NOT NULL,
  `id_proveedor` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `nombre_servicio`, `descripcion`, `id_tipo_servicio`, `id_proveedor`, `created_at`, `updated_at`) VALUES
(1, 'Luz Basica Endesa', 'Tarifa estandar de electricidad con acceso flexible', 1, 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(2, 'Luz Plus Endesa', 'Tarifa con descuentos y ofertas adicionales', 1, 1, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(3, 'Luz Eco Iberdrola', 'Tarifa con energias renovables certificadas', 1, 2, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(4, 'Luz Estandar EDF', 'Tarifa competitiva sin permanencia', 1, 3, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(5, 'Gas Natural Naturgy', 'Suministro de gas natural con contrato flexible', 2, 4, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(6, 'Gas Plus Naturgy', 'Tarifa premium con seguros incluidos', 2, 4, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(7, 'Fibra + Fijo Telefonica', 'Fibra optica 300Mbps + telefonia fija', 3, 5, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(8, 'Fibra + Movil Vodafone', 'Fibra optica 600Mbps + linea movil ilimitada', 3, 6, '2026-02-13 18:10:31', '2026-02-13 18:10:31');

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

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CsCmB45Hcp5Fen8FF0JyQzYRAqopgkWjh40UFlPY', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 OPR/129.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic1NIdkk1VkJPUUpOQlltTUJwcG92Rm5HYjVKQXg2RlpqTkhGWTBIaCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1775576730);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifas`
--

CREATE TABLE `tarifas` (
  `id_tarifa` int(10) UNSIGNED NOT NULL,
  `nombre_tarifa` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `unidad_precio` varchar(50) DEFAULT NULL,
  `permanencia` varchar(100) DEFAULT NULL,
  `condiciones` text DEFAULT NULL,
  `url_oferta_externa` varchar(255) DEFAULT NULL,
  `id_servicio` int(10) UNSIGNED NOT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tarifas`
--

INSERT INTO `tarifas` (`id_tarifa`, `nombre_tarifa`, `precio`, `unidad_precio`, `permanencia`, `condiciones`, `url_oferta_externa`, `id_servicio`, `fecha_actualizacion`, `created_at`, `updated_at`) VALUES
(1, 'Tarifa Luz Basica', 45.50, 'mes', 'Sin permanencia', 'Acceso 0.10€/kWh + potencia 90€/ano', 'https://www.endesa.es/es/particulares/luz', 1, '2026-02-13 23:31:06', '2026-02-13 18:10:31', '2026-02-13 23:31:06'),
(2, 'Tarifa Luz Plus', 52.30, 'mes', '12 meses', 'Descuento 15% + seguros incluidos', 'https://www.endesa.es/es/particulares/luz', 2, '2026-02-13 18:10:31', '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(3, 'Tarifa Luz Eco', 48.75, 'mes', '12 meses', '100% energia renovable certificada', 'https://www.iberdrola.es/clientes/luz', 3, '2026-02-13 23:31:35', '2026-02-13 18:10:31', '2026-02-13 23:31:35'),
(4, 'Tarifa Luz Ahorro', 44.20, 'mes', 'Sin permanencia', 'Acceso flexible + cambio sin penalizacion', 'https://www.iberdrola.es/clientes/luz', 3, '2026-02-13 23:31:42', '2026-02-13 18:10:31', '2026-02-13 23:31:42'),
(5, 'Tarifa Luz Estandar', 46.99, 'mes', 'Sin permanencia', 'Precio fijo durante 1 ano', 'https://www.edf.es/es/hogares', 4, '2026-02-13 23:32:10', '2026-02-13 18:10:31', '2026-02-13 23:32:10'),
(6, 'Tarifa Gas Natural', 35.40, 'mes', 'Sin permanencia', 'Precio variable + facturacion mensual', 'https://www.naturgy.es', 5, '2026-02-13 23:32:17', '2026-02-13 18:10:31', '2026-02-13 23:32:17'),
(7, 'Tarifa Gas Plus', 42.80, 'mes', '24 meses', 'Incluye seguros de hogar + precio fijo', 'https://www.naturgy.es', 6, '2026-02-13 18:10:31', '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(8, 'Fibra 300Mbps + Fijo', 49.95, 'mes', '12 meses', 'Velocidad hasta 300Mbps + llamadas ilimitadas', 'https://www.telefonica.es', 7, '2026-02-13 18:10:31', '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(9, 'Fibra 600Mbps + Movil', 59.90, 'mes', '12 meses', 'Velocidad 600Mbps + linea movil 50GB', 'https://www.vodafone.es', 8, '2026-02-13 23:31:55', '2026-02-13 18:10:31', '2026-02-13 23:31:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_servicios`
--

CREATE TABLE `tipos_servicios` (
  `id_tipo_servicio` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_servicios`
--

INSERT INTO `tipos_servicios` (`id_tipo_servicio`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Luz', 'Servicio de suministro electrico residencial', '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(2, 'Gas', 'Servicio de suministro de gas natural', '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(3, 'Telefonia', 'Servicio de telefonia fija e internet', '2026-02-13 18:10:31', '2026-02-13 18:10:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id_ubicacion` int(10) UNSIGNED NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`id_ubicacion`, `codigo_postal`, `ciudad`, `provincia`, `numero`, `created_at`, `updated_at`) VALUES
(1, '28001', 'Madrid', 'Madrid', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(2, '28002', 'Madrid', 'Madrid', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(3, '28003', 'Madrid', 'Madrid', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(4, '28004', 'Madrid', 'Madrid', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(5, '28005', 'Madrid', 'Madrid', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(6, '28006', 'Madrid', 'Madrid', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(7, '28007', 'Madrid', 'Madrid', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(8, '28008', 'Madrid', 'Madrid', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(9, '28009', 'Madrid', 'Madrid', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(10, '28010', 'Madrid', 'Madrid', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(11, '08001', 'Barcelona', 'Barcelona', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(12, '08002', 'Barcelona', 'Barcelona', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31'),
(13, '08003', 'Barcelona', 'Barcelona', NULL, '2026-02-13 18:10:31', '2026-02-13 18:10:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol` enum('admin','usuario') DEFAULT 'usuario',
  `preferencias` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `fecha_registro`, `rol`, `preferencias`) VALUES
(1, 'jose', 'jpb0028@alu.medac.es', '$2y$12$1hWmc1y0RZ1QUyWe2KZpBerqnj8ZONH/.uU5bNwWY5FBABOSwh4i6', '2026-04-07 15:44:17', 'usuario', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `comparaciones`
--
ALTER TABLE `comparaciones`
  ADD PRIMARY KEY (`id_comparacion`),
  ADD KEY `idx_usuario` (`id_usuario`),
  ADD KEY `idx_ubicacion` (`id_ubicacion`),
  ADD KEY `idx_tipo_servicio` (`id_tipo_servicio`),
  ADD KEY `idx_fecha` (`fecha`),
  ADD KEY `idx_usuario_fecha` (`id_usuario`,`fecha`);

--
-- Indices de la tabla `comparacion_tarifas`
--
ALTER TABLE `comparacion_tarifas`
  ADD PRIMARY KEY (`id_comparacion_tarifa`),
  ADD UNIQUE KEY `unique_comparacion_tarifa` (`id_comparacion`,`id_tarifa`),
  ADD KEY `idx_comparacion` (`id_comparacion`),
  ADD KEY `idx_tarifa` (`id_tarifa`);

--
-- Indices de la tabla `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD PRIMARY KEY (`id_disponibilidad`),
  ADD UNIQUE KEY `unique_tarifa_ubicacion` (`id_tarifa`,`id_ubicacion`),
  ADD KEY `idx_tarifa` (`id_tarifa`),
  ADD KEY `idx_ubicacion` (`id_ubicacion`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `idx_nombre` (`nombre`),
  ADD KEY `idx_tipo_proveedor` (`tipo_proveedor`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `idx_tipo_servicio` (`id_tipo_servicio`),
  ADD KEY `idx_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tarifas`
--
ALTER TABLE `tarifas`
  ADD PRIMARY KEY (`id_tarifa`),
  ADD KEY `idx_servicio` (`id_servicio`),
  ADD KEY `idx_precio` (`precio`),
  ADD KEY `idx_fecha_actualizacion` (`fecha_actualizacion`),
  ADD KEY `idx_servicio_precio` (`id_servicio`,`precio`);

--
-- Indices de la tabla `tipos_servicios`
--
ALTER TABLE `tipos_servicios`
  ADD PRIMARY KEY (`id_tipo_servicio`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `idx_nombre` (`nombre`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id_ubicacion`),
  ADD UNIQUE KEY `unique_ubicacion` (`codigo_postal`,`ciudad`,`provincia`,`numero`),
  ADD KEY `idx_codigo_postal` (`codigo_postal`),
  ADD KEY `idx_ciudad` (`ciudad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuarios_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comparaciones`
--
ALTER TABLE `comparaciones`
  MODIFY `id_comparacion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `comparacion_tarifas`
--
ALTER TABLE `comparacion_tarifas`
  MODIFY `id_comparacion_tarifa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `disponibilidad`
--
ALTER TABLE `disponibilidad`
  MODIFY `id_disponibilidad` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tarifas`
--
ALTER TABLE `tarifas`
  MODIFY `id_tarifa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tipos_servicios`
--
ALTER TABLE `tipos_servicios`
  MODIFY `id_tipo_servicio` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id_ubicacion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comparaciones`
--
ALTER TABLE `comparaciones`
  ADD CONSTRAINT `comparaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `comparaciones_ibfk_2` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicaciones` (`id_ubicacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `comparaciones_ibfk_3` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `tipos_servicios` (`id_tipo_servicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comparacion_tarifas`
--
ALTER TABLE `comparacion_tarifas`
  ADD CONSTRAINT `comparacion_tarifas_ibfk_1` FOREIGN KEY (`id_comparacion`) REFERENCES `comparaciones` (`id_comparacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `comparacion_tarifas_ibfk_2` FOREIGN KEY (`id_tarifa`) REFERENCES `tarifas` (`id_tarifa`) ON DELETE CASCADE;

--
-- Filtros para la tabla `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD CONSTRAINT `disponibilidad_ibfk_1` FOREIGN KEY (`id_tarifa`) REFERENCES `tarifas` (`id_tarifa`) ON DELETE CASCADE,
  ADD CONSTRAINT `disponibilidad_ibfk_2` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicaciones` (`id_ubicacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `tipos_servicios` (`id_tipo_servicio`) ON DELETE CASCADE,
  ADD CONSTRAINT `servicios_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tarifas`
--
ALTER TABLE `tarifas`
  ADD CONSTRAINT `tarifas_ibfk_1` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
