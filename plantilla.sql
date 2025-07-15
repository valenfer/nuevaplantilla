-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-07-2025 a las 10:45:41
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
-- Base de datos: `plantilla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos`
--

CREATE TABLE `codigos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `ajuste` varchar(255) NOT NULL,
  `valor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`id`, `ajuste`, `valor`) VALUES
(1, 'nombrePromo', 'Nueva'),
(2, 'codigo', '0'),
(3, 'color', '#f91f1f'),
(4, 'nombreEmpresa', 'Cas&Carry Díaz Cadenas'),
(5, 'multiParticipacion', '0'),
(6, 'asuntoMail', '¡Enhorabuena! Tu regalo ya está aquí'),
(7, 'correoEmpresa', 'marketin@cashdiazcadena.com'),
(8, 'estado', '1'),
(9, 'visitas', '0'),
(10, 'fin_promo', '2026-02-01'),
(11, 'infoLGPD', 'En cumplimiento de lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de protección de Datos de Carácter Personal (en adelante LOPD), les informamos que los datos de carácter personal que nos sean facilitados se integrarán en un fichero de cuyo tratamiento es responsable Cash&carry Diaz Cadenas y serán utilizados para la gestión del presente sorteo.</br></br>\r\n\r\n	Asimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando un correo electrónico a info@cashdiazcadenas.com con el asunto “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.\r\n\r\n	Asimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando un correo electrónico a marketinng@diazcadenas.com con el asunto “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.'),
(12, 'bases_legales', 'div class=\"page\" title=\"Page 1\">\r\n<div class=\"layoutArea\">\r\n<div class=\"column\">\r\n\r\nBASES DE LA PROMOCIÓN\r\n\r\n“Hola Puente Genil”\r\n\r\nI.-ORGANIZA\r\n\r\nAlimentación y Bebidas Díaz Cadenas, con CIF: B91146365\r\n\r\nII.OBJETO DE LA PROMOCIÓN\r\n\r\nEl objeto del sorteo es regalar 1 jamón y 1 caja de gambas al día desde el 30 de mayo al 15 de junio en el nuevo centro de Puente Genil.\r\n\r\nIII.PREMIOS\r\n\r\n• 1 jamón al día\r\n\r\n• 1 caja de gambas al día\r\n\r\nEl premio no es canjeable por dinero, no admiten devolución, ni cambio en efectivo, ni cambio de participante, etc.\r\n\r\nSe deberá presentar el cupón ganador y el mail de ganador.\r\n\r\nIV.PROCESO DE PARTICIPACIÓN\r\n\r\n1.Requisitos de participación.\r\n\r\nEl cliente debe realizar una compra sin mínimo en el centro Díaz Cadenas de Puente Genil para que se le entregue la tarjeta de participación.\r\n\r\n2.Periodo de participación.\r\n\r\nDel 30 de mayo al 15 de junio, excepto domingos y festivos\r\n\r\n3.Modo de participación.\r\n\r\nPara participar en el sorteo deben seguir los siguientes pasos:\r\n\r\n• Hacer una compra sin un mínimo\r\n\r\n• Escanear el código QR de la tarjeta de participación.\r\n\r\n• Rellenar el formulario con el código de la tarjeta.\r\n\r\n• Se sabrá al momento si has sido ganador o no.\r\n\r\nJURADO Y LA ORGANIZACIÓN\r\n\r\nSe constituirá un jurado, compuesto por representantes de la organización y la gerencia del Cash&Carry Diaz Cadenas.\r\n\r\nEl jurado y/o la organización tendrá las potestades, además de las de:\r\n\r\nDescalificación de los participantes que no cumplan los requisitos exigidos o no cumplan alguna de las normas establecidas.\r\n\r\nResolución de cualquier disputa durante el transcurso de la promoción, el sorteo y el disfrute de los premios.\r\n\r\nLos participantes aceptan y acatan expresamente los criterios e instrucciones que marquen el jurado y/o la organización en general y respecto de cualquier conflicto surgido durante la promoción y el sorteo, sin que los participantes tengan nada que reclamar al respecto.\r\n\r\nDESCALIFICACIÓN\r\n\r\nLa organización y/o el jurado se reservan el derecho de eliminar a cualquier participante en la promoción cuyos datos sean inexactos, no hayan cumplido los requisitos, no se adapten al espíritu de la promoción, atenten contra los usos y buenas costumbres, no acaten las instrucciones recibidas, albergue alguna duda sobre la veracidad de la promoción, o se haya valido de sistemas y/o programas informáticos para participar y mejorar los resultados del mismo, alterando el normal desarrollo del sorteo, o actúe fraudulentamente. Asimismo, quedarán descalificados aquellos participantes que no cumplan las normas establecidas para la participación, y los que se hallen en los demás supuestos previstos en este documento para ser invalidados.\r\n\r\nLEY DE PROTECCIÓN DE DATOS\r\n\r\nEn cumplimiento de lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de protección de Datos de Carácter Personal (en adelante LOPD), les informamos que los datos de carácter personal que nos sean facilitados se integrarán en un fichero de cuyo tratamiento es responsable Cash&Carry Diaz Cadenas y serán utilizados para la gestión del presente sorteo.\r\n\r\nAsimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando una carta a la dirección antes indicada con la referencia “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.\r\n\r\nAUTORIZACIÓN LEGAL\r\n\r\nLos participantes consienten automáticamente al participar en la presente promoción a la utilización, publicación y reproducción sin limitación, por parte de Cash&Carry Diaz Cadenas, de su imagen y nombre en cualquier tipo de publicidad, promoción, publicación, incluido Internet, o cualquier otro medio de la naturaleza que sea, con fines comerciales o informativos siempre que éstos se relacionen con la presente promoción, sin que dicha utilización le confiera derecho de remuneración o beneficio alguno.\r\n\r\nAsimismo, el participante acepta el uso de los datos recogidos para la comunicación de futuras promociones de Cash&Carry Diaz Cadenas.\r\n\r\nACEPTACIÓN DE LAS BASES\r\n\r\nLa participación en la promoción supone la aceptación íntegra de las Bases, la expresa renuncia de los participantes a realizar impugnación alguna sobre las mismas y al ejercicio de cualquier otra acción administrativa o judicial que pudiera corresponderles.\r\n\r\nLos participantes y ganadores eximen expresamente a Cash&Carry Diaz Cadenas así como a las empresas promotoras o colaboradoras de la presente promoción de las responsabilidades derivadas del mal funcionamiento de la red de internet, de servidores y de cuantos agentes participen en la difusión de la página Web, o por fuerza mayor o caso fortuito, no teniendo nada que reclamar contra ninguno de los entes antes reseñados.\r\n\r\nPara la resolución de cualquier duda sobre la mecánica, los premios o el funcionamiento de la aplicación objeto de la promoción, los usuarios pueden contactar con el Cash&Carry Diaz Cadenas a través del correo electrónico comercial@diazcadenas.com El Cash&Carry Diaz Cadenas se reserva el derecho a modificar, ampliar, suspender, restringir o retirar la presente promoción en cualquier momento, por razones justificadas.\r\n\r\nDISPOSICIÓN DE LAS BASES\r\n\r\nTanto las Bases del Sorteo como los detalles descriptivos de los premios, podrán consultarse en el Cash&Carry Díaz Cadenas.\r\n\r\nEn Utrera, a 27 de mayo de 2024\r\n\r\n</div>\r\n</div>\r\n</div>\r\n'),
(13, 'texto_mail_ganador', '<p>¡Gracias por tu participación!</p>\r\n<small>Para reclamar tu premio, acércate a nuestro centro junto a tu código ganador.</br>\r\nEs indispensable conservar este correo hasta la entrega del regalo</small>'),
(14, 'texto_mail_perdedor', '<h1>¡Gracias por participar en la promoción!</h1>\r\n<p>Esta vez no has resultado ganador, pero puedes volver a intentarlo</p>\r\n<p>¡Mucha suerte!</p>\r\n		   			\r\n		   				'),
(15, 'asuntoMailPerdedor', '¡Gracias por participar en nuestro sorteo!'),
(16, 'minutos', '0'),
(17, 'horaAp', '00:00:00'),
(18, 'horaC', '23:59:00'),
(19, 'host', 'smtp.diazcadenas.es'),
(20, 'username', 'marketin@cashdiazcadena.com'),
(21, 'password', 'Maruja2025!'),
(22, 'port', '465'),
(23, 'link', ''),
(24, 'bbdd', 'localhost'),
(25, 'userbd', 'root'),
(26, 'passbd', ''),
(27, 'campos', '{\"nombre\":[\"text\",1],\"edad\":[\"number\",0],\"municipio\":[\"text\",0],\"direccion\":[\"text\",0],\"codp\":[\"number\",0],\"email\":[\"text\",1],\"ticket\":[\"text\",0],\"auxiliar1\":[\"text\",0],\"auxiliar2\":[\"text\",0],\"auxiliar3\":[\"number\",0],\"auxiliar4\":[\"number\",0]}'),
(28, 'linkBasesLegales', 'https://cashdiazcadenas.com/bases-legales-hola-puente-genil/'),
(29, 'linkTerminosUso', 'https://cashdiazcadenas.com/politica-privacidad/'),
(30, 'inicio_promo', '2025-05-01'),
(31, 'subirImagen', '0'),
(32, 'descripcionPromo', ''),
(33, 'textoFavicon', 'Obando'),
(34, 'colorFondoFooter', ''),
(35, 'colorFondoCabecera', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nombreEmpresa` varchar(255) DEFAULT NULL,
  `correoEmpresa` varchar(255) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `asuntoMail` varchar(255) DEFAULT NULL,
  `txtMailGanador` text DEFAULT NULL,
  `asuntoMailPerdedor` varchar(255) DEFAULT NULL,
  `txtMailPerdedor` text DEFAULT NULL,
  `infoLegal` text DEFAULT NULL,
  `basesLegales` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `footer` text NOT NULL,
  `linkBasesLegales` text DEFAULT NULL,
  `linkTerminosUso` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `nombreEmpresa`, `correoEmpresa`, `host`, `username`, `password`, `port`, `asuntoMail`, `txtMailGanador`, `asuntoMailPerdedor`, `txtMailPerdedor`, `infoLegal`, `basesLegales`, `logo`, `footer`, `linkBasesLegales`, `linkTerminosUso`) VALUES
(1, 'C.C. Aleste', 'marketin@aleste.es', 'dns111177.phdns6.es', 'marketin@aleste.e', 'YdE2xf13', 587, '¡Enhorabuena! Tu regalo ya está aquí', '<p>¡Gracias por tu participación!</p>\r\n<small>Para reclamar tu premio, acércate a nuestro centro junto a tu código ganador.</br>\r\nEs indispensable conservar este correo hasta la entrega del regalo</small>', '¡Gracias por participar en nuestro sorteo!', '<h1>¡Gracias por participar en la promoción!</h1>\r\n<p>Esta vez no has resultado ganador, pero puedes volver a intentarlo</p>\r\n<p>¡Mucha suerte!</p>\r\n		   			\r\n		   				', 'En cumplimiento de lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de protección de Datos de Carácter Personal (en adelante LOPD), les informamos que los datos de carácter personal que nos sean facilitados se integrarán en un fichero de cuyo tratamiento es responsable C.C. Aleste y serán utilizados para la gestión del presente sorteo.</br></br>\r\n\r\n	Asimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando un correo electrónico a marketing@aleste.es con el asunto “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.', '<div class=\"page\" title=\"Page 1\">\r\n<div class=\"layoutArea\">\r\n<div class=\"column\">\r\n\r\nBASES DE LA PROMOCIÓN\r\n“Lluvia regalos Cádiz”\r\n<h3>I.-ORGANIZA</h3>\r\nAlimentación y Bebidas Díaz Cadenas, con CIF: B91146365\r\n\r\nII.OBJETO DE LA PROMOCIÓN\r\n\r\nEl objeto de la promoción es hacer diferentes regalos con una compra superior a 30€ en el centro  Cash&Carry Díaz Cadenas de Cádiz.\r\n<h3>III.PREMIOS</h3>\r\n\r\nLos premios son:\r\n-	6 jamones\r\n-	200 sombrillas\r\n-	1.000 neveras grandes\r\n-	500 neveras pequeñas\r\n-	50 altavoces bluetooth\r\n-	2.664 Frisbies rojos\r\n-	2.000 gafas de sol\r\n\r\nEl premio no es canjeable por dinero, no admiten devolución, ni cambio en efectivo, ni cambio de participante, etc.\r\nPara canjear el premio, se deberá de entregar el cupón con el código ganador, el ticket de compra y enseñar el mensaje de código ganador.\r\n<h3>IV.PROCESO DE PARTICIPACIÓN</h3>\r\n1.Requisitos de participación.\r\nPodrán participar en el sorteo todas las personas mayores de 18 años, de nacionalidad españolas o residentes legales en España.\r\n2.Periodo de participación.\r\nDel 19 de julio al 31 de agosto, ambos incluidos.\r\n3.Modo de participación.\r\nPara participar en el sorteo deben seguir los siguientes pasos:\r\n•	Realizar una compra mínima de 30€ en Cash & Carry Díaz Cadenas Cádiz. Maximo 3 participaciones por persona y dia. \r\n•	Introducir el código que se entrega junto a los datos participantes en https://cashcadiz.com\r\n•	Sabrás instantáneamente si has sido premiado \r\nNo podrán participar en el concurso los trabajadores de Cash&Carry Diaz Cadenas ni Maruja Limón. Podrá participar tantas veces como se quiera.\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"page\" title=\"Page 2\">\r\n<div class=\"layoutArea\">\r\n<div class=\"column\">\r\n\r\n<h3>JURADO Y LA ORGANIZACIÓN</h3>\r\nSe constituirá un jurado, compuesto por representantes de la organización y la gerencia del Cash&Carry Diaz Cadenas.\r\nEl jurado y/o la organización tendrá las potestades, además de las de: Descalificación de los participantes que no cumplan los requisitos exigidos o no cumplan alguna de las normas establecidas.\r\nResolución de cualquier disputa durante el transcurso de la promoción, el sorteo y el disfrute de los premios. Los participantes aceptan y acatan expresamente los criterios e instrucciones que marquen el jurado y/o la organización en general y respecto de cualquier conflicto surgido durante la promoción y el sorteo, sin que los participantes tengan nada que reclamar al respecto.\r\n<h3>DESCALIFICACIÓN</h3>\r\nLa organización y/o el jurado se reservan el derecho de eliminar a cualquier participante en la promoción cuyos datos sean inexactos, no hayan cumplido los requisitos, no se adapten al espíritu de la promoción, atenten contra los usos y buenas costumbres, no acaten las instrucciones recibidas, albergue alguna duda sobre la veracidad de la promoción, o se haya valido de sistemas y/o programas informáticos para participar y mejorar los resultados del mismo, alterando el normal desarrollo del sorteo, o actúe fraudulentamente.\r\nAsimismo, quedarán descalificados aquellos participantes que no cumplan las normas establecidas para la participación, y los que se hallen en los demás supuestos previstos en este documento para ser invalidados.\r\n<h3>LEY DE PROTECCIÓN DE DATOS</h3>\r\nEn cumplimiento de lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de protección de Datos de Carácter Personal (en adelante LOPD), les informamos que los datos de carácter personal que nos sean facilitados se integrarán en un fichero de cuyo tratamiento es responsable Cash&Carry Diaz Cadenas y serán utilizados para la gestión del presente sorteo.\r\nAsimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando una carta a la dirección antes indicada con la referencia “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.\r\n\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"page\" title=\"Page 3\">\r\n<div class=\"layoutArea\">\r\n<div class=\"column\">\r\n\r\n<h3>AUTORIZACIÓN LEGAL</h3>\r\nLos participantes consienten automáticamente al participar en la presente promoción a la utilización, publicación y reproducción sin limitación, por parte de Cash&Carry Diaz Cadenas, de su imagen y nombre en cualquier tipo de publicidad, promoción, publicación, incluido Internet, o cualquier otro medio de la naturaleza que sea, con fines comerciales o informativos siempre que éstos se relacionen con la presente promoción, sin que dicha utilización le confiera derecho de remuneración o beneficio alguno.\r\nAsimismo, el participante acepta el uso de los datos recogidos para la comunicación de futuras promociones de Cash&Carry Diaz Cadenas.\r\n<h3>ACEPTACIÓN DE LAS BASES</h3>\r\nLa participación en la promoción supone la aceptación íntegra de las Bases, la expresa renuncia de los participantes a realizar impugnación alguna sobre las mismas y al ejercicio de cualquier otra acción administrativa o judicial que pudiera corresponderles.\r\nLos participantes y ganadores eximen expresamente a Cash&Carry Diaz Cadenas así como a las empresas promotoras o colaboradoras de la presente promoción de las responsabilidades derivadas del mal funcionamiento de la red de internet, de servidores y de cuantos agentes participen en la difusión de la página Web, o por fuerza mayor o caso fortuito, no teniendo nada que reclamar contra ninguno de los entes antes reseñados.\r\nPara la resolución de cualquier duda sobre la mecánica, los premios o el funcionamiento de la aplicación objeto de la promoción, los usuarios pueden contactar con el Cash&Carry Diaz Cadenas a través del correo electrónico comercial@diazcadenas.com El Cash&Carry Diaz Cadenas se reserva el derecho a modificar, ampliar, suspender, restringir o retirar la presente promoción en cualquier momento, por razones justificadas.\r\n<h3>DISPOSICIÓN DE LAS BASES</h3>\r\nTanto las Bases del Sorteo como los detalles descriptivos de los premios, podrán consultarse en el Cash&Carry Díaz Cadenas.\r\nEn Utrera, a 14 de julio de 2021.\r\n\r\n</div>\r\n</div>\r\n</div>\r\n', NULL, '', './Bases_Legales_SAN VALENTIN.pdf', 'https://alesteplaza.es/politica-de-privacidad/'),
(2, 'C.C. Almazara', 'info@almazara.es', 'almazara.es', 'info@almazara.es', 'Maruja2025!', 465, '¡Enhorabuena! Tu regalo ya está aquí', '<p>¡Gracias por tu participación!</p>\r\n<small>Para reclamar tu premio, acércate a nuestro centro junto a tu código ganador.</br>\r\nEs indispensable conservar este correo hasta la entrega del regalo</small>', '¡Gracias por participar en nuestro sorteo!', '<h1>¡Gracias por participar en la promoción!</h1>\r\n<p>Esta vez no has resultado ganador, pero puedes volver a intentarlo</p>\r\n<p>¡Mucha suerte!</p>\r\n		   			\r\n		   				', 'En cumplimiento de lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de protección de Datos de Carácter Personal (en adelante LOPD), les informamos que los datos de carácter personal que nos sean facilitados se integrarán en un fichero de cuyo tratamiento es responsable C.C. Almazara y serán utilizados para la gestión del presente sorteo.</br></br>\r\n\r\n	Asimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando un correo electrónico a info@almazara.com con el asunto “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.', '<div class=\"page\" title=\"Page 1\">\r\n<div class=\"layoutArea\">\r\n<div class=\"column\">\r\n\r\nBASES DE LA PROMOCIÓN\r\n“Lluvia regalos Cádiz”\r\n<h3>I.-ORGANIZA</h3>\r\nAlimentación y Bebidas Díaz Cadenas, con CIF: B91146365\r\n\r\nII.OBJETO DE LA PROMOCIÓN\r\n\r\nEl objeto de la promoción es hacer diferentes regalos con una compra superior a 30€ en el centro  Cash&Carry Díaz Cadenas de Cádiz.\r\n<h3>III.PREMIOS</h3>\r\n\r\nLos premios son:\r\n-	6 jamones\r\n-	200 sombrillas\r\n-	1.000 neveras grandes\r\n-	500 neveras pequeñas\r\n-	50 altavoces bluetooth\r\n-	2.664 Frisbies rojos\r\n-	2.000 gafas de sol\r\n\r\nEl premio no es canjeable por dinero, no admiten devolución, ni cambio en efectivo, ni cambio de participante, etc.\r\nPara canjear el premio, se deberá de entregar el cupón con el código ganador, el ticket de compra y enseñar el mensaje de código ganador.\r\n<h3>IV.PROCESO DE PARTICIPACIÓN</h3>\r\n1.Requisitos de participación.\r\nPodrán participar en el sorteo todas las personas mayores de 18 años, de nacionalidad españolas o residentes legales en España.\r\n2.Periodo de participación.\r\nDel 19 de julio al 31 de agosto, ambos incluidos.\r\n3.Modo de participación.\r\nPara participar en el sorteo deben seguir los siguientes pasos:\r\n•	Realizar una compra mínima de 30€ en Cash & Carry Díaz Cadenas Cádiz. Maximo 3 participaciones por persona y dia. \r\n•	Introducir el código que se entrega junto a los datos participantes en https://cashcadiz.com\r\n•	Sabrás instantáneamente si has sido premiado \r\nNo podrán participar en el concurso los trabajadores de Cash&Carry Diaz Cadenas ni Maruja Limón. Podrá participar tantas veces como se quiera.\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"page\" title=\"Page 2\">\r\n<div class=\"layoutArea\">\r\n<div class=\"column\">\r\n\r\n<h3>JURADO Y LA ORGANIZACIÓN</h3>\r\nSe constituirá un jurado, compuesto por representantes de la organización y la gerencia del Cash&Carry Diaz Cadenas.\r\nEl jurado y/o la organización tendrá las potestades, además de las de: Descalificación de los participantes que no cumplan los requisitos exigidos o no cumplan alguna de las normas establecidas.\r\nResolución de cualquier disputa durante el transcurso de la promoción, el sorteo y el disfrute de los premios. Los participantes aceptan y acatan expresamente los criterios e instrucciones que marquen el jurado y/o la organización en general y respecto de cualquier conflicto surgido durante la promoción y el sorteo, sin que los participantes tengan nada que reclamar al respecto.\r\n<h3>DESCALIFICACIÓN</h3>\r\nLa organización y/o el jurado se reservan el derecho de eliminar a cualquier participante en la promoción cuyos datos sean inexactos, no hayan cumplido los requisitos, no se adapten al espíritu de la promoción, atenten contra los usos y buenas costumbres, no acaten las instrucciones recibidas, albergue alguna duda sobre la veracidad de la promoción, o se haya valido de sistemas y/o programas informáticos para participar y mejorar los resultados del mismo, alterando el normal desarrollo del sorteo, o actúe fraudulentamente.\r\nAsimismo, quedarán descalificados aquellos participantes que no cumplan las normas establecidas para la participación, y los que se hallen en los demás supuestos previstos en este documento para ser invalidados.\r\n<h3>LEY DE PROTECCIÓN DE DATOS</h3>\r\nEn cumplimiento de lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de protección de Datos de Carácter Personal (en adelante LOPD), les informamos que los datos de carácter personal que nos sean facilitados se integrarán en un fichero de cuyo tratamiento es responsable Cash&Carry Diaz Cadenas y serán utilizados para la gestión del presente sorteo.\r\nAsimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando una carta a la dirección antes indicada con la referencia “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.\r\n\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"page\" title=\"Page 3\">\r\n<div class=\"layoutArea\">\r\n<div class=\"column\">\r\n\r\n<h3>AUTORIZACIÓN LEGAL</h3>\r\nLos participantes consienten automáticamente al participar en la presente promoción a la utilización, publicación y reproducción sin limitación, por parte de Cash&Carry Diaz Cadenas, de su imagen y nombre en cualquier tipo de publicidad, promoción, publicación, incluido Internet, o cualquier otro medio de la naturaleza que sea, con fines comerciales o informativos siempre que éstos se relacionen con la presente promoción, sin que dicha utilización le confiera derecho de remuneración o beneficio alguno.\r\nAsimismo, el participante acepta el uso de los datos recogidos para la comunicación de futuras promociones de Cash&Carry Diaz Cadenas.\r\n<h3>ACEPTACIÓN DE LAS BASES</h3>\r\nLa participación en la promoción supone la aceptación íntegra de las Bases, la expresa renuncia de los participantes a realizar impugnación alguna sobre las mismas y al ejercicio de cualquier otra acción administrativa o judicial que pudiera corresponderles.\r\nLos participantes y ganadores eximen expresamente a Cash&Carry Diaz Cadenas así como a las empresas promotoras o colaboradoras de la presente promoción de las responsabilidades derivadas del mal funcionamiento de la red de internet, de servidores y de cuantos agentes participen en la difusión de la página Web, o por fuerza mayor o caso fortuito, no teniendo nada que reclamar contra ninguno de los entes antes reseñados.\r\nPara la resolución de cualquier duda sobre la mecánica, los premios o el funcionamiento de la aplicación objeto de la promoción, los usuarios pueden contactar con el Cash&Carry Diaz Cadenas a través del correo electrónico comercial@diazcadenas.com El Cash&Carry Diaz Cadenas se reserva el derecho a modificar, ampliar, suspender, restringir o retirar la presente promoción en cualquier momento, por razones justificadas.\r\n<h3>DISPOSICIÓN DE LAS BASES</h3>\r\nTanto las Bases del Sorteo como los detalles descriptivos de los premios, podrán consultarse en el Cash&Carry Díaz Cadenas.\r\nEn Utrera, a 14 de julio de 2021.\r\n\r\n</div>\r\n</div>\r\n</div>\r\n', NULL, '', 'https://almazaraplaza.com/wp-content/uploads/2025/02/BASES-APP-SAN-VALENTIN-25.pdf', 'https://almazaraplaza.com/politica-de-privacidad/'),
(4, 'Cas&Carry Díaz Cadenas', 'marketin@cashdiazcadena.com', 'smtp.diazcadenas.es', 'marketin@cashdiazcadena.com', 'Maruja2025!', 465, '¡Enhorabuena! Tu regalo ya está aquí', '<p>¡Gracias por tu participación!</p>\r\n<small>Para reclamar tu premio, acércate a nuestro centro junto a tu código ganador.</br>\r\nEs indispensable conservar este correo hasta la entrega del regalo</small>', '¡Gracias por participar en nuestro sorteo!', '<h1>¡Gracias por participar en la promoción!</h1>\r\n<p>Esta vez no has resultado ganador, pero puedes volver a intentarlo</p>\r\n<p>¡Mucha suerte!</p>\r\n		   			\r\n		   				', 'En cumplimiento de lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de protección de Datos de Carácter Personal (en adelante LOPD), les informamos que los datos de carácter personal que nos sean facilitados se integrarán en un fichero de cuyo tratamiento es responsable Cash&carry Diaz Cadenas y serán utilizados para la gestión del presente sorteo.</br></br>\r\n\r\n	Asimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando un correo electrónico a info@cashdiazcadenas.com con el asunto “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.\r\n\r\n	Asimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando un correo electrónico a marketinng@diazcadenas.com con el asunto “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.', 'div class=\"page\" title=\"Page 1\">\r\n<div class=\"layoutArea\">\r\n<div class=\"column\">\r\n\r\nBASES DE LA PROMOCIÓN\r\n\r\n“Hola Puente Genil”\r\n\r\nI.-ORGANIZA\r\n\r\nAlimentación y Bebidas Díaz Cadenas, con CIF: B91146365\r\n\r\nII.OBJETO DE LA PROMOCIÓN\r\n\r\nEl objeto del sorteo es regalar 1 jamón y 1 caja de gambas al día desde el 30 de mayo al 15 de junio en el nuevo centro de Puente Genil.\r\n\r\nIII.PREMIOS\r\n\r\n• 1 jamón al día\r\n\r\n• 1 caja de gambas al día\r\n\r\nEl premio no es canjeable por dinero, no admiten devolución, ni cambio en efectivo, ni cambio de participante, etc.\r\n\r\nSe deberá presentar el cupón ganador y el mail de ganador.\r\n\r\nIV.PROCESO DE PARTICIPACIÓN\r\n\r\n1.Requisitos de participación.\r\n\r\nEl cliente debe realizar una compra sin mínimo en el centro Díaz Cadenas de Puente Genil para que se le entregue la tarjeta de participación.\r\n\r\n2.Periodo de participación.\r\n\r\nDel 30 de mayo al 15 de junio, excepto domingos y festivos\r\n\r\n3.Modo de participación.\r\n\r\nPara participar en el sorteo deben seguir los siguientes pasos:\r\n\r\n• Hacer una compra sin un mínimo\r\n\r\n• Escanear el código QR de la tarjeta de participación.\r\n\r\n• Rellenar el formulario con el código de la tarjeta.\r\n\r\n• Se sabrá al momento si has sido ganador o no.\r\n\r\nJURADO Y LA ORGANIZACIÓN\r\n\r\nSe constituirá un jurado, compuesto por representantes de la organización y la gerencia del Cash&Carry Diaz Cadenas.\r\n\r\nEl jurado y/o la organización tendrá las potestades, además de las de:\r\n\r\nDescalificación de los participantes que no cumplan los requisitos exigidos o no cumplan alguna de las normas establecidas.\r\n\r\nResolución de cualquier disputa durante el transcurso de la promoción, el sorteo y el disfrute de los premios.\r\n\r\nLos participantes aceptan y acatan expresamente los criterios e instrucciones que marquen el jurado y/o la organización en general y respecto de cualquier conflicto surgido durante la promoción y el sorteo, sin que los participantes tengan nada que reclamar al respecto.\r\n\r\nDESCALIFICACIÓN\r\n\r\nLa organización y/o el jurado se reservan el derecho de eliminar a cualquier participante en la promoción cuyos datos sean inexactos, no hayan cumplido los requisitos, no se adapten al espíritu de la promoción, atenten contra los usos y buenas costumbres, no acaten las instrucciones recibidas, albergue alguna duda sobre la veracidad de la promoción, o se haya valido de sistemas y/o programas informáticos para participar y mejorar los resultados del mismo, alterando el normal desarrollo del sorteo, o actúe fraudulentamente. Asimismo, quedarán descalificados aquellos participantes que no cumplan las normas establecidas para la participación, y los que se hallen en los demás supuestos previstos en este documento para ser invalidados.\r\n\r\nLEY DE PROTECCIÓN DE DATOS\r\n\r\nEn cumplimiento de lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de protección de Datos de Carácter Personal (en adelante LOPD), les informamos que los datos de carácter personal que nos sean facilitados se integrarán en un fichero de cuyo tratamiento es responsable Cash&Carry Diaz Cadenas y serán utilizados para la gestión del presente sorteo.\r\n\r\nAsimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando una carta a la dirección antes indicada con la referencia “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.\r\n\r\nAUTORIZACIÓN LEGAL\r\n\r\nLos participantes consienten automáticamente al participar en la presente promoción a la utilización, publicación y reproducción sin limitación, por parte de Cash&Carry Diaz Cadenas, de su imagen y nombre en cualquier tipo de publicidad, promoción, publicación, incluido Internet, o cualquier otro medio de la naturaleza que sea, con fines comerciales o informativos siempre que éstos se relacionen con la presente promoción, sin que dicha utilización le confiera derecho de remuneración o beneficio alguno.\r\n\r\nAsimismo, el participante acepta el uso de los datos recogidos para la comunicación de futuras promociones de Cash&Carry Diaz Cadenas.\r\n\r\nACEPTACIÓN DE LAS BASES\r\n\r\nLa participación en la promoción supone la aceptación íntegra de las Bases, la expresa renuncia de los participantes a realizar impugnación alguna sobre las mismas y al ejercicio de cualquier otra acción administrativa o judicial que pudiera corresponderles.\r\n\r\nLos participantes y ganadores eximen expresamente a Cash&Carry Diaz Cadenas así como a las empresas promotoras o colaboradoras de la presente promoción de las responsabilidades derivadas del mal funcionamiento de la red de internet, de servidores y de cuantos agentes participen en la difusión de la página Web, o por fuerza mayor o caso fortuito, no teniendo nada que reclamar contra ninguno de los entes antes reseñados.\r\n\r\nPara la resolución de cualquier duda sobre la mecánica, los premios o el funcionamiento de la aplicación objeto de la promoción, los usuarios pueden contactar con el Cash&Carry Diaz Cadenas a través del correo electrónico comercial@diazcadenas.com El Cash&Carry Diaz Cadenas se reserva el derecho a modificar, ampliar, suspender, restringir o retirar la presente promoción en cualquier momento, por razones justificadas.\r\n\r\nDISPOSICIÓN DE LAS BASES\r\n\r\nTanto las Bases del Sorteo como los detalles descriptivos de los premios, podrán consultarse en el Cash&Carry Díaz Cadenas.\r\n\r\nEn Utrera, a 27 de mayo de 2024\r\n\r\n</div>\r\n</div>\r\n</div>\r\n', NULL, '', 'https://cashdiazcadenas.com/bases-legales-hola-puente-genil/', 'https://cashdiazcadenas.com/politica-privacidad/'),
(0, 'Nueva', 'nueva@ejemplo.es', 'smtp.nueva.com', 'ejemplo@nueva.com', 'password', 465, '¡Enhorabuena! Tu regalo ya está aquí', '<p>¡Gracias por tu participación!</p>\r\n<small>Para reclamar tu premio, acércate a nuestro centro junto a tu código ganador.</br>\r\nEs indispensable conservar este correo hasta la entrega del regalo</small>', '¡Gracias por participar en nuestro sorteo!', '<h1>¡Gracias por participar en la promoción!</h1>\r\n<p>Esta vez no has resultado ganador, pero puedes volver a intentarlo</p>\r\n<p>¡Mucha suerte!</p>\r\n		   			\r\n		   				', 'En cumplimiento de lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de protección de Datos de Carácter Personal (en adelante LOPD), les informamos que los datos de carácter personal que nos sean facilitados se integrarán en un fichero de cuyo tratamiento es responsable NUEVA y serán utilizados para la gestión del presente sorteo.</br></br>\r\n\r\n	Asimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando un correo electrónico a ********************EJEMPLO@NUEVA.COM *****************con el asunto “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.', '<div class=\"page\" title=\"Page 1\">\r\n<div class=\"layoutArea\">\r\n<div class=\"column\">\r\n\r\nBASES DE LA PROMOCIÓN\r\n************** TITULO DE LA PROMOCION *********************************\r\n<h3>I.-ORGANIZA</h3>\r\n****************** NOMBRE DE LA EMPRESA QUE ORGANIZA **************************\r\n\r\nII.OBJETO DE LA PROMOCIÓN\r\n\r\nEl objeto de la promoción es hacer diferentes regalos ******* CONDICIONES DEL REGALO Y DONDE SE REALIZARÁ *********\r\n<h3>III.PREMIOS</h3>\r\n\r\nLos premios son:\r\n****************+ PREMIOS ***********************************\r\n\r\nEl premio no es canjeable por dinero, no admiten devolución, ni cambio en efectivo, ni cambio de participante, etc.\r\nPara canjear el premio, se deberá de entregar el cupón con el código ganador, el ticket de compra y enseñar el mensaje de código ganador.\r\n<h3>IV.PROCESO DE PARTICIPACIÓN</h3>\r\n1.Requisitos de participación.\r\nPodrán participar en el sorteo todas las personas mayores de 18 años, de nacionalidad españolas o residentes legales en España.\r\n2.Periodo de participación.\r\n************************** PERIODO DE PARTICIPACION *******************************\r\n3.Modo de participación.\r\nPara participar en el sorteo deben seguir los siguientes pasos:\r\n•	******************* CONDICIONES ******************************* \r\n•	\r\n•	\r\nNo podrán participar en el concurso los trabajadores de ************** EMPRESA ORGANIZADORA **************** ni Maruja Limón. \r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"page\" title=\"Page 2\">\r\n<div class=\"layoutArea\">\r\n<div class=\"column\">\r\n\r\n<h3>JURADO Y LA ORGANIZACIÓN</h3>\r\nSe constituirá un jurado, compuesto por representantes de la organización y la gerencia del ************** EMPRESA ++++++++++++++++++\r\nEl jurado y/o la organización tendrá las potestades, además de las de: Descalificación de los participantes que no cumplan los requisitos exigidos o no cumplan alguna de las normas establecidas.\r\nResolución de cualquier disputa durante el transcurso de la promoción, el sorteo y el disfrute de los premios. Los participantes aceptan y acatan expresamente los criterios e instrucciones que marquen el jurado y/o la organización en general y respecto de cualquier conflicto surgido durante la promoción y el sorteo, sin que los participantes tengan nada que reclamar al respecto.\r\n<h3>DESCALIFICACIÓN</h3>\r\nLa organización y/o el jurado se reservan el derecho de eliminar a cualquier participante en la promoción cuyos datos sean inexactos, no hayan cumplido los requisitos, no se adapten al espíritu de la promoción, atenten contra los usos y buenas costumbres, no acaten las instrucciones recibidas, albergue alguna duda sobre la veracidad de la promoción, o se haya valido de sistemas y/o programas informáticos para participar y mejorar los resultados del mismo, alterando el normal desarrollo del sorteo, o actúe fraudulentamente.\r\nAsimismo, quedarán descalificados aquellos participantes que no cumplan las normas establecidas para la participación, y los que se hallen en los demás supuestos previstos en este documento para ser invalidados.\r\n<h3>LEY DE PROTECCIÓN DE DATOS</h3>\r\nEn cumplimiento de lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de protección de Datos de Carácter Personal (en adelante LOPD), les informamos que los datos de carácter personal que nos sean facilitados se integrarán en un fichero de cuyo tratamiento es responsable *************** EMPRESA ORGANIZADORA ************* y serán utilizados para la gestión del presente sorteo.\r\nAsimismo, les comunicamos que podrán, en cualquier momento, ejercitar los derechos de acceso, rectificación, cancelación y oposición, que legalmente les corresponden, con respecto a sus datos de carácter personal, enviando una carta a la dirección antes indicada con la referencia “Protección de Datos”. Leído y conforme, consienten el tratamiento notificado a los efectos de lo establecido en los artículos 5.1, 6.1 y 11.1 de la LOPD y los artículos 20 y 22 de la ley 34/2002, de 11 de julio, de servicios de la sociedad de la información del comercio electrónico.\r\n\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"page\" title=\"Page 3\">\r\n<div class=\"layoutArea\">\r\n<div class=\"column\">\r\n\r\n<h3>AUTORIZACIÓN LEGAL</h3>\r\nLos participantes consienten automáticamente al participar en la presente promoción a la utilización, publicación y reproducción sin limitación, por parte de *************** EMPRESA ORGANIZADORA ************* , de su imagen y nombre en cualquier tipo de publicidad, promoción, publicación, incluido Internet, o cualquier otro medio de la naturaleza que sea, con fines comerciales o informativos siempre que éstos se relacionen con la presente promoción, sin que dicha utilización le confiera derecho de remuneración o beneficio alguno.\r\nAsimismo, el participante acepta el uso de los datos recogidos para la comunicación de futuras promociones de *************** EMPRESA ORGANIZADORA ************* .\r\n<h3>ACEPTACIÓN DE LAS BASES</h3>\r\nLa participación en la promoción supone la aceptación íntegra de las Bases, la expresa renuncia de los participantes a realizar impugnación alguna sobre las mismas y al ejercicio de cualquier otra acción administrativa o judicial que pudiera corresponderles.\r\nLos participantes y ganadores eximen expresamente a *************** EMPRESA ORGANIZADORA *************  así como a las empresas promotoras o colaboradoras de la presente promoción de las responsabilidades derivadas del mal funcionamiento de la red de internet, de servidores y de cuantos agentes participen en la difusión de la página Web, o por fuerza mayor o caso fortuito, no teniendo nada que reclamar contra ninguno de los entes antes reseñados.\r\nPara la resolución de cualquier duda sobre la mecánica, los premios o el funcionamiento de la aplicación objeto de la promoción, los usuarios pueden contactar con el *************** EMPRESA ORGANIZADORA *************  a través del correo electrónico *************** EMAIL EMPRESA ORGANIZADORA *************  El *************** EMPRESA ORGANIZADORA *************  se reserva el derecho a modificar, ampliar, suspender, restringir o retirar la presente promoción en cualquier momento, por razones justificadas.\r\n<h3>DISPOSICIÓN DE LAS BASES</h3>\r\nTanto las Bases del Sorteo como los detalles descriptivos de los premios, podrán consultarse en el *************** EMPRESA ORGANIZADORA ************* .\r\nEn *********** LOCALIDAD ***********, a ***************** FECHA *******************.\r\n\r\n</div>\r\n</div>\r\n</div>\r\n', NULL, '', 'https://ejemplo.es/bases-legales/', 'https://ejemplo.es/politica-de-privacidad/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `momentos`
--

CREATE TABLE `momentos` (
  `id` int(11) NOT NULL,
  `nivel` int(1) NOT NULL,
  `hora` time NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `momentos`
--

INSERT INTO `momentos` (`id`, `nivel`, `hora`, `fecha`) VALUES
(117, 1, '12:30:00', '2025-02-15'),
(118, 2, '12:40:00', '2025-02-15'),
(119, 1, '20:00:00', '2025-02-15'),
(120, 2, '20:00:00', '2025-02-15'),
(121, 1, '20:00:00', '2025-02-15'),
(122, 2, '20:00:00', '2025-02-15'),
(123, 1, '20:00:00', '2025-02-15'),
(124, 2, '20:00:00', '2025-02-15'),
(125, 1, '20:00:00', '2025-02-15'),
(126, 1, '20:00:00', '2025-02-15'),
(127, 1, '20:00:00', '2025-02-15'),
(128, 1, '20:00:00', '2025-02-15'),
(129, 1, '20:00:00', '2025-02-15'),
(130, 1, '20:00:00', '2025-02-15'),
(131, 1, '20:00:00', '2025-02-15'),
(132, 1, '20:00:00', '2025-02-15'),
(133, 1, '20:00:00', '2025-02-15'),
(134, 1, '20:00:00', '2025-02-15'),
(135, 1, '20:00:00', '2025-02-15'),
(136, 1, '20:00:00', '2025-02-15'),
(137, 1, '20:00:00', '2025-02-15'),
(138, 1, '20:00:00', '2025-02-15'),
(139, 1, '20:00:00', '2025-02-15'),
(140, 1, '20:00:00', '2025-02-15'),
(141, 1, '20:00:00', '2025-02-15'),
(142, 1, '20:00:00', '2025-02-15'),
(143, 1, '20:00:00', '2025-02-15'),
(144, 1, '20:00:00', '2025-02-15'),
(145, 1, '20:00:00', '2025-02-15'),
(146, 1, '20:00:00', '2025-02-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes`
--

CREATE TABLE `participantes` (
  `id` int(11) NOT NULL,
  `cod_juego` varchar(10) NOT NULL,
  `cod_canjeo` varchar(10) NOT NULL,
  `premio` varchar(200) NOT NULL,
  `email` varchar(150) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `edad` int(3) NOT NULL,
  `municipio` varchar(50) NOT NULL,
  `cod_postal` int(6) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `fecha_jugada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `canjeado` varchar(2) NOT NULL,
  `estado_mail` varchar(2) NOT NULL,
  `ticket` text DEFAULT NULL,
  `auxiliar1` text DEFAULT NULL,
  `auxiliar2` text DEFAULT NULL,
  `auxiliar3` int(11) DEFAULT NULL,
  `auxiliar4` int(11) DEFAULT NULL,
  `imagen_subida` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premiados`
--

CREATE TABLE `premiados` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `premio` varchar(255) NOT NULL,
  `canjeado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premios`
--

CREATE TABLE `premios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `cantidad` int(5) NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT 1,
  `img` varchar(100) NOT NULL,
  `momento` time DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `id` int(11) NOT NULL,
  `nombrePromo` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `codigo` tinyint(1) DEFAULT NULL,
  `multiParticipacion` tinyint(1) DEFAULT NULL,
  `fin_promo` date DEFAULT NULL,
  `horaAp` time DEFAULT NULL,
  `horaC` time DEFAULT NULL,
  `link` text DEFAULT NULL,
  `campos` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id`, `nombrePromo`, `color`, `codigo`, `multiParticipacion`, `fin_promo`, `horaAp`, `horaC`, `link`, `campos`) VALUES
(0, 'Nueva', '#f91f1f', 0, 0, '2026-02-01', '00:00:00', '23:59:00', '', NULL),
(0, 'Almazara_verano', '#0000ff', 0, 0, '2025-12-30', '00:00:00', '23:59:00', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regalos`
--

CREATE TABLE `regalos` (
  `regalo` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `regalos`
--

INSERT INTO `regalos` (`regalo`, `imagen`, `id`) VALUES
('Jamón', 'jamon.jpg', 1),
('Caja de Gambas', '2.jpg', 2),
('Flor de chocolate', '3.jpg', 3),
('Caja de bombones', '4.jpg', 4),
('Entrada doble Musical 80s 90s', '5.jpg', 5),
('Domino', 'domino.jpg', 9);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `codigos`
--
ALTER TABLE `codigos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `momentos`
--
ALTER TABLE `momentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `premiados`
--
ALTER TABLE `premiados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `premios`
--
ALTER TABLE `premios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `codigos`
--
ALTER TABLE `codigos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `momentos`
--
ALTER TABLE `momentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT de la tabla `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `premiados`
--
ALTER TABLE `premiados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `premios`
--
ALTER TABLE `premios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
