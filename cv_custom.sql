-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-10-2025 a las 02:13:02
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
-- Base de datos: `cv_custom`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados`
--

CREATE TABLE `certificados` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `entidad` varchar(150) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `seccion_id` int(11) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `certificados`
--

INSERT INTO `certificados` (`id`, `usuario_id`, `titulo`, `entidad`, `fecha`, `url`, `seccion_id`, `orden`) VALUES
(18, 1, 'HTML5 desde cero Edición 2020', 'Udemy', '2024-03-20', 'https://www.udemy.com/certificate/UC-10f65e51-a8aa-4ff7-b7dc-7737a18f7a7c/', 10, 1),
(19, 1, 'Git y GitHub - Udemy', 'Udemy', '2023-11-01', 'https://www.udemy.com/certificate/UC-cc845787-da7e-4ef3-841e-dcbdcfb35318/', 10, 5),
(20, 1, 'Curso de PHP', 'Udemy', '2023-08-23', 'https://www.udemy.com/certificate/UC-483ace09-0e5b-4141-acba-2ec6e53ffa86/', 10, 3),
(21, 1, 'Patrón de diseño MVC (Modelo vista controlador) en PHP', 'Udemy', '2023-11-13', 'https://www.udemy.com/certificate/UC-76480f2f-cf81-49f6-bca2-81b6510553b2/', 10, 4),
(22, 1, 'Aprende Java con 100 Ejercicios prácticos (incluye JavaFx)', 'Udemy', '2020-04-21', 'https://www.udemy.com/certificate/UC-b4479166-13ba-4146-8719-58a8d3eb4010/', 10, 7),
(23, 1, 'Desarrollo Web. CSS Desde cero. Edicion 2020', 'Udemy', '2025-10-03', 'https://www.udemy.com/certificate/UC-f81adf58-6fc2-4ad3-b8e4-7902ead673b2/', 10, 2),
(24, 1, 'Aprende Oracle SQL desde cero', 'Udemy', '2025-10-03', 'https://www.udemy.com/certificate/UC-dde831b2-9838-4643-8ffb-8717be8a94df/', 10, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educacion`
--

CREATE TABLE `educacion` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `centro` varchar(150) NOT NULL,
  `titulacion` varchar(150) NOT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `seccion_id` int(11) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `educacion`
--

INSERT INTO `educacion` (`id`, `usuario_id`, `centro`, `titulacion`, `ubicacion`, `fecha_inicio`, `fecha_fin`, `descripcion`, `seccion_id`, `orden`) VALUES
(21, 1, 'I.E.S Alfonso X \"El Sabio\" Finalizado', 'Desarrollo de Aplicaciones Multiplataforma', 'Murcia', '2024-09-28', '2025-07-18', NULL, NULL, 1),
(22, 1, 'C.E.I.F.P Carlos III ', 'Desarrollo de Aplicaciones Web', 'Cartagena', '2019-07-28', '2021-10-28', NULL, NULL, 2),
(23, 1, 'I.E.S Ingeniero de la Cierva', 'Sistemas Microinformáticos y Redes', 'Murcia', '2013-07-18', '2015-12-18', NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `experiencia`
--

CREATE TABLE `experiencia` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `empresa` varchar(150) NOT NULL,
  `rol` varchar(150) NOT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `seccion_id` int(11) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `experiencia`
--

INSERT INTO `experiencia` (`id`, `usuario_id`, `empresa`, `rol`, `ubicacion`, `fecha_inicio`, `fecha_fin`, `descripcion`, `seccion_id`, `orden`) VALUES
(13, 1, 'Manufacturas Ruiz S.A.', 'Programador de Software', 'Murcia', '2024-05-21', '2024-08-30', '<ul>\n    <li>Desarrollo de Software a medida y optimización de aplicaciones logísticas.</li>\n    <li>Implementación de sistemas de autenticación (login y registro) de usuarios y control roles.</li>\n    <li>Refactorización de código obsoleto con el lenguaje de programación PHP y JavaScript.</li>\n    <li>Uso de tecnologías avanzadas con JQuery y Ajax.</li>\n    <li>Consultas de bases de datos no relacionales con MySQL.</li>\n    <li>Implementación de código QR.</li>\n  </ul>', 7, 1),
(17, 1, 'NTTDATA', 'Programador', 'Murcia', '2025-10-02', '2025-10-02', '<ul>\r\n  <li>\r\n    <strong>Habilidades como Desarrollador Site Building:</strong>\r\n    <ul>\r\n      <li>Amplia experiencia en desarrollo y migración en <strong>Drupal 8, 9 y 10</strong>, especializado en backend y site building.</li>\r\n      <li>Sólida trayectoria en la creación y personalización de módulos durante 2 años, así como en el consumo y desarrollo de servicios para integrar funcionalidades avanzadas en proyectos complejos.</li>\r\n    </ul>\r\n  </li>\r\n\r\n  <li>\r\n    <strong>Habilidades como programador en Drupal:</strong>\r\n    <ul>\r\n      <li>Control de Versiones y Herramientas de Desarrollo: dominio del sistema de control de versiones <strong>Git</strong>, garantizando una gestión eficiente del código y facilitando la colaboración en entornos de desarrollo dinámicos.</li>\r\n    </ul>\r\n  </li>\r\n\r\n  <li>\r\n    <strong>Conocimientos Técnicos Complementarios:</strong>\r\n    <ul>\r\n      <li>Competencia en <strong>SQL</strong> para consultas y optimización de bases de datos.</li>\r\n      <li>Experiencia en <strong>JavaScript</strong> y <strong>jQuery</strong> para enriquecer la experiencia de usuario y mejorar la interactividad de las aplicaciones web.</li>\r\n    </ul>\r\n  </li>\r\n\r\n  <li>\r\n    <strong>Habilidades Interpersonales y Gestión de Equipos:</strong>\r\n    <ul>\r\n      <li>Capacidad comprobada para comunicarse y coordinar eficazmente con otros miembros del equipo, asegurando una colaboración fluida y el cumplimiento de objetivos comunes.</li>\r\n      <li>Experiencia en la gestión de equipos pequeños (2 a 3 personas), con conocimientos en la administración de tareas y tiempos mediante <strong>Jira</strong>, optimizando el flujo de trabajo y garantizando la entrega de proyectos en plazos establecidos.</li>\r\n    </ul>\r\n  </li>\r\n</ul>\r\n', 7, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilidades`
--

CREATE TABLE `habilidades` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tipo` enum('frontend','backend','base_datos','multiplataforma','softskill') NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `seccion_id` int(11) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `habilidades`
--

INSERT INTO `habilidades` (`id`, `usuario_id`, `tipo`, `nombre`, `descripcion`, `seccion_id`, `orden`) VALUES
(1, 1, 'frontend', 'HTML', 'Lenguaje de marcado para la web', 9, 1),
(2, 1, 'frontend', 'CSS', 'Estilos para diseño web', 9, 2),
(3, 1, 'frontend', 'JavaScript', 'Lenguaje de programación frontend', 9, 3),
(4, 1, 'backend', 'PHP', 'Lenguaje backend para aplicaciones web', 9, 4),
(5, 1, 'backend', 'Java', 'Lenguaje backend multiplataforma', 9, 5),
(6, 1, 'base_datos', 'MySQL', 'Base de datos relacional', 9, 6),
(7, 1, 'multiplataforma', 'Electron', 'Framework para apps de escritorio', 9, 7),
(8, 1, 'softskill', 'Comunicación efectiva', 'Capacidad para transmitir ideas claramente', 10, 1),
(9, 1, 'softskill', 'Trabajo en equipo', 'Colaboración en proyectos grupales', 10, 2),
(10, 1, 'softskill', 'Creatividad', 'Aportar ideas innovadoras en el desarrollo', 10, 3),
(11, 1, 'multiplataforma', 'Java FX', 'Lenguaje para apps de escritorio', 9, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otros_datos_interes`
--

CREATE TABLE `otros_datos_interes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `seccion_id` int(11) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `otros_datos_interes`
--

INSERT INTO `otros_datos_interes` (`id`, `usuario_id`, `titulo`, `descripcion`, `seccion_id`, `orden`) VALUES
(1, 1, 'Disponibilidad Inmediata', 'Si.', NULL, 1),
(2, 1, 'Jornada Completa', 'Si.', NULL, 2),
(3, 1, 'Carnet de Conducir: B', 'Si.', NULL, 3),
(4, 1, 'Trabajo Remoto/Hibrido', 'Si.', NULL, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `alias` varchar(100) DEFAULT NULL,
  `profesion` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `sitio_web` varchar(200) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `icono_email` varchar(50) DEFAULT NULL,
  `icono_telefono` varchar(50) DEFAULT NULL,
  `icono_direccion` varchar(50) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id`, `usuario_id`, `alias`, `profesion`, `bio`, `email`, `telefono`, `direccion`, `sitio_web`, `foto`, `icono_email`, `icono_telefono`, `icono_direccion`, `creado_en`) VALUES
(6, 1, 'David Milanés', 'Desarrollador de Sotfware', 'Me gusta construir aplicaciones escalables y modernas, además tengo +2 años de experiencia en el mundo del desarrollo web.', 'dmilanestrabajo@gmail.com', '697727706', 'Santiago el Mayor, Murcia', 'https://dmilanes.es/', 'perfil_1759311641.png', 'fas fa-envelope', 'fas fa-phone', 'fas fa-map-marker-alt', '2025-10-01 09:40:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes_sociales`
--

CREATE TABLE `redes_sociales` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `plataforma` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `icono` varchar(100) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 1,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `redes_sociales`
--

INSERT INTO `redes_sociales` (`id`, `usuario_id`, `plataforma`, `url`, `usuario`, `icono`, `orden`, `visible`) VALUES
(9, 1, 'Linkedin', 'https://www.linkedin.com/in/david-milanés/', 'dmilanes', 'fab fa-linkedin', 1, 1),
(10, 1, 'Twitter', 'https://x.com/Milan3s', 'Milan3s', 'fab fa-twitter', 1, 1),
(11, 1, 'Github', 'https://github.com/Milan3s', 'Milan3s', 'fab fa-github', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secciones`
--

CREATE TABLE `secciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `columna` enum('izquierda','derecha','full') NOT NULL DEFAULT 'izquierda',
  `icono` varchar(100) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 1,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `secciones`
--

INSERT INTO `secciones` (`id`, `usuario_id`, `nombre`, `titulo`, `columna`, `icono`, `orden`, `creado_en`) VALUES
(7, 1, 'experiencia', 'Experiencia', 'derecha', 'fas fa-briefcase', 1, '2025-10-01 21:21:26'),
(8, 1, 'educacion', 'Educación', 'derecha', 'fas fa-graduation-cap', 2, '2025-10-01 21:21:26'),
(9, 1, 'habilidades', 'Habilidades', 'izquierda', 'fas fa-code', 3, '2025-10-01 21:21:26'),
(10, 1, 'certificados', 'Certificados', 'derecha', 'fas fa-certificate', 4, '2025-10-01 21:21:26'),
(11, 1, 'otros_datos_interes', 'Otros Datos de Interés', 'izquierda', 'fas fa-info-circle', 5, '2025-10-01 21:21:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `password`, `email`) VALUES
(1, 'David', '$2y$10$By0L8E3FgKDDchTOH9tNPeygBJLeWIomWh6A1hAcWegaC0yHiv3eG', 'dmilanestrabajo@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_certificados_usuario` (`usuario_id`),
  ADD KEY `fk_certificados_seccion` (`seccion_id`);

--
-- Indices de la tabla `educacion`
--
ALTER TABLE `educacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_educacion_usuario` (`usuario_id`),
  ADD KEY `fk_educacion_seccion` (`seccion_id`);

--
-- Indices de la tabla `experiencia`
--
ALTER TABLE `experiencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_experiencia_usuario` (`usuario_id`),
  ADD KEY `fk_experiencia_seccion` (`seccion_id`);

--
-- Indices de la tabla `habilidades`
--
ALTER TABLE `habilidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_habilidades_usuario` (`usuario_id`),
  ADD KEY `fk_habilidades_seccion` (`seccion_id`);

--
-- Indices de la tabla `otros_datos_interes`
--
ALTER TABLE `otros_datos_interes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_otros_usuario` (`usuario_id`),
  ADD KEY `fk_otros_seccion` (`seccion_id`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_redes_usuario` (`usuario_id`);

--
-- Indices de la tabla `secciones`
--
ALTER TABLE `secciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_secciones_usuario` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `certificados`
--
ALTER TABLE `certificados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `educacion`
--
ALTER TABLE `educacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `experiencia`
--
ALTER TABLE `experiencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `habilidades`
--
ALTER TABLE `habilidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `otros_datos_interes`
--
ALTER TABLE `otros_datos_interes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `secciones`
--
ALTER TABLE `secciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD CONSTRAINT `fk_certificados_seccion` FOREIGN KEY (`seccion_id`) REFERENCES `secciones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_certificados_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `educacion`
--
ALTER TABLE `educacion`
  ADD CONSTRAINT `fk_educacion_seccion` FOREIGN KEY (`seccion_id`) REFERENCES `secciones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_educacion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `experiencia`
--
ALTER TABLE `experiencia`
  ADD CONSTRAINT `fk_experiencia_seccion` FOREIGN KEY (`seccion_id`) REFERENCES `secciones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_experiencia_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `habilidades`
--
ALTER TABLE `habilidades`
  ADD CONSTRAINT `fk_habilidades_seccion` FOREIGN KEY (`seccion_id`) REFERENCES `secciones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_habilidades_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `otros_datos_interes`
--
ALTER TABLE `otros_datos_interes`
  ADD CONSTRAINT `fk_otros_seccion` FOREIGN KEY (`seccion_id`) REFERENCES `secciones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_otros_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD CONSTRAINT `perfil_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  ADD CONSTRAINT `fk_redes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `secciones`
--
ALTER TABLE `secciones`
  ADD CONSTRAINT `fk_secciones_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
