DROP TABLE IF EXISTS `#__secretario`;

CREATE TABLE `#__secretario` (
	 `id` INT(11)  NOT NULL AUTO_INCREMENT,
	 `published` INT(11),
	 `nome_secretario` VARCHAR(255),
	 `imagem` VARCHAR(500),
	 `endereco_secretario` VARCHAR(255),
	 `sobre_secretario` TEXT,
	 `atribuicoes_secretaria` TEXT,
	 `link_sitesecretaria` VARCHAR(255),
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;
