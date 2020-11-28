DROP TABLE IF EXISTS "#__servico";

CREATE TABLE "#__servico" (
	 "id" SERIAL NOT NULL,
	 "published" INT DEFAULT 1,
	 "titulo" VARCHAR(255),
	 "subtitulo" VARCHAR(255),
	 "conteudo" VARCHAR(500),
	 "catid" INT,
	 "link_maisinfo" VARCHAR(255),
	 "link_acessowebsite" VARCHAR(255),
	 "link_email" VARCHAR(255),
	 "ordering" bigint NOT NULL DEFAULT 0,
	 PRIMARY KEY ("id")
)
