DROP TABLE IF EXISTS "#__avisometeorologico";

CREATE TABLE "#__avisometeorologico" (
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
	PRIMARY KEY (id)
);

CREATE TABLE "#__avisometeorologico_anexo" (
	id SERIAL NOT NULL,
	arquivo VARCHAR(500),
	titulo VARCHAR(500),
	created timestamp,
	id_aviso INT,
	id_user INT,
	tipo INT,
	PRIMARY KEY (id)
);
