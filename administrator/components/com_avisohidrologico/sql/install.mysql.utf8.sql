DROP TABLE IF EXISTS `#__avisohidrologico`;

CREATE TABLE `#__avisohidrologico` (
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
);

CREATE TABLE "#__avisohidrologico_anexo" (
	id SERIAL NOT NULL,
	arquivo VARCHAR(500),
	titulo VARCHAR(500),
	created timestamp,
	id_aviso INT,
	id_user INT,
	tipo INT,
	PRIMARY KEY (id)
);
