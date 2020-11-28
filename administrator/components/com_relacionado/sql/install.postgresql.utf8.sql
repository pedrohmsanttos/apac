DROP TABLE IF EXISTS "#__relacionado";

CREATE TABLE "#__relacionado" (
	 id SERIAL NOT NULL,
	 published INT DEFAULT 1,
	 created timestamp,
	 titulo TEXT,
	 artigos TEXT,
	 ordering integer DEFAULT 0,
  	user_id integer,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS "#__relacionado_anexo";

CREATE TABLE "#__relacionado_anexo" (
	id SERIAL NOT NULL,
	arquivo TEXT,
	titulo TEXT,
	created timestamp,
	id_relacionado INT,
	parent_id INT,
	level_id INT,
	level_parent INT,
	id_user INT,
	tipo INT,
	PRIMARY KEY (id)
);