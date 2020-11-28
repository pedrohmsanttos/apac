CREATE TABLE IF NOT EXISTS `#__previsaodotempo_previsao` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`datavlida` DATE NOT NULL ,
`tipo` VARCHAR(255)  NOT NULL ,
`horario` TIME NOT NULL ,
`observaes` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

