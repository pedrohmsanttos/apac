DROP TABLE IF EXISTS "#__avisohidrologico";

CREATE TABLE "#__avisohidrologico" (
	 id SERIAL NOT NULL,
	 published INT DEFAULT 1,
	 created timestamp,
	 conteudo TEXT,
	 tipo INT,
	 ordering INT,
	 identificador VARCHAR(200),
	 titulo text,
	 validade timestamp,
	 inicio timestamp,
	 regioes VARCHAR(200),
	 tags VARCHAR(200),
	 area VARCHAR(20),
	 descricao VARCHAR(1000),
	  user_id INT,
	 associados VARCHAR(1000),
	 arquivo_1 VARCHAR(1000),
	 arquivo_2 VARCHAR(1000),
	 arquivo_3 VARCHAR(1000),
	 arquivo_4 VARCHAR(1000),
	PRIMARY KEY (id)
);
