
CREATE TABLE IF NOT EXISTS "#__envio_de_artigos" (
	id SERIAL NOT NULL,
	created_by INT NOT NULL,
	state INT NOT NULL,
	ordering INT NOT NULL,
	enviado INT NOT NULL,
	artigo_id INT NOT NULL,
	PRIMARY KEY (id)
)
