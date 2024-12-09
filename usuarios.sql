-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-09-2024 a las 17:33:44
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
-- Base de datos: `u919161175_lnwqi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IdUsuario` int(18) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Usuario` varchar(30) NOT NULL,
  `Clave` varchar(50) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1,
  `Categoria` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IdUsuario`, `Nombre`, `Apellido`, `Usuario`, `Clave`, `Activo`, `Categoria`) VALUES
(1, 'Ronaldo', 'Syddall', 'Ronaldo', '85f3935b8064b4c3ffaf11cde6820782', 1, 1),
(2, 'Franco', 'Quintero', 'Franco', '85f3935b8064b4c3ffaf11cde6820782', 1, 1),
(3, 'Leandro', 'Fernandez', 'Lean', '85f3935b8064b4c3ffaf11cde6820782', 1, 1),
(4, 'Profesor', 'Profesor', 'Profesor', '85f3935b8064b4c3ffaf11cde6820782', 1, 1),
(5, 'Juan', 'Garcia', 'Usuario2', 'dc647eb65e6711e155375218212b3964', 0, 0),
(6, 'Jorge ', 'García ', 'Jorge ', '4d186321c1a7f0f354b297e8914ab240', 1, 1),
(7, 'Roberto', 'Sanchez', 'Rsanchez', 'eb62f6b9306db575c2d596b1279627a4', 1, 0),
(8, 'Maria', 'Perez', 'Usuario3', '85f3935b8064b4c3ffaf11cde6820782', 1, 0),
(9, 'juan', 'Garcia', 'Garcia', '85f3935b8064b4c3ffaf11cde6820782', 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IdUsuario` int(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
