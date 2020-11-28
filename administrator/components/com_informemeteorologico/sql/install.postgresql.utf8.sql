DROP TABLE IF EXISTS "#__informemeteorologico";

CREATE TABLE "#__informemeteorologico" (
    id SERIAL NOT NULL,
    ordering INT ,
    state INT ,
    checked_out INT   ,
    checked_out_time TIMESTAMP  ,
    created_by INT ,
    modified_by INT ,
    titulo VARCHAR(255)  NOT NULL ,
    tipo TEXT NOT NULL ,
    observacao TEXT ,
    tags VARCHAR(255) ,
    arquivo TEXT NOT NULL ,
    publicacao TIMESTAMP NOT NULL ,
	PRIMARY KEY (id)
)