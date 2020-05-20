CREATE SEQUENCE public.id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.id_seq
    OWNER TO euronet;


CREATE TABLE public.person
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    name character varying(30) COLLATE pg_catalog."default" NOT NULL,
    birthdate date NOT NULL,
    gender bit(1) NOT NULL,
    CONSTRAINT person_pkey PRIMARY KEY (id),
    CONSTRAINT person_name_birthdate_gender_key UNIQUE (name, birthdate, gender)
)

TABLESPACE pg_default;

ALTER TABLE public.person
    OWNER to euronet;