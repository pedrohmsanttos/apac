DROP TABLE IF EXISTS "#__telefone";

CREATE TABLE "#__telefone" (
	 "id" SERIAL NOT NULL,
	 "published" INT,
	 "descricao" VARCHAR(255),
	 "numero" VARCHAR(255),
	 "catid" INT,
	PRIMARY KEY ("id")
)
