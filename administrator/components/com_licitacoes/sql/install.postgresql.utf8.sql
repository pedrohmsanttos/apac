DROP TABLE IF EXISTS "#__licitacoes";

CREATE TABLE "#__licitacoes" (
 	id SERIAL NOT NULL,
    ordering INT ,
    state INT ,
    checked_out INT   ,
    checked_out_time TIMESTAMP  ,
    created_by INT ,
    modified_by INT ,
	publicado VARCHAR(255)  NOT NULL ,
	titulo VARCHAR(255)  NOT NULL ,
	resumo TEXT NOT NULL ,
	data_licitacao DATE NOT NULL ,
	numero_processo VARCHAR(255)  NOT NULL ,
	ano_processo VARCHAR(255)  NOT NULL ,
	modalidade VARCHAR(255)  NOT NULL ,
	numero_modalidade VARCHAR(255)  NOT NULL ,
	ano_modalidade VARCHAR(255)  NOT NULL ,
	objeto TEXT NOT NULL ,
	data_publicacao DATE NOT NULL ,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS "#__modalidade_licitacao";

CREATE TABLE "#__modalidade_licitacao" (
	id SERIAL NOT NULL,
	nome VARCHAR(255)  NOT NULL ,
	ativo INT DEFAULT 1,
	PRIMARY KEY (id)
);

INSERT INTO "#__modalidade_licitacao"(nome) VALUES('Concorrência');
INSERT INTO "#__modalidade_licitacao"(nome) VALUES('Convite');
INSERT INTO "#__modalidade_licitacao"(nome) VALUES('Tomada de preços');
INSERT INTO "#__modalidade_licitacao"(nome) VALUES('Pregão Eletrônico');
INSERT INTO "#__modalidade_licitacao"(nome) VALUES('Pregão Presencial');
INSERT INTO "#__modalidade_licitacao"(nome) VALUES('Inexigibilidade de Licitação');
INSERT INTO "#__modalidade_licitacao"(nome) VALUES('Dispensa de Licitação');


DROP TABLE IF EXISTS "#__arquivos_licitacao";

CREATE TABLE "#__arquivos_licitacao"
(
  "id" serial NOT NULL,
  "ordering" integer NOT NULL,
  "state" smallint NOT NULL,
  "checked_out" integer NOT NULL,
  "checked_out_time" timestamp(0) without time zone NOT NULL,
  "created_by" integer NOT NULL,
  "modified_by" integer NOT NULL,
  "id_licitacao" integer NOT NULL,
  "titulo" character varying(255) NOT NULL,
  "arquivo" character varying(255) NOT NULL,
  "tipo" integer NOT NULL,
  PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "#__relatorio_licitacao";

CREATE TABLE "#__relatorio_licitacao" (

"id" serial NOT NULL,
"state" integer NOT NULL,
"checked_out" integer NOT NULL,
"checked_out_time" timestamp(0) NOT NULL,
"created_by" integer NOT NULL,
"modified_by" integer NOT NULL,
"id_licitacao" integer NOT NULL,
"documento_usuario" varchar(255) NOT NULL,
"numero_processo" varchar(255)  NOT NULL,
"ano_processo" varchar(255)  NOT NULL,
"nome_razao" varchar(255)  NOT NULL,
"data_download" varchar(255)  NOT NULL,
"id_users" integer,
"tipo_users" varchar(1),
"telefone_users" varchar(255),
PRIMARY KEY ("id")
);


