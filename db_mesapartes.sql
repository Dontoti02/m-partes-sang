-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-09-2026 a las 21:25:14
-- Versión del servidor: 11.8.2-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_mesapartes`
--

DELIMITER $$
--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `gen_cod_area` (`caracter` VARCHAR(3), `longitud` INT) RETURNS VARCHAR(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  Begin

  declare con int default 0;

  declare cadena varchar(6) default '';

	set con=(select max(idarea) from area);

  if(con is null) then
    set cadena=CONCAT(caracter, RIGHT(CONCAT('000001'),longitud));
  else
    SET cadena = CONCAT(caracter, RIGHT(CONCAT('00000', (con + 1)),longitud));
  end if;
Return cadena;

End$$

CREATE DEFINER=`root`@`localhost` FUNCTION `gen_cod_empleado` (`caracter` VARCHAR(3), `longitud` INT) RETURNS VARCHAR(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  Begin
  declare con int default 0;
  declare cadena varchar(6) default '';
	set con=(select max(idempleado) from empleado);
  if(con is null) then
    set cadena= CONCAT(caracter, RIGHT(CONCAT('000001'),longitud));
  else
    SET cadena = CONCAT(caracter, RIGHT(CONCAT('00000', (con + 1)),longitud));
  end if;
Return cadena;

End$$

CREATE DEFINER=`root`@`localhost` FUNCTION `gen_nroexpediente` () RETURNS VARCHAR(6) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  Begin
  declare con int default 0;
  declare cadena varchar(6) default '';
	set con=(select max(iddocumento) from documento);
  if(con is null) then
    set cadena='000001';
  else
    SET cadena = RIGHT(CONCAT('00000', (con + 1)),6);
  end if;
Return cadena;

End$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `idarea` int(11) NOT NULL,
  `cod_area` varchar(15) NOT NULL,
  `area` varchar(200) NOT NULL DEFAULT '',
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`idarea`, `cod_area`, `area`, `deleted`) VALUES
(1, 'A0001', 'DIRECCION GRAL', 0),
(2, 'A0002', 'SECRETARIA GRAL', 0),
(3, 'A0003', 'TECNOLOGIA DE LA INFORMACION (TI)', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areainstitu`
--

CREATE TABLE `areainstitu` (
  `idareainstitu` int(11) NOT NULL,
  `idinstitucion` int(11) NOT NULL,
  `idarea` int(11) NOT NULL,
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `areainstitu`
--

INSERT INTO `areainstitu` (`idareainstitu`, `idinstitucion`, `idarea`, `deleted`) VALUES
(1, 1, 1, 0),
(2, 1, 2, 0),
(3, 1, 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `derivacion`
--

CREATE TABLE `derivacion` (
  `idderivacion` int(11) NOT NULL,
  `fechad` datetime NOT NULL,
  `origen` varchar(100) NOT NULL,
  `idareainstitu` int(11) NOT NULL,
  `iddocumento` int(11) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `derivacion`
--

INSERT INTO `derivacion` (`idderivacion`, `fechad`, `origen`, `idareainstitu`, `iddocumento`, `descripcion`, `deleted`) VALUES
(1, '2026-01-30 11:28:13', 'EXTERIOR', 2, 1, 'DERIVANDO A SECRETARIA', 0),
(2, '2026-01-30 11:35:47', 'EXTERIOR', 2, 2, 'DERIVANDO A SECRETARIA', 0),
(3, '2026-01-30 11:41:16', 'EXTERIOR', 2, 3, 'DERIVANDO A SECRETARIA', 0),
(4, '2026-01-30 11:43:51', 'EXTERIOR', 2, 4, 'DERIVANDO A SECRETARIA', 0),
(5, '2026-01-30 11:49:36', 'EXTERIOR', 2, 5, 'DERIVANDO A SECRETARIA', 0),
(6, '2026-01-30 11:57:34', 'EXTERIOR', 2, 6, 'DERIVANDO A SECRETARIA', 0),
(7, '2026-01-30 11:58:23', 'EXTERIOR', 2, 7, 'DERIVANDO A SECRETARIA', 0),
(8, '2026-01-30 12:02:49', 'EXTERIOR', 2, 8, 'DERIVANDO A SECRETARIA', 0),
(9, '2026-01-30 12:05:14', 'EXTERIOR', 2, 9, 'DERIVANDO A SECRETARIA', 0),
(10, '2026-01-30 12:05:55', 'EXTERIOR', 2, 10, 'DERIVANDO A SECRETARIA', 0),
(11, '2026-01-30 12:08:22', 'EXTERIOR', 2, 11, 'DERIVANDO A SECRETARIA', 0),
(12, '2026-01-30 12:16:15', 'EXTERIOR', 2, 12, 'DERIVANDO A SECRETARIA', 0),
(13, '2026-01-30 12:18:34', 'EXTERIOR', 2, 13, 'DERIVANDO A SECRETARIA', 0),
(14, '2026-01-30 12:20:56', 'EXTERIOR', 2, 14, 'DERIVANDO A SECRETARIA', 0),
(15, '2026-01-30 12:49:31', 'EXTERIOR', 2, 15, 'DERIVANDO A SECRETARIA', 0),
(16, '2026-01-30 12:50:53', 'EXTERIOR', 2, 16, 'DERIVANDO A SECRETARIA', 0),
(17, '2026-01-30 12:51:42', 'EXTERIOR', 2, 17, 'DERIVANDO A SECRETARIA', 0),
(18, '2026-01-30 12:52:59', 'EXTERIOR', 2, 18, 'DERIVANDO A SECRETARIA', 0),
(19, '2026-01-30 12:53:41', 'EXTERIOR', 2, 19, 'DERIVANDO A SECRETARIA', 0),
(20, '2026-01-30 13:01:10', 'EXTERIOR', 2, 20, 'DERIVANDO A SECRETARIA', 0),
(21, '2026-01-30 13:01:51', 'EXTERIOR', 2, 21, 'DERIVANDO A SECRETARIA', 0),
(22, '2026-01-30 13:02:18', 'EXTERIOR', 2, 22, 'DERIVANDO A SECRETARIA', 0),
(23, '2026-01-30 13:04:56', 'EXTERIOR', 2, 23, 'DERIVANDO A SECRETARIA', 0),
(24, '2026-01-30 13:16:56', 'EXTERIOR', 2, 24, 'DERIVANDO A SECRETARIA', 0),
(25, '2026-01-30 13:18:24', 'EXTERIOR', 2, 25, 'DERIVANDO A SECRETARIA', 0),
(26, '2026-01-30 13:29:20', 'EXTERIOR', 2, 26, 'DERIVANDO A SECRETARIA', 0),
(27, '2026-01-30 13:35:40', 'EXTERIOR', 2, 27, 'DERIVANDO A SECRETARIA', 0),
(28, '2026-01-30 13:43:40', 'EXTERIOR', 2, 28, 'DERIVANDO A SECRETARIA', 0),
(29, '2026-01-30 13:56:34', 'EXTERIOR', 2, 28, 'DERIVANDO PARA REVISIÓN', 0),
(30, '2026-01-30 17:46:31', 'EXTERIOR', 2, 29, 'DERIVANDO A SECRETARIA', 0),
(31, '2026-01-30 17:48:59', 'EXTERIOR', 2, 30, 'DERIVANDO A SECRETARIA', 0),
(32, '2026-01-30 17:58:37', 'EXTERIOR', 2, 31, 'DERIVANDO A SECRETARIA', 0),
(33, '2026-01-31 10:29:30', 'EXTERIOR', 2, 32, 'DERIVANDO A SECRETARIA', 0);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `docs_procesados_fecha`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `docs_procesados_fecha` (
`fecha` varchar(10)
,`cantidad` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `iddocumento` int(11) NOT NULL,
  `nro_expediente` varchar(10) NOT NULL,
  `nro_doc` varchar(10) NOT NULL,
  `folios` int(11) NOT NULL DEFAULT 0,
  `asunto` varchar(500) NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT '',
  `archivo` text NOT NULL,
  `idpersona` int(11) NOT NULL,
  `idtipodoc` int(11) NOT NULL,
  `idubicacion` int(11) NOT NULL DEFAULT 0,
  `deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `fecha_registro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`iddocumento`, `nro_expediente`, `nro_doc`, `folios`, `asunto`, `estado`, `archivo`, `idpersona`, `idtipodoc`, `idubicacion`, `deleted`, `fecha_registro`) VALUES
(1, '000001', '12', 452, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000013001202661486305.pdf', 2, 1, 2, 0, '2026-01-30 11:28:13'),
(2, '000002', '12', 452, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000023001202661436306.pdf', 3, 1, 2, 0, '2026-01-30 11:35:47'),
(3, '000003', '12', 12, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000033001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 11:41:16'),
(4, '000004', '12', 12, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000043001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 11:43:51'),
(5, '000005', '12', 452, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000053001202661436306.pdf', 3, 1, 2, 0, '2026-01-30 11:49:36'),
(6, '000006', '12', 453, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000063001202661436306.pdf', 3, 3, 2, 0, '2026-01-30 11:57:34'),
(7, '000007', '12', 45, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000073001202661436306.pdf', 3, 4, 2, 0, '2026-01-30 11:58:23'),
(8, '000008', '12', 45, 'ASUNTOS', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000083001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 12:02:49'),
(9, '000009', '12', 45, 'ASUNTOS', 'OBSERVADO', 'files/docs/2026/01/30/doc_0000093001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 12:05:14'),
(10, '000010', '12', 452, 'INGRESE ASUNTO', 'ACEPTADO', 'files/docs/2026/01/30/doc_0000103001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 12:05:55'),
(11, '000011', '12', 452, 'ASUNTOS', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000113001202661436306.pdf', 3, 3, 2, 0, '2026-01-30 12:08:22'),
(12, '000012', '12', 458, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000123001202661436306.pdf', 3, 1, 2, 0, '2026-01-30 12:16:15'),
(13, '000013', '12', 789, 'ASUNTOS', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000133001202661486305.pdf', 2, 3, 2, 0, '2026-01-30 12:18:34'),
(14, '000014', '12', 789, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000143001202661486305.pdf', 2, 2, 2, 0, '2026-01-30 12:20:56'),
(15, '000015', '12', 456, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000153001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 12:49:31'),
(16, '000016', '12', 45, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000163001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 12:50:53'),
(17, '000017', '12', 789, 'ASUNTNI', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000173001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 12:51:42'),
(18, '000018', '12', 879, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000183001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 12:52:59'),
(19, '000019', '12', 456, '978', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000193001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 12:53:41'),
(20, '000020', '12', 456, 'ASUNTO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000203001202661436306.pdf', 3, 3, 2, 0, '2026-01-30 13:01:10'),
(21, '000021', '12', 789, 'ASUNTO DE CORREO', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000213001202661436306.pdf', 3, 3, 2, 0, '2026-01-30 13:01:51'),
(22, '000022', '12', 45, 'ASUNTOS DE PRUEBA', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000223001202661436306.pdf', 3, 3, 2, 0, '2026-01-30 13:02:18'),
(23, '000023', '12', 456, 'JHDFG', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000233001202661486305.pdf', 2, 3, 2, 0, '2026-01-30 13:04:56'),
(24, '000024', '12', 64, 'ASUNTOS', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000243001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 13:16:56'),
(25, '000025', '12', 456, 'DOCUEMNEOS', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000253001202661436306.pdf', 3, 3, 2, 0, '2026-01-30 13:18:24'),
(26, '000026', '12', 546, 'MESA DE PARTES', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000263001202661436306.pdf', 3, 3, 2, 0, '2026-01-30 13:29:20'),
(27, '000027', '12', 45, 'ASAS', 'ACEPTADO', 'files/docs/2026/01/30/doc_0000273001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 13:35:40'),
(28, '000028', '12', 12, 'GTFH', 'OBSERVADO', 'files/docs/2026/01/30/doc_000028_30012026_61436306.pdf', 3, 3, 2, 0, '2026-01-30 13:43:40'),
(29, '000029', '12', 455, 'ADSFFDS', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000293001202661436306.pdf', 3, 2, 2, 0, '2026-01-30 17:46:31'),
(30, '000030', '12', 56, 'DFD', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000303001202661436306.pdf', 3, 3, 2, 0, '2026-01-30 17:48:59'),
(31, '000031', '12', 45, 'FF', 'PENDIENTE', 'files/docs/2026/01/30/doc_0000313001202661436306.pdf', 3, 1, 2, 0, '2026-01-30 17:58:37'),
(32, '000032', '45', 156, 'MESA DE PARTES', 'PENDIENTE', 'files/docs/2026/01/31/doc_0000323101202661436306.pdf', 3, 2, 2, 0, '2026-01-31 10:29:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `idempleado` int(11) NOT NULL,
  `cod_empleado` varchar(15) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `idareainstitu` int(11) NOT NULL DEFAULT 0,
  `deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`idempleado`, `cod_empleado`, `idpersona`, `idareainstitu`, `deleted`) VALUES
(1, 'E00001', 1, 3, 0),
(2, 'E00002', 2, 2, 0),
(3, 'E00003', 4, 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `idhistorial` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `expediente` varchar(6) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `accion` varchar(100) NOT NULL DEFAULT '',
  `area` varchar(200) NOT NULL,
  `descrip` varchar(500) DEFAULT NULL,
  `idusuario` int(11) NOT NULL,
  `dni_usuario` varchar(8) DEFAULT NULL,
  `usuario` varchar(200) DEFAULT NULL,
  `rol` varchar(100) DEFAULT NULL,
  `area_usuario` varchar(200) DEFAULT NULL,
  `deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`idhistorial`, `fecha`, `expediente`, `dni`, `accion`, `area`, `descrip`, `idusuario`, `dni_usuario`, `usuario`, `rol`, `area_usuario`, `deleted`) VALUES
(1, '2026-01-30 11:28:13', '000001', '61486305', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(2, '2026-01-30 11:35:47', '000002', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(3, '2026-01-30 11:41:16', '000003', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(4, '2026-01-30 11:43:51', '000004', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(5, '2026-01-30 11:49:36', '000005', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(6, '2026-01-30 11:57:34', '000006', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(7, '2026-01-30 11:58:23', '000007', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(8, '2026-01-30 12:02:49', '000008', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(9, '2026-01-30 12:05:14', '000009', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(10, '2026-01-30 12:05:55', '000010', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(11, '2026-01-30 12:08:22', '000011', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(12, '2026-01-30 12:16:15', '000012', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(13, '2026-01-30 12:18:34', '000013', '61486305', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(14, '2026-01-30 12:20:56', '000014', '61486305', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(15, '2026-01-30 12:49:31', '000015', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(16, '2026-01-30 12:50:53', '000016', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(17, '2026-01-30 12:51:42', '000017', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(18, '2026-01-30 12:52:59', '000018', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(19, '2026-01-30 12:53:41', '000019', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(20, '2026-01-30 13:01:10', '000020', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(21, '2026-01-30 13:01:51', '000021', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(22, '2026-01-30 13:02:18', '000022', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(23, '2026-01-30 13:04:56', '000023', '61486305', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(24, '2026-01-30 13:16:56', '000024', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(25, '2026-01-30 13:18:24', '000025', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(26, '2026-01-30 13:29:20', '000026', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(27, '2026-01-30 13:35:40', '000027', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(28, '2026-01-30 13:42:11', '000027', '61436306', 'ACEPTADO', 'SECRETARIA GRAL', '', 2, '61486305', 'CARLOS CARLOS RIVAROLA', 'ADMINISTRADOR', 'SECRETARIA GRAL', 0),
(29, '2026-01-30 13:43:40', '000028', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 2, '61486305', 'CARLOS CARLOS RIVAROLA', 'ADMINISTRADOR', 'SECRETARIA GRAL', 0),
(30, '2026-01-30 13:54:31', '000028', '61436306', 'OBSERVADO', 'SECRETARIA GRAL', 'GGG', 1, '12345678', 'JAVIER GONZALES PRADA', 'ADMINISTRADOR', 'TECNOLOGIA DE LA INFORMACION (TI)', 0),
(31, '2026-01-30 13:56:34', '000028', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'LEVANTAMIENTO DE OBSERVACIONES', 0, '-', '-', '-', '-', 0),
(32, '2026-01-30 14:30:15', '000028', '61436306', 'OBSERVADO', 'SECRETARIA GRAL', 'HH', 1, '12345678', 'JAVIER GONZALES PRADA', 'ADMINISTRADOR', 'TECNOLOGIA DE LA INFORMACION (TI)', 0),
(33, '2026-01-30 14:30:54', '000010', '61436306', 'ACEPTADO', 'SECRETARIA GRAL', 'DSDS', 1, '12345678', 'JAVIER GONZALES PRADA', 'ADMINISTRADOR', 'TECNOLOGIA DE LA INFORMACION (TI)', 0),
(34, '2026-01-30 14:31:03', '000009', '61436306', 'OBSERVADO', 'SECRETARIA GRAL', 'RT', 1, '12345678', 'JAVIER GONZALES PRADA', 'ADMINISTRADOR', 'TECNOLOGIA DE LA INFORMACION (TI)', 0),
(35, '2026-01-30 17:46:31', '000029', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(36, '2026-01-30 17:48:59', '000030', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(37, '2026-01-30 17:58:37', '000031', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0),
(38, '2026-01-31 10:29:30', '000032', '61436306', 'DERIVADO', 'SECRETARIA GRAL', 'INGRESO DE NUEVO TRÁMITE', 0, '-', '-', '-', '-', 0);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `ingreso_docs_fecha`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `ingreso_docs_fecha` (
`fecha` varchar(10)
,`cantidad` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `institucion`
--

CREATE TABLE `institucion` (
  `idinstitucion` int(11) NOT NULL,
  `ruc` varchar(15) NOT NULL,
  `razon` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL DEFAULT '',
  `telefono` varchar(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `web` varchar(50) DEFAULT NULL,
  `sector` varchar(100) DEFAULT NULL,
  `logo` text NOT NULL,
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `institucion`
--

INSERT INTO `institucion` (`idinstitucion`, `ruc`, `razon`, `direccion`, `telefono`, `email`, `web`, `sector`, `logo`, `deleted`) VALUES
(1, '20987654321', 'TRAMITADOC', 'AV. LOS ALISOS MZ13 LT4 - ANCASH', '999999999', 'virtualiza@gmail.com', 'virtualiza.com', 'DOCUMENTARIO', 'files/logo/logo1_20987654321_20241029.png', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `idmodulo` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `estado`) VALUES
(1, 'Dashboard', 'Dashboard Principal del sistema', 1),
(2, 'Usuarios', 'Gestion de Usuarios del sistema', 1),
(3, 'Roles', 'Gestion de Roles del sistema', 1),
(4, 'Áreas', 'Gestion de Areas del sistema', 1),
(5, 'Empleados', 'Gestión de Empleados del sistema', 1),
(6, 'Trámites', 'Vista de Tramites del sistema', 1),
(7, 'Nuevo Trámite', 'Registro de nuevo Tramite al sistema', 1),
(8, 'Trámites Recibidos', 'Gestion trámites recibidos del área perteneciente', 1),
(9, 'Trámites Enviados', 'Vista de trámites enviados desde el área perteneciente', 1),
(10, 'Búsqueda', 'Busqueda de tramite en el sistema', 1),
(11, 'Informes', 'Generar Informes del sistema', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `idroles` int(11) NOT NULL,
  `idmodulo` int(11) NOT NULL,
  `cre` tinyint(1) NOT NULL DEFAULT 0,
  `rea` tinyint(1) NOT NULL DEFAULT 0,
  `upd` tinyint(1) NOT NULL DEFAULT 0,
  `del` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `idroles`, `idmodulo`, `cre`, `rea`, `upd`, `del`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(2, 1, 2, 1, 1, 1, 1),
(3, 1, 3, 1, 1, 1, 1),
(4, 1, 4, 1, 1, 1, 1),
(5, 1, 5, 1, 1, 1, 1),
(6, 1, 6, 1, 1, 1, 1),
(7, 1, 7, 1, 1, 1, 1),
(8, 1, 8, 1, 1, 1, 1),
(9, 1, 9, 1, 1, 1, 1),
(10, 1, 10, 1, 1, 1, 1),
(11, 1, 11, 1, 1, 1, 1),
(23, 3, 1, 1, 1, 1, 1),
(24, 3, 2, 0, 0, 0, 0),
(25, 3, 3, 0, 0, 0, 0),
(26, 3, 4, 0, 0, 0, 0),
(27, 3, 5, 0, 0, 0, 0),
(28, 3, 6, 0, 0, 0, 0),
(29, 3, 7, 1, 1, 1, 1),
(30, 3, 8, 1, 1, 1, 1),
(31, 3, 9, 1, 1, 1, 1),
(32, 3, 10, 1, 1, 1, 1),
(33, 3, 11, 0, 0, 0, 0),
(34, 4, 1, 0, 1, 0, 0),
(35, 4, 2, 0, 1, 0, 0),
(36, 4, 3, 0, 0, 0, 0),
(37, 4, 4, 0, 1, 0, 0),
(38, 4, 5, 0, 1, 0, 0),
(39, 4, 6, 0, 1, 0, 0),
(40, 4, 7, 0, 1, 0, 0),
(41, 4, 8, 0, 0, 0, 0),
(42, 4, 9, 0, 0, 0, 0),
(43, 4, 10, 0, 1, 0, 0),
(44, 4, 11, 0, 1, 0, 0),
(45, 5, 1, 0, 1, 0, 0),
(46, 5, 2, 0, 1, 0, 0),
(47, 5, 3, 0, 0, 0, 0),
(48, 5, 4, 0, 1, 0, 0),
(49, 5, 5, 0, 1, 0, 0),
(50, 5, 6, 0, 1, 0, 0),
(51, 5, 7, 0, 0, 0, 0),
(52, 5, 8, 0, 0, 0, 0),
(53, 5, 9, 0, 0, 0, 0),
(54, 5, 10, 0, 1, 0, 0),
(55, 5, 11, 0, 1, 0, 0),
(67, 2, 1, 1, 1, 1, 1),
(68, 2, 2, 0, 1, 0, 0),
(69, 2, 3, 0, 1, 0, 0),
(70, 2, 4, 0, 1, 0, 0),
(71, 2, 5, 0, 1, 0, 0),
(72, 2, 6, 0, 1, 0, 0),
(73, 2, 7, 0, 1, 0, 0),
(74, 2, 8, 0, 1, 0, 0),
(75, 2, 9, 0, 1, 0, 0),
(76, 2, 10, 0, 1, 0, 0),
(77, 2, 11, 0, 1, 0, 0),
(78, 6, 1, 0, 1, 1, 0),
(79, 6, 2, 0, 0, 0, 0),
(80, 6, 3, 0, 0, 0, 0),
(81, 6, 4, 0, 0, 0, 0),
(82, 6, 5, 0, 0, 0, 0),
(83, 6, 6, 1, 1, 1, 1),
(84, 6, 7, 0, 0, 0, 0),
(85, 6, 8, 0, 0, 0, 0),
(86, 6, 9, 0, 0, 0, 0),
(87, 6, 10, 0, 0, 0, 0),
(88, 6, 11, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `ap_paterno` varchar(100) NOT NULL,
  `ap_materno` varchar(100) NOT NULL,
  `nombres` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `telefono` int(9) UNSIGNED NOT NULL DEFAULT 0,
  `direccion` varchar(100) NOT NULL,
  `ruc_institu` varchar(15) DEFAULT NULL,
  `institucion` varchar(200) DEFAULT NULL,
  `deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `dni`, `ap_paterno`, `ap_materno`, `nombres`, `email`, `telefono`, `direccion`, `ruc_institu`, `institucion`, `deleted`) VALUES
(1, '12345678', 'GONZALES', 'PRADA', 'JAVIER', 'admin@gmail.com', 999999900, 'PERU', NULL, NULL, 0),
(2, '61486305', 'CARLOS', 'RIVAROLA', 'CARLOS', 'rivarolac682@gmail.com', 987654321, 'CIUDAD CHIUAHUA', NULL, NULL, 0),
(3, '61436306', 'MACHADO', 'RUIZ', 'JOSE GABRIEL', 'rivarolac682@gmail.com', 987654321, 'CIUDAD CHIUAHUA', '', '', 0),
(4, '61423256', 'RUIZ', 'MM', 'AGABRIEL', 'faxal40086@coswz.com', 987654320, 'CIUDAD CHIUAHUA', NULL, NULL, 0),
(5, '61425666', 'MARTIN', 'PAREDES', 'MARCOAS', 'portalwebdrepuno@gmail.com', 987654326, 'CIUDAD CHIUAHUA', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `ranking_docs_area`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `ranking_docs_area` (
`area` varchar(200)
,`total_documentos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idroles` int(11) NOT NULL,
  `rol` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `estado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idroles`, `rol`, `descripcion`, `estado`, `deleted`) VALUES
(1, 'ADMINISTRADOR', 'TODOS LOS MODULOS', 1, 0),
(2, 'ASISTENTE', 'RECEPCIONA Y DERIVA', 1, 0),
(3, 'AUXILIAR', 'GESTION DE DOCUMENTOS', 1, 0),
(4, 'SUPERVISOR', 'SUPERVISAR PROCESOS', 1, 0),
(5, 'INVITADO', 'VER INFORMACION DEL SISTEMA', 1, 0),
(6, 'COORDINADOR', 'ANALIZAR LOS INFORMES', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodoc`
--

CREATE TABLE `tipodoc` (
  `idtipodoc` int(11) NOT NULL,
  `tipodoc` varchar(50) NOT NULL,
  `deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipodoc`
--

INSERT INTO `tipodoc` (`idtipodoc`, `tipodoc`, `deleted`) VALUES
(1, 'OFICIO', 0),
(2, 'OFICIO MULTIPLE', 0),
(3, 'MEMORANDUM', 0),
(4, 'SOLICITUD', 0),
(5, 'INFORME', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuarios` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `dni` varchar(8) NOT NULL DEFAULT '',
  `contrasena` varchar(100) NOT NULL DEFAULT '',
  `fecharegistro` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `ultacceso` datetime DEFAULT NULL,
  `fechaedicion` datetime NOT NULL,
  `estado` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `foto` text DEFAULT NULL,
  `idroles` int(11) NOT NULL,
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuarios`, `nombre`, `dni`, `contrasena`, `fecharegistro`, `ultacceso`, `fechaedicion`, `estado`, `foto`, `idroles`, `deleted`) VALUES
(1, 'JavierGP78', '12345678', '$2y$10$7c2.tsXblMuxNHK8T5vT0.yjdpE5koySOvcetpl7Egt3hZJ7J3H5.', '2024-12-02 19:36:46', '2026-01-30 13:54:06', '2024-12-02 19:36:58', 1, 'files/images/0/user.png', 1, 0),
(2, 'CarlosCR05', '61486305', '$2y$10$WrJVdghyNQlXXS551j5tWeSNRR5LTmOQUf5D6nr/Zpkay0yuM6oTK', '2026-01-30 10:04:47', '2026-01-31 16:16:51', '2026-01-31 16:04:37', 1, 'files/images/2/profile2_61486305_20260131.jpg', 1, 0),
(3, 'AgabrielRM56', '61423256', '$2y$10$IeyiLrQrt5wwVjFq/ze4mucSPHnD4HSY69bBmrQyOmRasRG53Xp7m', '2026-01-30 14:42:09', '2026-01-30 14:44:17', '2026-01-30 14:42:18', 1, 'files/images/0/user.png', 2, 0),
(4, 'MarcoasMP66', '61425666', '$2y$10$wn4.TDlkI/wZyr3FavvqiOvcDR.uI6HbYBV0F/B6SWmobqbXZwgUS', '2026-01-31 16:09:02', '2026-01-31 16:16:15', '2026-01-31 16:09:47', 1, 'files/images/0/user.png', 6, 0);

-- --------------------------------------------------------

--
-- Estructura para la vista `docs_procesados_fecha`
--
DROP TABLE IF EXISTS `docs_procesados_fecha`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `docs_procesados_fecha`  AS SELECT date_format(`h`.`fecha`,'%d/%m/%Y') AS `fecha`, count(distinct `h`.`expediente`) AS `cantidad` FROM `historial` AS `h` WHERE `h`.`idhistorial` > (select min(`h2`.`idhistorial`) from `historial` `h2` where `h2`.`expediente` = `h`.`expediente`) GROUP BY cast(`h`.`fecha` as date) ORDER BY cast(`h`.`fecha` as date) ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `ingreso_docs_fecha`
--
DROP TABLE IF EXISTS `ingreso_docs_fecha`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ingreso_docs_fecha`  AS SELECT date_format(`documento`.`fecha_registro`,'%d/%m/%Y') AS `fecha`, count(0) AS `cantidad` FROM `documento` GROUP BY cast(`documento`.`fecha_registro` as date) ORDER BY cast(`documento`.`fecha_registro` as date) ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `ranking_docs_area`
--
DROP TABLE IF EXISTS `ranking_docs_area`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ranking_docs_area`  AS SELECT `a`.`area` AS `area`, count(`d`.`idubicacion`) AS `total_documentos` FROM ((`documento` `d` join `areainstitu` `ae` on(`ae`.`idareainstitu` = `d`.`idubicacion`)) join `area` `a` on(`a`.`idarea` = `ae`.`idarea`)) GROUP BY `ae`.`idareainstitu` ORDER BY count(`d`.`idubicacion`) DESC ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`idarea`);

--
-- Indices de la tabla `areainstitu`
--
ALTER TABLE `areainstitu`
  ADD PRIMARY KEY (`idareainstitu`),
  ADD KEY `idinstitucion` (`idinstitucion`),
  ADD KEY `idarea` (`idarea`);

--
-- Indices de la tabla `derivacion`
--
ALTER TABLE `derivacion`
  ADD PRIMARY KEY (`idderivacion`),
  ADD KEY `idareainstitu` (`idareainstitu`),
  ADD KEY `iddocumento` (`iddocumento`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`iddocumento`),
  ADD KEY `idpersona` (`idpersona`),
  ADD KEY `idtipodoc` (`idtipodoc`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`idempleado`),
  ADD KEY `idpersona` (`idpersona`),
  ADD KEY `idareainstitu` (`idareainstitu`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`idhistorial`);

--
-- Indices de la tabla `institucion`
--
ALTER TABLE `institucion`
  ADD PRIMARY KEY (`idinstitucion`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idmodulo`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`),
  ADD KEY `FK_permiso_1` (`idroles`),
  ADD KEY `FK_permiso_2` (`idmodulo`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idroles`);

--
-- Indices de la tabla `tipodoc`
--
ALTER TABLE `tipodoc`
  ADD PRIMARY KEY (`idtipodoc`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuarios`),
  ADD KEY `idroles` (`idroles`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `idarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `areainstitu`
--
ALTER TABLE `areainstitu`
  MODIFY `idareainstitu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `derivacion`
--
ALTER TABLE `derivacion`
  MODIFY `idderivacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `iddocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `idempleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `idhistorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `institucion`
--
ALTER TABLE `institucion`
  MODIFY `idinstitucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idmodulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idroles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipodoc`
--
ALTER TABLE `tipodoc`
  MODIFY `idtipodoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `areainstitu`
--
ALTER TABLE `areainstitu`
  ADD CONSTRAINT `areainstitu_ibfk_1` FOREIGN KEY (`idinstitucion`) REFERENCES `institucion` (`idinstitucion`),
  ADD CONSTRAINT `areainstitu_ibfk_2` FOREIGN KEY (`idarea`) REFERENCES `area` (`idarea`);

--
-- Filtros para la tabla `derivacion`
--
ALTER TABLE `derivacion`
  ADD CONSTRAINT `derivacion_ibfk_1` FOREIGN KEY (`idareainstitu`) REFERENCES `areainstitu` (`idareainstitu`),
  ADD CONSTRAINT `derivacion_ibfk_2` FOREIGN KEY (`iddocumento`) REFERENCES `documento` (`iddocumento`);

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`),
  ADD CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`idtipodoc`) REFERENCES `tipodoc` (`idtipodoc`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`),
  ADD CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`idareainstitu`) REFERENCES `areainstitu` (`idareainstitu`);

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `FK_permiso_1` FOREIGN KEY (`idroles`) REFERENCES `roles` (`idroles`),
  ADD CONSTRAINT `FK_permiso_2` FOREIGN KEY (`idmodulo`) REFERENCES `modulo` (`idmodulo`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_usuarios_1` FOREIGN KEY (`idroles`) REFERENCES `roles` (`idroles`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
