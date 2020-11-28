DROP TABLE IF EXISTS "#__prefeitura";

CREATE TABLE "#__prefeitura" (
	 "id" SERIAL NOT NULL,
	 "published" INT DEFAULT 1,
	 "nome" VARCHAR(255),
	 "catid" int,
	PRIMARY KEY ("id")
)
