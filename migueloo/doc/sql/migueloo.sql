# phpMyAdmin MySQL-Dump
# version 2.5.1
# http://www.phpmyadmin.net/ (download page)
#
# Servidor: localhost
# Tiempo de generación: 13-06-2004 a las 12:51:08
# Versión del servidor: 4.0.18
# Versión de PHP: 4.3.4
# Base de datos : `migueloo_desa`
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `area`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `AREA_ID` int(11) NOT NULL auto_increment,
  `DEPARTMENT_ID` int(11) NOT NULL default '0',
  `FACULTY_ID` int(11) NOT NULL default '0',
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `AREA_NAME` char(70) NOT NULL default '',
  `AREA_DESCRIPTION` char(100) NOT NULL default '',
  `AREA_RESPONSABLE` char(80) NOT NULL default '',
  `AREA_ADDRESS` char(100) NOT NULL default '',
  `AREA_URL` char(30) NOT NULL default '',
  `AREA_MAIL` char(30) NOT NULL default '',
  PRIMARY KEY  (`AREA_ID`,`DEPARTMENT_ID`,`FACULTY_ID`,`INSTITUTION_ID`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

#
# Volcar la base de datos para la tabla `area`
#

INSERT INTO `area` (`AREA_ID`, `DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `AREA_NAME`, `AREA_DESCRIPTION`, `AREA_RESPONSABLE`, `AREA_ADDRESS`, `AREA_URL`, `AREA_MAIL`) VALUES (1, 1, 1, 1, 'Específica Electrónica', 'Continua', '', '', '', '');
INSERT INTO `area` (`AREA_ID`, `DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `AREA_NAME`, `AREA_DESCRIPTION`, `AREA_RESPONSABLE`, `AREA_ADDRESS`, `AREA_URL`, `AREA_MAIL`) VALUES (2, 2, 2, 1, 'Fisioterapia', 'Mantenimiento físico', '', '', '', '');
INSERT INTO `area` (`AREA_ID`, `DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `AREA_NAME`, `AREA_DESCRIPTION`, `AREA_RESPONSABLE`, `AREA_ADDRESS`, `AREA_URL`, `AREA_MAIL`) VALUES (3, 3, 0, 2, 'Programación', 'Cursines de Programación', 'El dire', '', '', '');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `area_course`
#
# Creación: 21-05-2004 a las 23:57:22
# Última actualización: 22-05-2004 a las 00:09:34
#

DROP TABLE IF EXISTS `area_course`;
CREATE TABLE `area_course` (
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `FACULTY_ID` int(11) NOT NULL default '0',
  `DEPARTMENT_ID` int(11) NOT NULL default '0',
  `AREA_ID` int(11) NOT NULL default '0',
  `COURSE_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`INSTITUTION_ID`,`FACULTY_ID`,`DEPARTMENT_ID`,`AREA_ID`,`COURSE_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `area_course`
#

INSERT INTO `area_course` (`INSTITUTION_ID`, `FACULTY_ID`, `DEPARTMENT_ID`, `AREA_ID`, `COURSE_ID`) VALUES (1, 1, 1, 1, 4);
INSERT INTO `area_course` (`INSTITUTION_ID`, `FACULTY_ID`, `DEPARTMENT_ID`, `AREA_ID`, `COURSE_ID`) VALUES (1, 2, 2, 2, 6);
INSERT INTO `area_course` (`INSTITUTION_ID`, `FACULTY_ID`, `DEPARTMENT_ID`, `AREA_ID`, `COURSE_ID`) VALUES (2, 0, 3, 3, 5);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `book`
#
# Creación: 08-06-2004 a las 22:33:49
# Última actualización: 08-06-2004 a las 22:33:49
#

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `IDBOOK` int(11) NOT NULL auto_increment,
  `AUTHOR` varchar(100) NOT NULL default '',
  `TITLE` varchar(100) NOT NULL default '',
  `PUBLISHDATE` date default '0000-00-00',
  `EDITORIAL` varchar(100) default '',
  `PUBLISHPLACE` varchar(100) default '',
  `DESCRIPTION` text NOT NULL,
  `CONTENT` text,
  `HOWOBTAINIT` varchar(100) default '',
  PRIMARY KEY  (`IDBOOK`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `book`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `bookcomment`
#
# Creación: 08-06-2004 a las 22:33:49
# Última actualización: 08-06-2004 a las 22:33:49
#

DROP TABLE IF EXISTS `bookcomment`;
CREATE TABLE `bookcomment` (
  `IDBOOKCOMMENT` int(11) NOT NULL auto_increment,
  `IDBOOK` int(11) NOT NULL default '0',
  `USER_ID` int(11) NOT NULL default '0',
  `DESCRIPTION` text NOT NULL,
  `VALUE` int(11) NOT NULL default '0',
  PRIMARY KEY  (`IDBOOKCOMMENT`,`IDBOOK`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `bookcomment`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `calendar`
#
# Creación: 06-06-2004 a las 12:22:51
# Última actualización: 06-06-2004 a las 16:44:15
#

DROP TABLE IF EXISTS `calendar`;
CREATE TABLE `calendar` (
  `CALENDAR_ID` int(11) NOT NULL auto_increment,
  `COURSE_ID` int(11) NOT NULL default '0',
  `EVENT_TYPE_ID` int(11) NOT NULL default '0',
  `TITLE` char(30) NOT NULL default '',
  `DESCRIPTION` char(255) NOT NULL default '',
  `DATE_START` datetime NOT NULL default '0000-00-00 00:00:00',
  `DATE_END` datetime NOT NULL default '0000-00-00 00:00:00',
  `ALL_DAY` tinyint(1) NOT NULL default '0',
  `AUD_TIME` datetime default NULL,
  `AUD_USER_ID` int(11) unsigned default NULL,
  PRIMARY KEY  (`CALENDAR_ID`,`COURSE_ID`),
  KEY `CALENDAR_ID` (`CALENDAR_ID`)
) TYPE=MyISAM AUTO_INCREMENT=19 ;

#
# Volcar la base de datos para la tabla `calendar`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `candidate`
#
# Creación: 08-06-2004 a las 22:33:49
# Última actualización: 08-06-2004 a las 23:00:50
#

DROP TABLE IF EXISTS `candidate`;
CREATE TABLE `candidate` (
  `PERSON_ID` int(11) NOT NULL auto_increment,
  `PERSON_NAME` char(30) NOT NULL default '',
  `PERSON_SURNAME` char(50) NOT NULL default '',
  `TREATMENT_ID` tinyint(4) NOT NULL default '0',
  `DNI` char(9) NOT NULL default '',
  `BIRTHDAY` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`PERSON_ID`),
  KEY `TREATMENT_ID` (`TREATMENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `candidate`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `candidate_data`
#
# Creación: 08-06-2004 a las 22:34:11
# Última actualización: 08-06-2004 a las 23:00:50
#

DROP TABLE IF EXISTS `candidate_data`;
CREATE TABLE `candidate_data` (
  `person_id` int(11) NOT NULL default '0',
  `street` varchar(150) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `council` varchar(50) NOT NULL default '',
  `country` varchar(50) NOT NULL default '',
  `postalcode` varchar(5) NOT NULL default '',
  `phone` varchar(20) NOT NULL default '',
  `fax` varchar(20) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `jabber` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`person_id`,`person_id`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `candidate_data`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `contact`
#
# Creación: 26-05-2004 a las 23:34:03
# Última actualización: 27-05-2004 a las 00:29:49
#

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `CONTACT_ID` int(11) NOT NULL auto_increment,
  `USER_ID` int(11) NOT NULL default '0',
  `CONTACT_NAME` char(30) NOT NULL default '',
  `CONTACT_SURNAME` char(50) NOT NULL default '',
  `CONTACT_NICK` char(30) NOT NULL default '',
  `CONTACT_MAIL` char(20) NOT NULL default '',
  `CONTACT_JABBER` char(20) NOT NULL default '',
  `CONTACT_COMMENTS` char(255) NOT NULL default '',
  `IS_FROM_MIGUEL` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`CONTACT_ID`,`USER_ID`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;

#
# Volcar la base de datos para la tabla `contact`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course`
#
# Creación: 20-05-2004 a las 00:32:57
# Última actualización: 02-06-2004 a las 22:31:02
#

DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `COURSE_ID` int(11) NOT NULL auto_increment,
  `COURSE_NAME` char(70) NOT NULL default '',
  `COURSE_DESCRIPTION` char(100) NOT NULL default '',
  `COURSE_LANGUAGE` char(5) NOT NULL default '',
  `COURSE_ACCESS` tinyint(4) NOT NULL default '0',
  `COURSE_ACTIVE` tinyint(1) NOT NULL default '0',
  `USER_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`COURSE_ID`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

#
# Volcar la base de datos para la tabla `course`
#

INSERT INTO `course` (`COURSE_ID`, `COURSE_NAME`, `COURSE_DESCRIPTION`, `COURSE_LANGUAGE`, `COURSE_ACCESS`, `COURSE_ACTIVE`, `USER_ID`) VALUES (4, 'miguel_courseDescriptionName', 'miguel_courseDescriptionExamplemás texto', 'es_ES', 1, 1, 1);
INSERT INTO `course` (`COURSE_ID`, `COURSE_NAME`, `COURSE_DESCRIPTION`, `COURSE_LANGUAGE`, `COURSE_ACCESS`, `COURSE_ACTIVE`, `USER_ID`) VALUES (5, 'Fisioterapia básica', 'Introducción al uso de las manos en los problemas musculares leves.', 'es_ES', 1, 0, 8);
INSERT INTO `course` (`COURSE_ID`, `COURSE_NAME`, `COURSE_DESCRIPTION`, `COURSE_LANGUAGE`, `COURSE_ACCESS`, `COURSE_ACTIVE`, `USER_ID`) VALUES (6, 'Andromeda en miguelOO', 'Introducción al framework de miguelOO.MVC.API.', 'es_ES', 1, 0, 8);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course_visual`
#
# Creación: 30-05-2004 a las 15:48:55
# Última actualización: 06-06-2004 a las 16:50:22
#

DROP TABLE IF EXISTS `course_visual`;
CREATE TABLE `course_visual` (
  `course_id` int(11) NOT NULL default '0',
  `item_id` int(11) NOT NULL default '0',
  `visible` char(1) NOT NULL default '',
  `admin` char(1) NOT NULL default '',
  PRIMARY KEY  (`course_id`,`item_id`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `course_visual`
#

INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 1, '0', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 2, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 3, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 4, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 5, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 6, '0', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 7, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 8, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 9, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 10, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 11, '1', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 12, '1', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 13, '1', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 14, '0', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 15, '1', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 16, '1', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 17, '1', '1');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course_visual_item`
#
# Creación: 30-05-2004 a las 15:50:54
# Última actualización: 06-06-2004 a las 16:49:46
#

DROP TABLE IF EXISTS `course_visual_item`;
CREATE TABLE `course_visual_item` (
  `item_id` int(11) NOT NULL auto_increment,
  `label` varchar(20) NOT NULL default '',
  `link` varchar(45) NOT NULL default '',
  `param` varchar(45) NOT NULL default '',
  `image` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`item_id`)
) TYPE=MyISAM AUTO_INCREMENT=18 ;

#
# Volcar la base de datos para la tabla `course_visual_item`
#

INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (1, 'miguel_courseAE', 'calendar', 'status=list', 'agenda');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (2, 'miguel_courseER', 'links', '', 'links');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (3, 'miguel_courseDoc', '', '', 'coursedocuments');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (4, 'miguel_courseTU', '', '', 'works');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (5, 'miguel_courseTA', 'notice', 'status=list', 'announces');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (6, 'miguel_courseMC', '', '', 'listusers');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (7, 'miguel_courseFC', '', '', 'forum');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (8, 'miguel_courseEjer', '', '', 'tests');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (9, 'miguel_courseGT', '', '', 'group');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (10, 'miguel_courseDesc', '', '', 'info');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (11, 'miguel_courseEstat', '', '', 'stats');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (12, 'miguel_courseNP', '', '', 'addmodule');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (13, 'miguel_courseNE', '', '', 'addpage');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (14, 'miguel_courseModInfo', '', '', 'editinfocourse');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (15, 'miguel_courseDelC', '', '', 'delcourse');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (16, 'miguel_courseNTA', 'notice', 'status=new', 'announces');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (17, 'miguel_courseNAE', 'calendar', 'status=new', 'agenda');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `department`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `DEPARTMENT_ID` int(11) NOT NULL auto_increment,
  `FACULTY_ID` int(11) NOT NULL default '0',
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `DEPARTMENT_PARENT_ID` int(11) NOT NULL default '0',
  `DEPARTMENT_NAME` char(70) NOT NULL default '',
  `DEPARTMENT_DESCRIPTION` char(100) NOT NULL default '',
  `DEPARTMENT_RESPONSABLE` char(80) NOT NULL default '',
  `DEPARTMENT_ADDRESS` char(100) NOT NULL default '',
  `DEPARMENT_URL` char(30) NOT NULL default '',
  `DEPARTMENT_MAIL` char(30) NOT NULL default '',
  PRIMARY KEY  (`DEPARTMENT_ID`,`INSTITUTION_ID`,`FACULTY_ID`),
  KEY `DEPARTMENT_PARENT_ID` (`DEPARTMENT_PARENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

#
# Volcar la base de datos para la tabla `department`
#

INSERT INTO `department` (`DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `DEPARTMENT_PARENT_ID`, `DEPARTMENT_NAME`, `DEPARTMENT_DESCRIPTION`, `DEPARTMENT_RESPONSABLE`, `DEPARTMENT_ADDRESS`, `DEPARMENT_URL`, `DEPARTMENT_MAIL`) VALUES (1, 1, 1, 0, 'Departamento Electrónica', 'Ingeniería Electrónica', 'El elestricista', '', '', '');
INSERT INTO `department` (`DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `DEPARTMENT_PARENT_ID`, `DEPARTMENT_NAME`, `DEPARTMENT_DESCRIPTION`, `DEPARTMENT_RESPONSABLE`, `DEPARTMENT_ADDRESS`, `DEPARMENT_URL`, `DEPARTMENT_MAIL`) VALUES (2, 2, 1, 0, 'Enfermería', 'Enfermería elemental', 'Sta. Desconocida', '', '', '');
INSERT INTO `department` (`DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `DEPARTMENT_PARENT_ID`, `DEPARTMENT_NAME`, `DEPARTMENT_DESCRIPTION`, `DEPARTMENT_RESPONSABLE`, `DEPARTMENT_ADDRESS`, `DEPARMENT_URL`, `DEPARTMENT_MAIL`) VALUES (3, 0, 2, 0, 'Pruebas', 'Probando', '', '', '', '');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `document`
#
# Creación: 06-06-2004 a las 23:12:40
# Última actualización: 06-06-2004 a las 23:12:40
#

DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `id` int(4) NOT NULL auto_increment,
  `course_id` int(11) NOT NULL default '0',
  `path` varchar(255) NOT NULL default '',
  `visibility` char(1) NOT NULL default 'v',
  `comment` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Volcar la base de datos para la tabla `document`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `event_type`
#
# Creación: 05-06-2004 a las 13:50:14
# Última actualización: 05-06-2004 a las 13:51:52
#

DROP TABLE IF EXISTS `event_type`;
CREATE TABLE `event_type` (
  `EVENT_TYPE_ID` int(11) NOT NULL auto_increment,
  `EVENT_TYPE_DESCRIPTION` char(30) NOT NULL default '',
  PRIMARY KEY  (`EVENT_TYPE_ID`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

#
# Volcar la base de datos para la tabla `event_type`
#

INSERT INTO `event_type` (`EVENT_TYPE_ID`, `EVENT_TYPE_DESCRIPTION`) VALUES (1, 'Inicio Curso');
INSERT INTO `event_type` (`EVENT_TYPE_ID`, `EVENT_TYPE_DESCRIPTION`) VALUES (2, 'Clase presencial');
INSERT INTO `event_type` (`EVENT_TYPE_ID`, `EVENT_TYPE_DESCRIPTION`) VALUES (3, 'Fin de curso');
INSERT INTO `event_type` (`EVENT_TYPE_ID`, `EVENT_TYPE_DESCRIPTION`) VALUES (4, 'Otros');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `exercise_question`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `exercise_question`;
CREATE TABLE `exercise_question` (
  `EXERCICE_ID` int(11) NOT NULL default '0',
  `QUESTION_ID` int(11) NOT NULL default '0',
  `EQ_POSITION` tinyint(4) NOT NULL default '0',
  `EQ_WEIGHT` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`QUESTION_ID`,`EXERCICE_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `exercise_question`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `faculty`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE `faculty` (
  `FACULTY_ID` int(11) NOT NULL auto_increment,
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `FACULTY_NAME` char(70) NOT NULL default '',
  `FACULTY_DESCRIPTION` char(100) NOT NULL default '',
  `FACULTY_RESPONSABLE` char(80) NOT NULL default '',
  `FACULTY_ADDRESS` char(100) NOT NULL default '',
  `FACULTY_URL` char(30) NOT NULL default '',
  `FACULTY_MAIL` char(30) NOT NULL default '',
  PRIMARY KEY  (`FACULTY_ID`,`INSTITUTION_ID`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Volcar la base de datos para la tabla `faculty`
#

INSERT INTO `faculty` (`FACULTY_ID`, `INSTITUTION_ID`, `FACULTY_NAME`, `FACULTY_DESCRIPTION`, `FACULTY_RESPONSABLE`, `FACULTY_ADDRESS`, `FACULTY_URL`, `FACULTY_MAIL`) VALUES (1, 1, 'Facultad de Ciencias', 'Puteamos a los estudiantes', 'Catedrático chungo', 'EPS', 'http://www.eps.ujaen.es', 'eps@ujaen.es');
INSERT INTO `faculty` (`FACULTY_ID`, `INSTITUTION_ID`, `FACULTY_NAME`, `FACULTY_DESCRIPTION`, `FACULTY_RESPONSABLE`, `FACULTY_ADDRESS`, `FACULTY_URL`, `FACULTY_MAIL`) VALUES (2, 1, 'Facultad de Medicina', 'Mata sanos y enfermeras', 'Catedrático muy malo', 'Hopital Salvese quien pueda', '', '');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `forum`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `forum`;
CREATE TABLE `forum` (
  `FORUM_ID` int(11) NOT NULL auto_increment,
  `FORUM_NAME` char(30) NOT NULL default '',
  `FORUM_DESCRIPTION` char(100) NOT NULL default '',
  `FORUM_MODERATOR` int(1) NOT NULL default '0',
  `FORUM_ACCESS` tinyint(4) NOT NULL default '0',
  `FORUM_CAT_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`FORUM_ID`),
  KEY `FORUM_CAT_ID` (`FORUM_CAT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `forum`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `forum_category`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `forum_category`;
CREATE TABLE `forum_category` (
  `FORUM_CATEGORY_ID` int(11) NOT NULL auto_increment,
  `FORUM_CATEGORY_DESCRIPTION` char(255) NOT NULL default '',
  `COURSE_ID` int(11) NOT NULL default '0',
  `GROUP_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`FORUM_CATEGORY_ID`),
  KEY `COURSE_ID` (`COURSE_ID`),
  KEY `GROUP_ID` (`GROUP_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `forum_category`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `forum_post`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `forum_post`;
CREATE TABLE `forum_post` (
  `FORUM_POST_ID` int(11) NOT NULL auto_increment,
  `FORUM_TOPIC_ID` int(11) NOT NULL default '0',
  `FORUM_ID` int(11) NOT NULL default '0',
  `FORUM_POST_TEXT` char(255) NOT NULL default '',
  `FORUM_POST_POSTER` int(11) NOT NULL default '0',
  `FORUM_POST_TIME` date NOT NULL default '0000-00-00',
  `FORUM_POST_IP` char(15) NOT NULL default '',
  PRIMARY KEY  (`FORUM_POST_ID`),
  KEY `FORUM_TOPIC_ID` (`FORUM_TOPIC_ID`),
  KEY `FORUM_ID` (`FORUM_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `forum_post`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `forum_topic`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `forum_topic`;
CREATE TABLE `forum_topic` (
  `FORUM_TOPIC_ID` int(11) NOT NULL auto_increment,
  `FORUM_TOPIC_TITLE` char(30) NOT NULL default '',
  `FORUM_TOPIC_NUMVIEW` int(11) NOT NULL default '0',
  `FORUM_TOPIC_REPLIES` int(11) NOT NULL default '0',
  `FORUM_TOPIC_NOTIFY` tinyint(1) NOT NULL default '0',
  `FORUM_TOPIC_STATUS` tinyint(4) NOT NULL default '0',
  `FORUM_TOPIC_POSTER` int(11) NOT NULL default '0',
  `FORUM_TOPIC_DATE` date NOT NULL default '0000-00-00',
  `FORUM_ID` int(11) NOT NULL default '0',
  `NUMBER_OF_VISITS` int(11) NOT NULL default '0',
  `NUMBER_OF_POSTS` tinyint(4) NOT NULL default '0',
  `LAST_POST_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`FORUM_TOPIC_ID`,`FORUM_ID`),
  KEY `LAST_POST_ID` (`LAST_POST_ID`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `forum_topic`
#


# --------------------------------------------------------

#
# Estructura de tabla para la tabla `institution`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `institution`;
CREATE TABLE `institution` (
  `INSTITUTION_ID` int(11) NOT NULL auto_increment,
  `INSTITUTION_HASH_ID` char(40) NOT NULL default '',
  `INSTITUTION_NAME` char(70) NOT NULL default '',
  `INSTITUTION_DESCRIPTION` char(100) NOT NULL default '',
  `INSTITUTION_RESPONSABLE` char(80) NOT NULL default '',
  `INSTITUTION_PHONE` char(12) NOT NULL default '',
  `INSTITUTION_URL` char(30) NOT NULL default '',
  `INSTITUTION_MAIL` char(20) NOT NULL default '',
  `INSTITUTION_ADDRESS` char(100) NOT NULL default '',
  `INSTITUTION_THEME` char(20) NOT NULL default '',
  `INSTITUTION_LANGUAGE` char(5) NOT NULL default '',
  `INSTITUTION_FORUM_TYPE_BB` tinyint(1) NOT NULL default '0',
  `INSTITUTION_MAIN_PAGE_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`INSTITUTION_ID`),
  KEY `INSTITUTION_MAIN_PAGE_ID` (`INSTITUTION_MAIN_PAGE_ID`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Volcar la base de datos para la tabla `institution`
#

INSERT INTO `institution` (`INSTITUTION_ID`, `INSTITUTION_HASH_ID`, `INSTITUTION_NAME`, `INSTITUTION_DESCRIPTION`, `INSTITUTION_RESPONSABLE`, `INSTITUTION_PHONE`, `INSTITUTION_URL`, `INSTITUTION_MAIL`, `INSTITUTION_ADDRESS`, `INSTITUTION_THEME`, `INSTITUTION_LANGUAGE`, `INSTITUTION_FORUM_TYPE_BB`, `INSTITUTION_MAIN_PAGE_ID`) VALUES (1, '', 'Universidad de Jaén', 'Es una Universidad mu bonica', 'Antonio', '123456789', 'http://www.ujaen.es', 'virtual@ujaen.es', 'Jaén', 'NORMAL', 'ES_ES', 0, 0);
INSERT INTO `institution` (`INSTITUTION_ID`, `INSTITUTION_HASH_ID`, `INSTITUTION_NAME`, `INSTITUTION_DESCRIPTION`, `INSTITUTION_RESPONSABLE`, `INSTITUTION_PHONE`, `INSTITUTION_URL`, `INSTITUTION_MAIL`, `INSTITUTION_ADDRESS`, `INSTITUTION_THEME`, `INSTITUTION_LANGUAGE`, `INSTITUTION_FORUM_TYPE_BB`, `INSTITUTION_MAIN_PAGE_ID`) VALUES (2, '', 'Academia CSET', 'Academia la más bonica', 'Antonio', '123456789', 'http://www.cset.com', 'formacion@cset.com', 'Martos', 'NORMAL', 'ES_ES', 0, 0);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `loginout`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 13-06-2004 a las 12:48:49
#

DROP TABLE IF EXISTS `loginout`;
CREATE TABLE `loginout` (
  `idLog` mediumint(9) unsigned NOT NULL auto_increment,
  `id_user` mediumint(9) unsigned NOT NULL default '0',
  `ip` char(16) NOT NULL default '0.0.0.0',
  `log_when` datetime NOT NULL default '0000-00-00 00:00:00',
  `log_action` enum('LOGIN','LOGOUT') NOT NULL default 'LOGIN',
  PRIMARY KEY  (`idLog`)
) TYPE=MyISAM AUTO_INCREMENT=460 ;

#
# Volcar la base de datos para la tabla `loginout`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `message`
#
# Creación: 01-06-2004 a las 22:45:26
# Última actualización: 02-06-2004 a las 00:17:38
#

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `sender` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `body` mediumtext NOT NULL,
  `subject` text NOT NULL,
  `date` datetime NOT NULL default '2000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=14 ;

#
# Volcar la base de datos para la tabla `message`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `notice`
#
# Creación: 01-06-2004 a las 23:54:53
# Última actualización: 04-06-2004 a las 19:50:16
#

DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `notice_id` int(11) NOT NULL auto_increment,
  `author` varchar(50) NOT NULL default '',
  `subject` varchar(50) NOT NULL default '',
  `text` mediumtext NOT NULL,
  `time` datetime default NULL,
  PRIMARY KEY  (`notice_id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Volcar la base de datos para la tabla `notice`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `person`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 08-06-2004 a las 23:00:50
#

DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `PERSON_ID` int(11) NOT NULL auto_increment,
  `PERSON_JABBER` char(20) NOT NULL default '',
  `PERSON_NAME` char(30) NOT NULL default '',
  `PERSON_SURNAME` char(50) NOT NULL default '',
  `TREATMENT_ID` tinyint(4) NOT NULL default '0',
  `CARGO` char(10) NOT NULL default '',
  PRIMARY KEY  (`PERSON_ID`),
  KEY `TREATMENT_ID` (`TREATMENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=13 ;

#
# Volcar la base de datos para la tabla `person`
#

INSERT INTO `person` (`PERSON_ID`, `PERSON_JABBER`, `PERSON_NAME`, `PERSON_SURNAME`, `TREATMENT_ID`, `CARGO`) VALUES (1, '', 'Invitado', '', 1, '');
INSERT INTO `person` (`PERSON_ID`, `PERSON_JABBER`, `PERSON_NAME`, `PERSON_SURNAME`, `TREATMENT_ID`, `CARGO`) VALUES (2, 'antoniofcano', 'Antonio Francisco', 'Cano Damas', 2, 'Jefe Proy.');
INSERT INTO `person` (`PERSON_ID`, `PERSON_JABBER`, `PERSON_NAME`, `PERSON_SURNAME`, `TREATMENT_ID`, `CARGO`) VALUES (3, '', 'Administrador', '(Cambiar)', 2, 'admin');
INSERT INTO `person` (`PERSON_ID`, `PERSON_JABBER`, `PERSON_NAME`, `PERSON_SURNAME`, `TREATMENT_ID`, `CARGO`) VALUES (8, 'none', 'Pantuflo', 'Zapatilla', 4, 'none');
INSERT INTO `person` (`PERSON_ID`, `PERSON_JABBER`, `PERSON_NAME`, `PERSON_SURNAME`, `TREATMENT_ID`, `CARGO`) VALUES (9, 'none', 'Sherlock', 'Holmes', 4, 'none');
INSERT INTO `person` (`PERSON_ID`, `PERSON_JABBER`, `PERSON_NAME`, `PERSON_SURNAME`, `TREATMENT_ID`, `CARGO`) VALUES (10, 'none', 'Annibal', 'Lecter', 4, 'none');
INSERT INTO `person` (`PERSON_ID`, `PERSON_JABBER`, `PERSON_NAME`, `PERSON_SURNAME`, `TREATMENT_ID`, `CARGO`) VALUES (11, '', 'Tom', 'Builder', 4, '');
INSERT INTO `person` (`PERSON_ID`, `PERSON_JABBER`, `PERSON_NAME`, `PERSON_SURNAME`, `TREATMENT_ID`, `CARGO`) VALUES (12, '', 'Tom', 'Builder', 4, '');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `person_data`
#
# Creación: 08-06-2004 a las 22:35:56
# Última actualización: 08-06-2004 a las 23:00:50
#

DROP TABLE IF EXISTS `person_data`;
CREATE TABLE `person_data` (
  `person_id` int(11) NOT NULL auto_increment,
  `street` varchar(150) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `council` varchar(50) NOT NULL default '',
  `country` varchar(50) NOT NULL default '',
  `postalcode` varchar(5) NOT NULL default '',
  `phone` varchar(20) NOT NULL default '',
  `fax` varchar(20) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `jabber` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`person_id`)
) TYPE=MyISAM AUTO_INCREMENT=13 ;

#
# Volcar la base de datos para la tabla `person_data`
#

INSERT INTO `person_data` (`person_id`, `street`, `city`, `council`, `country`, `postalcode`, `phone`, `fax`, `email`, `jabber`) VALUES (12, 'Bajada de la Cañada grande, s/n', 'Wedmister', 'New London', 'England', '00000', '9997854568', '', 'desco@sin.ip', 'none');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `profile`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `ID_PROFILE` tinyint(4) NOT NULL auto_increment,
  `PROFILE_DESCRIPTION` char(20) NOT NULL default '',
  PRIMARY KEY  (`ID_PROFILE`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

#
# Volcar la base de datos para la tabla `profile`
#

INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`) VALUES (1, 'Administrador');
INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`) VALUES (2, 'Tutor');
INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`) VALUES (3, 'Profesor');
INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`) VALUES (4, 'Alumno');
INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`) VALUES (5, 'Secretaria');
INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`) VALUES (6, 'Visitante');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `receiver_message`
#
# Creación: 01-06-2004 a las 22:45:51
# Última actualización: 02-06-2004 a las 00:18:51
#

DROP TABLE IF EXISTS `receiver_message`;
CREATE TABLE `receiver_message` (
  `id_receiver` int(11) NOT NULL default '0',
  `id_message` int(11) NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id_receiver`,`id_message`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `receiver_message`
#


# --------------------------------------------------------

#
# Estructura de tabla para la tabla `suggestion`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `suggestion`;
CREATE TABLE `suggestion` (
  `SUGGESTION_ID` int(11) NOT NULL auto_increment,
  `SUGGESTION_DESCRIPTION` char(255) NOT NULL default '',
  `SUGGESTION_READ` tinyint(1) NOT NULL default '0',
  `SUGGESTION_DATE_SENT` date NOT NULL default '0000-00-00',
  `SUGGESTION_PRIORITY` tinyint(4) NOT NULL default '0',
  `USER_ID` int(11) NOT NULL default '0',
  `SUGGESTION_NAME` char(255) NOT NULL default '',
  `SUGGESTION_EMAIL` char(255) NOT NULL default '',
  PRIMARY KEY  (`SUGGESTION_ID`),
  KEY `USER_ID` (`USER_ID`)
) TYPE=MyISAM AUTO_INCREMENT=29 ;

#
# Volcar la base de datos para la tabla `suggestion`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `todo`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `todo`;
CREATE TABLE `todo` (
  `id` mediumint(9) NOT NULL auto_increment,
  `contenu` text,
  `temps` datetime default '0000-00-00 00:00:00',
  `auteur` varchar(80) default NULL,
  `email` varchar(80) default NULL,
  `priority` tinyint(4) default '0',
  `type` varchar(8) default NULL,
  `cible` varchar(30) default NULL,
  `statut` varchar(8) default NULL,
  `assignTo` mediumint(9) default NULL,
  `showToUsers` enum('YES','NO') NOT NULL default 'YES',
  PRIMARY KEY  (`id`),
  KEY `temps` (`temps`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `todo`
#


# --------------------------------------------------------

#
# Estructura de tabla para la tabla `treatment`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 11-05-2004 a las 22:54:53
#

DROP TABLE IF EXISTS `treatment`;
CREATE TABLE `treatment` (
  `TREATMENT_ID` tinyint(4) NOT NULL auto_increment,
  `TREATMENT_DESCRIPTION` char(20) NOT NULL default '',
  PRIMARY KEY  (`TREATMENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=10 ;

#
# Volcar la base de datos para la tabla `treatment`
#

INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (1, '');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (2, 'Don');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (3, 'Doña');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (4, 'Señor');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (5, 'Señora');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (6, 'Doctor');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (7, 'Doctora');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (8, 'Catedrático');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (9, 'Catedrática');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `user`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 08-06-2004 a las 23:00:50
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `USER_ID` int(11) NOT NULL auto_increment,
  `USER_ALIAS` char(10) NOT NULL default '',
  `THEME` char(20) NOT NULL default '',
  `LANGUAGE` char(5) NOT NULL default '',
  `USER_PASSWORD` char(255) NOT NULL default '',
  `ACTIVE` char(1) NOT NULL default '',
  `ACTIVATE_HASH` char(16) NOT NULL default '',
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `FORUM_TYPE_BB` tinyint(1) NOT NULL default '0',
  `MAIN_PAGE_ID` int(11) NOT NULL default '0',
  `PERSON_ID` int(11) NOT NULL default '0',
  `ID_PROFILE` tinyint(4) NOT NULL default '0',
  `TREATMENT_ID` tinyint(4) NOT NULL default '0',
  `EMAIL` char(100) NOT NULL default '',
  `USER_NOTIFY_EMAIL` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`USER_ID`),
  KEY `INSTITUTION_ID` (`INSTITUTION_ID`),
  KEY `MAIN_PAGE_ID` (`MAIN_PAGE_ID`),
  KEY `PERSON_ID` (`PERSON_ID`),
  KEY `ID_PROFILE` (`ID_PROFILE`),
  KEY `TREATMENT_ID` (`TREATMENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=13 ;

#
# Volcar la base de datos para la tabla `user`
#

INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (2, 'guest', 'default', 'es_ES', 'guest', '1', '', 0, 0, 0, 1, 6, 1, '', 0);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (3, 'antonio', 'default', 'es_ES', 'tonino007', '1', '', 1, 0, 0, 2, 2, 2, 'antoniofcano@telefonica.net', 1);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (1, 'admin', 'default', 'es_ES', 'admin', '1', '', 0, 0, 0, 3, 1, 2, '', 0);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (8, 'profesor', 'Miguel', 'es_ES', 'profesor', '1', '', 0, 0, 0, 8, 3, 4, 'ningun@correo.aun', 0);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (9, 'tutor', 'Miguel', 'es_ES', 'tutor', '1', '', 0, 0, 0, 9, 2, 4, 'sincorreo@en.isp', 0);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (10, 'alumno', 'Miguel', 'es_ES', 'alumno', '1', '', 0, 0, 0, 10, 4, 4, 'alumno', 0);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (11, 'secretaria', 'Miguel', 'es_ES', 'secretaria', '1', '', 0, 0, 0, 11, 5, 4, 'desco@sin.ip', 0);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (12, 'secretario', 'Miguel', 'es_ES', 'secretario', '1', '', 0, 0, 0, 12, 5, 4, 'desco@sin.ip', 0);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `user_course`
#
# Creación: 11-05-2004 a las 22:54:53
# Última actualización: 04-06-2004 a las 16:37:17
# Última revisión: 20-05-2004 a las 00:16:15
#

DROP TABLE IF EXISTS `user_course`;
CREATE TABLE `user_course` (
  `USER_ID` int(11) NOT NULL default '0',
  `COURSE_ID` int(11) NOT NULL default '0',
  `UD_DATE` date NOT NULL default '0000-00-00',
  `UC_UID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`USER_ID`,`COURSE_ID`),
  KEY `UC_UID` (`UC_UID`),
  KEY `COURSE_ID` (`COURSE_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `user_course`
#

INSERT INTO `user_course` (`USER_ID`, `COURSE_ID`, `UD_DATE`, `UC_UID`) VALUES (8, 4, '2004-05-22', 0);
INSERT INTO `user_course` (`USER_ID`, `COURSE_ID`, `UD_DATE`, `UC_UID`) VALUES (1, 4, '0000-00-00', 0);
INSERT INTO `user_course` (`USER_ID`, `COURSE_ID`, `UD_DATE`, `UC_UID`) VALUES (1, 6, '2004-05-20', 0);
INSERT INTO `user_course` (`USER_ID`, `COURSE_ID`, `UD_DATE`, `UC_UID`) VALUES (8, 5, '2004-05-22', 0);
INSERT INTO `user_course` (`USER_ID`, `COURSE_ID`, `UD_DATE`, `UC_UID`) VALUES (8, 6, '2004-05-22', 0);
INSERT INTO `user_course` (`USER_ID`, `COURSE_ID`, `UD_DATE`, `UC_UID`) VALUES (2, 4, '2004-05-22', 0);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `work`
#
# Creación: 06-06-2004 a las 23:12:50
# Última actualización: 06-06-2004 a las 23:12:50
#

DROP TABLE IF EXISTS `work`;
CREATE TABLE `work` (
  `id` int(11) NOT NULL auto_increment,
  `course_id` int(11) NOT NULL default '0',
  `path` varchar(200) default NULL,
  `titre` varchar(200) default NULL,
  `comment` varchar(250) default NULL,
  `auteurs` varchar(200) default NULL,
  `visibility` char(1) default NULL,
  `accepted` tinyint(1) default NULL,
  `gid` int(11) default NULL,
  `uid` int(11) default NULL,
  `dc` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `work`
#


