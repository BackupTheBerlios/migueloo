# phpMyAdmin MySQL-Dump
# version 2.2.7-pl1
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# servidor: localhost
# Tiempo de Generacion: 16-04-2004 a les 12:26:07
# Version del Servidor: 3.23.46
# Version del PHP: 4.1.0
# Base De Datos : `migueloo_desa`
# --------------------------------------------------------

#
# Estructura de tabla para tabla `area`
#

DROP TABLE IF EXISTS area;
CREATE TABLE area (
  AREA_ID int(11) NOT NULL auto_increment,
  DEPARTMENT_ID int(11) NOT NULL default '0',
  FACULTY_ID int(11) NOT NULL default '0',
  INSTITUTION_ID int(11) NOT NULL default '0',
  AREA_NAME char(70) NOT NULL default '',
  AREA_DESCRIPTION char(100) NOT NULL default '',
  AREA_RESPONSABLE char(80) NOT NULL default '',
  AREA_ADDRESS char(100) NOT NULL default '',
  AREA_URL char(30) NOT NULL default '',
  AREA_MAIL char(30) NOT NULL default '',
  PRIMARY KEY  (AREA_ID,DEPARTMENT_ID,FACULTY_ID,INSTITUTION_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `area`
#

INSERT INTO area (AREA_ID, DEPARTMENT_ID, FACULTY_ID, INSTITUTION_ID, AREA_NAME, AREA_DESCRIPTION, AREA_RESPONSABLE, AREA_ADDRESS, AREA_URL, AREA_MAIL) VALUES (1, 1, 1, 1, 'Específica Electrónica', 'Continua', '', '', '', '');
INSERT INTO area (AREA_ID, DEPARTMENT_ID, FACULTY_ID, INSTITUTION_ID, AREA_NAME, AREA_DESCRIPTION, AREA_RESPONSABLE, AREA_ADDRESS, AREA_URL, AREA_MAIL) VALUES (2, 2, 2, 1, 'Fisio', 'A dar masajines', '', '', '', '');
INSERT INTO area (AREA_ID, DEPARTMENT_ID, FACULTY_ID, INSTITUTION_ID, AREA_NAME, AREA_DESCRIPTION, AREA_RESPONSABLE, AREA_ADDRESS, AREA_URL, AREA_MAIL) VALUES (3, 3, 0, 2, 'Programación', 'Cursines de Programación', 'El dire', '', '', '');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `course`
#

DROP TABLE IF EXISTS course;
CREATE TABLE course (
  COURSE_ID int(11) NOT NULL auto_increment,
  COURSE_NAME char(70) NOT NULL default '',
  COURSE_DESCRIPTION char(100) NOT NULL default '',
  COURSE_LANGUAGE char(5) NOT NULL default '',
  COURSE_ACCESS tinyint(4) NOT NULL default '0',
  INSTITUTION_ID int(11) NOT NULL default '0',
  FACULTY_ID int(11) NOT NULL default '0',
  AREA_ID int(11) NOT NULL default '0',
  DEPARTMENT_ID int(11) NOT NULL default '0',
  USER_ID int(11) NOT NULL default '0',
  COURSE_ACTIVE tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (COURSE_ID),
  KEY DEPARTMENT_ID (DEPARTMENT_ID),
  KEY USER_ID (USER_ID),
  KEY INSTITUTION_ID (INSTITUTION_ID),
  KEY AREA_ID (AREA_ID),
  KEY FACULTY_ID (FACULTY_ID),
  KEY INSTITUTION_ID_2 (INSTITUTION_ID,FACULTY_ID,AREA_ID,DEPARTMENT_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `course`
#

INSERT INTO course (COURSE_ID, COURSE_NAME, COURSE_DESCRIPTION, COURSE_LANGUAGE, COURSE_ACCESS, INSTITUTION_ID, FACULTY_ID, AREA_ID, DEPARTMENT_ID, USER_ID, COURSE_ACTIVE) VALUES (1, 'CURSO PHP', 'PROGRAMANDO PHP', 'es_es', 0, 2, 0, 0, 3, 2, 0);
INSERT INTO course (COURSE_ID, COURSE_NAME, COURSE_DESCRIPTION, COURSE_LANGUAGE, COURSE_ACCESS, INSTITUTION_ID, FACULTY_ID, AREA_ID, DEPARTMENT_ID, USER_ID, COURSE_ACTIVE) VALUES (2, 'Operando', 'Operaciones básicas', 'es_es', 0, 1, 2, 2, 2, 2, 0);
INSERT INTO course (COURSE_ID, COURSE_NAME, COURSE_DESCRIPTION, COURSE_LANGUAGE, COURSE_ACCESS, INSTITUTION_ID, FACULTY_ID, AREA_ID, DEPARTMENT_ID, USER_ID, COURSE_ACTIVE) VALUES (3, 'Energia', 'calculo numérico', 'es_es', 0, 1, 2, 2, 2, 1, 0);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `department`
#

DROP TABLE IF EXISTS department;
CREATE TABLE department (
  DEPARTMENT_ID int(11) NOT NULL auto_increment,
  FACULTY_ID int(11) NOT NULL default '0',
  INSTITUTION_ID int(11) NOT NULL default '0',
  DEPARTMENT_PARENT_ID int(11) NOT NULL default '0',
  DEPARTMENT_NAME char(70) NOT NULL default '',
  DEPARTMENT_DESCRIPTION char(100) NOT NULL default '',
  DEPARTMENT_RESPONSABLE char(80) NOT NULL default '',
  DEPARTMENT_ADDRESS char(100) NOT NULL default '',
  DEPARMENT_URL char(30) NOT NULL default '',
  DEPARTMENT_MAIL char(30) NOT NULL default '',
  PRIMARY KEY  (DEPARTMENT_ID,INSTITUTION_ID,FACULTY_ID),
  KEY DEPARTMENT_PARENT_ID (DEPARTMENT_PARENT_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `department`
#

INSERT INTO department (DEPARTMENT_ID, FACULTY_ID, INSTITUTION_ID, DEPARTMENT_PARENT_ID, DEPARTMENT_NAME, DEPARTMENT_DESCRIPTION, DEPARTMENT_RESPONSABLE, DEPARTMENT_ADDRESS, DEPARMENT_URL, DEPARTMENT_MAIL) VALUES (1, 1, 1, 0, 'Departamento Electrónica', 'Ingeniería Electrónica', 'El elestricista', '', '', '');
INSERT INTO department (DEPARTMENT_ID, FACULTY_ID, INSTITUTION_ID, DEPARTMENT_PARENT_ID, DEPARTMENT_NAME, DEPARTMENT_DESCRIPTION, DEPARTMENT_RESPONSABLE, DEPARTMENT_ADDRESS, DEPARMENT_URL, DEPARTMENT_MAIL) VALUES (2, 2, 1, 0, 'Enfermería', 'Enfermeras cachondas', 'Tetas grandes', '', '', '');
INSERT INTO department (DEPARTMENT_ID, FACULTY_ID, INSTITUTION_ID, DEPARTMENT_PARENT_ID, DEPARTMENT_NAME, DEPARTMENT_DESCRIPTION, DEPARTMENT_RESPONSABLE, DEPARTMENT_ADDRESS, DEPARMENT_URL, DEPARTMENT_MAIL) VALUES (3, 0, 2, 0, 'Pruebas', 'Probando', '', '', '', '');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `exercise_question`
#

DROP TABLE IF EXISTS exercise_question;
CREATE TABLE exercise_question (
  EXERCICE_ID int(11) NOT NULL default '0',
  QUESTION_ID int(11) NOT NULL default '0',
  EQ_POSITION tinyint(4) NOT NULL default '0',
  EQ_WEIGHT tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (QUESTION_ID,EXERCICE_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `exercise_question`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `faculty`
#

DROP TABLE IF EXISTS faculty;
CREATE TABLE faculty (
  FACULTY_ID int(11) NOT NULL auto_increment,
  INSTITUTION_ID int(11) NOT NULL default '0',
  FACULTY_NAME char(70) NOT NULL default '',
  FACULTY_DESCRIPTION char(100) NOT NULL default '',
  FACULTY_RESPONSABLE char(80) NOT NULL default '',
  FACULTY_ADDRESS char(100) NOT NULL default '',
  FACULTY_URL char(30) NOT NULL default '',
  FACULTY_MAIL char(30) NOT NULL default '',
  PRIMARY KEY  (FACULTY_ID,INSTITUTION_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `faculty`
#

INSERT INTO faculty (FACULTY_ID, INSTITUTION_ID, FACULTY_NAME, FACULTY_DESCRIPTION, FACULTY_RESPONSABLE, FACULTY_ADDRESS, FACULTY_URL, FACULTY_MAIL) VALUES (1, 1, 'Facultad de Ciencias', 'Puteamos a los estudiantes', 'Catedrático chungo', 'EPS', 'http://www.eps.ujaen.es', 'eps@ujaen.es');
INSERT INTO faculty (FACULTY_ID, INSTITUTION_ID, FACULTY_NAME, FACULTY_DESCRIPTION, FACULTY_RESPONSABLE, FACULTY_ADDRESS, FACULTY_URL, FACULTY_MAIL) VALUES (2, 1, 'Facultad de Medicina', 'Mata sanos y enfermeras', 'Catedrático muy malo', 'Hopital Salvese quien pueda', '', '');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `forum`
#

DROP TABLE IF EXISTS forum;
CREATE TABLE forum (
  FORUM_ID int(11) NOT NULL auto_increment,
  FORUM_NAME char(30) NOT NULL default '',
  FORUM_DESCRIPTION char(100) NOT NULL default '',
  FORUM_MODERATOR int(1) NOT NULL default '0',
  FORUM_ACCESS tinyint(4) NOT NULL default '0',
  FORUM_CAT_ID int(11) NOT NULL default '0',
  PRIMARY KEY  (FORUM_ID),
  KEY FORUM_CAT_ID (FORUM_CAT_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `forum`
#

INSERT INTO forum (FORUM_ID, FORUM_NAME, FORUM_DESCRIPTION, FORUM_MODERATOR, FORUM_ACCESS, FORUM_CAT_ID) VALUES (1, 'prueba', 'primer_foro', 0, 0, 0);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `forum_category`
#

DROP TABLE IF EXISTS forum_category;
CREATE TABLE forum_category (
  FORUM_CATEGORY_ID int(11) NOT NULL auto_increment,
  FORUM_CATEGORY_DESCRIPTION char(255) NOT NULL default '',
  COURSE_ID int(11) NOT NULL default '0',
  GROUP_ID int(11) NOT NULL default '0',
  PRIMARY KEY  (FORUM_CATEGORY_ID),
  KEY COURSE_ID (COURSE_ID),
  KEY GROUP_ID (GROUP_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `forum_category`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `forum_post`
#

DROP TABLE IF EXISTS forum_post;
CREATE TABLE forum_post (
  FORUM_POST_ID int(11) NOT NULL auto_increment,
  FORUM_TOPIC_ID int(11) NOT NULL default '0',
  FORUM_ID int(11) NOT NULL default '0',
  FORUM_POST_TEXT char(255) NOT NULL default '',
  FORUM_POST_POSTER int(11) NOT NULL default '0',
  FORUM_POST_TIME date NOT NULL default '0000-00-00',
  FORUM_POST_IP char(15) NOT NULL default '',
  PRIMARY KEY  (FORUM_POST_ID),
  KEY FORUM_TOPIC_ID (FORUM_TOPIC_ID),
  KEY FORUM_ID (FORUM_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `forum_post`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `forum_topic`
#

DROP TABLE IF EXISTS forum_topic;
CREATE TABLE forum_topic (
  FORUM_TOPIC_ID int(11) NOT NULL auto_increment,
  FORUM_TOPIC_TITLE char(30) NOT NULL default '',
  FORUM_TOPIC_NUMVIEW int(11) NOT NULL default '0',
  FORUM_TOPIC_REPLIES int(11) NOT NULL default '0',
  FORUM_TOPIC_NOTIFY tinyint(1) NOT NULL default '0',
  FORUM_TOPIC_STATUS tinyint(4) NOT NULL default '0',
  FORUM_TOPIC_POSTER int(11) NOT NULL default '0',
  FORUM_TOPIC_DATE date NOT NULL default '0000-00-00',
  FORUM_ID int(11) NOT NULL default '0',
  NUMBER_OF_VISITS int(11) NOT NULL default '0',
  NUMBER_OF_POSTS tinyint(4) NOT NULL default '0',
  LAST_POST_ID int(11) NOT NULL default '0',
  PRIMARY KEY  (FORUM_TOPIC_ID,FORUM_ID),
  KEY LAST_POST_ID (LAST_POST_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `forum_topic`
#

INSERT INTO forum_topic (FORUM_TOPIC_ID, FORUM_TOPIC_TITLE, FORUM_TOPIC_NUMVIEW, FORUM_TOPIC_REPLIES, FORUM_TOPIC_NOTIFY, FORUM_TOPIC_STATUS, FORUM_TOPIC_POSTER, FORUM_TOPIC_DATE, FORUM_ID, NUMBER_OF_VISITS, NUMBER_OF_POSTS, LAST_POST_ID) VALUES (1, 'Primera noticia', 0, 0, 0, 0, 0, '0000-00-00', 1, 0, 0, 0);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_acl`
#

DROP TABLE IF EXISTS gacl_acl;
CREATE TABLE gacl_acl (
  id int(11) NOT NULL default '0',
  section_value varchar(230) NOT NULL default 'system',
  allow int(11) NOT NULL default '0',
  enabled int(11) NOT NULL default '0',
  return_value longtext,
  note longtext,
  updated_date int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id_enabled_acl (id,enabled),
  KEY section_value_acl (section_value),
  KEY updated_date_acl (updated_date)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_acl`
#

INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (10, 'user', 0, 1, '', '', 1075199673);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (11, 'user', 1, 1, '', '', 1075199712);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (12, 'user', 0, 1, '', '', 1075200237);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (13, 'user', 1, 1, '', '', 1075200258);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (14, 'user', 1, 1, '', '', 1075201682);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (15, 'user', 0, 1, '', '', 1075201707);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (16, 'user', 1, 1, '', '', 1075201741);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (17, 'user', 0, 1, '', '', 1075201755);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (18, 'user', 1, 1, '', '', 1075201779);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (19, 'user', 0, 1, '', '', 1075201795);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (20, 'user', 1, 1, '', '', 1075201822);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (21, 'user', 0, 1, '', '', 1075201838);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (22, 'user', 1, 1, '', '', 1075201902);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (23, 'user', 0, 1, '', '', 1075201919);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (24, 'user', 1, 1, '', '', 1075201940);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (25, 'user', 0, 1, '', '', 1075201960);
INSERT INTO gacl_acl (id, section_value, allow, enabled, return_value, note, updated_date) VALUES (26, 'user', 1, 1, '', '', 1075201980);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_acl_sections`
#

DROP TABLE IF EXISTS gacl_acl_sections;
CREATE TABLE gacl_acl_sections (
  id int(11) NOT NULL default '0',
  value varchar(230) NOT NULL default '',
  order_value int(11) NOT NULL default '0',
  name varchar(230) NOT NULL default '',
  hidden int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY value_acl_sections (value),
  KEY hidden_acl_sections (hidden)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_acl_sections`
#

INSERT INTO gacl_acl_sections (id, value, order_value, name, hidden) VALUES (1, 'system', 1, 'System', 0);
INSERT INTO gacl_acl_sections (id, value, order_value, name, hidden) VALUES (2, 'user', 2, 'User', 0);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_acl_seq`
#

DROP TABLE IF EXISTS gacl_acl_seq;
CREATE TABLE gacl_acl_seq (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_acl_seq`
#

INSERT INTO gacl_acl_seq (id) VALUES (26);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aco`
#

DROP TABLE IF EXISTS gacl_aco;
CREATE TABLE gacl_aco (
  id int(11) NOT NULL default '0',
  section_value varchar(240) NOT NULL default '0',
  value varchar(240) NOT NULL default '',
  order_value int(11) NOT NULL default '0',
  name varchar(255) NOT NULL default '',
  hidden int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY section_value_value_aco (section_value,value),
  KEY hidden_aco (hidden)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aco`
#

INSERT INTO gacl_aco (id, section_value, value, order_value, name, hidden) VALUES (10, 'miguel_VMenu', 'listcourses', 1, 'Listar cursos', 0);
INSERT INTO gacl_aco (id, section_value, value, order_value, name, hidden) VALUES (11, 'miguel_VMenu', 'todo', 2, 'Sugerencias', 0);
INSERT INTO gacl_aco (id, section_value, value, order_value, name, hidden) VALUES (12, 'miguel_VMenu', 'forum', 3, 'Foros', 0);
INSERT INTO gacl_aco (id, section_value, value, order_value, name, hidden) VALUES (13, 'miguel_VMenu', 'admin', 4, 'Administración', 0);
INSERT INTO gacl_aco (id, section_value, value, order_value, name, hidden) VALUES (14, 'miguel_VMenu', 'newcourse', 5, 'Nuevo curso', 0);
INSERT INTO gacl_aco (id, section_value, value, order_value, name, hidden) VALUES (15, 'miguel_VMenu', 'inscrip', 6, 'Inscripción en el Campus Virtual', 0);
INSERT INTO gacl_aco (id, section_value, value, order_value, name, hidden) VALUES (16, 'miguel_VMenu', 'prefs', 7, 'Preferencias de Usuario', 0);
INSERT INTO gacl_aco (id, section_value, value, order_value, name, hidden) VALUES (17, 'miguel_VMenu', 'askpassword', 8, 'Preguntas Clave', 0);
INSERT INTO gacl_aco (id, section_value, value, order_value, name, hidden) VALUES (18, 'miguel_VMenu', 'logout', 9, 'Salir', 0);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aco_map`
#

DROP TABLE IF EXISTS gacl_aco_map;
CREATE TABLE gacl_aco_map (
  acl_id int(11) NOT NULL default '0',
  section_value varchar(230) NOT NULL default '0',
  value varchar(230) NOT NULL default '',
  KEY acl_id_aco_map (acl_id)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aco_map`
#

INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (10, 'miguel_VMenu', 'admin');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (11, 'miguel_VMenu', 'admin');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (12, 'miguel_VMenu', 'inscrip');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (13, 'miguel_VMenu', 'inscrip');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (14, 'miguel_VMenu', 'listcourses');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (15, 'miguel_VMenu', 'listcourses');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (16, 'miguel_VMenu', 'todo');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (17, 'miguel_VMenu', 'todo');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (18, 'miguel_VMenu', 'forum');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (19, 'miguel_VMenu', 'forum');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (20, 'miguel_VMenu', 'newcourse');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (21, 'miguel_VMenu', 'newcourse');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (22, 'miguel_VMenu', 'prefs');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (23, 'miguel_VMenu', 'prefs');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (24, 'miguel_VMenu', 'askpassword');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (25, 'miguel_VMenu', 'askpassword');
INSERT INTO gacl_aco_map (acl_id, section_value, value) VALUES (26, 'miguel_VMenu', 'logout');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aco_sections`
#

DROP TABLE IF EXISTS gacl_aco_sections;
CREATE TABLE gacl_aco_sections (
  id int(11) NOT NULL default '0',
  value varchar(230) NOT NULL default '',
  order_value int(11) NOT NULL default '0',
  name varchar(230) NOT NULL default '',
  hidden int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY value_aco_sections (value),
  KEY hidden_aco_sections (hidden)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aco_sections`
#

INSERT INTO gacl_aco_sections (id, value, order_value, name, hidden) VALUES (10, 'module', 10, 'Módulos de miguelOO', 0);
INSERT INTO gacl_aco_sections (id, value, order_value, name, hidden) VALUES (11, 'window', 20, 'Pantallas de miguelOO', 0);
INSERT INTO gacl_aco_sections (id, value, order_value, name, hidden) VALUES (12, 'element', 30, 'Elementos atómicos de miguelOO', 0);
INSERT INTO gacl_aco_sections (id, value, order_value, name, hidden) VALUES (13, 'miguel_VMenu', 24, 'Barra de menu genérica de miguelOO', 0);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aco_sections_seq`
#

DROP TABLE IF EXISTS gacl_aco_sections_seq;
CREATE TABLE gacl_aco_sections_seq (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aco_sections_seq`
#

INSERT INTO gacl_aco_sections_seq (id) VALUES (13);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aco_seq`
#

DROP TABLE IF EXISTS gacl_aco_seq;
CREATE TABLE gacl_aco_seq (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aco_seq`
#

INSERT INTO gacl_aco_seq (id) VALUES (18);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aro`
#

DROP TABLE IF EXISTS gacl_aro;
CREATE TABLE gacl_aro (
  id int(11) NOT NULL default '0',
  section_value varchar(240) NOT NULL default '0',
  value varchar(240) NOT NULL default '',
  order_value int(11) NOT NULL default '0',
  name varchar(255) NOT NULL default '',
  hidden int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY section_value_value_aro (section_value,value),
  KEY hidden_aro (hidden)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aro`
#

INSERT INTO gacl_aro (id, section_value, value, order_value, name, hidden) VALUES (10, 'profile', '1', 1, 'Administrador de miguelOO', 0);
INSERT INTO gacl_aro (id, section_value, value, order_value, name, hidden) VALUES (11, 'profile', '2', 10, 'Tutor registrado', 0);
INSERT INTO gacl_aro (id, section_value, value, order_value, name, hidden) VALUES (12, 'profile', '3', 20, 'Profesor autorizado', 0);
INSERT INTO gacl_aro (id, section_value, value, order_value, name, hidden) VALUES (13, 'profile', '4', 30, 'Alumno registrado', 0);
INSERT INTO gacl_aro (id, section_value, value, order_value, name, hidden) VALUES (14, 'profile', '5', 50, 'Secretaria', 0);
INSERT INTO gacl_aro (id, section_value, value, order_value, name, hidden) VALUES (15, 'profile', '6', 99, 'Invitado (usuario no registrado)', 0);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aro_groups`
#

DROP TABLE IF EXISTS gacl_aro_groups;
CREATE TABLE gacl_aro_groups (
  id int(11) NOT NULL default '0',
  parent_id int(11) NOT NULL default '0',
  name varchar(255) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY parent_id_aro_groups (parent_id)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aro_groups`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aro_groups_map`
#

DROP TABLE IF EXISTS gacl_aro_groups_map;
CREATE TABLE gacl_aro_groups_map (
  acl_id int(11) NOT NULL default '0',
  group_id int(11) NOT NULL default '0',
  UNIQUE KEY acl_id_group_id_aro_groups_map (acl_id,group_id)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aro_groups_map`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aro_groups_path`
#

DROP TABLE IF EXISTS gacl_aro_groups_path;
CREATE TABLE gacl_aro_groups_path (
  id int(11) NOT NULL default '0',
  group_id int(11) NOT NULL default '0',
  tree_level int(11) NOT NULL default '0',
  UNIQUE KEY id_group_id_tree_level_aro_groups_path (id,group_id,tree_level)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aro_groups_path`
#

INSERT INTO gacl_aro_groups_path (id, group_id, tree_level) VALUES (10, 0, 0);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aro_groups_path_id_seq`
#

DROP TABLE IF EXISTS gacl_aro_groups_path_id_seq;
CREATE TABLE gacl_aro_groups_path_id_seq (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aro_groups_path_id_seq`
#

INSERT INTO gacl_aro_groups_path_id_seq (id) VALUES (10);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aro_groups_path_map`
#

DROP TABLE IF EXISTS gacl_aro_groups_path_map;
CREATE TABLE gacl_aro_groups_path_map (
  path_id int(11) NOT NULL default '0',
  group_id int(11) NOT NULL default '0',
  UNIQUE KEY path_id_group_id_aro_groups_path_map (path_id,group_id)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aro_groups_path_map`
#

INSERT INTO gacl_aro_groups_path_map (path_id, group_id) VALUES (10, 10);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aro_map`
#

DROP TABLE IF EXISTS gacl_aro_map;
CREATE TABLE gacl_aro_map (
  acl_id int(11) NOT NULL default '0',
  section_value varchar(230) NOT NULL default '0',
  value varchar(230) NOT NULL default '',
  KEY acl_id_aro_map (acl_id)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aro_map`
#

INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (10, 'profile', '2');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (10, 'profile', '3');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (10, 'profile', '4');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (10, 'profile', '5');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (10, 'profile', '6');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (11, 'profile', '1');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (12, 'profile', '1');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (12, 'profile', '2');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (12, 'profile', '3');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (12, 'profile', '4');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (12, 'profile', '5');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (13, 'profile', '6');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (14, 'profile', '2');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (14, 'profile', '3');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (14, 'profile', '4');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (14, 'profile', '6');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (15, 'profile', '1');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (15, 'profile', '5');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (16, 'profile', '2');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (16, 'profile', '3');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (16, 'profile', '4');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (16, 'profile', '6');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (17, 'profile', '1');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (17, 'profile', '5');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (18, 'profile', '2');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (18, 'profile', '3');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (18, 'profile', '4');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (19, 'profile', '1');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (19, 'profile', '5');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (19, 'profile', '6');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (20, 'profile', '2');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (20, 'profile', '5');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (21, 'profile', '1');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (21, 'profile', '3');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (21, 'profile', '4');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (21, 'profile', '6');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (22, 'profile', '1');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (22, 'profile', '2');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (22, 'profile', '3');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (22, 'profile', '4');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (22, 'profile', '5');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (23, 'profile', '6');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (24, 'profile', '6');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (25, 'profile', '1');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (25, 'profile', '2');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (25, 'profile', '3');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (26, 'profile', '1');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (26, 'profile', '2');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (26, 'profile', '3');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (26, 'profile', '4');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (26, 'profile', '5');
INSERT INTO gacl_aro_map (acl_id, section_value, value) VALUES (26, 'profile', '6');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aro_sections`
#

DROP TABLE IF EXISTS gacl_aro_sections;
CREATE TABLE gacl_aro_sections (
  id int(11) NOT NULL default '0',
  value varchar(230) NOT NULL default '',
  order_value int(11) NOT NULL default '0',
  name varchar(230) NOT NULL default '',
  hidden int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY value_aro_sections (value),
  KEY hidden_aro_sections (hidden)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aro_sections`
#

INSERT INTO gacl_aro_sections (id, value, order_value, name, hidden) VALUES (10, 'profile', 10, 'Perfil de usuario de miguelOO', 0);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aro_sections_seq`
#

DROP TABLE IF EXISTS gacl_aro_sections_seq;
CREATE TABLE gacl_aro_sections_seq (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aro_sections_seq`
#

INSERT INTO gacl_aro_sections_seq (id) VALUES (10);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_aro_seq`
#

DROP TABLE IF EXISTS gacl_aro_seq;
CREATE TABLE gacl_aro_seq (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_aro_seq`
#

INSERT INTO gacl_aro_seq (id) VALUES (15);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_axo`
#

DROP TABLE IF EXISTS gacl_axo;
CREATE TABLE gacl_axo (
  id int(11) NOT NULL default '0',
  section_value varchar(240) NOT NULL default '0',
  value varchar(240) NOT NULL default '',
  order_value int(11) NOT NULL default '0',
  name varchar(255) NOT NULL default '',
  hidden int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY section_value_value_axo (section_value,value),
  KEY hidden_axo (hidden)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_axo`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_axo_groups`
#

DROP TABLE IF EXISTS gacl_axo_groups;
CREATE TABLE gacl_axo_groups (
  id int(11) NOT NULL default '0',
  parent_id int(11) NOT NULL default '0',
  name varchar(255) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY parent_id_axo_groups (parent_id)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_axo_groups`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_axo_groups_map`
#

DROP TABLE IF EXISTS gacl_axo_groups_map;
CREATE TABLE gacl_axo_groups_map (
  acl_id int(11) NOT NULL default '0',
  group_id int(11) NOT NULL default '0',
  UNIQUE KEY acl_id_group_id_axo_groups_map (acl_id,group_id)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_axo_groups_map`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_axo_groups_path`
#

DROP TABLE IF EXISTS gacl_axo_groups_path;
CREATE TABLE gacl_axo_groups_path (
  id int(11) NOT NULL default '0',
  group_id int(11) NOT NULL default '0',
  tree_level int(11) NOT NULL default '0',
  UNIQUE KEY id_group_id_tree_level_axo_groups_path (id,group_id,tree_level)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_axo_groups_path`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_axo_groups_path_map`
#

DROP TABLE IF EXISTS gacl_axo_groups_path_map;
CREATE TABLE gacl_axo_groups_path_map (
  path_id int(11) NOT NULL default '0',
  group_id int(11) NOT NULL default '0',
  UNIQUE KEY path_id_group_id_axo_groups_path_map (path_id,group_id)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_axo_groups_path_map`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_axo_map`
#

DROP TABLE IF EXISTS gacl_axo_map;
CREATE TABLE gacl_axo_map (
  acl_id int(11) NOT NULL default '0',
  section_value varchar(230) NOT NULL default '0',
  value varchar(230) NOT NULL default '',
  KEY acl_id_axo_map (acl_id)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_axo_map`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_axo_sections`
#

DROP TABLE IF EXISTS gacl_axo_sections;
CREATE TABLE gacl_axo_sections (
  id int(11) NOT NULL default '0',
  value varchar(230) NOT NULL default '',
  order_value int(11) NOT NULL default '0',
  name varchar(230) NOT NULL default '',
  hidden int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY value_axo_sections (value),
  KEY hidden_axo_sections (hidden)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_axo_sections`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_groups_aro_map`
#

DROP TABLE IF EXISTS gacl_groups_aro_map;
CREATE TABLE gacl_groups_aro_map (
  group_id int(11) NOT NULL default '0',
  section_value varchar(240) NOT NULL default '',
  value varchar(240) NOT NULL default '',
  UNIQUE KEY group_id_aro_id_groups_aro_map (section_value,value)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_groups_aro_map`
#

INSERT INTO gacl_groups_aro_map (group_id, section_value, value) VALUES (10, 'profile', 'admin');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_groups_axo_map`
#

DROP TABLE IF EXISTS gacl_groups_axo_map;
CREATE TABLE gacl_groups_axo_map (
  group_id int(11) NOT NULL default '0',
  section_value varchar(240) NOT NULL default '',
  value varchar(240) NOT NULL default '',
  UNIQUE KEY group_id_axo_id_groups_axo_map (section_value,value)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_groups_axo_map`
#

# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_groups_id_seq`
#

DROP TABLE IF EXISTS gacl_groups_id_seq;
CREATE TABLE gacl_groups_id_seq (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_groups_id_seq`
#

INSERT INTO gacl_groups_id_seq (id) VALUES (10);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `gacl_phpgacl`
#

DROP TABLE IF EXISTS gacl_phpgacl;
CREATE TABLE gacl_phpgacl (
  name varchar(230) NOT NULL default '',
  value varchar(230) NOT NULL default '',
  PRIMARY KEY  (name)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `gacl_phpgacl`
#

INSERT INTO gacl_phpgacl (name, value) VALUES ('version', '3.2.2');
INSERT INTO gacl_phpgacl (name, value) VALUES ('schema_version', '2.0');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `institution`
#

DROP TABLE IF EXISTS institution;
CREATE TABLE institution (
  INSTITUTION_ID int(11) NOT NULL auto_increment,
  INSTITUTION_HASH_ID char(40) NOT NULL default '',
  INSTITUTION_NAME char(70) NOT NULL default '',
  INSTITUTION_DESCRIPTION char(100) NOT NULL default '',
  INSTITUTION_RESPONSABLE char(80) NOT NULL default '',
  INSTITUTION_PHONE char(12) NOT NULL default '',
  INSTITUTION_URL char(30) NOT NULL default '',
  INSTITUTION_MAIL char(20) NOT NULL default '',
  INSTITUTION_ADDRESS char(100) NOT NULL default '',
  INSTITUTION_THEME char(20) NOT NULL default '',
  INSTITUTION_LANGUAGE char(5) NOT NULL default '',
  INSTITUTION_FORUM_TYPE_BB tinyint(1) NOT NULL default '0',
  INSTITUTION_MAIN_PAGE_ID int(11) NOT NULL default '0',
  PRIMARY KEY  (INSTITUTION_ID),
  KEY INSTITUTION_MAIN_PAGE_ID (INSTITUTION_MAIN_PAGE_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `institution`
#

INSERT INTO institution (INSTITUTION_ID, INSTITUTION_HASH_ID, INSTITUTION_NAME, INSTITUTION_DESCRIPTION, INSTITUTION_RESPONSABLE, INSTITUTION_PHONE, INSTITUTION_URL, INSTITUTION_MAIL, INSTITUTION_ADDRESS, INSTITUTION_THEME, INSTITUTION_LANGUAGE, INSTITUTION_FORUM_TYPE_BB, INSTITUTION_MAIN_PAGE_ID) VALUES (1, '', 'Universidad de Jaén', 'Es una Universidad mu bonica', 'Antonio', '123456789', 'http://www.ujaen.es', 'virtual@ujaen.es', 'Jaén', 'NORMAL', 'ES_ES', 0, 0);
INSERT INTO institution (INSTITUTION_ID, INSTITUTION_HASH_ID, INSTITUTION_NAME, INSTITUTION_DESCRIPTION, INSTITUTION_RESPONSABLE, INSTITUTION_PHONE, INSTITUTION_URL, INSTITUTION_MAIL, INSTITUTION_ADDRESS, INSTITUTION_THEME, INSTITUTION_LANGUAGE, INSTITUTION_FORUM_TYPE_BB, INSTITUTION_MAIN_PAGE_ID) VALUES (2, '', 'Academia CSET', 'Academia la más bonica', 'Antonio', '123456789', 'http://www.cset.com', 'formacion@cset.com', 'Martos', 'NORMAL', 'ES_ES', 0, 0);
# --------------------------------------------------------

#
# Estructura de tabla para tabla `loginout`
#

DROP TABLE IF EXISTS loginout;
CREATE TABLE loginout (
  idLog mediumint(9) unsigned NOT NULL auto_increment,
  id_user mediumint(9) unsigned NOT NULL default '0',
  ip char(16) NOT NULL default '0.0.0.0',
  log_when datetime NOT NULL default '0000-00-00 00:00:00',
  log_action enum('LOGIN','LOGOUT') NOT NULL default 'LOGIN',
  PRIMARY KEY  (idLog)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `loginout`
#

INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (1, 1, '172.22.65.11', '2004-04-15 17:48:13', 'LOGIN');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (2, 0, '172.22.65.11', '2004-04-15 17:49:43', 'LOGOUT');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (3, 1, '172.22.65.11', '2004-04-15 17:49:57', 'LOGIN');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (4, 0, '172.22.65.11', '2004-04-15 17:50:05', 'LOGOUT');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (5, 1, '172.22.65.11', '2004-04-16 10:10:18', 'LOGIN');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (6, 0, '172.22.65.11', '2004-04-16 10:10:52', 'LOGOUT');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (7, 2, '172.22.65.11', '2004-04-16 10:28:21', 'LOGIN');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (8, 0, '172.22.65.11', '2004-04-16 10:28:31', 'LOGOUT');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (9, 1, '172.22.65.11', '2004-04-16 10:30:44', 'LOGIN');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (10, 0, '172.22.65.11', '2004-04-16 10:35:49', 'LOGOUT');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (11, 2, '172.22.65.11', '2004-04-16 10:35:59', 'LOGIN');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (12, 0, '172.22.65.11', '2004-04-16 10:37:18', 'LOGOUT');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (13, 2, '172.22.65.11', '2004-04-16 10:37:43', 'LOGIN');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (14, 0, '172.22.65.11', '2004-04-16 10:39:08', 'LOGOUT');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (15, 2, '172.22.65.11', '2004-04-16 10:39:22', 'LOGIN');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (16, 0, '172.22.65.11', '2004-04-16 10:39:37', 'LOGOUT');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (17, 1, '172.22.65.11', '2004-04-16 12:12:20', 'LOGIN');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (18, 0, '172.22.65.11', '2004-04-16 12:12:48', 'LOGOUT');
INSERT INTO loginout (idLog, id_user, ip, log_when, log_action) VALUES (19, 2, '172.22.65.11', '2004-04-16 12:12:57', 'LOGIN');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `person`
#

DROP TABLE IF EXISTS person;
CREATE TABLE person (
  PERSON_ID int(11) NOT NULL auto_increment,
  PERSON_JABBER char(20) NOT NULL default '',
  PERSON_NAME char(30) NOT NULL default '',
  PERSON_SURNAME char(50) NOT NULL default '',
  TREATMENT_ID tinyint(4) NOT NULL default '0',
  CARGO char(10) NOT NULL default '',
  PRIMARY KEY  (PERSON_ID),
  KEY TREATMENT_ID (TREATMENT_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `person`
#

INSERT INTO person (PERSON_ID, PERSON_JABBER, PERSON_NAME, PERSON_SURNAME, TREATMENT_ID, CARGO) VALUES (1, '', 'Invitado', '', 1, '');
INSERT INTO person (PERSON_ID, PERSON_JABBER, PERSON_NAME, PERSON_SURNAME, TREATMENT_ID, CARGO) VALUES (2, 'antoniofcano', 'Antonio Francisco', 'Cano Damas', 2, 'Jefe Proy.');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `profile`
#

DROP TABLE IF EXISTS profile;
CREATE TABLE profile (
  ID_PROFILE tinyint(4) NOT NULL auto_increment,
  PROFILE_DESCRIPTION char(20) NOT NULL default '',
  PRIMARY KEY  (ID_PROFILE)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `profile`
#

INSERT INTO profile (ID_PROFILE, PROFILE_DESCRIPTION) VALUES (1, 'Administrador');
INSERT INTO profile (ID_PROFILE, PROFILE_DESCRIPTION) VALUES (2, 'Tutor');
INSERT INTO profile (ID_PROFILE, PROFILE_DESCRIPTION) VALUES (3, 'Profesor');
INSERT INTO profile (ID_PROFILE, PROFILE_DESCRIPTION) VALUES (4, 'Alumno');
INSERT INTO profile (ID_PROFILE, PROFILE_DESCRIPTION) VALUES (5, 'Secretaria');
INSERT INTO profile (ID_PROFILE, PROFILE_DESCRIPTION) VALUES (6, 'Visitante');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `suggestion`
#

DROP TABLE IF EXISTS suggestion;
CREATE TABLE suggestion (
  SUGGESTION_ID int(11) NOT NULL auto_increment,
  SUGGESTION_DESCRIPTION char(255) NOT NULL default '',
  SUGGESTION_READ tinyint(1) NOT NULL default '0',
  SUGGESTION_DATE_SENT date NOT NULL default '0000-00-00',
  SUGGESTION_PRIORITY tinyint(4) NOT NULL default '0',
  USER_ID int(11) NOT NULL default '0',
  SUGGESTION_NAME char(255) NOT NULL default '',
  SUGGESTION_EMAIL char(255) NOT NULL default '',
  PRIMARY KEY  (SUGGESTION_ID),
  KEY USER_ID (USER_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `suggestion`
#

INSERT INTO suggestion (SUGGESTION_ID, SUGGESTION_DESCRIPTION, SUGGESTION_READ, SUGGESTION_DATE_SENT, SUGGESTION_PRIORITY, USER_ID, SUGGESTION_NAME, SUGGESTION_EMAIL) VALUES (26, 'comentario1', 0, '2004-03-05', 0, 0, '', '');
INSERT INTO suggestion (SUGGESTION_ID, SUGGESTION_DESCRIPTION, SUGGESTION_READ, SUGGESTION_DATE_SENT, SUGGESTION_PRIORITY, USER_ID, SUGGESTION_NAME, SUGGESTION_EMAIL) VALUES (27, 'otromas', 0, '2004-03-05', 0, 0, '', '');
INSERT INTO suggestion (SUGGESTION_ID, SUGGESTION_DESCRIPTION, SUGGESTION_READ, SUGGESTION_DATE_SENT, SUGGESTION_PRIORITY, USER_ID, SUGGESTION_NAME, SUGGESTION_EMAIL) VALUES (28, 'mundo', 0, '2004-03-05', 0, 0, '', '');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `todo`
#

DROP TABLE IF EXISTS todo;
CREATE TABLE todo (
  id mediumint(9) NOT NULL auto_increment,
  contenu text,
  temps datetime default '0000-00-00 00:00:00',
  auteur varchar(80) default NULL,
  email varchar(80) default NULL,
  priority tinyint(4) default '0',
  type varchar(8) default NULL,
  cible varchar(30) default NULL,
  statut varchar(8) default NULL,
  assignTo mediumint(9) default NULL,
  showToUsers enum('YES','NO') NOT NULL default 'YES',
  PRIMARY KEY  (id),
  KEY temps (temps)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `todo`
#

INSERT INTO todo (id, contenu, temps, auteur, email, priority, type, cible, statut, assignTo, showToUsers) VALUES (1, 'sdfaafsdsfad', '2004-02-24 00:46:09', 'pepe', 'aa@hola.net', 0, '0', '0', '0', 0, 'YES');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `treatment`
#

DROP TABLE IF EXISTS treatment;
CREATE TABLE treatment (
  TREATMENT_ID tinyint(4) NOT NULL auto_increment,
  TREATMENT_DESCRIPTION char(20) NOT NULL default '',
  PRIMARY KEY  (TREATMENT_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `treatment`
#

INSERT INTO treatment (TREATMENT_ID, TREATMENT_DESCRIPTION) VALUES (1, '');
INSERT INTO treatment (TREATMENT_ID, TREATMENT_DESCRIPTION) VALUES (2, 'Don');
INSERT INTO treatment (TREATMENT_ID, TREATMENT_DESCRIPTION) VALUES (3, 'Doña');
INSERT INTO treatment (TREATMENT_ID, TREATMENT_DESCRIPTION) VALUES (4, 'Señor');
INSERT INTO treatment (TREATMENT_ID, TREATMENT_DESCRIPTION) VALUES (5, 'Señora');
INSERT INTO treatment (TREATMENT_ID, TREATMENT_DESCRIPTION) VALUES (6, 'Doctor');
INSERT INTO treatment (TREATMENT_ID, TREATMENT_DESCRIPTION) VALUES (7, 'Doctora');
INSERT INTO treatment (TREATMENT_ID, TREATMENT_DESCRIPTION) VALUES (8, 'Catedrático');
INSERT INTO treatment (TREATMENT_ID, TREATMENT_DESCRIPTION) VALUES (9, 'Catedrática');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `user`
#

DROP TABLE IF EXISTS user;
CREATE TABLE user (
  USER_ID int(11) NOT NULL auto_increment,
  USER_ALIAS char(10) NOT NULL default '',
  THEME char(20) NOT NULL default '',
  LANGUAGE char(5) NOT NULL default '',
  USER_PASSWORD char(255) NOT NULL default '',
  ACTIVE char(1) NOT NULL default '',
  ACTIVATE_HASH char(16) NOT NULL default '',
  INSTITUTION_ID int(11) NOT NULL default '0',
  FORUM_TYPE_BB tinyint(1) NOT NULL default '0',
  MAIN_PAGE_ID int(11) NOT NULL default '0',
  PERSON_ID int(11) NOT NULL default '0',
  ID_PROFILE tinyint(4) NOT NULL default '0',
  TREATMENT_ID tinyint(4) NOT NULL default '0',
  EMAIL char(100) NOT NULL default '',
  PRIMARY KEY  (USER_ID),
  KEY INSTITUTION_ID (INSTITUTION_ID),
  KEY MAIN_PAGE_ID (MAIN_PAGE_ID),
  KEY PERSON_ID (PERSON_ID),
  KEY ID_PROFILE (ID_PROFILE),
  KEY TREATMENT_ID (TREATMENT_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `user`
#

INSERT INTO user (USER_ID, USER_ALIAS, THEME, LANGUAGE, USER_PASSWORD, ACTIVE, ACTIVATE_HASH, INSTITUTION_ID, FORUM_TYPE_BB, MAIN_PAGE_ID, PERSON_ID, ID_PROFILE, TREATMENT_ID, EMAIL) VALUES (1, 'guest', 'default', 'es_ES', 'guest', '1', '', 0, 0, 0, 1, 6, 1, '');
INSERT INTO user (USER_ID, USER_ALIAS, THEME, LANGUAGE, USER_PASSWORD, ACTIVE, ACTIVATE_HASH, INSTITUTION_ID, FORUM_TYPE_BB, MAIN_PAGE_ID, PERSON_ID, ID_PROFILE, TREATMENT_ID, EMAIL) VALUES (2, 'antonio', 'default', 'es_ES', 'tonino007', '1', '', 1, 0, 0, 2, 1, 2, '');
# --------------------------------------------------------

#
# Estructura de tabla para tabla `user_course`
#

DROP TABLE IF EXISTS user_course;
CREATE TABLE user_course (
  USER_ID int(11) NOT NULL default '0',
  COURSE_ID int(11) NOT NULL default '0',
  UD_DATE date NOT NULL default '0000-00-00',
  UC_UID int(11) NOT NULL default '0',
  PRIMARY KEY  (USER_ID,COURSE_ID),
  KEY UC_UID (UC_UID),
  KEY COURSE_ID (COURSE_ID)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `user_course`
#

INSERT INTO user_course (USER_ID, COURSE_ID, UD_DATE, UC_UID) VALUES (2, 1, '0000-00-00', 0);
INSERT INTO user_course (USER_ID, COURSE_ID, UD_DATE, UC_UID) VALUES (2, 2, '0000-00-00', 0);
INSERT INTO user_course (USER_ID, COURSE_ID, UD_DATE, UC_UID) VALUES (2, 3, '0000-00-00', 0);

