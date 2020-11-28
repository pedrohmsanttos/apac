DROP TABLE IF EXISTS `#__arquivo`;
CREATE TABLE `#__arquivo` (
	 `id` INT(11)     NOT NULL AUTO_INCREMENT,
	 `published` INT(1) DEFAULT 1,
	 `titulo` VARCHAR(255),
	 `arquivo` VARCHAR(255),
   `link` VARCHAR(500),
	 `tipo` VARCHAR(500),
	 `catid` int(11),
	PRIMARY KEY (`id`)
);

CREATE TABLE `#__arquivo_castegorias` (
	 `id` INT(11)     NOT NULL AUTO_INCREMENT,
	 `published` INT(1) DEFAULT 1,
	 `titulo` VARCHAR(255),
	 `icone` VARCHAR(255),
	PRIMARY KEY (`id`)
);
