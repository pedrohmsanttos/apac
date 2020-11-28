DROP TABLE IF EXISTS "#__previsaodotempo_previsao";

CREATE TABLE "#__previsaodotempo_previsao"
(
    "id" SERIAL NOT NULL,
    "ordering" INT  NOT NULL,
    "state" SMALLINT  NOT NULL,
    "checked_out" INT  NOT NULL,
    "checked_out_time" TIMESTAMP(0) NOT NULL,
    "checked_update_time" TIMESTAMP(0) NOT NULL,
    "created_by" INT  NOT NULL,
    "modified_by" INT  NOT NULL,
    "datavlida" DATE NOT NULL,
    "tipo" VARCHAR(255)  NOT NULL,
    "horario" TIME(0) NOT NULL,
    "valores" text,
    "mesorregioes" text,
    "observaes" TEXT NOT NULL,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "#__previsaodotempo_mesorregiao";

CREATE TABLE "#__previsaodotempo_mesorregiao"
(
  "id" serial NOT NULL,
  "ordering" integer NOT NULL,
  "state" smallint NOT NULL,
  "checked_out" integer NOT NULL,
  "checked_out_time" timestamp(0) without time zone NOT NULL,
  "created_by" integer NOT NULL,
  "modified_by" integer NOT NULL,
  "nome" character varying(255) NOT NULL,
  "descricao" text NOT NULL,
  "geojson" text NOT NULL,
  PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "#__previsaodotempo_variavel";

CREATE TABLE "#__previsaodotempo_variavel"
(
  "id" serial NOT NULL,
  "nome" character varying(255) NOT NULL,
  "ordering" integer NOT NULL,
  "state" smallint NOT NULL,
  "checked_out" integer NOT NULL,
  "checked_out_time" timestamp(0) without time zone NOT NULL,
  "created_by" integer NOT NULL,
  "modified_by" integer NOT NULL,
  PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "#__previsaodotempo_icone";

CREATE TABLE "#__previsaodotempo_icone"
(
  "id" serial NOT NULL,
  "ordering" integer NOT NULL,
  "state" smallint NOT NULL,
  "checked_out" integer NOT NULL,
  "checked_out_time" timestamp(0) without time zone NOT NULL,
  "created_by" integer NOT NULL,
  "modified_by" integer NOT NULL,
  "nome" character varying(255) NOT NULL,
  "icone" character varying(255) NOT NULL,
  PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "#__previsaodotempo_variavel_valor";

CREATE TABLE "#__previsaodotempo_variavel_valor"
(
  "id" serial NOT NULL,
  "valor" character varying(255) NOT NULL,
  "id_variavel" integer NOT NULL,
  "checked_out" integer NOT NULL,
  "checked_out_time" timestamp(0) without time zone NOT NULL,
  "created_by" integer NOT NULL,
  PRIMARY KEY ("id")
);