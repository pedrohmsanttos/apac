DROP TABLE IF EXISTS `#__aviso`;

CREATE TABLE `#__aviso` (
	 `id` INT(11)  NOT NULL AUTO_INCREMENT,
	 `published` INT(1) DEFAULT 1,
	 `created` timestamp,
	 `validade` timestamp,
	 `conteudo` TEXT,
	 `tipo` INT(10),
	 `ordering` INT(10),
	 `identificador` VARCHAR(200),
	 `titulo` text,
	 `regioes` VARCHAR(200),
	 `tags` VARCHAR(200),
	PRIMARY KEY (`id`)
)
