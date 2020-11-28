DROP TABLE IF EXISTS `#__contato`;

CREATE TABLE `#__contato` (
	`id` INT(11)     NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(100),
	`assunto` VARCHAR(100),
	`endereco` VARCHAR(200),
	`numero` VARCHAR(100),
	`bairro` VARCHAR(100),
	`cep` VARCHAR(100),
	`complemento` VARCHAR(100),
	`cidade` VARCHAR(100),
	`estado` VARCHAR(100),
	`telefone` VARCHAR(100),
	`celular` VARCHAR(100),
	`mensagem` VARCHAR(500),
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;