DROP TABLE IF EXISTS "#__arquivo";
CREATE TABLE "#__arquivo" (
	 "id" SERIAL NOT NULL,
	 "published" INT DEFAULT 1,
	 "titulo" VARCHAR(255),
	 "descricao" VARCHAR(500),
	 "formato" int,
	 "arquivo" VARCHAR(255),
	 "tags" VARCHAR(500),
	 "link" VARCHAR(500),
	 "linkonly" VARCHAR(500),
	 "catid" int,
	PRIMARY KEY ("id")
);
