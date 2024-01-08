-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-09-2023 a las 18:10:21
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dta_hoteles`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion_caja`
--

CREATE TABLE `accion_caja` (
  `id` int(11) NOT NULL,
  `pk_accion` varchar(99) NOT NULL,
  `tipo_accion` varchar(45) NOT NULL,
  `caja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `idalmacen` int(11) NOT NULL,
  `nombre_almacen` varchar(50) NOT NULL,
  `ubicacion_almacen` varchar(100) NOT NULL,
  `descripcion_almacen` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`idalmacen`, `nombre_almacen`, `ubicacion_almacen`, `descripcion_almacen`, `estado`) VALUES
(1, 'Almacen Principal', 'Peru', 'Principal', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleta`
--

CREATE TABLE `boleta` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `token` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `serie` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `estado_fila` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id_caja` int(11) NOT NULL,
  `nombre_caja` varchar(50) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id_caja`, `nombre_caja`, `ubicacion`, `descripcion`, `estado`) VALUES
(1, 'Recepcion Principal', 'Peru', 'Principal', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_habitacion`
--

CREATE TABLE `categoria_habitacion` (
  `id_categoria_habitacion` int(11) NOT NULL,
  `nombre_categoria_habitacion` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_producto`
--

CREATE TABLE `categoria_producto` (
  `idcategoria` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` tinyint(3) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_servicio`
--

CREATE TABLE `categoria_servicio` (
  `idcategoria` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobante_hash`
--

CREATE TABLE `comprobante_hash` (
  `pkComprobante` bigint(50) NOT NULL,
  `aceptada` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `hash` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `hash_qr` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `respuesta_sunat` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `fecha_cierre` date NOT NULL,
  `nombre_negocio` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `ruc` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `razon_social` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `serie_boleta` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `serie_factura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `estado_fila` int(11) DEFAULT 1,
  `correoElectronico` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `ruta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `token` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `id_detraccion` int(11) DEFAULT NULL,
  `estadia_dias_horas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `fecha_cierre`, `nombre_negocio`, `ruc`, `direccion`, `telefono`, `razon_social`, `serie_boleta`, `serie_factura`, `estado_fila`, `correoElectronico`, `ruta`, `token`, `id_detraccion`, `estadia_dias_horas`) VALUES
(1, '2023-02-01', 'Ti Cambiar', 'Ti Cambiar', 'Ti Cambiar', 'Ti Cambiar', 'Ti Cambiar', 'Ti Cambiar', 'Ti Cambiar', 1, 'Ti Cambiar', 'Ti Cambiar', 'Ti Cambiar', 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumos`
--

CREATE TABLE `consumos` (
  `idconsumo` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `tipo_comprobante` int(11) NOT NULL,
  `reservaid` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  `total_impuestos` float NOT NULL,
  `total_consumo` decimal(8,2) NOT NULL,
  `consumo_estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corte`
--

CREATE TABLE `corte` (
  `id` int(11) NOT NULL,
  `fecha_cierre` date NOT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime DEFAULT NULL,
  `monto_inicial` float NOT NULL,
  `estado_fila` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_consumo`
--

CREATE TABLE `detalle_consumo` (
  `id_detalle_consumo` int(11) NOT NULL,
  `consumoid` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `reservaid` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(8,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `descripcionConsumoDesechado` text NOT NULL,
  `cantidadConsumoDesechado` int(11) NOT NULL,
  `cantidadActual` int(11) NOT NULL,
  `diasAdicional` int(11) NOT NULL,
  `horasAdicional` int(11) NOT NULL,
  `minutosAdicional` int(11) NOT NULL,
  `tipoServicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_movimiento_almacen`
--

CREATE TABLE `detalle_movimiento_almacen` (
  `iddetalle_movimiento` int(11) NOT NULL,
  `movimientoid` int(11) NOT NULL,
  `almacenid` int(11) NOT NULL,
  `productoid` int(11) NOT NULL,
  `cantidad_retirada` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id_detalle_venta` int(11) NOT NULL,
  `ventaid` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(8,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `token` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `serie` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `estado_fila` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `idhabitacion` int(11) NOT NULL,
  `nombre_habitacion` varchar(100) NOT NULL,
  `categoriahabitacionid` int(11) NOT NULL,
  `estado_habitacion` varchar(50) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `idpiso` int(11) NOT NULL DEFAULT 1,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medio_pago`
--

CREATE TABLE `medio_pago` (
  `idmediopago` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medio_pago`
--

INSERT INTO `medio_pago` (`idmediopago`, `nombre`, `estado`) VALUES
(1, 'Efectivo', 1),
(2, 'Visa', 1),
(3, 'Mastercard', 1),
(4, 'Transferencia', 1),
(5, 'Yape', 1),
(6, 'Plin', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `idmodulo` bigint(20) NOT NULL,
  `titulo` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `estado`) VALUES
(1, 'Dashboard', 'Dashboard', 1),
(2, 'Ventas', 'Ventas', 1),
(3, 'Reservas', 'Reservas', 1),
(4, 'Caja', 'Caja', 1),
(5, 'Movimiento de caja', 'Movimientos', 1),
(6, 'Almacenes', 'Almacenes', 1),
(7, 'Productos', 'Productos', 1),
(8, 'Servicios', 'Servicios', 1),
(9, 'Kardex', 'Kardex', 1),
(10, 'Boletas', 'Boletas', 1),
(11, 'Facturas', 'Facturas', 1),
(12, 'Habitaciones', 'Habitaciones', 1),
(13, 'Configuracion', 'Configuracion', 1),
(14, 'Reportes', 'Reportes', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `id_moneda` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `simbolo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`id_moneda`, `descripcion`, `simbolo`) VALUES
(1, 'SOLES', 'PEN'),
(2, 'DOLARES', 'USD'),
(3, 'EUROS', 'EUR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_almacenes`
--

CREATE TABLE `movimiento_almacenes` (
  `idmovimiento_almacen` int(11) NOT NULL,
  `tipo_movimiento` int(11) NOT NULL,
  `almacenid` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `datecreated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movimiento_almacenes`
--

INSERT INTO `movimiento_almacenes` (`idmovimiento_almacen`, `tipo_movimiento`, `almacenid`, `descripcion`, `datecreated_at`, `estado`) VALUES
(1, 3, 1, 'Salidas', '2023-01-14 11:44:39', 1),
(2, 1, 1, 'Ingreso', '2023-01-14 11:48:23', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_caja`
--

CREATE TABLE `movimiento_caja` (
  `id_movimientocaja` int(11) NOT NULL,
  `monedaid` int(11) NOT NULL,
  `tipomovimientocaja_id` int(11) NOT NULL,
  `cajaid` int(11) NOT NULL,
  `turnoid` int(11) NOT NULL,
  `mediopagoid` int(11) NOT NULL,
  `usuarioid` int(11) NOT NULL,
  `monto` decimal(8,2) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_hora` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_producto`
--

CREATE TABLE `movimiento_producto` (
  `idmovimiento_producto` int(11) NOT NULL,
  `productoid` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tipo_movimiento` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `almacenid` int(11) NOT NULL,
  `movimientoid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `origen_reservacion`
--

CREATE TABLE `origen_reservacion` (
  `idorigen_reservacion` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `origen_reservacion`
--

INSERT INTO `origen_reservacion` (`idorigen_reservacion`, `nombre`, `created_at`) VALUES
(1, 'Directa', '2022-05-11 15:11:29'),
(2, 'Telefonica', '2022-05-11 15:11:29'),
(3, 'Correo electronico', '2022-05-11 15:11:44'),
(4, 'Redes sociales', '2022-05-11 15:11:44'),
(5, 'Trivago', '2022-05-11 15:11:54'),
(6, 'Otro', '2022-05-11 15:11:54'),
(7, 'Booking', '2022-09-21 08:57:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `idpermiso` bigint(20) NOT NULL,
  `rolid` int(11) NOT NULL,
  `moduloid` bigint(20) NOT NULL,
  `r` int(11) NOT NULL DEFAULT 0,
  `w` int(11) NOT NULL DEFAULT 0,
  `u` int(11) NOT NULL DEFAULT 0,
  `d` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idpermiso`, `rolid`, `moduloid`, `r`, `w`, `u`, `d`) VALUES
(1, 1, 1, 1, 0, 0, 0),
(2, 1, 2, 1, 0, 0, 0),
(3, 1, 3, 1, 0, 0, 0),
(4, 1, 4, 1, 0, 0, 0),
(5, 1, 5, 1, 0, 0, 0),
(6, 1, 6, 1, 0, 0, 0),
(7, 1, 7, 1, 0, 0, 0),
(8, 1, 8, 1, 0, 0, 0),
(9, 1, 9, 1, 0, 0, 0),
(10, 1, 10, 1, 0, 0, 0),
(11, 1, 11, 1, 0, 0, 0),
(12, 1, 12, 1, 0, 0, 0),
(13, 1, 13, 1, 0, 0, 0),
(14, 1, 14, 1, 0, 0, 0),
(267, 5, 1, 1, 0, 0, 0),
(268, 5, 2, 1, 0, 0, 0),
(269, 5, 3, 1, 0, 0, 0),
(270, 5, 4, 1, 0, 0, 0),
(271, 5, 5, 1, 0, 0, 0),
(272, 5, 6, 1, 0, 0, 0),
(273, 5, 7, 1, 0, 0, 0),
(274, 5, 8, 1, 0, 0, 0),
(275, 5, 9, 1, 0, 0, 0),
(276, 5, 10, 1, 0, 0, 0),
(277, 5, 11, 1, 0, 0, 0),
(278, 5, 12, 1, 0, 0, 0),
(279, 5, 13, 0, 0, 0, 0),
(280, 5, 14, 1, 0, 0, 0),
(351, 2, 1, 0, 0, 0, 0),
(352, 2, 2, 1, 0, 0, 0),
(353, 2, 3, 1, 0, 0, 0),
(354, 2, 4, 1, 0, 0, 0),
(355, 2, 5, 1, 0, 0, 0),
(356, 2, 6, 0, 0, 0, 0),
(357, 2, 7, 0, 0, 0, 0),
(358, 2, 8, 0, 0, 0, 0),
(359, 2, 9, 0, 0, 0, 0),
(360, 2, 10, 1, 0, 0, 0),
(361, 2, 11, 1, 0, 0, 0),
(362, 2, 12, 0, 0, 0, 0),
(363, 2, 13, 0, 0, 0, 0),
(364, 2, 14, 1, 1, 1, 0),
(407, 11, 1, 1, 1, 1, 1),
(408, 11, 2, 1, 1, 1, 1),
(409, 11, 3, 1, 1, 1, 1),
(410, 11, 4, 1, 1, 1, 1),
(411, 11, 5, 1, 1, 1, 1),
(412, 11, 6, 1, 1, 1, 1),
(413, 11, 7, 1, 1, 1, 1),
(414, 11, 8, 1, 1, 1, 1),
(415, 11, 9, 1, 1, 1, 1),
(416, 11, 10, 1, 1, 1, 1),
(417, 11, 11, 1, 1, 1, 1),
(418, 11, 12, 1, 1, 1, 1),
(419, 11, 13, 1, 1, 1, 1),
(420, 11, 14, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piso_habitacion`
--

CREATE TABLE `piso_habitacion` (
  `idpiso` int(11) NOT NULL,
  `nombrepiso` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `porcentaje_detraccion`
--

CREATE TABLE `porcentaje_detraccion` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(4) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `porcentaje` decimal(6,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `porcentaje_detraccion`
--

INSERT INTO `porcentaje_detraccion` (`id`, `codigo`, `nombre`, `descripcion`, `porcentaje`, `created_at`, `updated_at`, `deleted_at`) VALUES
(0, '0', 'NO DETRACCION', NULL, '0.00', NULL, NULL, NULL),
(1, '001', 'Azucar y melaza de cana', 'Bienes comprendidos en las subpartidas nacionales 1701.13.00.00, 1701.14.00.00, 1701.91.00.00, 1701.99.90.00 y 1703.10.00.00.', '10.00', NULL, NULL, NULL),
(2, '002', 'Arroz', NULL, NULL, NULL, NULL, NULL),
(3, '003', 'Alcohol etilico', 'Bienes comprendidos en las subpartidas nacionales 2207.10.00.00, 2207.20.00.10, 2207.20.00.90 y 2208.90.10.00.', '10.00', NULL, NULL, NULL),
(4, '004', 'Recursos Hidrobiologicos', 'Pescados  destinados al procesamiento de harina y aceite de pescado comprendidos en las subpartidas nacionales 0302.11.00.00/0305.69.00.00 y huevas, lechas y   desperdicios de pescado y demás contemplados en las subpartidas nacionales   0511.91.10.00/0511.91.90.00.\\r\\n\\r\\nSe   incluyen en esta definición los peces vivos, pescados no destinados al   procesamiento de harina y aceite de pescado, crustáceos, moluscos y demás   invertebrados acuáticos comprendidos en las subpartidas nacionales   0301.10.00.00/0307.99.90.90,cuando el proveedor hubiera renunciado a la   exoneración contenida en el inciso A) del Apéndice I de la Ley del IGV.', '4.00', NULL, NULL, NULL),
(5, '005', 'Maiz amarillo duro', 'La   presente definición incluye lo siguiente:\\r\\n\\r\\na) Bienes   comprendidos en la subpartida nacional 1005.90.11.00.\\r\\n\\r\\nb) Sólo la   harina de maíz amarillo duro comprendida en la subpartida nacional   1102.20.00.00.\\r\\n\\r\\nc) Sólo los grañones y sémola de maíz amarillo duro comprendidos en la subpartida   nacional 1103.13.00.00.\\r\\n\\r\\nd) Sólo \\\"pellets\\\" de maíz amarillo duro comprendidos en la subpartida   nacional 1103.20.00.00.\\r\\n\\r\\ne) Sólo los granos aplastados de maíz amarillo duro comprendidos en la subpartida   nacional 1104.19.00.00.\\r\\n\\r\\nf) Sólo  los demás granos trabajados de maíz amarillo duro comprendidos en la   subpartida nacional 1104.23.00.00.\\r\\n\\r\\ng) Sólo el germen de maíz amarillo duro entero, aplastado o molido comprendido en la   subpartida nacional 1104.30.00.00.\\r\\n\\r\\nh) Sólo los salvados, moyuelos y demás residuos del cernido, de la molienda o de   otros tratamientos del maíz amarillo duro, incluso en \\\"pellets\\\",   comprendidos en la subpartida nacional 2302.10.00.00.', '4.00', NULL, NULL, NULL),
(7, '007', 'Cana de azucar', 'Bienes comprendidos en la subpartida nacional 1212.93.00.00.', '10.00', NULL, NULL, NULL),
(8, '008', ' Madera', 'Bienes   comprendidos en las subpartidas nacionales 4403.10.00.00/4404.20.00.00,   4407.10.10.00/4409.20.90.00 y 4412.13.00.00/4413.00.00.00.', '4.00', NULL, NULL, NULL),
(9, '009', 'Arena y piedra', 'Bienes   comprendidos en las subpartidas nacionales 2505.10.00.00, 2505.90.00.00,   2515.11.00.00/2517.49.00.00 y 2521.00.00.00.\\r\\n\\r\\nBienes   comprendidos en las subpartidas nacionales 2505.10.00.00, 2505.90.00.00,   2515.11.00.00/2517.49.00.00 y 2521.00.00.00.', '10.00', NULL, NULL, NULL),
(10, '010', 'Residuos, subproductos, desechos, recortes y desperdicios', 'Solo los   residuos, subproductos, desechos, recortes y desperdicios comprendidos en las   subpartidas nacionales 2303.10.00.00/2303.30.00.00, 2305.00.00.00/2308.00.90.00,   2401.30.00.00, 3915.10.00.00/3915.90.00.00, 4004.00.00.00,4017.00.00.00,   4115.20.00.00, 4706.10.00.00/4707.90.00.00, 5202.10.00.00/5202.99.00.00,   5301.30.00.00, 5505.10.00.00, 5505.20.00.00, 6310.10.00.00, 6310.90.00.00,   6808.00.00.00, 7001.00.10.00, 7112.30.00.00/7112.99.00.00,   7204.10.00.00/7204.50.00.00, 7404.00.00.00, 7503.00.00.00, 7602.00.00.00,   7802.00.00.00, 7902.00.00.00, 8002.00.00.00, 8101.97.00.00, 8102.97.00.00,   8103.30.00.00, 8104.20.00.00, 8105.30.00.00, 8106.00.12.00, 8107.30.00.00,   8108.30.00.00, 8109.30.00.00, 8110.20.00.00, 8111.00.12.00, 8112.13.00.00,   8112.22.00.00, 8112.30.20.00, 8112.40.20.00, 8112.52.00.00, 8112.92.20.00,   8113.00.00.00, 8548.10.00.00 y 8548.90.00.00.\\r\\n  Se incluye en esta definición lo siguiente:\\r\\n\\r\\na) Sólo   los desperdicios comprendidos en las subpartidas nacionales 5302.90.00.00,   5303.90.30.00, 5303.90.90.00, 5304.90.00.00 y 5305.11.00.00/5305.90.00.00,   cuando el proveedor hubiera renunciado a la exoneración contenida en el   inciso A) del Apéndice I de la Ley del IGV.\\r\\n\\r\\nb) Los   residuos, subproductos, desechos, recortes y desperdicios de aleaciones de   hierro, acero, cobre, níquel, aluminio, plomo, cinc, estaño y/o demás metales   comunes a los que se refiere la Sección XV del Arancel de Aduanas, aprobado   por el Decreto Supremo N° 239-2001-EF y norma modificatoria.\\r\\n\\r\\nAdemás, se   incluye a las formas primarias comprendidas en las subpartidas nacionales   3907.60.10.00 y 3907.60.90.00', '15.00', NULL, NULL, NULL),
(11, '011', ' Bienes gravados con el IGV, o renuncia a la exoneracion', 'Bienes comprendidos en las subpartidas nacionales del inciso A) del Apéndice I de la Ley del IGV, siempre que el proveedor hubiera renunciado a la exoneración del IGV. Se excluye de esta definición a los bienes comprendidos en las subpartidas nacionales incluidas expresamente en otras definiciones del presente anexo', '10.00', NULL, NULL, NULL),
(12, '012', 'Intermediacion laboral y tercerizacion', 'A lo siguiente, independientemente del nombre que le   asignen las partes:\r\n\r\na) Los servicios temporales, complementarios o de alta   especialización prestados de acuerdo a lo dispuesto en la Ley N° 27626 y su   reglamento, aprobado por el Decreto Supremo N° 003-2002-TR, aun cuando el   sujeto que presta el servicio:\r\n\r\na.1) Sea distinto a los señalados   en los artículos 11° y 12° de la citada ley;   a.2) No hubiera cumplido con los requisitos exigidos por ésta para   realizar actividades de intermediación laboral; o,\r\n\r\na.3) Destaque al usuario   trabajadores que a su vez le hayan sido destacados.\r\n\r\nb) Los contratos de gerencia, conforme al artículo   193° de la Ley General de Sociedades.\r\n\r\nc) Los contratos en los cuales el prestador del   servicio dota de trabajadores al usuario del mismo, sin embargo éstos no   realizan labores en el centro de trabajo o de operaciones de este último sino   en el de un tercero.', '10.00', NULL, NULL, NULL),
(13, '014', 'Carnes y despojos comestibles', '\r\nSólo los bienes comprendidos en las   subpartidas nacionales 0201.10.00.00/0206.90.00.00.', '4.00', NULL, NULL, NULL),
(14, '016', 'Aceite de pescado', 'Bienes comprendidos en las subpartidas nacionales 1504.10.21.00/1504.20.90.00', '10.00', NULL, NULL, NULL),
(15, '017', ' Harina, polvo y pellets de pescado, crustaceos, moluscos y demas invertebrados acuaticos', 'Bienes   comprendidos en las subpartidas nacionales 2301.20.10.10/2301.20.90.00.', '4.00', NULL, NULL, NULL),
(17, '019', 'Arrendamiento de bienes muebles', 'Al arrendamiento, subarrendamiento o cesión en uso de   bienes muebles e inmuebles. Para tal efecto se consideran bienes muebles a   los definidos en el inciso b) del artículo 3° de la Ley del IGV. Se incluye   en la presente definición al arrendamiento, subarrendamiento o cesión en uso   de bienes muebles dotado de operario en tanto que no califique como contrato   de construcción de acuerdo a la definición contenida en el numeral 9 del   presente anexo. No se incluyen en esta   definición los contratos de arrendamiento financiero.', '10.00', NULL, NULL, NULL),
(18, '020', ' Mantenimiento y reparacion de bienes muebles', 'Al mantenimiento o reparación de bienes muebles   corporales y de las naves y aeronaves comprendidos en la definición prevista   en el inciso b) del   artículo 3° de la Ley del IGV.', '10.00', NULL, NULL, NULL),
(19, '021', 'Movimiento de carga', 'A la estiba o carga, desestiba o descarga, movilización y/o tarja de bienes. Para tal efecto se entenderá por:   \r\n\r\na)Estiba o carga: A la colocación conveniente y en forma ordenada de los bienes a bordo de cualquier medio de transporte, según las instrucciones del usuario del servicio.\r\n\r\nb)Desestiba o descarga: Al retiro conveniente y en forma ordenada de los bienes que se encuentran a bordo de cualquier medio de transporte, según las instrucciones del usuario del servicio.\r\n\r\nc) Movilización: A cualquier movimiento de los bienes, realizada dentro del centro de producción.\r\n\r\nd) Tarja: Al conteo y registro de los bienes que se cargan o descargan, o que se encuentren dentro del centro de producción, comprendiendo la anotación de la información que en cada caso se requiera, tal como el tipo de mercancía, cantidad, marcas, estado y condición exterior del embalaje y si se separó para inventario. No se incluye en esta definición el servicio de transporte de bienes, ni los servicios a los que se refiere el numeral 3 del Apéndice II de la Ley del IGV.\r\n\r\nNo están incluidos los servicios prestados por operadores de comercio exterior a los sujetos que soliciten cualquiera de los regímenes o destinos aduaneros especiales o de excepción, siempre que tales servicios estén vinculados a operaciones de comercio exterior (*).\r\n\r\nSe considera operadores de comercio exterior:\r\n\r\n1. Agentes marítimos\r\n\r\n2. Compañías aéreas\r\n\r\n3. Agentes de carga internacional\r\n\r\n4. Almacenes aduaneros\r\n\r\n5. Empresas de Servicio de Entrega Rápida\r\n\r\n6. Agentes de aduana.\r\n\r\n(*)Exclusión aplicable a las operaciones cuyo nacimiento de la obligación tributaria se produzca a partir del 14.07.2012, según Tercera Disposición Complementaria Final de la R.S. Nº 158-2012/SUNAT publicada el 13.07.2012.', '10.00', NULL, NULL, NULL),
(20, '022', 'Otros servicios empresariales', 'A cualquiera de las siguientes actividades comprendidas en la Clasificación Industrial Internacional Uniforme (CIIU) de las Naciones Unidas - Tercera revisión, siempre que no estén comprendidas en la definición de intermediación laboral y tercerización contenida en el presente anexo:\r\n\r\na) Actividades jurídicas (7411).\r\n\r\nb).Actividades de contabilidad, tejeduría de libros y auditoria; asesoramiento en materia de impuestos (7412).\r\n\r\nc).Investigaciones de mercados y realización de encuestas de opinión pública (7413).\r\n\r\nd).Actividades de asesoramiento empresarial y en materia de gestión (7414).\r\n\r\ne).Actividades de arquitectura e ingeniería y actividades conexas de asesoramiento técnico (7421).\r\n\r\nf).Publicidad (7430).\r\n\r\ng).Actividades de investigación y seguridad (7492).\r\n\r\nh).Actividades de limpieza de edificios (7493).\r\n\r\ni) Actividades de envase y empaque (7495).', '10.00', NULL, NULL, NULL),
(21, '023', 'Leche', 'Sólo la leche cruda entera comprendida en la subpartida nacional 0401.20.00.00, siempre que el proveedor hubiera renunciado a la exoneración del IGV.', '4.00', NULL, NULL, NULL),
(22, '024', 'Comision mercantil', 'Al Mandato que tiene por objeto un acto u operación de   comercio en la que el comitente o el comisionista son comerciantes o agentes   mediadores de comercio, de conformidad con el artículo 237° del Código de   Comercio.\r\n\r\nSe excluye de la presente definición al mandato en el que el   comisionista es:\r\n\r\na.Un   corredor o agente de intermediación de operaciones en la Bolsa de Productos o   Bolsa de Valores.\r\n\r\nb.Una empresa del Sistema Financiero y del Sistema de   Seguros.\r\n\r\nc.Un Agente de Aduana y el comitente aquel que   solicite cualquiera de los regímenes, operaciones o destinos aduaneros   especiales o de excepción.', '10.00', NULL, NULL, NULL),
(23, '025', 'Fabricacion de bienes por encargo', 'A aquel servicio mediante el cual el prestador del   mismo se hace cargo de todo o una parte del proceso de elaboración,   producción, fabricación o transformación de un bien. Para tal efecto, el   usuario del servicio entregará todo o parte de las materias primas, insumos,   bienes intermedios o cualquier otro bien necesario para la obtención de   aquéllos que se hubieran encargado elaborar, producir, fabricar o   transformar.\r\n\r\nSe incluye en la presente definición a la venta de bienes,   cuando las materias primas, insumos, bienes intermedios o cualquier otro bien   con los que el vendedor ha elaborado, producido, fabricado o transformado los   bienes vendidos, han sido transferidos bajo cualquier título por el comprador   de los mismos.\r\n\r\nNo se incluye en esta definición:\r\n\r\na. Las operaciones por las cuales el usuario   entrega únicamente avíos textiles, en tanto el prestador se hace cargo de   todo el proceso de fabricación de prendas textiles. Para efecto de la   presente disposición, son avíos textiles, los siguientes bienes: etiquetas, hangtags, stickers, entretelas, elásticos, aplicaciones, botones, broches,   ojalillos, hebillas, cierres, clips, colgadores, cordones, cintas twill,   sujetadores, alfileres, almas, bolsas, plataformas y cajas de embalaje.\r\n\r\nb. Las operaciones por las cuales el usuario entrega únicamente diseños, planos o cualquier bien intangible, mientras que el   prestador se hace cargo de todo el proceso de elaboración, producción,   fabricación, o transformación de un bien.', '10.00', NULL, NULL, NULL),
(24, '026', 'Servicio de transporte de personas', 'A aquel servicio prestado por vía terrestre, por el   cual se emita comprobante de pago que permita ejercer el derecho al crédito fiscal del IGV, de conformidad con el Reglamento de Comprobantes de Pago.', '10.00', NULL, NULL, NULL),
(25, '027', 'Servicio de transporte de carga', 'A aquel servicio prestado por vía terrestre, por el   cual se emita comprobante de pago que permita ejercer el derecho al crédito fiscal del IGV, de conformidad con el Reglamento de Comprobantes de Pago.', '10.00', NULL, NULL, NULL),
(26, '028', 'Transporte de pasajeros', NULL, NULL, NULL, NULL, NULL),
(28, '030', 'Contratos de construccion', 'A los que se celebren respecto de las actividades   comprendidas en el inciso d) del artículo 3° de la Ley del IGV, con excepción   de aquellos que consistan exclusivamente en el arrendamiento,   subarrendamiento o cesión en uso de equipo de construcción dotado de operario', '4.00', NULL, NULL, NULL),
(29, '031', 'Oro gravado con el IGV', 'a) Bienes   comprendidos en las subpartidas nacionales 2616.90.10.00, 7108.13.00.00 y   7108.20.00.00.\r\n\r\nb) Sólo la   amalgama de oro comprendida en la subpartida nacional 2843.90.00.00.\r\n\r\nc) Sólo   los desperdicios y desechos de oro, comprendidos en la subpartida nacional   7112.91.00.00.\r\n\r\nd) Bienes   comprendidos en las subpartidas nacionales 7108.11.00.00 y 7108.12.00.00   cuando el proveedor hubiera renunciado a la exoneración contenida en el inciso   A) del Apéndice I de la Ley del IGV.', '10.00', NULL, NULL, NULL),
(30, '032', 'Paprika y otros frutos de los generos capsicum o pimienta', 'Bienes comprendidos en las subpartidas nacionales 0904.21.10.10, 0904.21.10.90, 0904.21.90.00, 0904.22.10.00, 0904.22.90.00', '10.00', NULL, NULL, NULL),
(32, '034', 'Minerales metalicos no auriferos', 'Esta   definición incluye:\\r\\n\\r\\na) Los bienes comprendidos en las   subpartidas nacionales 2504.10.00.00, 2504.90.00.00,   2506.10.00.00/2509.00.00.00, 2511.10.00.00, 2512.00.00.00,   2513.10.00.10/2514.00.00.00, 2518.10.00.00/25.18.30.00.00, 2520.10.00.00,   2520.20.00.00, 2522.10.00.00/2522.30.00.00, 2526.10.00.00/2528.00.90.00,   2701.11.00.00/ 2704.00.30.00 y 2706.00.00.00.\\r\\n\\r\\nb) Sólo la puzolana comprendida en la   subpartida nacional 2530.90.00.90.', '10.00', NULL, NULL, NULL),
(33, '035', 'Bienes exonerados del IGV', 'Bienes   comprendidos en las subpartidas nacionales del inciso A) del Apéndice I de la   Ley del IGV. Se excluye de esta definición a los bienes comprendidos en las   subpartidas nacionales incluidas expresamente en otras definiciones del   presente anexo.', '1.50', NULL, NULL, NULL),
(34, '036', 'Oro y demas minerales metalicos exonerados del IGV', 'En esta   definición se incluye lo siguiente:\\r\\n\\r\\na) Bienes   comprendidos en las subpartidas nacionales 7108.11.00.00 y 7108.12.00.00.\\r\\n\\r\\nb)La venta   de bienes prevista en el inciso a) del numeral 13.1 del artículo 13° de la   Ley N.° 27037 - Ley de Promoción de la Inversión en la Amazonia, y sus normas   modificatorias y complementarias, respecto de:\\r\\n\\r\\nb.1)   Bienes comprendidos en las subpartidas nacionales 7108.13.00.00/   7108.20.00.00.\\r\\n\\r\\nb.2) Sólo   la amalgama de oro comprendida en la subpartida nacional 2843.90.00.00.\\r\\n\\r\\nb.3) Sólo   los desperdicios y desechos de oro, comprendidos en la subpartida nacional   7112.91.00.00.\\r\\n\\r\\nb.4) Sólo   el mineral metalífero y sus concentrados, escorias y cenizas comprendidos en   las subpartidas nacionales del Capítulo 26 de la Sección V del Arancel de   Aduanas aprobado por el Decreto Supremo N.° 238-2011-EF, incluso cuando se   presenten en conjunto con otros minerales o cuando hayan sido objeto de un   proceso de chancado y/o molienda.', '1.50', NULL, NULL, NULL),
(35, '037', 'Demas servicios gravados con el IGV', 'A toda prestación de servicios en el país comprendida en el numeral 1) del inciso c) del artículo 3º de la Ley del IGV que no se encuentre incluida en algún otro numeral del presente Anexo.\r\n\r\nSe excluye de esta definición:\r\n\r\na).Los servicios prestados por las empresas a que se refiere el artículo 16 de la Ley Nº 26702 – Ley General del Sistema Financiero y del Sistema de Seguros y Orgánica de la Superintendencia de Banca y Seguros, y normas modificatorias.\r\n\r\nb). Los servicios prestados por el Seguro Social de Salud - ESSALUD.\r\n\r\nc).Los servicios prestados por la Oficina de Normalización Previsional - ONP.\r\n\r\nd).El servicio de expendio de comidas y bebidas en establecimientos abiertos al público tales como restaurantes y bares.\r\n\r\ne).El servicio de alojamiento no permanente, incluidos los servicios complementarios a éste, prestado al huésped por los establecimientos de hospedaje a que se refiere el Reglamento de Establecimientos de Hospedaje, aprobado por Decreto Supremo Nº 029-2004-MINCETUR.\r\n\r\nf).El servicio postal y el servicio de entrega rápida.\r\n\r\ng).El servicio de transporte de bienes realizado por vía terrestre a que se refiere la Resolución de Superintendencia Nº 073-2006-SUNAT y normas modificatorias.\r\n\r\nh).El servicio de transporte público de pasajeros realizado por vía terrestre a que alude la Resolución de Superintendencia Nº 057-2007-SUNAT y normas modificatorias.\r\n\r\ni).Servicios comprendidos en las Exclusiones previstas en el literal a) del numeral 6 y en los literales a) y b) del numeral 7 del presente Anexo.\r\n\r\nj).Actividades de generación, transmisión y distribución de la energía eléctrica reguladas en la Ley de Concesiones Eléctricas aprobada por el Decreto Ley N.° 25844.\r\n\r\nk).Los servicios de exploración y/o explotación de hidrocarburos prestados a favor de PERUPETRO S.A. en virtud de contratos celebrados al amparo de los Decretos Leyes N.os 22774 y 22775 y normas modificatorias(*).\r\n\r\nl).Los servicios prestados por las instituciones de compensación y liquidación de valores a las que se refiere el Capítulo III del Título VIII del Texto Único Ordenado de la Ley del Mercado de Valores, aprobado por el Decreto Supremo N.° 093-2002-EF y normas modificatorias.\r\n\r\nll).Los servicios prestados por los administradores portuarios y aeroportuarios.”\r\n\r\nm).El servicio de espectáculo público y otras realizadas por el promotor. (9) (14)', '10.00', NULL, NULL, NULL),
(37, '039', 'Minerales no metalicos', 'Esta   definición incluye:\r\n\r\na) Los bienes comprendidos en las   subpartidas nacionales 2504.10.00.00, 2504.90.00.00,   2506.10.00.00/2509.00.00.00, 2511.10.00.00, 2512.00.00.00,   2513.10.00.10/2514.00.00.00, 2518.10.00.00/25.18.30.00.00, 2520.10.00.00,   2520.20.00.00, 2522.10.00.00/2522.30.00.00, 2526.10.00.00/2528.00.90.00,   2701.11.00.00/ 2704.00.30.00 y 2706.00.00.00.\r\n\r\nb) Sólo la puzolana comprendida en la   subpartida nacional 2530.90.00.90.', '10.00', NULL, NULL, NULL),
(38, '040', 'Bien inmueble gravado con IGV', NULL, NULL, NULL, NULL, NULL),
(39, '041', 'Plomo', 'Solo los bienes comprendidos en las subpartidas nacionales 7801.10.00.00, 7801.91.00.00 y 7801.99.00.00', '15.00', NULL, NULL, NULL),
(40, '013', ' ANIMALES VIVOS', NULL, NULL, NULL, NULL, NULL),
(41, '015', ' ABONOS, CUEROS Y PIELES DE ORIGEN ANIMAL', NULL, NULL, NULL, NULL, NULL),
(42, '099', 'LEY 30737', NULL, NULL, NULL, NULL, NULL),
(0, '0', 'NO DETRACCION', NULL, '0.00', NULL, NULL, NULL),
(1, '001', 'Azucar y melaza de cana', 'Bienes comprendidos en las subpartidas nacionales 1701.13.00.00, 1701.14.00.00, 1701.91.00.00, 1701.99.90.00 y 1703.10.00.00.', '10.00', NULL, NULL, NULL),
(2, '002', 'Arroz', NULL, NULL, NULL, NULL, NULL),
(3, '003', 'Alcohol etilico', 'Bienes comprendidos en las subpartidas nacionales 2207.10.00.00, 2207.20.00.10, 2207.20.00.90 y 2208.90.10.00.', '10.00', NULL, NULL, NULL),
(4, '004', 'Recursos Hidrobiologicos', 'Pescados  destinados al procesamiento de harina y aceite de pescado comprendidos en las subpartidas nacionales 0302.11.00.00/0305.69.00.00 y huevas, lechas y   desperdicios de pescado y demás contemplados en las subpartidas nacionales   0511.91.10.00/0511.91.90.00.\\r\\n\\r\\nSe   incluyen en esta definición los peces vivos, pescados no destinados al   procesamiento de harina y aceite de pescado, crustáceos, moluscos y demás   invertebrados acuáticos comprendidos en las subpartidas nacionales   0301.10.00.00/0307.99.90.90,cuando el proveedor hubiera renunciado a la   exoneración contenida en el inciso A) del Apéndice I de la Ley del IGV.', '4.00', NULL, NULL, NULL),
(5, '005', 'Maiz amarillo duro', 'La   presente definición incluye lo siguiente:\\r\\n\\r\\na) Bienes   comprendidos en la subpartida nacional 1005.90.11.00.\\r\\n\\r\\nb) Sólo la   harina de maíz amarillo duro comprendida en la subpartida nacional   1102.20.00.00.\\r\\n\\r\\nc) Sólo los grañones y sémola de maíz amarillo duro comprendidos en la subpartida   nacional 1103.13.00.00.\\r\\n\\r\\nd) Sólo \\\"pellets\\\" de maíz amarillo duro comprendidos en la subpartida   nacional 1103.20.00.00.\\r\\n\\r\\ne) Sólo los granos aplastados de maíz amarillo duro comprendidos en la subpartida   nacional 1104.19.00.00.\\r\\n\\r\\nf) Sólo  los demás granos trabajados de maíz amarillo duro comprendidos en la   subpartida nacional 1104.23.00.00.\\r\\n\\r\\ng) Sólo el germen de maíz amarillo duro entero, aplastado o molido comprendido en la   subpartida nacional 1104.30.00.00.\\r\\n\\r\\nh) Sólo los salvados, moyuelos y demás residuos del cernido, de la molienda o de   otros tratamientos del maíz amarillo duro, incluso en \\\"pellets\\\",   comprendidos en la subpartida nacional 2302.10.00.00.', '4.00', NULL, NULL, NULL),
(7, '007', 'Cana de azucar', 'Bienes comprendidos en la subpartida nacional 1212.93.00.00.', '10.00', NULL, NULL, NULL),
(8, '008', ' Madera', 'Bienes   comprendidos en las subpartidas nacionales 4403.10.00.00/4404.20.00.00,   4407.10.10.00/4409.20.90.00 y 4412.13.00.00/4413.00.00.00.', '4.00', NULL, NULL, NULL),
(9, '009', 'Arena y piedra', 'Bienes   comprendidos en las subpartidas nacionales 2505.10.00.00, 2505.90.00.00,   2515.11.00.00/2517.49.00.00 y 2521.00.00.00.\\r\\n\\r\\nBienes   comprendidos en las subpartidas nacionales 2505.10.00.00, 2505.90.00.00,   2515.11.00.00/2517.49.00.00 y 2521.00.00.00.', '10.00', NULL, NULL, NULL),
(10, '010', 'Residuos, subproductos, desechos, recortes y desperdicios', 'Solo los   residuos, subproductos, desechos, recortes y desperdicios comprendidos en las   subpartidas nacionales 2303.10.00.00/2303.30.00.00, 2305.00.00.00/2308.00.90.00,   2401.30.00.00, 3915.10.00.00/3915.90.00.00, 4004.00.00.00,4017.00.00.00,   4115.20.00.00, 4706.10.00.00/4707.90.00.00, 5202.10.00.00/5202.99.00.00,   5301.30.00.00, 5505.10.00.00, 5505.20.00.00, 6310.10.00.00, 6310.90.00.00,   6808.00.00.00, 7001.00.10.00, 7112.30.00.00/7112.99.00.00,   7204.10.00.00/7204.50.00.00, 7404.00.00.00, 7503.00.00.00, 7602.00.00.00,   7802.00.00.00, 7902.00.00.00, 8002.00.00.00, 8101.97.00.00, 8102.97.00.00,   8103.30.00.00, 8104.20.00.00, 8105.30.00.00, 8106.00.12.00, 8107.30.00.00,   8108.30.00.00, 8109.30.00.00, 8110.20.00.00, 8111.00.12.00, 8112.13.00.00,   8112.22.00.00, 8112.30.20.00, 8112.40.20.00, 8112.52.00.00, 8112.92.20.00,   8113.00.00.00, 8548.10.00.00 y 8548.90.00.00.\\r\\n  Se incluye en esta definición lo siguiente:\\r\\n\\r\\na) Sólo   los desperdicios comprendidos en las subpartidas nacionales 5302.90.00.00,   5303.90.30.00, 5303.90.90.00, 5304.90.00.00 y 5305.11.00.00/5305.90.00.00,   cuando el proveedor hubiera renunciado a la exoneración contenida en el   inciso A) del Apéndice I de la Ley del IGV.\\r\\n\\r\\nb) Los   residuos, subproductos, desechos, recortes y desperdicios de aleaciones de   hierro, acero, cobre, níquel, aluminio, plomo, cinc, estaño y/o demás metales   comunes a los que se refiere la Sección XV del Arancel de Aduanas, aprobado   por el Decreto Supremo N° 239-2001-EF y norma modificatoria.\\r\\n\\r\\nAdemás, se   incluye a las formas primarias comprendidas en las subpartidas nacionales   3907.60.10.00 y 3907.60.90.00', '15.00', NULL, NULL, NULL),
(11, '011', ' Bienes gravados con el IGV, o renuncia a la exoneracion', 'Bienes comprendidos en las subpartidas nacionales del inciso A) del Apéndice I de la Ley del IGV, siempre que el proveedor hubiera renunciado a la exoneración del IGV. Se excluye de esta definición a los bienes comprendidos en las subpartidas nacionales incluidas expresamente en otras definiciones del presente anexo', '10.00', NULL, NULL, NULL),
(12, '012', 'Intermediacion laboral y tercerizacion', 'A lo siguiente, independientemente del nombre que le   asignen las partes:\r\n\r\na) Los servicios temporales, complementarios o de alta   especialización prestados de acuerdo a lo dispuesto en la Ley N° 27626 y su   reglamento, aprobado por el Decreto Supremo N° 003-2002-TR, aun cuando el   sujeto que presta el servicio:\r\n\r\na.1) Sea distinto a los señalados   en los artículos 11° y 12° de la citada ley;   a.2) No hubiera cumplido con los requisitos exigidos por ésta para   realizar actividades de intermediación laboral; o,\r\n\r\na.3) Destaque al usuario   trabajadores que a su vez le hayan sido destacados.\r\n\r\nb) Los contratos de gerencia, conforme al artículo   193° de la Ley General de Sociedades.\r\n\r\nc) Los contratos en los cuales el prestador del   servicio dota de trabajadores al usuario del mismo, sin embargo éstos no   realizan labores en el centro de trabajo o de operaciones de este último sino   en el de un tercero.', '10.00', NULL, NULL, NULL),
(13, '014', 'Carnes y despojos comestibles', '\r\nSólo los bienes comprendidos en las   subpartidas nacionales 0201.10.00.00/0206.90.00.00.', '4.00', NULL, NULL, NULL),
(14, '016', 'Aceite de pescado', 'Bienes comprendidos en las subpartidas nacionales 1504.10.21.00/1504.20.90.00', '10.00', NULL, NULL, NULL),
(15, '017', ' Harina, polvo y pellets de pescado, crustaceos, moluscos y demas invertebrados acuaticos', 'Bienes   comprendidos en las subpartidas nacionales 2301.20.10.10/2301.20.90.00.', '4.00', NULL, NULL, NULL),
(17, '019', 'Arrendamiento de bienes muebles', 'Al arrendamiento, subarrendamiento o cesión en uso de   bienes muebles e inmuebles. Para tal efecto se consideran bienes muebles a   los definidos en el inciso b) del artículo 3° de la Ley del IGV. Se incluye   en la presente definición al arrendamiento, subarrendamiento o cesión en uso   de bienes muebles dotado de operario en tanto que no califique como contrato   de construcción de acuerdo a la definición contenida en el numeral 9 del   presente anexo. No se incluyen en esta   definición los contratos de arrendamiento financiero.', '10.00', NULL, NULL, NULL),
(18, '020', ' Mantenimiento y reparacion de bienes muebles', 'Al mantenimiento o reparación de bienes muebles   corporales y de las naves y aeronaves comprendidos en la definición prevista   en el inciso b) del   artículo 3° de la Ley del IGV.', '10.00', NULL, NULL, NULL),
(19, '021', 'Movimiento de carga', 'A la estiba o carga, desestiba o descarga, movilización y/o tarja de bienes. Para tal efecto se entenderá por:   \r\n\r\na)Estiba o carga: A la colocación conveniente y en forma ordenada de los bienes a bordo de cualquier medio de transporte, según las instrucciones del usuario del servicio.\r\n\r\nb)Desestiba o descarga: Al retiro conveniente y en forma ordenada de los bienes que se encuentran a bordo de cualquier medio de transporte, según las instrucciones del usuario del servicio.\r\n\r\nc) Movilización: A cualquier movimiento de los bienes, realizada dentro del centro de producción.\r\n\r\nd) Tarja: Al conteo y registro de los bienes que se cargan o descargan, o que se encuentren dentro del centro de producción, comprendiendo la anotación de la información que en cada caso se requiera, tal como el tipo de mercancía, cantidad, marcas, estado y condición exterior del embalaje y si se separó para inventario. No se incluye en esta definición el servicio de transporte de bienes, ni los servicios a los que se refiere el numeral 3 del Apéndice II de la Ley del IGV.\r\n\r\nNo están incluidos los servicios prestados por operadores de comercio exterior a los sujetos que soliciten cualquiera de los regímenes o destinos aduaneros especiales o de excepción, siempre que tales servicios estén vinculados a operaciones de comercio exterior (*).\r\n\r\nSe considera operadores de comercio exterior:\r\n\r\n1. Agentes marítimos\r\n\r\n2. Compañías aéreas\r\n\r\n3. Agentes de carga internacional\r\n\r\n4. Almacenes aduaneros\r\n\r\n5. Empresas de Servicio de Entrega Rápida\r\n\r\n6. Agentes de aduana.\r\n\r\n(*)Exclusión aplicable a las operaciones cuyo nacimiento de la obligación tributaria se produzca a partir del 14.07.2012, según Tercera Disposición Complementaria Final de la R.S. Nº 158-2012/SUNAT publicada el 13.07.2012.', '10.00', NULL, NULL, NULL),
(20, '022', 'Otros servicios empresariales', 'A cualquiera de las siguientes actividades comprendidas en la Clasificación Industrial Internacional Uniforme (CIIU) de las Naciones Unidas - Tercera revisión, siempre que no estén comprendidas en la definición de intermediación laboral y tercerización contenida en el presente anexo:\r\n\r\na) Actividades jurídicas (7411).\r\n\r\nb).Actividades de contabilidad, tejeduría de libros y auditoria; asesoramiento en materia de impuestos (7412).\r\n\r\nc).Investigaciones de mercados y realización de encuestas de opinión pública (7413).\r\n\r\nd).Actividades de asesoramiento empresarial y en materia de gestión (7414).\r\n\r\ne).Actividades de arquitectura e ingeniería y actividades conexas de asesoramiento técnico (7421).\r\n\r\nf).Publicidad (7430).\r\n\r\ng).Actividades de investigación y seguridad (7492).\r\n\r\nh).Actividades de limpieza de edificios (7493).\r\n\r\ni) Actividades de envase y empaque (7495).', '10.00', NULL, NULL, NULL),
(21, '023', 'Leche', 'Sólo la leche cruda entera comprendida en la subpartida nacional 0401.20.00.00, siempre que el proveedor hubiera renunciado a la exoneración del IGV.', '4.00', NULL, NULL, NULL),
(22, '024', 'Comision mercantil', 'Al Mandato que tiene por objeto un acto u operación de   comercio en la que el comitente o el comisionista son comerciantes o agentes   mediadores de comercio, de conformidad con el artículo 237° del Código de   Comercio.\r\n\r\nSe excluye de la presente definición al mandato en el que el   comisionista es:\r\n\r\na.Un   corredor o agente de intermediación de operaciones en la Bolsa de Productos o   Bolsa de Valores.\r\n\r\nb.Una empresa del Sistema Financiero y del Sistema de   Seguros.\r\n\r\nc.Un Agente de Aduana y el comitente aquel que   solicite cualquiera de los regímenes, operaciones o destinos aduaneros   especiales o de excepción.', '10.00', NULL, NULL, NULL),
(23, '025', 'Fabricacion de bienes por encargo', 'A aquel servicio mediante el cual el prestador del   mismo se hace cargo de todo o una parte del proceso de elaboración,   producción, fabricación o transformación de un bien. Para tal efecto, el   usuario del servicio entregará todo o parte de las materias primas, insumos,   bienes intermedios o cualquier otro bien necesario para la obtención de   aquéllos que se hubieran encargado elaborar, producir, fabricar o   transformar.\r\n\r\nSe incluye en la presente definición a la venta de bienes,   cuando las materias primas, insumos, bienes intermedios o cualquier otro bien   con los que el vendedor ha elaborado, producido, fabricado o transformado los   bienes vendidos, han sido transferidos bajo cualquier título por el comprador   de los mismos.\r\n\r\nNo se incluye en esta definición:\r\n\r\na. Las operaciones por las cuales el usuario   entrega únicamente avíos textiles, en tanto el prestador se hace cargo de   todo el proceso de fabricación de prendas textiles. Para efecto de la   presente disposición, son avíos textiles, los siguientes bienes: etiquetas, hangtags, stickers, entretelas, elásticos, aplicaciones, botones, broches,   ojalillos, hebillas, cierres, clips, colgadores, cordones, cintas twill,   sujetadores, alfileres, almas, bolsas, plataformas y cajas de embalaje.\r\n\r\nb. Las operaciones por las cuales el usuario entrega únicamente diseños, planos o cualquier bien intangible, mientras que el   prestador se hace cargo de todo el proceso de elaboración, producción,   fabricación, o transformación de un bien.', '10.00', NULL, NULL, NULL),
(24, '026', 'Servicio de transporte de personas', 'A aquel servicio prestado por vía terrestre, por el   cual se emita comprobante de pago que permita ejercer el derecho al crédito fiscal del IGV, de conformidad con el Reglamento de Comprobantes de Pago.', '10.00', NULL, NULL, NULL),
(25, '027', 'Servicio de transporte de carga', 'A aquel servicio prestado por vía terrestre, por el   cual se emita comprobante de pago que permita ejercer el derecho al crédito fiscal del IGV, de conformidad con el Reglamento de Comprobantes de Pago.', '10.00', NULL, NULL, NULL),
(26, '028', 'Transporte de pasajeros', NULL, NULL, NULL, NULL, NULL),
(28, '030', 'Contratos de construccion', 'A los que se celebren respecto de las actividades   comprendidas en el inciso d) del artículo 3° de la Ley del IGV, con excepción   de aquellos que consistan exclusivamente en el arrendamiento,   subarrendamiento o cesión en uso de equipo de construcción dotado de operario', '4.00', NULL, NULL, NULL),
(29, '031', 'Oro gravado con el IGV', 'a) Bienes   comprendidos en las subpartidas nacionales 2616.90.10.00, 7108.13.00.00 y   7108.20.00.00.\r\n\r\nb) Sólo la   amalgama de oro comprendida en la subpartida nacional 2843.90.00.00.\r\n\r\nc) Sólo   los desperdicios y desechos de oro, comprendidos en la subpartida nacional   7112.91.00.00.\r\n\r\nd) Bienes   comprendidos en las subpartidas nacionales 7108.11.00.00 y 7108.12.00.00   cuando el proveedor hubiera renunciado a la exoneración contenida en el inciso   A) del Apéndice I de la Ley del IGV.', '10.00', NULL, NULL, NULL),
(30, '032', 'Paprika y otros frutos de los generos capsicum o pimienta', 'Bienes comprendidos en las subpartidas nacionales 0904.21.10.10, 0904.21.10.90, 0904.21.90.00, 0904.22.10.00, 0904.22.90.00', '10.00', NULL, NULL, NULL),
(32, '034', 'Minerales metalicos no auriferos', 'Esta   definición incluye:\\r\\n\\r\\na) Los bienes comprendidos en las   subpartidas nacionales 2504.10.00.00, 2504.90.00.00,   2506.10.00.00/2509.00.00.00, 2511.10.00.00, 2512.00.00.00,   2513.10.00.10/2514.00.00.00, 2518.10.00.00/25.18.30.00.00, 2520.10.00.00,   2520.20.00.00, 2522.10.00.00/2522.30.00.00, 2526.10.00.00/2528.00.90.00,   2701.11.00.00/ 2704.00.30.00 y 2706.00.00.00.\\r\\n\\r\\nb) Sólo la puzolana comprendida en la   subpartida nacional 2530.90.00.90.', '10.00', NULL, NULL, NULL),
(33, '035', 'Bienes exonerados del IGV', 'Bienes   comprendidos en las subpartidas nacionales del inciso A) del Apéndice I de la   Ley del IGV. Se excluye de esta definición a los bienes comprendidos en las   subpartidas nacionales incluidas expresamente en otras definiciones del   presente anexo.', '1.50', NULL, NULL, NULL),
(34, '036', 'Oro y demas minerales metalicos exonerados del IGV', 'En esta   definición se incluye lo siguiente:\\r\\n\\r\\na) Bienes   comprendidos en las subpartidas nacionales 7108.11.00.00 y 7108.12.00.00.\\r\\n\\r\\nb)La venta   de bienes prevista en el inciso a) del numeral 13.1 del artículo 13° de la   Ley N.° 27037 - Ley de Promoción de la Inversión en la Amazonia, y sus normas   modificatorias y complementarias, respecto de:\\r\\n\\r\\nb.1)   Bienes comprendidos en las subpartidas nacionales 7108.13.00.00/   7108.20.00.00.\\r\\n\\r\\nb.2) Sólo   la amalgama de oro comprendida en la subpartida nacional 2843.90.00.00.\\r\\n\\r\\nb.3) Sólo   los desperdicios y desechos de oro, comprendidos en la subpartida nacional   7112.91.00.00.\\r\\n\\r\\nb.4) Sólo   el mineral metalífero y sus concentrados, escorias y cenizas comprendidos en   las subpartidas nacionales del Capítulo 26 de la Sección V del Arancel de   Aduanas aprobado por el Decreto Supremo N.° 238-2011-EF, incluso cuando se   presenten en conjunto con otros minerales o cuando hayan sido objeto de un   proceso de chancado y/o molienda.', '1.50', NULL, NULL, NULL),
(35, '037', 'Demas servicios gravados con el IGV', 'A toda prestación de servicios en el país comprendida en el numeral 1) del inciso c) del artículo 3º de la Ley del IGV que no se encuentre incluida en algún otro numeral del presente Anexo.\r\n\r\nSe excluye de esta definición:\r\n\r\na).Los servicios prestados por las empresas a que se refiere el artículo 16 de la Ley Nº 26702 – Ley General del Sistema Financiero y del Sistema de Seguros y Orgánica de la Superintendencia de Banca y Seguros, y normas modificatorias.\r\n\r\nb). Los servicios prestados por el Seguro Social de Salud - ESSALUD.\r\n\r\nc).Los servicios prestados por la Oficina de Normalización Previsional - ONP.\r\n\r\nd).El servicio de expendio de comidas y bebidas en establecimientos abiertos al público tales como restaurantes y bares.\r\n\r\ne).El servicio de alojamiento no permanente, incluidos los servicios complementarios a éste, prestado al huésped por los establecimientos de hospedaje a que se refiere el Reglamento de Establecimientos de Hospedaje, aprobado por Decreto Supremo Nº 029-2004-MINCETUR.\r\n\r\nf).El servicio postal y el servicio de entrega rápida.\r\n\r\ng).El servicio de transporte de bienes realizado por vía terrestre a que se refiere la Resolución de Superintendencia Nº 073-2006-SUNAT y normas modificatorias.\r\n\r\nh).El servicio de transporte público de pasajeros realizado por vía terrestre a que alude la Resolución de Superintendencia Nº 057-2007-SUNAT y normas modificatorias.\r\n\r\ni).Servicios comprendidos en las Exclusiones previstas en el literal a) del numeral 6 y en los literales a) y b) del numeral 7 del presente Anexo.\r\n\r\nj).Actividades de generación, transmisión y distribución de la energía eléctrica reguladas en la Ley de Concesiones Eléctricas aprobada por el Decreto Ley N.° 25844.\r\n\r\nk).Los servicios de exploración y/o explotación de hidrocarburos prestados a favor de PERUPETRO S.A. en virtud de contratos celebrados al amparo de los Decretos Leyes N.os 22774 y 22775 y normas modificatorias(*).\r\n\r\nl).Los servicios prestados por las instituciones de compensación y liquidación de valores a las que se refiere el Capítulo III del Título VIII del Texto Único Ordenado de la Ley del Mercado de Valores, aprobado por el Decreto Supremo N.° 093-2002-EF y normas modificatorias.\r\n\r\nll).Los servicios prestados por los administradores portuarios y aeroportuarios.”\r\n\r\nm).El servicio de espectáculo público y otras realizadas por el promotor. (9) (14)', '10.00', NULL, NULL, NULL),
(37, '039', 'Minerales no metalicos', 'Esta   definición incluye:\r\n\r\na) Los bienes comprendidos en las   subpartidas nacionales 2504.10.00.00, 2504.90.00.00,   2506.10.00.00/2509.00.00.00, 2511.10.00.00, 2512.00.00.00,   2513.10.00.10/2514.00.00.00, 2518.10.00.00/25.18.30.00.00, 2520.10.00.00,   2520.20.00.00, 2522.10.00.00/2522.30.00.00, 2526.10.00.00/2528.00.90.00,   2701.11.00.00/ 2704.00.30.00 y 2706.00.00.00.\r\n\r\nb) Sólo la puzolana comprendida en la   subpartida nacional 2530.90.00.90.', '10.00', NULL, NULL, NULL),
(38, '040', 'Bien inmueble gravado con IGV', NULL, NULL, NULL, NULL, NULL),
(39, '041', 'Plomo', 'Solo los bienes comprendidos en las subpartidas nacionales 7801.10.00.00, 7801.91.00.00 y 7801.99.00.00', '15.00', NULL, NULL, NULL),
(40, '013', ' ANIMALES VIVOS', NULL, NULL, NULL, NULL, NULL),
(41, '015', ' ABONOS, CUEROS Y PIELES DE ORIGEN ANIMAL', NULL, NULL, NULL, NULL, NULL),
(42, '099', 'LEY 30737', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preciohabitacion`
--

CREATE TABLE `preciohabitacion` (
  `idPrecioHabitacion` int(11) NOT NULL,
  `idTarifa` int(11) NOT NULL,
  `idHabitacion` int(11) NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `dias` int(11) NOT NULL,
  `horas` int(11) NOT NULL,
  `minutos` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(10) UNSIGNED NOT NULL,
  `categoriaid` int(11) NOT NULL,
  `sunatid` int(11) NOT NULL,
  `unidadMedida` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `precio_venta` decimal(8,2) NOT NULL,
  `estado` tinyint(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regalos`
--

CREATE TABLE `regalos` (
  `id` int(11) NOT NULL,
  `clienteid` int(11) NOT NULL,
  `usuarioid` int(11) NOT NULL,
  `reservaid` int(11) NOT NULL,
  `fecha_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones`
--

CREATE TABLE `reservaciones` (
  `id_reservacion` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `cliente` int(11) NOT NULL,
  `reservacion_origen_id` int(11) NOT NULL,
  `reservacion_estado_id` int(11) NOT NULL,
  `turno_id` int(11) NOT NULL,
  `habitacion_id` int(11) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `costoHabitacion` decimal(8,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_hora_checkIn` datetime NOT NULL DEFAULT current_timestamp(),
  `descuento` decimal(8,2) NOT NULL,
  `tipoServicio` int(11) NOT NULL,
  `diasAdicional` int(11) NOT NULL,
  `horasAdicional` int(11) NOT NULL,
  `minutosAdicional` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones_estados`
--

CREATE TABLE `reservaciones_estados` (
  `id_reservacionestado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reservaciones_estados`
--

INSERT INTO `reservaciones_estados` (`id_reservacionestado`, `nombre`, `created_at`) VALUES
(1, 'Pendiente', '2022-05-11 15:12:16'),
(2, 'Checked In', '2022-05-11 15:12:16'),
(3, 'Checked Out', '2022-05-11 15:12:29'),
(4, 'Anulada', '2022-05-11 15:12:29'),
(5, 'Pagada', '2022-08-25 23:21:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones_payments`
--

CREATE TABLE `reservaciones_payments` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `reservacionid` int(11) NOT NULL,
  `movimientocashid` int(11) NOT NULL,
  `voucher_electronico_id` int(11) NOT NULL,
  `metodo_pago_id` int(11) NOT NULL,
  `usuarioid` int(11) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva_medio_pago`
--

CREATE TABLE `reserva_medio_pago` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `mediopago` int(11) NOT NULL,
  `monto` int(11) NOT NULL,
  `estado_fila` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombre_rol`, `estado`) VALUES
(1, 'Administrador', 1),
(2, 'Recepcionista', 1),
(5, 'Supervisor', 1),
(7, 'Clientes', 1),
(11, 'SuperAdministrador', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `idservicio` int(11) NOT NULL,
  `nombre_servicio` varchar(50) NOT NULL,
  `descripcion_servicio` text NOT NULL,
  `precio_servicio` decimal(8,2) NOT NULL,
  `fecharegistro_servicio` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `idcodsunat` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sunat_codes`
--

CREATE TABLE `sunat_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sunat_codes`
--

INSERT INTO `sunat_codes` (`id`, `code`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(26137, '47131835', 'Agente desulfurizante', NULL, NULL, NULL),
(26138, '47131900', 'Absorbentes', NULL, NULL, NULL),
(26139, '47131901', 'Almohadillas absorbentes', NULL, NULL, NULL),
(26140, '47131902', 'Absorbentes granulares', NULL, NULL, NULL),
(26141, '47131903', 'Compuesto taponador', NULL, NULL, NULL),
(26142, '47131904', 'Medias absorbentes', NULL, NULL, NULL),
(26143, '47131905', 'Kits para derrames', NULL, NULL, NULL),
(26144, '47131906', 'Bandejas absorbentes', NULL, NULL, NULL),
(26145, '47131907', 'Escobas absorbentes', NULL, NULL, NULL),
(26146, '47131908', 'Almohadas absorbentes', NULL, NULL, NULL),
(26147, '47131909', 'Almohadillas o rollos absorbentes', NULL, NULL, NULL),
(26148, '47131910', 'Polimero super absorbente', NULL, NULL, NULL),
(26149, '47132100', 'Kits de limpieza', NULL, NULL, NULL),
(26150, '47132101', 'Kits de limpieza industrial', NULL, NULL, NULL),
(26151, '47132102', 'Kits de limpieza para uso general', NULL, NULL, NULL),
(26694, '50000000', 'Alimentos; Bebidas y Tabaco', NULL, NULL, NULL),
(26695, '50100000', 'Frutos secos', NULL, NULL, NULL),
(26696, '50101700', 'Frutos secos', NULL, NULL, NULL),
(26699, '50110000', 'Productos de carne y aves de corral', NULL, NULL, NULL),
(26700, '90111500', 'Hoteles y moteles y pensiones', NULL, NULL, NULL),
(26701, '20000000', 'Servicios', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sunat_transaccion`
--

CREATE TABLE `sunat_transaccion` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `estado_fila` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `sunat_transaccion`
--

INSERT INTO `sunat_transaccion` (`id`, `descripcion`, `estado_fila`) VALUES
(1, 'VENTA INTERNA', 0),
(2, 'EXPORTACION', 0),
(4, 'VENTA INTERNA - ANTICIPOS', 0),
(29, 'VENTAS NO DOMICILIADOS QUE NO CALIFICAN COMO EXPORTACION', 0),
(30, 'OPERACION SUJETA A DETRACCIÓN', 0),
(31, 'DETRACCIÓN - RECURSOS HIDROBIOLÓGICOS', 0),
(32, 'DETRACCIÓN - SERVICIOS DE TRANSPORTE DE PASAJEROS', 0),
(33, 'DETRACCIÓN - SERVICIOS DE TRANSPORTE CARGA ', 0),
(34, 'OPERACIÓN SUJETA A PERCEPCIÓN\r\nOPERACIÓN SUJETA A PERCEPCIÓNOPERACIÓN SUJETA A PERCEPCIÓN\r\nOPERACIÓN', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifas`
--

CREATE TABLE `tarifas` (
  `idTarifa` int(11) NOT NULL,
  `nombreTarifa` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tarifas`
--

INSERT INTO `tarifas` (`idTarifa`, `nombreTarifa`, `estado`) VALUES
(1, 'Horas', 1),
(2, 'Dias', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_comprobante_sunat`
--

CREATE TABLE `tipo_comprobante_sunat` (
  `id_tipo_comprobante` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `estado_fila` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_comprobante_sunat`
--

INSERT INTO `tipo_comprobante_sunat` (`id_tipo_comprobante`, `descripcion`, `estado_fila`) VALUES
(1, 'FACTURA', 0),
(2, 'BOLETA', 0),
(3, 'TICKET', 0),
(4, 'PRECUENTA', 0),
(5, 'CONSUMO', 0),
(6, 'CORTESIA', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_impuesto`
--

CREATE TABLE `tipo_impuesto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `codigo_impuesto` char(10) DEFAULT NULL,
  `codigo_tarifa` char(10) DEFAULT NULL,
  `tarifa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_impuesto`
--

INSERT INTO `tipo_impuesto` (`id`, `nombre`, `codigo_impuesto`, `codigo_tarifa`, `tarifa`) VALUES
(6, 'IVA12%', '2', '2', 12),
(7, 'IVA 0%', '2', '0', 0),
(8, 'IVA 14%', '2', '3', 14),
(9, 'NO OBJETO IVA', '2', '6', 0),
(10, 'EXENTO IVA', '2', '7', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_movimiento_caja`
--

CREATE TABLE `tipo_movimiento_caja` (
  `id_tipomovimientocaja` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `entrada_dinero` int(11) NOT NULL,
  `salida_dinero` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_movimiento_caja`
--

INSERT INTO `tipo_movimiento_caja` (`id_tipomovimientocaja`, `nombre`, `entrada_dinero`, `salida_dinero`, `created_at`) VALUES
(1, 'Monto inicial', 1, 0, '2022-05-12 15:31:28'),
(2, 'Pago de reservacion', 1, 1, '2022-05-12 15:31:28'),
(3, 'Pago de venta', 1, 1, '2022-05-12 15:31:46'),
(4, 'Pago de credito', 1, 1, '2022-05-12 15:31:46'),
(5, 'Pago de consumo', 1, 1, '2022-05-12 15:32:18'),
(6, 'Pago de servicio', 1, 1, '2022-05-12 15:32:18'),
(7, 'Pago de reservacion y consumo', 1, 1, '2022-05-12 15:32:34'),
(8, 'Vuelto', 0, 1, '2022-05-12 15:32:34'),
(9, 'Anulacion de venta', 0, 1, '2022-05-12 15:32:56'),
(10, 'Anulacion de venta', 0, 1, '2022-05-12 15:32:56'),
(11, 'Otro tipo de ingreso', 1, 1, '2022-05-12 15:33:05'),
(12, 'Otro tipo de salida', 0, 1, '2022-05-12 16:11:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `idturno` int(11) NOT NULL,
  `nombre_turno` varchar(50) NOT NULL,
  `inicio_turno` time NOT NULL,
  `fin_turno` time NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`idturno`, `nombre_turno`, `inicio_turno`, `fin_turno`, `estado`) VALUES
(1, 'Turno 1', '07:00:00', '21:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `identificacion` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `nombres` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `apellidos` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` bigint(20) DEFAULT NULL,
  `email_user` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `token` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `rolid` int(11) NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `identificacion`, `nombres`, `apellidos`, `telefono`, `email_user`, `direccion`, `password`, `token`, `rolid`, `datecreated`, `estado`) VALUES
(1, '73631587', 'SOPORTE', 'USQAY', 925820785, 'soporteusqay@gmail.com', 'CORPORACION USQAY', '8c4099c80d477941245d82be08d2b3af090a619bca9f535dd2b8b2212c869948', '', 1, '2023-02-02 10:13:59', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `clienteid` varchar(100) NOT NULL,
  `tipo_comprobante` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  `total_impuestos` float NOT NULL,
  `total_venta` decimal(8,2) NOT NULL,
  `venta_estado_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_hora` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_estado`
--

CREATE TABLE `ventas_estado` (
  `id_venta_estado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas_estado`
--

INSERT INTO `ventas_estado` (`id_venta_estado`, `nombre`, `created_at`) VALUES
(1, 'Creada', '2022-05-23 14:53:44'),
(2, 'Pagada', '2022-05-23 14:53:44'),
(3, 'Anulada', '2022-05-23 14:53:52'),
(4, 'Actualizada', '2022-08-08 12:27:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_medio_pago`
--

CREATE TABLE `venta_medio_pago` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `mediopago` int(11) NOT NULL,
  `monto` float NOT NULL,
  `estado_fila` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accion_caja`
--
ALTER TABLE `accion_caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pk_accion` (`pk_accion`),
  ADD KEY `tipo_accion` (`tipo_accion`),
  ADD KEY `caja` (`caja`);

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`idalmacen`);

--
-- Indices de la tabla `boleta`
--
ALTER TABLE `boleta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `categoria_habitacion`
--
ALTER TABLE `categoria_habitacion`
  ADD PRIMARY KEY (`id_categoria_habitacion`);

--
-- Indices de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `categoria_servicio`
--
ALTER TABLE `categoria_servicio`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `consumos`
--
ALTER TABLE `consumos`
  ADD PRIMARY KEY (`idconsumo`),
  ADD KEY `tipo_comprobante` (`tipo_comprobante`),
  ADD KEY `reservaid` (`reservaid`);

--
-- Indices de la tabla `corte`
--
ALTER TABLE `corte`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_consumo`
--
ALTER TABLE `detalle_consumo`
  ADD PRIMARY KEY (`id_detalle_consumo`);

--
-- Indices de la tabla `detalle_movimiento_almacen`
--
ALTER TABLE `detalle_movimiento_almacen`
  ADD PRIMARY KEY (`iddetalle_movimiento`),
  ADD KEY `almacenid` (`almacenid`),
  ADD KEY `productoid` (`productoid`),
  ADD KEY `movimientoid` (`movimientoid`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id_detalle_venta`),
  ADD KEY `idarticulo` (`idarticulo`),
  ADD KEY `ventaid` (`ventaid`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`idhabitacion`),
  ADD KEY `categoriahabitacionid` (`categoriahabitacionid`),
  ADD KEY `idpiso` (`idpiso`);

--
-- Indices de la tabla `medio_pago`
--
ALTER TABLE `medio_pago`
  ADD PRIMARY KEY (`idmediopago`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idmodulo`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`id_moneda`);

--
-- Indices de la tabla `movimiento_almacenes`
--
ALTER TABLE `movimiento_almacenes`
  ADD PRIMARY KEY (`idmovimiento_almacen`),
  ADD KEY `almacenid` (`almacenid`);

--
-- Indices de la tabla `movimiento_caja`
--
ALTER TABLE `movimiento_caja`
  ADD PRIMARY KEY (`id_movimientocaja`),
  ADD KEY `monedaid` (`monedaid`),
  ADD KEY `cajaid` (`cajaid`),
  ADD KEY `turnoid` (`turnoid`),
  ADD KEY `mediopagoid` (`mediopagoid`),
  ADD KEY `usuarioid` (`usuarioid`),
  ADD KEY `tipomovimientocaja_id` (`tipomovimientocaja_id`);

--
-- Indices de la tabla `movimiento_producto`
--
ALTER TABLE `movimiento_producto`
  ADD PRIMARY KEY (`idmovimiento_producto`),
  ADD KEY `productoid` (`productoid`),
  ADD KEY `movimientoid` (`movimientoid`);

--
-- Indices de la tabla `origen_reservacion`
--
ALTER TABLE `origen_reservacion`
  ADD PRIMARY KEY (`idorigen_reservacion`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `piso_habitacion`
--
ALTER TABLE `piso_habitacion`
  ADD PRIMARY KEY (`idpiso`);

--
-- Indices de la tabla `preciohabitacion`
--
ALTER TABLE `preciohabitacion`
  ADD PRIMARY KEY (`idPrecioHabitacion`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `categoriaid` (`categoriaid`),
  ADD KEY `sunat` (`sunatid`);

--
-- Indices de la tabla `regalos`
--
ALTER TABLE `regalos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD PRIMARY KEY (`id_reservacion`),
  ADD KEY `reservacion_origen_id` (`reservacion_origen_id`),
  ADD KEY `reservacion_estado_id` (`reservacion_estado_id`),
  ADD KEY `turno_id` (`turno_id`),
  ADD KEY `habitacion_id` (`habitacion_id`);

--
-- Indices de la tabla `reservaciones_estados`
--
ALTER TABLE `reservaciones_estados`
  ADD PRIMARY KEY (`id_reservacionestado`);

--
-- Indices de la tabla `reservaciones_payments`
--
ALTER TABLE `reservaciones_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservacionid` (`reservacionid`),
  ADD KEY `movimientocashid` (`movimientocashid`),
  ADD KEY `voucher_electronico_id` (`voucher_electronico_id`),
  ADD KEY `metodo_pago_id` (`metodo_pago_id`),
  ADD KEY `usuarioid` (`usuarioid`);

--
-- Indices de la tabla `reserva_medio_pago`
--
ALTER TABLE `reserva_medio_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`idservicio`);

--
-- Indices de la tabla `sunat_codes`
--
ALTER TABLE `sunat_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sunat_codes_code_unique` (`code`);

--
-- Indices de la tabla `tarifas`
--
ALTER TABLE `tarifas`
  ADD PRIMARY KEY (`idTarifa`);

--
-- Indices de la tabla `tipo_comprobante_sunat`
--
ALTER TABLE `tipo_comprobante_sunat`
  ADD PRIMARY KEY (`id_tipo_comprobante`);

--
-- Indices de la tabla `tipo_movimiento_caja`
--
ALTER TABLE `tipo_movimiento_caja`
  ADD PRIMARY KEY (`id_tipomovimientocaja`);

--
-- Indices de la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`idturno`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `tipo_comprobante` (`tipo_comprobante`),
  ADD KEY `venta_estado_id` (`venta_estado_id`);

--
-- Indices de la tabla `ventas_estado`
--
ALTER TABLE `ventas_estado`
  ADD PRIMARY KEY (`id_venta_estado`);

--
-- Indices de la tabla `venta_medio_pago`
--
ALTER TABLE `venta_medio_pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `mediopago` (`mediopago`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accion_caja`
--
ALTER TABLE `accion_caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `idalmacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categoria_habitacion`
--
ALTER TABLE `categoria_habitacion`
  MODIFY `id_categoria_habitacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  MODIFY `idcategoria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria_servicio`
--
ALTER TABLE `categoria_servicio`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `consumos`
--
ALTER TABLE `consumos`
  MODIFY `idconsumo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corte`
--
ALTER TABLE `corte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_consumo`
--
ALTER TABLE `detalle_consumo`
  MODIFY `id_detalle_consumo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_movimiento_almacen`
--
ALTER TABLE `detalle_movimiento_almacen`
  MODIFY `iddetalle_movimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id_detalle_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `idhabitacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medio_pago`
--
ALTER TABLE `medio_pago`
  MODIFY `idmediopago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idmodulo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `id_moneda` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `movimiento_almacenes`
--
ALTER TABLE `movimiento_almacenes`
  MODIFY `idmovimiento_almacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `movimiento_caja`
--
ALTER TABLE `movimiento_caja`
  MODIFY `id_movimientocaja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimiento_producto`
--
ALTER TABLE `movimiento_producto`
  MODIFY `idmovimiento_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `origen_reservacion`
--
ALTER TABLE `origen_reservacion`
  MODIFY `idorigen_reservacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=421;

--
-- AUTO_INCREMENT de la tabla `piso_habitacion`
--
ALTER TABLE `piso_habitacion`
  MODIFY `idpiso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preciohabitacion`
--
ALTER TABLE `preciohabitacion`
  MODIFY `idPrecioHabitacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `regalos`
--
ALTER TABLE `regalos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  MODIFY `id_reservacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservaciones_payments`
--
ALTER TABLE `reservaciones_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reserva_medio_pago`
--
ALTER TABLE `reserva_medio_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `idservicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sunat_codes`
--
ALTER TABLE `sunat_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26702;

--
-- AUTO_INCREMENT de la tabla `tarifas`
--
ALTER TABLE `tarifas`
  MODIFY `idTarifa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_comprobante_sunat`
--
ALTER TABLE `tipo_comprobante_sunat`
  MODIFY `id_tipo_comprobante` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_movimiento_caja`
--
ALTER TABLE `tipo_movimiento_caja`
  MODIFY `id_tipomovimientocaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `turnos`
--
ALTER TABLE `turnos`
  MODIFY `idturno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas_estado`
--
ALTER TABLE `ventas_estado`
  MODIFY `id_venta_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `venta_medio_pago`
--
ALTER TABLE `venta_medio_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
