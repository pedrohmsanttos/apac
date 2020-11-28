DROP TABLE IF EXISTS `#__telefone`;
 
CREATE TABLE `#__telefone` (
	 `id` INT(11)     NOT NULL AUTO_INCREMENT,
	 `published` INT(11),
	 `descricao` VARCHAR(255),
	 `numero` VARCHAR(255),
	 `catid` INT(11),
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

-- campo de categoria é uma flag para definir onde vai carregar cada tipo de telefone, ex: 1 urgencia e 2 serviços publicos.