ALTER TABLE `users`
ADD `matricula` varchar(200) COLLATE 'utf8_general_ci' NOT NULL AFTER `nome`,
COMMENT='';