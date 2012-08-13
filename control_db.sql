-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 31-07-2012 a las 16:24:01
-- Versión del servidor: 5.5.24
-- Versión de PHP: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `control_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `access`
--

CREATE TABLE IF NOT EXISTS `access` (
  `name` varchar(150) NOT NULL DEFAULT '',
  `description` text,
  `access` varchar(150) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id_content` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_page` int(10) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(5) NOT NULL DEFAULT '',
  `meta_description` text,
  `meta_keywords` text,
  `title` text,
  `introtext` text,
  `maintext` text,
  `permalink` varchar(255) NOT NULL DEFAULT '',
  `date_last_update` datetime DEFAULT NULL,
  `id_user_last_update` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_content`),
  UNIQUE KEY `permalink` (`permalink`),
  FULLTEXT KEY `search_data` (`meta_description`,`meta_keywords`,`title`,`introtext`,`maintext`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `content`
--

INSERT INTO `content` (`id_content`, `id_page`, `lang`, `meta_description`, `meta_keywords`, `title`, `introtext`, `maintext`, `permalink`, `date_last_update`, `id_user_last_update`) VALUES
(1, 1, 'es', '', '', 'Inicio', '', '', 'inicio_1.html', '2012-07-25 11:37:48', 1),
(2, 2, 'es', '', '', 'QuiÃ©nes Somos', '<p><a href="http://www.g.cm">"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</a></p>\r\n<p><a href="http://www.ggg.gg">"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain..."</a></p>', '<p>It is a long established fact that a reader will be distracted by the \r\nreadable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using ''Content here, content here'', making it \r\nlook like readable English.</p>\r\n<table style="height: 124px;" border="0" width="442">\r\n<tbody>\r\n<tr>\r\n<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th>\r\n</tr>\r\n<tr>\r\n<th>2</th>\r\n<td>q</td>\r\n<td>w</td>\r\n<td>e</td>\r\n<td>r</td>\r\n<td>t</td>\r\n</tr>\r\n<tr>\r\n<th>3</th>\r\n<td>u</td>\r\n<td>i</td>\r\n<td>o</td>\r\n<td>p</td>\r\n<td><br /></td>\r\n</tr>\r\n<tr>\r\n<th>4</th>\r\n<td>a</td>\r\n<td>s</td>\r\n<td>d</td>\r\n<td>f</td>\r\n<td>g</td>\r\n</tr>\r\n<tr>\r\n<th>5</th>\r\n<td>h</td>\r\n<td>j</td>\r\n<td>k</td>\r\n<td>l</td>\r\n<td>Ã±</td>\r\n</tr>\r\n<tr>\r\n<th>6</th>\r\n<td>z</td>\r\n<td>x</td>\r\n<td>c</td>\r\n<td>v</td>\r\n<td>b</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p></p>\r\n<p></p>\r\n<p></p>\r\n<p></p>\r\n<ul>\r\n<li>1</li>\r\n<li>3</li>\r\n<li>5</li>\r\n<li>6</li>\r\n<li>5</li>\r\n<li>2</li>\r\n</ul>\r\n<p></p>\r\n<ol>\r\n<li>4</li>\r\n<li>58</li>\r\n<li>8</li>\r\n<li>5</li>\r\n<li>5</li>\r\n<li>1<br /></li>\r\n</ol>', 'quienes-somos_2.html', '2012-07-31 14:46:12', 1),
(3, 3, 'es', '', '', 'Productos', '', '', 'productos_3.html', '2012-07-30 15:43:57', 1),
(4, 4, 'es', '', '', 'AtenciÃ³n al Cliente', '', '', 'atencion-al-cliente_4.html', '2012-07-25 11:38:22', 1),
(5, 5, 'es', '', '', 'ContÃ¡ctenos', '', '', 'contactenos_5.html', '2012-07-25 11:38:39', 1),
(6, 6, 'es', '', '', 'Producto 1', '', '', 'producto-1_6.html', '2012-07-25 11:39:21', 1),
(7, 7, 'es', '', '', 'slide', '', '', 'slide_7.html', '2012-07-25 12:08:33', 1),
(8, 8, 'es', '', '', 'Videos', '', '', 'videos_8.html', '2012-07-25 12:27:57', 1),
(9, 9, 'es', 'http://www.youtube.com/watch?v=RL2RMemNAqA', '', 'Video1', '', '', 'video1_9.html', '2012-07-25 14:04:50', 1),
(10, 10, 'es', 'http://www.youtube.com/watch?v=RL2RMemNAqA', '', 'Video2', '', '', 'video2_10.html', '2012-07-25 14:07:33', 1),
(11, 11, 'es', '', '', 'Noticias', '', '', 'noticias_11.html', '2012-07-25 13:11:46', 1),
(12, 12, 'es', 'ghg', '', 'Noticia1', '', '<p>ghghghghghghgh</p>', 'noticia1_12.html', '2012-07-30 12:04:15', 1),
(13, 13, 'es', 'mjmj', '', 'Noticia2', '', '<p>..l.lk.jgkj</p>', 'noticia2_13.html', '2012-07-30 12:04:30', 1),
(14, 14, 'es', 'mj,', '', 'Noticia3', '', '<p>thjtyfh</p>', 'noticia3_14.html', '2012-07-30 12:04:48', 1),
(15, 15, 'es', 'tabla', '', 'tabla 1', '', '<table style="height: 124px;" border="0" width="442">\r\n<tbody>\r\n<tr>\r\n<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th>\r\n</tr>\r\n<tr>\r\n<th>2</th>\r\n<td>q</td>\r\n<td>w</td>\r\n<td>e</td>\r\n<td>r</td>\r\n<td>t</td>\r\n</tr>\r\n<tr>\r\n<th>3</th>\r\n<td>u</td>\r\n<td>i</td>\r\n<td>o</td>\r\n<td>p</td>\r\n<td><br /></td>\r\n</tr>\r\n<tr>\r\n<th>4</th>\r\n<td>a</td>\r\n<td>s</td>\r\n<td>d</td>\r\n<td>f</td>\r\n<td>g</td>\r\n</tr>\r\n<tr>\r\n<th>5</th>\r\n<td>h</td>\r\n<td>j</td>\r\n<td>k</td>\r\n<td>l</td>\r\n<td>Ã±</td>\r\n</tr>\r\n<tr>\r\n<th>6</th>\r\n<td>z</td>\r\n<td>x</td>\r\n<td>c</td>\r\n<td>v</td>\r\n<td>b</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p></p>\r\n<p></p>\r\n<p></p>\r\n<p></p>', 'tabla-1_15.html', '2012-07-30 09:36:07', 1),
(16, 16, 'es', 'lista', '', 'Lista 1', '', '<ul>\r\n<li>1</li>\r\n<li>3</li>\r\n<li>5</li>\r\n<li>6</li>\r\n<li>5</li>\r\n<li>2</li>\r\n</ul>\r\n<p></p>\r\n<ol>\r\n<li>4</li>\r\n<li>58</li>\r\n<li>8</li>\r\n<li>5</li>\r\n<li>5</li>\r\n<li>1<br /></li>\r\n</ol>', 'lista-1_16.html', '2012-07-30 09:35:55', 1),
(17, 17, 'es', 'enlace', '', 'Enlace 1', '', '<p><a href="http://www.google.com" target="_blank">http://www.google.com</a></p>\r\n<p><a href="http://www.11111.com">11111111</a></p>', 'enlace-1_17.html', '2012-07-30 11:16:15', 1),
(19, 19, 'es', '', '', 'prueba1', '', '<div class="bl">\r\n<div class="br">\r\n<div class="tl">\r\n<div class="tr"><span class="prodText">\r\n<p><strong><br /></strong></p>\r\n</span></div>\r\n</div>\r\n</div>\r\n</div>', 'prueba1_19.html', '2012-07-31 09:25:09', 1),
(20, 20, 'es', 'caracteristicas', '', 'caracteristicas', '', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type.</p>\r\n<ul>\r\n<li>Lorem Ipsum is simply dummy text of the printing and typesetting</li>\r\n<li>Lorem Ipsum is simply dummy text of</li>\r\n<li>Lorem Ipsum is simply dummy text of</li>\r\n<li>Lorem Ipsum is simply dummy text of</li>\r\n<li>Lorem Ipsum is simply dummy text of</li>\r\n<li>Lorem Ipsum is simply dummy text of the printing and typesetting</li>\r\n<li>Lorem Ipsum is simply dummy text of</li>\r\n<li>Lorem Ipsum is simply dummy text of</li>\r\n<li>Lorem Ipsum is simply dummy text of</li>\r\n<li>Lorem Ipsum is simply dummy text of</li>\r\n</ul>\r\n<ul>\r\n</ul>', 'caracteristicas_20.html', '2012-07-31 09:48:17', 1),
(21, 21, 'es', 'aplicasiones', '', 'aplicasiones', '', '<div style="width: 438px;">\r\n<p style="margin: 0px; font-family: ''Gothic''; font-size: 15px;">27/01/2012</p>\r\n<p style="margin: 0px; font-family: ''Gothic-Bolt''; font-size: 17px;">Aplicador de Etiquetas</p>\r\n<p style="margin: 0px; font-family: ''Gothic''; font-size: 12px;">Lorem\r\n Ipsum is simply dummy text of the printing and industry.Lorem Ipsum \r\nisext ng and industry.Lorem Ipsum is simply dummy text of the printing \r\nand typesetting industry.</p>\r\n</div>', 'aplicasiones_21.html', '2012-07-30 14:31:33', 1),
(22, 22, 'es', 'caracteristicas', '', 'caracteristicas', '', '<div class="bl">\r\n<div class="br">\r\n<div class="tl">\r\n<div class="tr"><span class="prodText">\r\n<p><strong>Fortalece tu \r\nsalud tomando agua de mejor sabor y purezaÂ  natural Fortalece tu salud \r\ntomando agua de mejor sabor y purezaÂ  natural Fortalece tu salud tomando\r\n agua de mejor sabor y purezaÂ  natural Fortalece tu salud tomando agua \r\nde mejor sabor y purezaÂ  natural </strong><strong><br /></strong></p>\r\n</span></div>\r\n</div>\r\n</div>\r\n</div>', 'caracteristicas_22.html', '2012-07-31 09:25:37', 1),
(23, 23, 'es', 'aplicasiones', '', 'aplicasiones', '', '<p>dddddddddddddddddddddddddd</p>', 'aplicasiones_23.html', '2012-07-31 09:26:10', 1),
(24, 24, 'es', 'clientes', '', 'clientes', '', '', 'clientes_24.html', '2012-07-31 12:17:45', 1),
(25, 25, 'es', '', '', 'Mapa del Sitio', '', '', 'mapa-del-sitio_25.html', '2012-07-31 15:06:38', 1),
(26, 26, 'es', '', '', 'PolÃ­tica de Privacidad', '', '', 'politica-de-privacidad_26.html', '2012-07-31 15:36:44', 1),
(27, 27, 'es', '', '', 'TÃ©rminos de Uso', '', '', 'terminos-de-uso_27.html', '2012-07-31 15:36:57', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `extra_page`
--

CREATE TABLE IF NOT EXISTS `extra_page` (
  `id_page` int(10) NOT NULL DEFAULT '0',
  `is_cover` tinyint(1) DEFAULT '0',
  `cover_order` int(10) DEFAULT '0',
  `attached_info` tinyint(1) NOT NULL DEFAULT '0',
  `date_event` datetime DEFAULT NULL,
  PRIMARY KEY (`id_page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id_file` int(10) NOT NULL AUTO_INCREMENT,
  `id_content` int(10) NOT NULL DEFAULT '0',
  `order` int(10) DEFAULT NULL,
  `title` text,
  `description` text,
  `filename` text,
  `type` varchar(20) DEFAULT NULL,
  `tag` text,
  `is_private` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_file`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Volcado de datos para la tabla `file`
--

INSERT INTO `file` (`id_file`, `id_content`, `order`, `title`, `description`, `filename`, `type`, `tag`, `is_private`) VALUES
(1, 7, 1, 'gg', '', 'historia.jpg', 'template_image', '', NULL),
(2, 7, 2, 'ggs', '', 'ingenieria.jpg', 'template_image', '', NULL),
(3, 7, 3, 'ggsd', '', 'ing_industrial.gif', 'template_image', '', NULL),
(4, 9, 1, 'Video1', '', 'youtube.png', 'template_image', '', NULL),
(7, 12, 1, 'Noticia1', '', 'thumbs.png', 'template_image', '', NULL),
(9, 14, 1, 'Noticia3', '', 'ingenieria.jpg', 'template_image', '', NULL),
(11, 2, 1, 'QuiÃ©nes Somos1', '', 'historia.jpg', 'template_image', '', NULL),
(12, 6, 1, 'pruebaV', '', 'historia.jpg', 'template_image', '', NULL),
(13, 6, 2, 'sas', '', 'ing_industrial.gif', 'template_image', '', NULL),
(14, 6, 1, 'pruebaV', '', 'prueba.doc', 'attach', '', NULL),
(15, 19, 1, 'prueba', '', 'ingenieria.jpg', 'template_image', '', NULL),
(16, 24, 1, 'pruebaV', '', 'ingenieria.jpg', 'template_image', '', NULL),
(17, 24, 2, 'clientes', '', 'youtube.png', 'template_image', '', NULL),
(18, 24, 3, 'aplicasiones', '', 'word.jpeg', 'template_image', '', NULL),
(19, 24, 4, 'caracteristicas', '', 'twitter_logo.png', 'template_image', '', NULL),
(24, 6, 3, 'prueba', '', 'pruebaj.doc', 'attach', '', NULL),
(23, 6, 2, 'pruebaV', '', 'fw4.pdf', 'attach', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id_page` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int(10) unsigned NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `extra` text,
  `options` text,
  `order` int(10) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `id_user_creator` int(10) unsigned NOT NULL DEFAULT '0',
  `id_user_last_update` int(10) unsigned NOT NULL DEFAULT '0',
  `date_publication` date DEFAULT NULL,
  `is_group` tinyint(1) DEFAULT NULL,
  `contenido` text NOT NULL,
  `links` text NOT NULL,
  PRIMARY KEY (`id_page`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `page`
--

INSERT INTO `page` (`id_page`, `id_parent`, `date_creation`, `date_last_update`, `extra`, `options`, `order`, `is_published`, `id_user_creator`, `id_user_last_update`, `date_publication`, `is_group`, `contenido`, `links`) VALUES
(1, 0, '2012-07-25 11:37:48', '0000-00-00 00:00:00', '', 'add_page', 1, 1, 1, 0, NULL, NULL, 'contenido', ''),
(2, 0, '2012-07-25 11:37:58', '0000-00-00 00:00:00', '', 'add_page', 2, 1, 1, 0, NULL, NULL, '', ''),
(3, 0, '2012-07-25 11:38:11', '0000-00-00 00:00:00', '', 'add_page', 3, 1, 1, 0, NULL, NULL, '', 'links'),
(4, 0, '2012-07-25 11:38:22', '0000-00-00 00:00:00', '', 'add_page', 4, 1, 1, 0, NULL, NULL, '', ''),
(5, 0, '2012-07-25 11:38:39', '0000-00-00 00:00:00', '', 'add_page', 5, 1, 1, 0, NULL, NULL, '', ''),
(6, 3, '2012-07-25 11:39:21', '0000-00-00 00:00:00', '', 'add_page', 1, 1, 1, 0, NULL, NULL, '', ''),
(7, 1, '2012-07-25 12:08:33', '0000-00-00 00:00:00', '', '', 1, 1, 1, 0, NULL, NULL, 'contenido', ''),
(8, 1, '2012-07-25 12:27:57', '0000-00-00 00:00:00', '', 'add_page', 2, 1, 1, 0, NULL, NULL, '', ''),
(9, 8, '2012-07-25 12:28:49', '0000-00-00 00:00:00', '', '', 1, 1, 1, 0, NULL, NULL, '', ''),
(10, 8, '2012-07-25 12:48:10', '0000-00-00 00:00:00', '', '', 2, 1, 1, 0, NULL, NULL, '', ''),
(11, 1, '2012-07-25 13:11:46', '0000-00-00 00:00:00', '', 'add_page', 3, 1, 1, 0, NULL, NULL, '', ''),
(12, 11, '2012-07-25 13:12:26', '0000-00-00 00:00:00', '', '', 1, 1, 1, 0, NULL, NULL, '', ''),
(13, 11, '2012-07-25 13:12:43', '0000-00-00 00:00:00', '', '', 2, 1, 1, 0, NULL, NULL, '', ''),
(14, 11, '2012-07-25 13:12:56', '0000-00-00 00:00:00', '', '', 3, 1, 1, 0, NULL, NULL, '', ''),
(15, 2, '2012-07-30 09:29:48', '0000-00-00 00:00:00', '', '', 1, 1, 1, 0, NULL, NULL, '', ''),
(16, 2, '2012-07-30 09:35:55', '0000-00-00 00:00:00', '', '', 2, 1, 1, 0, NULL, NULL, '', ''),
(17, 2, '2012-07-30 09:40:42', '0000-00-00 00:00:00', '', '', 3, 1, 1, 0, NULL, NULL, '', ''),
(19, 3, '2012-07-30 13:36:04', '0000-00-00 00:00:00', '', 'add_page', 2, 1, 1, 0, NULL, NULL, '', ''),
(20, 6, '2012-07-30 14:12:01', '0000-00-00 00:00:00', '', '', 1, 1, 1, 0, NULL, NULL, '', ''),
(21, 6, '2012-07-30 14:28:26', '0000-00-00 00:00:00', '', '', 2, 1, 1, 0, NULL, NULL, '', ''),
(22, 19, '2012-07-31 09:25:37', '0000-00-00 00:00:00', '', '', 1, 1, 1, 0, NULL, NULL, '', ''),
(23, 19, '2012-07-31 09:26:10', '0000-00-00 00:00:00', '', '', 2, 1, 1, 0, NULL, NULL, '', ''),
(24, 6, '2012-07-31 12:17:45', '0000-00-00 00:00:00', '', '', 3, 1, 1, 0, NULL, NULL, '', ''),
(25, 1, '2012-07-31 15:06:38', '0000-00-00 00:00:00', '', '', 4, 1, 1, 0, NULL, NULL, '', ''),
(26, 1, '2012-07-31 15:36:44', '0000-00-00 00:00:00', '', '', 5, 1, 1, 0, NULL, NULL, '', ''),
(27, 1, '2012-07-31 15:36:57', '0000-00-00 00:00:00', '', '', 6, 1, 1, 0, NULL, NULL, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id_product` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_product_category` int(10) unsigned NOT NULL DEFAULT '0',
  `title` text NOT NULL,
  `description` text NOT NULL,
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  `available` tinyint(1) DEFAULT NULL,
  `unitary_price` float DEFAULT NULL,
  `thumb_image` text NOT NULL,
  `big_image` text NOT NULL,
  `is_sponsor` tinyint(1) NOT NULL DEFAULT '0',
  `is_private` tinyint(1) DEFAULT NULL,
  `lang` varchar(5) NOT NULL,
  `t_nutricional` text,
  `envase` text,
  `c_envase` text,
  `preparacion` text,
  `ingredientes` text,
  `permalink` varchar(255) NOT NULL,
  PRIMARY KEY (`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_category`
--

CREATE TABLE IF NOT EXISTS `product_category` (
  `id_product_category` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int(10) unsigned NOT NULL DEFAULT '0',
  `title` text NOT NULL,
  `description` text,
  `order` int(10) NOT NULL DEFAULT '0',
  `image` text NOT NULL,
  `permalink` varchar(255) DEFAULT NULL,
  `lang` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_product_category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_file`
--

CREATE TABLE IF NOT EXISTS `product_file` (
  `id_product_file` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(10) unsigned NOT NULL DEFAULT '0',
  `title` text,
  `order` int(10) unsigned DEFAULT NULL,
  `filename` text,
  `type` text,
  `tag` text,
  `is_private` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_product_file`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_acct`
--

CREATE TABLE IF NOT EXISTS `user_acct` (
  `id_user_acct` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `name` text,
  `lastname` text,
  `ci` varchar(15) DEFAULT '',
  `id_type_user_acct` int(10) unsigned DEFAULT '0',
  `email` text,
  `search` text,
  `date_last_login` datetime DEFAULT NULL,
  `date_last_update` datetime DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `active` int(10) unsigned NOT NULL DEFAULT '0',
  `genre` int(10) unsigned NOT NULL DEFAULT '0',
  `login` varchar(150) NOT NULL DEFAULT '',
  `location` text,
  `community` text,
  `mail_format` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_user_acct`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `user_acct`
--

INSERT INTO `user_acct` (`id_user_acct`, `password`, `name`, `lastname`, `ci`, `id_type_user_acct`, `email`, `search`, `date_last_login`, `date_last_update`, `date_creation`, `active`, `genre`, `login`, `location`, `community`, `mail_format`) VALUES
(1, 'iLatina', 'Root', 'Ilatina', '', 5, 'admin@domain.com', 'Inform?tica Latina', '2012-07-30 13:24:38', '2008-07-25 18:21:06', '2006-03-31 15:57:04', 1, 1, 'root', '', '', 0),
(2, 'admin', 'Admin345654', 'Admin', '', 3, 'admin@todoturismo.org', '', '2012-07-25 10:04:21', '2009-01-29 16:54:18', '2007-06-27 10:33:46', 1, 1, 'admin', '', '', 0),
(3, 'adan', 'adan', 'adan', '', 1, 'adan@adan.com', '', '2009-04-09 09:53:09', '2009-01-20 12:58:53', '2009-01-20 12:58:53', 1, 1, 'adan', '', '', 0),
(4, '', 'kjl', 'kj', '', 1, 'nano_sis@hotmail.com', '', NULL, '2009-01-29 11:46:44', '2009-01-29 11:43:39', 1, 1, '', '', '', 0),
(5, '', '', '', '', 1, '', '', NULL, '2009-01-29 12:25:21', '2009-01-29 12:25:21', 1, 1, '1', '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_acct_access`
--

CREATE TABLE IF NOT EXISTS `user_acct_access` (
  `login` varchar(150) NOT NULL DEFAULT '',
  `access` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`login`,`access`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_acct_access`
--

INSERT INTO `user_acct_access` (`login`, `access`) VALUES
('', 'page_admin'),
('', 'user_admin'),
('1', 'page_admin'),
('1', 'user_admin'),
('adan', 'page_admin'),
('adan', 'user_admin'),
('admin', 'page_admin'),
('admin', 'user_admin'),
('romero1', 'page_admin'),
('romero1', 'user_admin'),
('root', 'page_admin'),
('root', 'user_admin');

