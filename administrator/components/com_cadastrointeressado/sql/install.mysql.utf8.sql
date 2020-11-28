CREATE TABLE IF NOT EXISTS `#__cadastrointeressado` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`nome` VARCHAR(255)  NOT NULL ,
`email` VARCHAR(255)  NOT NULL ,
`observacao` VARCHAR(255)  NOT NULL ,
`situacao` VARCHAR(255)  NOT NULL ,
`pertencegoverno` VARCHAR(255)  NOT NULL ,
`meteoroligia_informes` VARCHAR(255)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`meteoroligia_avisos` VARCHAR(255)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`hidrologia_avisos` VARCHAR(255)  NOT NULL ,
`hidrologia_informes` VARCHAR(255)  NOT NULL ,
`noticias` VARCHAR(255)  NOT NULL ,
`licitacoes` VARCHAR(255)  NOT NULL ,
`confidencial` VARCHAR(255)  NOT NULL ,
`enviado` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

