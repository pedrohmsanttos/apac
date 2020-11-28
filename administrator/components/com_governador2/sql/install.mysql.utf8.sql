DROP TABLE IF EXISTS `#__governador`;
 
CREATE TABLE `#__governador` (
	 `id` INT(11)     NOT NULL AUTO_INCREMENT,
	 `published` INT(1) DEFAULT 1,
	 `nome` VARCHAR(150),
	 `ano` VARCHAR(500),
	 `imagem` VARCHAR(200),
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;