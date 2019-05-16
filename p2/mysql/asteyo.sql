-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-04-2019 a las 20:21:41
-- Versión del servidor: 5.7.24-0ubuntu0.18.04.1
-- Versión de PHP: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asteyo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `achievement`
--

CREATE TABLE `achievement` (
  `id_user` int(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `date_got` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `achievement_img`
--
/*
CREATE TABLE `achievement_img` (
  `name` varchar(32) NOT NULL,
  `link` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(32) NOT NULL,
  `id_autor` int(32) NOT NULL,
  `id_meme` int(32) NOT NULL,
  `texto` text NOT NULL,
  `c_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `co_reports`
--

CREATE TABLE `co_reports` (
  `id_report` int(32) NOT NULL,
  `cause` enum('Spam','Ofensivo') DEFAULT NULL,
  `id_comment` int(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hashtags`
--

CREATE TABLE `hashtags` (
  `name` varchar(32) NOT NULL,
  `n_memes` int(255) NOT NULL,
  `n_mg` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `hashtags`
--

INSERT INTO `hashtags` (`name`, `n_memes`, `n_mg`) VALUES
('#atunes', 1, 0),
('#cosas', 2, 0),
('#cuencaMola', 1, 0),
('#informatico', 1, 0),
('#NotasDeRedes', 1, 0),
('#soyMaño', 1, 0),
('#StarWars', 1, 0),
('#trump', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hashtag_meme`
--

CREATE TABLE `hashtag_meme` (
  `name_hash` varchar(32) NOT NULL,
  `id_meme` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `hashtag_meme`
--

INSERT INTO `hashtag_meme` (`name_hash`, `id_meme`) VALUES
('#trump', 1),
('#cosas', 2),
('#soyMaño', 3),
('#cosas', 4),
('#informatico', 4),
('#cuencaMola', 5),
('#StarWars', 5),
('#atunes', 6),
('#NotasDeRedes', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `megustas`
--

CREATE TABLE `megustas` (
  `id_user` int(32) NOT NULL,
  `id_meme` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memes`
--

CREATE TABLE `memes` (
  `id_meme` int(32) NOT NULL,
  `title` varchar(100) NOT NULL,
  `num_megustas` int(64) NOT NULL,
  `id_autor` int(32) NOT NULL,
  `upload_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `memes`
--

INSERT INTO `memes` (`id_meme`, `title`, `num_megustas`, `id_autor`, `upload_date`) VALUES
(1, 'Cuando eres mago...', 0, 1, '2019-04-12 19:56:45'),
(2, 'Cosas', 0, 2, '2019-04-12 19:59:57'),
(3, 'Vaya chista...co', 0, 3, '2019-04-12 20:04:51'),
(4, 'El día a día', 0, 4, '2019-04-12 20:08:04'),
(5, 'Viva cuenca!!', 0, 5, '2019-04-12 20:12:11'),
(6, 'Eres un grande chaval', 0, 6, '2019-04-12 20:15:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `me_reports`
--

CREATE TABLE `me_reports` (
  `id_report` int(32) NOT NULL,
  `cause` enum('Spam','Ofensivo') DEFAULT NULL,
  `id_meme` int(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reports`
--

CREATE TABLE `reports` (
  `usr_that_reports` int(32) NOT NULL,
  `usr_reported` int(32) NOT NULL,
  `id_report` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(32) DEFAULT NULL,
  `last_connect` datetime DEFAULT NULL,
  `rol` enum('normal','moderador','administrador') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `last_connect`, `rol`) VALUES
(1, 'arturo', '$2y$10$f55WdAV0ZhbRC3/e1wWEYO6MqpUTDCy5P1JaB2KcztdSzlqEwlcfi', 'arturo@ucm.es', NULL, 'normal'),
(2, 'alvaro', '$2y$10$OKNnYR442UUhZTS/pYsw0OgNM2qEcWmTQ8u/OBLps1dp0iwq.T.Qm', 'alvaro@ucm.es', NULL, 'normal'),
(3, 'carlos', '$2y$10$U3uD7KC/vymD2duLXPn0J.cBDtB4jNwIieUaWCCbsgr/2MI0Div0W', 'carlos@ucm.es', NULL, 'normal'),
(4, 'amalia', '$2y$10$vxvhBPHbqoyGPM/tiIYZLedAfk1vRERWpmnHMCe.xWHhk6/SSIf4.', 'amalia@ucm.es', NULL, 'normal'),
(5, 'carmen', '$2y$10$pQimpQAi05vDl7s8j4.z/eiQoR4jiJZL/3ognziVvM0CNec8Am66e', 'carmen@ucm.es', NULL, 'normal'),
(6, 'daniel', '$2y$10$ZakIBe8K1DYw0p5kOsOmZuKRfb6PTFriGTOyJN9TeJLmqhuGoXiRS', 'daniel@ucm.es', NULL, 'normal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usr_reports`
--

CREATE TABLE `usr_reports` (
  `id_report` int(32) NOT NULL,
  `cause` enum('Foto de perfil ofensiva','Nombre inapropiado','Bot') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `achievement`
--
ALTER TABLE `achievement`
  ADD PRIMARY KEY (`name`),
  ADD KEY `id_user` (`id_user`);
/*
--
-- Indices de la tabla `achievement_img`
--
ALTER TABLE `achievement_img`
  ADD PRIMARY KEY (`name`),
  ADD KEY `achievement_name` (`name`);
*/
--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_user` (`id_autor`),
  ADD KEY `id_meme` (`id_meme`);

--
-- Indices de la tabla `co_reports`
--
ALTER TABLE `co_reports`
  ADD PRIMARY KEY (`id_report`),
  ADD KEY `report` (`id_report`),
  ADD KEY `co_reports_igfk_2` (`id_comment`);

--
-- Indices de la tabla `hashtags`
--
ALTER TABLE `hashtags`
  ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `hashtag_meme`
--
ALTER TABLE `hashtag_meme`
  ADD PRIMARY KEY (`id_meme`,`name_hash`),
  ADD KEY `hashtag_name` (`name_hash`),
  ADD KEY `id_meme` (`id_meme`);

--
-- Indices de la tabla `megustas`
--
ALTER TABLE `megustas`
  ADD PRIMARY KEY (`id_meme`,`id_user`),
  ADD KEY `mg_ibfk_2` (`id_user`);

--
-- Indices de la tabla `memes`
--
ALTER TABLE `memes`
  ADD PRIMARY KEY (`id_meme`),
  ADD KEY `id_user` (`id_autor`);

--
-- Indices de la tabla `me_reports`
--
ALTER TABLE `me_reports`
  ADD PRIMARY KEY (`id_report`),
  ADD KEY `report` (`id_report`),
  ADD KEY `me_igfk_2` (`id_meme`);

--
-- Indices de la tabla `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id_report`),
  ADD KEY `that_reports` (`usr_that_reports`),
  ADD KEY `reported` (`usr_reported`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `usr_reports`
--
ALTER TABLE `usr_reports`
  ADD PRIMARY KEY (`id_report`),
  ADD KEY `report` (`id_report`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `memes`
--
ALTER TABLE `memes`
  MODIFY `id_meme` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reports`
--
ALTER TABLE `reports`
  MODIFY `id_report` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `achievement`
--
ALTER TABLE `achievement`
  ADD CONSTRAINT `achievement_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
/*
--
-- Filtros para la tabla `achievement_img`
--
ALTER TABLE `achievement_img`
  ADD CONSTRAINT `achievement_img_ibfk_1` FOREIGN KEY (`name`) REFERENCES `achievement` (`name`) ON DELETE CASCADE;
*/
--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_meme`) REFERENCES `memes` (`id_meme`) ON DELETE CASCADE;

--
-- Filtros para la tabla `co_reports`
--
ALTER TABLE `co_reports`
  ADD CONSTRAINT `co_reports_igfk_1` FOREIGN KEY (`id_report`) REFERENCES `reports` (`id_report`) ON DELETE CASCADE,
  ADD CONSTRAINT `co_reports_igfk_2` FOREIGN KEY (`id_comment`) REFERENCES `comments` (`id_comment`) ON DELETE CASCADE;

--
-- Filtros para la tabla `hashtag_meme`
--
ALTER TABLE `hashtag_meme`
  ADD CONSTRAINT `hashtag_meme_ibfk_1` FOREIGN KEY (`name_hash`) REFERENCES `hashtags` (`name`) ON DELETE CASCADE,
  ADD CONSTRAINT `hashtag_meme_ibfk_2` FOREIGN KEY (`id_meme`) REFERENCES `memes` (`id_meme`) ON DELETE CASCADE;

--
-- Filtros para la tabla `megustas`
--
ALTER TABLE `megustas`
  ADD CONSTRAINT `mg_ibfk_1` FOREIGN KEY (`id_meme`) REFERENCES `memes` (`id_meme`) ON DELETE CASCADE,
  ADD CONSTRAINT `mg_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `memes`
--
ALTER TABLE `memes`
  ADD CONSTRAINT `memes_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `me_reports`
--
ALTER TABLE `me_reports`
  ADD CONSTRAINT `me_igfk_1` FOREIGN KEY (`id_report`) REFERENCES `reports` (`id_report`) ON DELETE CASCADE,
  ADD CONSTRAINT `me_igfk_2` FOREIGN KEY (`id_meme`) REFERENCES `memes` (`id_meme`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`usr_that_reports`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`usr_reported`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usr_reports`
--
ALTER TABLE `usr_reports`
  ADD CONSTRAINT `usr_reports_igfk_1` FOREIGN KEY (`id_report`) REFERENCES `reports` (`id_report`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
