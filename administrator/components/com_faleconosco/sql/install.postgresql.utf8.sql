DROP TABLE IF EXISTS '#__contato';

CREATE TABLE '#__contato' (
	id serial NOT NULL,
	published integer DEFAULT 1,
	nome character varying(500),
	email character varying(500),
	mensagem character varying(1000),
	created timestamp without time zone,
	status integer DEFAULT 1,
	setor character varying(1000)
	PRIMARY KEY (id)
)

CREATE TABLE '#__contato_setor' (
	id serial NOT NULL,
  	nome character varying(100) NOT NULL
	PRIMARY KEY (id)
)