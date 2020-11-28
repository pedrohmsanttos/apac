DROP TABLE IF EXISTS `#__prefeitura`;
 
CREATE TABLE `#__prefeitura` (
	 `id` INT(11)     NOT NULL AUTO_INCREMENT,
	 `published` INT(1) DEFAULT 1,
	 `nome` VARCHAR(255),
	 `catid` int(11),
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;