DROP TABLE IF EXISTS `#__avisometeorologico`;

CREATE TABLE `#__avisometeorologico` (
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
