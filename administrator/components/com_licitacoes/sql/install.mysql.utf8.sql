/*CREATE TABLE IF NOT EXISTS `#__licitacoes` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`publicado` VARCHAR(255)  NOT NULL ,
`titulo` VARCHAR(255)  NOT NULL ,
`resumo` TEXT NOT NULL ,
`data_licitacao` DATE NOT NULL ,
`numero_processo` VARCHAR(255)  NOT NULL ,
`ano_processo` VARCHAR(255)  NOT NULL ,
`modalidade` VARCHAR(255)  NOT NULL ,
`numero_modalidade` VARCHAR(255)  NOT NULL ,
`ano_modalidade` VARCHAR(255)  NOT NULL ,
`objeto` TEXT NOT NULL ,
`data_publicacao` DATE NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;
*/
