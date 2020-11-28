DROP TABLE IF EXISTS `#__secretaria`;
 
CREATE TABLE `#__secretaria` (
	 `id` INT(11)     NOT NULL AUTO_INCREMENT,
	 `published` INT(11),
	 `titulo` VARCHAR(255),
	 `subtitulo` VARCHAR(255),
	 `conteudo` VARCHAR(500),
	 `link_maisinfo` VARCHAR(255),
	 `link_acessowebsite` VARCHAR(255),
	 `link_email` VARCHAR(255),
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

