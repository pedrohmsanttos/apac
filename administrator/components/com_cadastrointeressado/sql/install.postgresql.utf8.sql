CREATE TABLE IF NOT EXISTS "#__cadastrointeressado" (
id SERIAL NOT NULL,
nome VARCHAR(255)   ,
email VARCHAR(255)   ,
observacao TEXT   ,
situacao VARCHAR(255)   ,
pertencegoverno VARCHAR(255)   ,
boletim TEXT,
state INT  ,
ordering INT   ,
checked_out INT   ,
checked_out_time TIMESTAMP  ,
created_by INT   ,
modified_by INT   ,
noticias VARCHAR(255)   ,
licitacoes VARCHAR(255)   ,
confidencial VARCHAR(255)   ,
data_criacao DATE,
previsao_tempo VARCHAR(255)
PRIMARY KEY (id)
)

