-- Adminer 4.7.3 PostgreSQL dump

DROP TABLE IF EXISTS "article";
DROP SEQUENCE IF EXISTS article_id_seq;
CREATE SEQUENCE article_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."article" (
    "id" integer DEFAULT nextval('article_id_seq') NOT NULL,
    "title" character varying(255) NOT NULL,
    "stars" smallint NOT NULL,
    CONSTRAINT "article_id" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "article" ("id", "title", "stars") VALUES
(2,	'PHP 5',	3),
(3,	'PHP 8',	4),
(4,	'PHP 7',	5),
(1,	'PHP 6',	1);

-- 2019-10-17 07:39:51.202973+00
