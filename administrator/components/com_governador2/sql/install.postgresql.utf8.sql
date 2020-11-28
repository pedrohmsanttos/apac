DROP TABLE IF EXISTS "#__governador";

CREATE TABLE "#__governador" (
	 id SERIAL NOT NULL,
	 published INT DEFAULT 1,
	 nome VARCHAR(150),
	 ano VARCHAR(500),
	 imagem VARCHAR(200),
	PRIMARY KEY (id)
)
