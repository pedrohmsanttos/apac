DROP TABLE IF EXISTS "#__secretaria";

CREATE TABLE "#__secretaria" (
	 id SERIAL NOT NULL,
	 published INT,
	 titulo VARCHAR(255),
	 subtitulo VARCHAR(255),
	 conteudo VARCHAR(500),
	 link_maisinfo VARCHAR(255),
	 link_acessowebsite VARCHAR(255),
	 link_email VARCHAR(255),
	PRIMARY KEY (id)
)
