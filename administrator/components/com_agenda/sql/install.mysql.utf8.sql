DROP TABLE IF EXISTS `#__agenda`;

CREATE TABLE `#__agenda` (
	 `id` INT(11) NOT NULL AUTO_INCREMENT,
	 `published` INT(1) DEFAULT 1,
	 `titulo` VARCHAR(150),
	 `descricao` VARCHAR(500),
	 `local` VARCHAR(200),
	 `data` DATETIME,
	 `link_noticia` INT(11),
	 `catid` INT(11),
	PRIMARY KEY (`id`)
)
