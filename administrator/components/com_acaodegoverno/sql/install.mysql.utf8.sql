DROP TABLE IF EXISTS `#__acaogoverno`;
 
CREATE TABLE `#__acaogoverno` (
	 `id` INT(11)     NOT NULL AUTO_INCREMENT,
	 `published` INT(11),
	 `titulo` VARCHAR(255),
	 `conteudo` VARCHAR(500),
	 `imagem` VARCHAR(255),
	 `artigo_id` INT(11),
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

