-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `itineraries`;
CREATE TABLE `itineraries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `entrada` time NOT NULL,
  `intervalo` time NOT NULL,
  `retorno` time NOT NULL,
  `saida` time NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `itineraries` (`id`, `descricao`, `entrada`, `intervalo`, `retorno`, `saida`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'08:00 as 17:00 (1h de intervalo)',	'08:00:00',	'12:00:00',	'13:00:00',	'17:00:00',	'0000-00-00 00:00:00',	NULL,	NULL),
(2,	'08:00 as 18:00 (2h de intervalo)',	'08:00:00',	'12:00:00',	'14:00:00',	'18:00:00',	'0000-00-00 00:00:00',	NULL,	NULL),
(3,	'09:00 as 18:00 (1h de intervalo)',	'09:00:00',	'12:00:00',	'13:00:00',	'18:00:00',	'0000-00-00 00:00:00',	NULL,	NULL);

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
(8,	'Parâmetros',	'icon-tasks',	5,	'2014-06-18 08:09:03',	'2014-06-18 08:10:00',	NULL);

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
(18,	6,	'Jornadas de Trabalho',	'/itineraries',	'icon-list-ol',	1,	NULL,	'2014-06-09 21:04:21',	'2014-06-09 21:07:55',	NULL);

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_group_id` int(11) unsigned NOT NULL,
  `navigation_page_id` int(11) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_group_id` (`users_group_id`),
  KEY `navigation_page_id` (`navigation_page_id`),
  CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`users_group_id`) REFERENCES `users_groups` (`id`),
  CONSTRAINT `permissions_ibfk_2` FOREIGN KEY (`navigation_page_id`) REFERENCES `navigation_pages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `permissions` (`id`, `users_group_id`, `navigation_page_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1100,	2,	1,	'2014-07-27 18:32:34',	NULL,	NULL),
(1101,	2,	2,	'2014-07-27 18:32:34',	NULL,	NULL),
(1102,	2,	3,	'2014-07-27 18:32:34',	NULL,	NULL),
(1103,	2,	4,	'2014-07-27 18:32:34',	NULL,	NULL),
(1104,	2,	5,	'2014-07-27 18:32:34',	NULL,	NULL),
(1106,	2,	6,	'2014-07-27 18:32:34',	NULL,	NULL),
(1107,	2,	7,	'2014-07-27 18:32:34',	NULL,	NULL),
(1109,	2,	18,	'2014-07-27 18:32:34',	NULL,	NULL),
(1110,	2,	8,	'2014-07-27 18:32:34',	NULL,	NULL),
(1111,	2,	17,	'2014-07-27 18:32:34',	NULL,	NULL),
(1112,	1,	1,	'2014-07-27 18:32:53',	NULL,	NULL),
(1113,	1,	2,	'2014-07-27 18:32:53',	NULL,	NULL),
(1114,	1,	3,	'2014-07-27 18:32:54',	NULL,	NULL),
(1115,	1,	4,	'2014-07-27 18:32:54',	NULL,	NULL),
(1116,	1,	5,	'2014-07-27 18:32:54',	NULL,	NULL),
(1118,	1,	6,	'2014-07-27 18:32:54',	NULL,	NULL),
(1119,	1,	7,	'2014-07-27 18:32:54',	NULL,	NULL),
(1121,	1,	18,	'2014-07-27 18:32:54',	NULL,	NULL),
(1122,	1,	8,	'2014-07-27 18:32:54',	NULL,	NULL),
(1123,	1,	17,	'2014-07-27 18:32:54',	NULL,	NULL);

DROP TABLE IF EXISTS `reasons`;
CREATE TABLE `reasons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `reasons` (`id`, `descricao`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'ENTRADA',	'<span class=\'label label-success\' style=\'font-weight: normal;\'><i class=\'icon-arrow-up\'></i>  ENTRADA</span>',	'0000-00-00 00:00:00',	NULL,	NULL),
(2,	'INTERVALO',	'<span class=\'label label-gray\' style=\'font-weight: normal;\'><i class=\'icon-arrow-down\'></i>  INTERVALO</span>',	'0000-00-00 00:00:00',	NULL,	NULL),
(3,	'RETORNO',	'<span class=\'label label-info\' style=\'font-weight: normal;\'><i class=\'icon-arrow-up\'></i>  RETORNO</span>',	'0000-00-00 00:00:00',	NULL,	NULL),
(4,	'SAIDA',	'<span class=\'label label-important\' style=\'font-weight: normal;\'><i class=\'icon-arrow-down\'></i>  SAIDA</span>',	'0000-00-00 00:00:00',	NULL,	NULL),
(5,	'EXTRA-INICIO',	'<span class=\'label label-warning\' style=\'font-weight: normal;\'><i class=\'icon-arrow-up\'></i>  EXTRA-INICIO</span>',	'0000-00-00 00:00:00',	NULL,	NULL),
(6,	'EXTRA-FIM',	'<span class=\'label\' style=\'font-weight: normal;\'><i class=\'icon-arrow-down\'></i>  EXTRA-FIM</span>',	'2014-06-09 20:51:15',	'2014-06-12 07:16:03',	NULL);

DROP TABLE IF EXISTS `records`;
CREATE TABLE `records` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `reason_id` int(11) unsigned NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `dataHora` datetime NOT NULL,
  `justificativa` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `reason_id` (`reason_id`),
  CONSTRAINT `records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `records_ibfk_2` FOREIGN KEY (`reason_id`) REFERENCES `reasons` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `system_logs`;
CREATE TABLE `system_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `tabela` varchar(255) DEFAULT NULL,
  `registro_id` varchar(255) DEFAULT NULL,
  `comando` varchar(255) DEFAULT NULL,
  `campo` varchar(255) DEFAULT NULL,
  `antes` varchar(255) DEFAULT NULL,
  `depois` varchar(255) DEFAULT NULL,
  `h` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `i` varchar(255) DEFAULT NULL,
  `j` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `system_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_group_id` int(11) unsigned NOT NULL,
  `itineraries_id` int(11) unsigned NOT NULL,
  `nome` varchar(200) NOT NULL,
  `cpf` char(20) NOT NULL,
  `email` varchar(120) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_group_id` (`users_group_id`),
  KEY `fk_users_itineraries1_idx` (`itineraries_id`),
  CONSTRAINT `fk_users_itineraries1` FOREIGN KEY (`itineraries_id`) REFERENCES `itineraries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`users_group_id`) REFERENCES `users_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `users_group_id`, `itineraries_id`, `nome`, `cpf`, `email`, `senha`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4,	1,	2,	'Giceu Cassiano de Figueiredo',	'069.272.444-33',	'gcfigueiredo@indracompany.com',	'e77989ed21758e78331b20e477fc5582',	'2014-06-08 14:12:31',	'2014-06-18 10:08:14',	NULL);

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL DEFAULT '',
  `descricao` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users_groups` (`id`, `nome`, `descricao`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'DevelopTeam',	'Grupo dos Desenvolvedores da INDRA',	'2013-05-21 13:37:44',	'2014-07-25 11:44:56',	NULL),
(2,	'Administrador',	'Grupo dos Administradores da INDRA',	'2013-05-23 15:15:50',	'2014-07-25 11:45:05',	NULL),
(3,	'Analistas',	'Grupo de Analista da INDRA',	'2014-05-30 19:00:36',	'2014-07-25 11:45:14',	NULL);

-- 2014-07-28 11:03:30
