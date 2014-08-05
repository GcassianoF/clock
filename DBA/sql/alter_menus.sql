-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `navigation_menus`;
CREATE TABLE `navigation_menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL DEFAULT '',
  `icone` varchar(150) DEFAULT NULL,
  `posicao` int(11) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posicao` (`posicao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `navigation_menus` (`id`, `nome`, `icone`, `posicao`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Usuários',	'icon-user',	1,	'2013-05-21 13:41:06',	'2014-06-18 08:06:09',	NULL),
(2,	'DevelopeAdmin',	'icon-cogs',	6,	'2013-05-21 13:41:47',	'2014-06-18 08:11:53',	NULL),
(5,	'Reports',	'icon-file-alt',	2,	'2014-06-01 15:37:53',	NULL,	NULL),
(6,	'Itinerarios',	'icon-book',	3,	'2014-06-08 20:29:48',	'2014-06-18 08:07:50',	NULL),
(7,	'Grupos',	'icon-group',	4,	'2014-06-18 08:04:24',	NULL,	NULL),
(8,	'Parâmetros',	'icon-tasks',	5,	'2014-06-18 08:09:03',	'2014-06-18 08:10:00',	NULL),
(9,	'Dashboard',	'icon-dashboard',	10,	'2014-08-03 14:38:19',	NULL,	NULL);

DROP TABLE IF EXISTS `navigation_pages`;
CREATE TABLE `navigation_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `navigation_menu_id` int(11) unsigned NOT NULL,
  `nome` varchar(150) NOT NULL DEFAULT '',
  `url` varchar(150) NOT NULL,
  `icone` varchar(150) DEFAULT NULL,
  `mostrar` int(1) unsigned NOT NULL DEFAULT '0',
  `alt` varchar(150) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `navigation_menu_id` (`navigation_menu_id`),
  CONSTRAINT `navigation_pages_ibfk_1` FOREIGN KEY (`navigation_menu_id`) REFERENCES `navigation_menus` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `navigation_pages` (`id`, `navigation_menu_id`, `nome`, `url`, `icone`, `mostrar`, `alt`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'Gerenciar Usuários',	'/users',	'icon-cog',	1,	NULL,	'2013-06-02 02:29:20',	'2013-06-02 02:29:20',	NULL),
(2,	1,	'Cadastrar Usuário',	'/users/add',	'icon-save',	0,	NULL,	'2013-05-21 13:44:16',	'2014-06-12 17:52:46',	NULL),
(3,	1,	'Excluir Usuario',	'/users/delete',	'icon-frown',	0,	NULL,	'2013-05-21 13:44:59',	'2013-11-19 14:42:59',	NULL),
(4,	1,	'Detalhes do Usuário',	'/users/show',	'icon-reply-all',	0,	NULL,	'2013-05-21 13:46:09',	'2013-05-27 18:05:05',	NULL),
(5,	1,	'Editar Usuário',	'/users/update',	'icon-pencil',	0,	NULL,	'2013-05-21 13:46:54',	'2014-06-01 06:27:10',	NULL),
(6,	2,	'Paginas',	'/settings/pages',	'icon-file',	1,	NULL,	'2013-05-21 13:48:23',	NULL,	NULL),
(7,	2,	'Permissões',	'/settings/permissions',	'icon-legal',	1,	NULL,	'2013-05-21 13:48:53',	'2013-05-28 18:06:48',	NULL),
(8,	7,	'Grupo de Usuario',	'/users_groups',	'icon-group',	1,	NULL,	'2014-05-30 18:59:24',	'2014-06-18 08:04:50',	NULL),
(17,	8,	'Tipo de Registros',	'/reasons',	'icon-exchange',	1,	NULL,	'2014-06-08 20:32:11',	'2014-06-18 08:09:28',	NULL),
(18,	6,	'Jornadas de Trabalho',	'/itineraries',	'icon-list-ol',	1,	NULL,	'2014-06-09 21:04:21',	'2014-06-09 21:07:55',	NULL),
(19,	9,	'Dashboard',	'/dashboard',	'icon-dashboard',	1,	NULL,	'2014-08-03 14:39:37',	'2014-08-03 14:39:56',	NULL);

-- 2014-08-05 07:40:17
