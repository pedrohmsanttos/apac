DROP TABLE IF EXISTS "#__acaogoverno";

CREATE TABLE "#__acaogoverno" (
	 "id" SERIAL NOT NULL,
	 "published" INT,
	 "titulo" VARCHAR(255),
	 "conteudo" VARCHAR(500),
	 "imagem" VARCHAR(255),
	 "artigo_id" INT,
	PRIMARY KEY ("id")
)
