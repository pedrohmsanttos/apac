DROP TABLE IF EXISTS "#__secretario";

CREATE TABLE "#__secretario" (
	 id SERIAL  NOT NULL,
	 published INT,
	 nome_secretario VARCHAR(255),
	 imagem VARCHAR(500),
	 endereco_secretario VARCHAR(255),
	 sobre_secretario TEXT,
	 atribuicoes_secretaria TEXT,
	 link_sitesecretaria VARCHAR(255),
	PRIMARY KEY (id)
)
