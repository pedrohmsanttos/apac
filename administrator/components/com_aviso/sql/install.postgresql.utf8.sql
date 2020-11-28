DROP TABLE IF EXISTS "#__aviso";

CREATE TABLE "#__aviso" (
	 id SERIAL NOT NULL,
	 published INT DEFAULT 1,
	 created timestamp,
	 conteudo VARCHAR(1000),
	 tipo INT,
	 ordering INT,
	 identificador VARCHAR(200),
	 titulo VARCHAR(200),
	 titulo text,
	 validade timestamp,
	 inicio timestamp,
	 regioes VARCHAR(200),
	 tags VARCHAR(200),
	 descricao VARCHAR(1000),
	PRIMARY KEY (id)
)

CREATE TABLE "#__regioes" (
	 id SERIAL NOT NULL,
	 published INT DEFAULT 1,
	 catid INT,
	 descricao VARCHAR(200),
	 title VARCHAR(500),
	PRIMARY KEY (id)
)
