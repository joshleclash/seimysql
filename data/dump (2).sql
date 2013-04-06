--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'LATIN1';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: armor(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION armor(bytea) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pg_armor';


ALTER FUNCTION public.armor(bytea) OWNER TO postgres;

--
-- Name: crypt(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION crypt(text, text) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pg_crypt';


ALTER FUNCTION public.crypt(text, text) OWNER TO postgres;

--
-- Name: dearmor(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dearmor(text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pg_dearmor';


ALTER FUNCTION public.dearmor(text) OWNER TO postgres;

--
-- Name: decrypt(bytea, bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION decrypt(bytea, bytea, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pg_decrypt';


ALTER FUNCTION public.decrypt(bytea, bytea, text) OWNER TO postgres;

--
-- Name: decrypt_iv(bytea, bytea, bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION decrypt_iv(bytea, bytea, bytea, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pg_decrypt_iv';


ALTER FUNCTION public.decrypt_iv(bytea, bytea, bytea, text) OWNER TO postgres;

--
-- Name: digest(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION digest(text, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pg_digest';


ALTER FUNCTION public.digest(text, text) OWNER TO postgres;

--
-- Name: digest(bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION digest(bytea, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pg_digest';


ALTER FUNCTION public.digest(bytea, text) OWNER TO postgres;

--
-- Name: encrypt(bytea, bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION encrypt(bytea, bytea, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pg_encrypt';


ALTER FUNCTION public.encrypt(bytea, bytea, text) OWNER TO postgres;

--
-- Name: encrypt_iv(bytea, bytea, bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION encrypt_iv(bytea, bytea, bytea, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pg_encrypt_iv';


ALTER FUNCTION public.encrypt_iv(bytea, bytea, bytea, text) OWNER TO postgres;

--
-- Name: gen_random_bytes(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gen_random_bytes(integer) RETURNS bytea
    LANGUAGE c STRICT
    AS '$libdir/pgcrypto', 'pg_random_bytes';


ALTER FUNCTION public.gen_random_bytes(integer) OWNER TO postgres;

--
-- Name: gen_salt(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gen_salt(text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/pgcrypto', 'pg_gen_salt';


ALTER FUNCTION public.gen_salt(text) OWNER TO postgres;

--
-- Name: gen_salt(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gen_salt(text, integer) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/pgcrypto', 'pg_gen_salt_rounds';


ALTER FUNCTION public.gen_salt(text, integer) OWNER TO postgres;

--
-- Name: hmac(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION hmac(text, text, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pg_hmac';


ALTER FUNCTION public.hmac(text, text, text) OWNER TO postgres;

--
-- Name: hmac(bytea, bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION hmac(bytea, bytea, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pg_hmac';


ALTER FUNCTION public.hmac(bytea, bytea, text) OWNER TO postgres;

--
-- Name: pgp_key_id(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_key_id(bytea) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pgp_key_id_w';


ALTER FUNCTION public.pgp_key_id(bytea) OWNER TO postgres;

--
-- Name: pgp_pub_decrypt(bytea, bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_pub_decrypt(bytea, bytea) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pgp_pub_decrypt_text';


ALTER FUNCTION public.pgp_pub_decrypt(bytea, bytea) OWNER TO postgres;

--
-- Name: pgp_pub_decrypt(bytea, bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_pub_decrypt(bytea, bytea, text) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pgp_pub_decrypt_text';


ALTER FUNCTION public.pgp_pub_decrypt(bytea, bytea, text) OWNER TO postgres;

--
-- Name: pgp_pub_decrypt(bytea, bytea, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_pub_decrypt(bytea, bytea, text, text) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pgp_pub_decrypt_text';


ALTER FUNCTION public.pgp_pub_decrypt(bytea, bytea, text, text) OWNER TO postgres;

--
-- Name: pgp_pub_decrypt_bytea(bytea, bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_pub_decrypt_bytea(bytea, bytea) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pgp_pub_decrypt_bytea';


ALTER FUNCTION public.pgp_pub_decrypt_bytea(bytea, bytea) OWNER TO postgres;

--
-- Name: pgp_pub_decrypt_bytea(bytea, bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_pub_decrypt_bytea(bytea, bytea, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pgp_pub_decrypt_bytea';


ALTER FUNCTION public.pgp_pub_decrypt_bytea(bytea, bytea, text) OWNER TO postgres;

--
-- Name: pgp_pub_decrypt_bytea(bytea, bytea, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_pub_decrypt_bytea(bytea, bytea, text, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pgp_pub_decrypt_bytea';


ALTER FUNCTION public.pgp_pub_decrypt_bytea(bytea, bytea, text, text) OWNER TO postgres;

--
-- Name: pgp_pub_encrypt(text, bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_pub_encrypt(text, bytea) RETURNS bytea
    LANGUAGE c STRICT
    AS '$libdir/pgcrypto', 'pgp_pub_encrypt_text';


ALTER FUNCTION public.pgp_pub_encrypt(text, bytea) OWNER TO postgres;

--
-- Name: pgp_pub_encrypt(text, bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_pub_encrypt(text, bytea, text) RETURNS bytea
    LANGUAGE c STRICT
    AS '$libdir/pgcrypto', 'pgp_pub_encrypt_text';


ALTER FUNCTION public.pgp_pub_encrypt(text, bytea, text) OWNER TO postgres;

--
-- Name: pgp_pub_encrypt_bytea(bytea, bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_pub_encrypt_bytea(bytea, bytea) RETURNS bytea
    LANGUAGE c STRICT
    AS '$libdir/pgcrypto', 'pgp_pub_encrypt_bytea';


ALTER FUNCTION public.pgp_pub_encrypt_bytea(bytea, bytea) OWNER TO postgres;

--
-- Name: pgp_pub_encrypt_bytea(bytea, bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_pub_encrypt_bytea(bytea, bytea, text) RETURNS bytea
    LANGUAGE c STRICT
    AS '$libdir/pgcrypto', 'pgp_pub_encrypt_bytea';


ALTER FUNCTION public.pgp_pub_encrypt_bytea(bytea, bytea, text) OWNER TO postgres;

--
-- Name: pgp_sym_decrypt(bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_sym_decrypt(bytea, text) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pgp_sym_decrypt_text';


ALTER FUNCTION public.pgp_sym_decrypt(bytea, text) OWNER TO postgres;

--
-- Name: pgp_sym_decrypt(bytea, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_sym_decrypt(bytea, text, text) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pgp_sym_decrypt_text';


ALTER FUNCTION public.pgp_sym_decrypt(bytea, text, text) OWNER TO postgres;

--
-- Name: pgp_sym_decrypt_bytea(bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_sym_decrypt_bytea(bytea, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pgp_sym_decrypt_bytea';


ALTER FUNCTION public.pgp_sym_decrypt_bytea(bytea, text) OWNER TO postgres;

--
-- Name: pgp_sym_decrypt_bytea(bytea, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_sym_decrypt_bytea(bytea, text, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/pgcrypto', 'pgp_sym_decrypt_bytea';


ALTER FUNCTION public.pgp_sym_decrypt_bytea(bytea, text, text) OWNER TO postgres;

--
-- Name: pgp_sym_encrypt(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_sym_encrypt(text, text) RETURNS bytea
    LANGUAGE c STRICT
    AS '$libdir/pgcrypto', 'pgp_sym_encrypt_text';


ALTER FUNCTION public.pgp_sym_encrypt(text, text) OWNER TO postgres;

--
-- Name: pgp_sym_encrypt(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_sym_encrypt(text, text, text) RETURNS bytea
    LANGUAGE c STRICT
    AS '$libdir/pgcrypto', 'pgp_sym_encrypt_text';


ALTER FUNCTION public.pgp_sym_encrypt(text, text, text) OWNER TO postgres;

--
-- Name: pgp_sym_encrypt_bytea(bytea, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_sym_encrypt_bytea(bytea, text) RETURNS bytea
    LANGUAGE c STRICT
    AS '$libdir/pgcrypto', 'pgp_sym_encrypt_bytea';


ALTER FUNCTION public.pgp_sym_encrypt_bytea(bytea, text) OWNER TO postgres;

--
-- Name: pgp_sym_encrypt_bytea(bytea, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgp_sym_encrypt_bytea(bytea, text, text) RETURNS bytea
    LANGUAGE c STRICT
    AS '$libdir/pgcrypto', 'pgp_sym_encrypt_bytea';


ALTER FUNCTION public.pgp_sym_encrypt_bytea(bytea, text, text) OWNER TO postgres;

--
-- Name: trigger_juego_mapa(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION trigger_juego_mapa() RETURNS trigger
    LANGUAGE plpgsql
    AS $$



DECLARE

   v_id_mapa INTEGER;

   v_query VARCHAR;

   v_record RECORD;

BEGIN

   v_id_mapa = NEW.id_mapa_conceptual;

   v_query = 'SELECT id_juego

	      FROM   juego';

   FOR v_record IN EXECUTE v_query 

   LOOP

      v_query = 'INSERT INTO juego_mapa ( mapa_conceptual_id_mapa_conceptual, juego_id_juego, estado_juego_mapa, mostrar_status, duracion_juego )

		 VALUES ( ' || v_id_mapa || ', ' || v_record.id_juego || ', 0, 1, 0 );';

      EXECUTE v_query;

   END LOOP;

 RETURN NEW;

END;

$$;


ALTER FUNCTION public.trigger_juego_mapa() OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = true;

--
-- Name: concepto; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE concepto (
    mapa_conceptual_id_mapa_conceptual integer NOT NULL,
    id_concepto character varying(70) NOT NULL,
    nombre_concepto character varying(100),
    texto_concepto text
);


ALTER TABLE public.concepto OWNER TO postgres;

--
-- Name: grupo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grupo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grupo_seq OWNER TO postgres;

--
-- Name: grupo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grupo_seq', 3, true);


--
-- Name: grupo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grupo (
    nombre_grupo character varying(30) NOT NULL,
    descripcion_grupo text NOT NULL,
    id_grupo integer DEFAULT nextval('grupo_seq'::regclass) NOT NULL
);


ALTER TABLE public.grupo OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: grupo_mapa_conceptual; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grupo_mapa_conceptual (
    mapa_conceptual_id_mapa integer NOT NULL,
    grupo_id_grupo integer NOT NULL
);


ALTER TABLE public.grupo_mapa_conceptual OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: grupo_usuario; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grupo_usuario (
    grupo_id_grupo integer NOT NULL,
    usuario_id_usuario integer NOT NULL
);


ALTER TABLE public.grupo_usuario OWNER TO postgres;

--
-- Name: historial_juego_respuesta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE historial_juego_respuesta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.historial_juego_respuesta_seq OWNER TO postgres;

--
-- Name: historial_juego_respuesta_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('historial_juego_respuesta_seq', 2, true);


--
-- Name: historial_juego_respuesta; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE historial_juego_respuesta (
    juego_mapa_juego_id_juego integer NOT NULL,
    juego_mapa_mapa_conceptual_id_mapa_conceptual integer NOT NULL,
    usuario_id_usuario integer NOT NULL,
    duracion_real integer,
    fecha_realizacion date,
    respuestas_acertadas character varying(10) NOT NULL,
    id_historial_juego_respuesta integer DEFAULT nextval('historial_juego_respuesta_seq'::regclass) NOT NULL
);


ALTER TABLE public.historial_juego_respuesta OWNER TO postgres;

--
-- Name: historial_mapa_conceptual_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE historial_mapa_conceptual_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.historial_mapa_conceptual_seq OWNER TO postgres;

--
-- Name: historial_mapa_conceptual_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('historial_mapa_conceptual_seq', 1, false);


--
-- Name: historial_mapa_conceptual; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE historial_mapa_conceptual (
    mapa_conceptual_id_mapa_conceptual integer NOT NULL,
    vigencia integer NOT NULL,
    fecha_inicio date NOT NULL,
    fecha_limite date NOT NULL,
    id_historial_mapa_conceptual integer DEFAULT nextval('historial_mapa_conceptual_seq'::regclass) NOT NULL,
    estado_mp boolean NOT NULL
);


ALTER TABLE public.historial_mapa_conceptual OWNER TO postgres;

--
-- Name: juego_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE juego_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.juego_seq OWNER TO postgres;

--
-- Name: juego_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('juego_seq', 1, false);


--
-- Name: juego; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE juego (
    nombre_juego character varying(30) NOT NULL,
    id_juego integer DEFAULT nextval('juego_seq'::regclass) NOT NULL
);


ALTER TABLE public.juego OWNER TO postgres;

--
-- Name: juego_mapa; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE juego_mapa (
    mapa_conceptual_id_mapa_conceptual integer NOT NULL,
    juego_id_juego integer NOT NULL,
    duracion_juego integer,
    estado_juego_mapa integer DEFAULT 0 NOT NULL,
    mostrar_status integer DEFAULT 1 NOT NULL
);


ALTER TABLE public.juego_mapa OWNER TO postgres;

--
-- Name: mapa_conceptual_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE mapa_conceptual_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mapa_conceptual_seq OWNER TO postgres;

--
-- Name: mapa_conceptual_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('mapa_conceptual_seq', 13, true);


--
-- Name: mapa_conceptual; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mapa_conceptual (
    usuario_id_usuario integer NOT NULL,
    tipo_mapa_id_tipo_mapa integer NOT NULL,
    nombre_mapa character varying(30) NOT NULL,
    total_conceptos integer NOT NULL,
    total_relaciones integer NOT NULL,
    estado_mapa character(1) NOT NULL,
    duracion_mapa integer NOT NULL,
    fecha_inicio timestamp without time zone NOT NULL,
    fecha_limite timestamp without time zone NOT NULL,
    id_mapa_conceptual integer DEFAULT nextval('mapa_conceptual_seq'::regclass) NOT NULL
);


ALTER TABLE public.mapa_conceptual OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: mapa_conceptual_tematica; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mapa_conceptual_tematica (
    tematica_id_tematica integer NOT NULL,
    mapa_conceptual_id_mapa_conceptual integer NOT NULL
);


ALTER TABLE public.mapa_conceptual_tematica OWNER TO postgres;

--
-- Name: perfil_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE perfil_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.perfil_seq OWNER TO postgres;

--
-- Name: perfil_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('perfil_seq', 1, true);


SET default_with_oids = true;

--
-- Name: perfil; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE perfil (
    nombre_perfil character varying(25),
    id_perfil integer DEFAULT nextval('perfil_seq'::regclass) NOT NULL
);


ALTER TABLE public.perfil OWNER TO postgres;

--
-- Name: relacion; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE relacion (
    concepto_mapa_conceptual_id_mapa_conceptual integer NOT NULL,
    concepto_id_concepto character varying(70) NOT NULL,
    id_concepto_hijo character varying(70) NOT NULL,
    nombre_relacion character varying(100) NOT NULL
);


ALTER TABLE public.relacion OWNER TO postgres;

--
-- Name: resultado_pregunta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE resultado_pregunta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.resultado_pregunta_seq OWNER TO postgres;

--
-- Name: resultado_pregunta_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('resultado_pregunta_seq', 6, true);


--
-- Name: resultado_pregunta; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE resultado_pregunta (
    usuario_id_usuario integer NOT NULL,
    relacion_concepto_mapa_conceptual_id_mapa_conceptual integer NOT NULL,
    relacion_concepto_id_concepto character varying(70) NOT NULL,
    relacion_id_concepto_hijo character varying(70) NOT NULL,
    valoracion_pregunta boolean NOT NULL,
    id_resultado_pregunta integer DEFAULT nextval('resultado_pregunta_seq'::regclass) NOT NULL
);


ALTER TABLE public.resultado_pregunta OWNER TO postgres;

--
-- Name: tematica_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tematica_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tematica_seq OWNER TO postgres;

--
-- Name: tematica_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tematica_seq', 3, true);


SET default_with_oids = false;

--
-- Name: tematica; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tematica (
    nombre_tematica character varying(50) NOT NULL,
    id_tematica integer DEFAULT nextval('tematica_seq'::regclass) NOT NULL
);


ALTER TABLE public.tematica OWNER TO postgres;

--
-- Name: tipo_mapa_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_mapa_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_mapa_seq OWNER TO postgres;

--
-- Name: tipo_mapa_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_mapa_seq', 1, false);


SET default_with_oids = true;

--
-- Name: tipo_mapa; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_mapa (
    nombre_tipo_mapa character varying(30) NOT NULL,
    id_tipo_mapa integer DEFAULT nextval('tipo_mapa_seq'::regclass) NOT NULL
);


ALTER TABLE public.tipo_mapa OWNER TO postgres;

--
-- Name: usuario; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usuario (
    id_usuario integer NOT NULL,
    perfil_id_perfil integer NOT NULL,
    nombre_usuario character varying(45) NOT NULL,
    apellido_usuario character varying(45) NOT NULL,
    clave text NOT NULL,
    correo_usuario character varying(60) NOT NULL
);


ALTER TABLE public.usuario OWNER TO postgres;

--
-- Data for Name: concepto; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO concepto VALUES (2, '1', 'ELABORACIÓN DE PROYECTOS', '');
INSERT INTO concepto VALUES (2, '1.1', 'IDENTIFICAR', '');
INSERT INTO concepto VALUES (2, '1.1.1', 'ASPECTOS', '');
INSERT INTO concepto VALUES (2, '1.1.2', 'CONFORMAN', '');
INSERT INTO concepto VALUES (2, '1.2', 'LENGUAJE CLARO', '');
INSERT INTO concepto VALUES (2, '1.2.1', 'NIVEL', '');
INSERT INTO concepto VALUES (2, '1.2.1.1', 'GERENCIAL', '');
INSERT INTO concepto VALUES (2, '1.2.1.2', 'TÉCNICO', '');
INSERT INTO concepto VALUES (2, '1.2.1.3', 'USUARIO', '');
INSERT INTO concepto VALUES (2, '1.3', 'DOCUMENTOS', '');
INSERT INTO concepto VALUES (2, '1.3.1', 'CARPETA GENERAL', '');
INSERT INTO concepto VALUES (2, '1.3.1.1', 'DETALLES', '');
INSERT INTO concepto VALUES (2, '1.3.1.2', 'BASES', '');
INSERT INTO concepto VALUES (2, '1.3.1.3', 'ORIGENES', '');
INSERT INTO concepto VALUES (2, '1.3.1.4', 'PROYECTO', '');
INSERT INTO concepto VALUES (2, '1.3.2', 'PLAN ECONÓMICO (FACTIBILIDAD)', '');
INSERT INTO concepto VALUES (2, '1.3.2.1', 'COSTOS', '');
INSERT INTO concepto VALUES (2, '1.3.2.2', 'DESARROLLO', '');
INSERT INTO concepto VALUES (2, '1.3.2.3', 'IMPLEMENTACION', '');
INSERT INTO concepto VALUES (2, '1.3.2.4', 'EJECUCION', '');
INSERT INTO concepto VALUES (3, '1', 'TEORIA GENERAL DE SISTEMAS', '');
INSERT INTO concepto VALUES (3, '1.1', 'SISTEMAS INTERACTUANTES', '');
INSERT INTO concepto VALUES (3, '1.1.1', 'OBJETIVO', '');
INSERT INTO concepto VALUES (3, '1.1.2', 'SISTEMAS', '');
INSERT INTO concepto VALUES (3, '1.1.2.1', 'ABIERTOS', '');
INSERT INTO concepto VALUES (3, '1.1.2.2', 'ESTRUCTURA', '');
INSERT INTO concepto VALUES (3, '1.2', 'ASTRACTOS', '');
INSERT INTO concepto VALUES (3, '1.2.1', 'CONCRETOS', '');
INSERT INTO concepto VALUES (3, '1.2.1.1', 'OBJETOS REALES', '');
INSERT INTO concepto VALUES (3, '1.2.2', 'SIMPLES', '');
INSERT INTO concepto VALUES (3, '1.2.2.1', 'ABIERTO', '');
INSERT INTO concepto VALUES (3, '1.2.2.1.1', 'ENTORNO', '');
INSERT INTO concepto VALUES (3, '1.2.2.1.2', 'ELEMENTOS DE SU ESTRUCTURA', '');
INSERT INTO concepto VALUES (3, '1.2.2.2', 'CERRADO', '');
INSERT INTO concepto VALUES (3, '1.2.2.2.1', 'SU ESTRUCTURA POR SI MISMA', '');
INSERT INTO concepto VALUES (3, '1.2.2.2.1.1', 'SINERGIA,', '');
INSERT INTO concepto VALUES (3, '1.2.2.2.1.1.1', 'ELEMENTOS', '');
INSERT INTO concepto VALUES (3, '1.2.2.2.1.2', 'RECURSIVIDAD', '');
INSERT INTO concepto VALUES (3, '1.2.2.2.1.2.1', 'TRANSPASAN SUS LIMITES', '');
INSERT INTO concepto VALUES (3, '1.2.2.2.1.2.2', 'FUNCIONAMIENTO', '');
INSERT INTO concepto VALUES (3, '1.2.2.2.1.3', 'HOMEÓSTASIS', '');
INSERT INTO concepto VALUES (3, '1.2.2.2.1.3.1', 'EQUILIBRIO DINÁMICO', '');
INSERT INTO concepto VALUES (3, '1.2.2.2.1.3.2', 'SISTEMA', '');
INSERT INTO concepto VALUES (3, '1.2.2.2.1.3.3', 'AMBIENTE', '');
INSERT INTO concepto VALUES (3, '1.2.2.3', 'COMPUESTOS', '');
INSERT INTO concepto VALUES (3, '1.2.2.3.1', 'SEMI-CERRADA O SEMI-ABIERTA', '');
INSERT INTO concepto VALUES (3, '1.2.2.3.2', 'ELEMENTOS', '');
INSERT INTO concepto VALUES (3, '1.2.2.3.2.1', 'INTERACCIÓN,INTERDEPENCIA', '');
INSERT INTO concepto VALUES (3, '1.2.2.3.2.2', 'OBJETIVOS', '');
INSERT INTO concepto VALUES (3, '1.2.2.3.2.2.1', 'PROPOSITOS ALCANZADOS', '');
INSERT INTO concepto VALUES (3, '1.2.2.3.2.3', '[Concepto]', '');
INSERT INTO concepto VALUES (4, '1', 'ORGANIZACIÓN DE INFORMACIÓN', '');
INSERT INTO concepto VALUES (4, '1.1', 'SUBSISTEMAS', '');
INSERT INTO concepto VALUES (4, '1.1.1', 'INTERACTÚAN DINAMICAMENTE', '');
INSERT INTO concepto VALUES (4, '1.1.1.1', 'FENÓMENOS ORGANIZACIONALES', '');
INSERT INTO concepto VALUES (4, '1.1.1.1.1', 'COMPORTAMIENTOS INDIVIDUALES', '');
INSERT INTO concepto VALUES (4, '1.1.1.1.1.1', 'ACEPTADO,DOCUMENTADO Y PROBADO', '');
INSERT INTO concepto VALUES (4, '1.2', 'ESTRATEGICO', '');
INSERT INTO concepto VALUES (4, '1.2.1', 'DIRECTORES', '');
INSERT INTO concepto VALUES (4, '1.2.1.1', 'S. APOYO A EJECUTIVOS (SSE)', '');
INSERT INTO concepto VALUES (4, '1.3', 'ADMINISTRATIVO', '');
INSERT INTO concepto VALUES (4, '1.3.1', 'GERENTES', '');
INSERT INTO concepto VALUES (4, '1.3.1.1', 'S. INFORMACIÓN GERENCIAL (MIS))', '');
INSERT INTO concepto VALUES (4, '1.3.1.1.1', 'RECOLECCIÓN DE SISTEMA DE INFORMACIÓN', '');
INSERT INTO concepto VALUES (4, '1.4', 'OPERATIVO', '');
INSERT INTO concepto VALUES (4, '1.4.1', 'OPERACIONES PRINCIPALES', '');
INSERT INTO concepto VALUES (4, '1.4.1.1', 'S. PROCESAMIENTO DE TRANSACCIONES', '');
INSERT INTO concepto VALUES (4, '1.5', 'ORGANIZACIONES INTELIGENTES', '');
INSERT INTO concepto VALUES (4, '1.5.1', 'SISTEMAS DE INFORMACIÓN', '');
INSERT INTO concepto VALUES (4, '1.5.1.1', 'EQUIPO DE TRABAJO Y ORGANIZACIÓN DE INFORMACIÓN', '');
INSERT INTO concepto VALUES (4, '1.5.1.1.1', 'PRINCIPIOS, EFICACIA Y EFICIENCIA', '');
INSERT INTO concepto VALUES (4, '1.5.1.1.1.1', 'S.DE INFORMACIÓN EJECUTIVA', '');
INSERT INTO concepto VALUES (4, '1.5.1.1.1.1.1', 'SOPORTE A LAS PERSONAS', '');
INSERT INTO concepto VALUES (4, '1.5.1.1.1.1.1.1', 'SISTEMA SOPORTE A LAS DECISIONES (DSS)', '');
INSERT INTO concepto VALUES (4, '1.5.1.1.1.1.2', 'S.PROCESAMIENTO DE TRANSACCIONES', '');
INSERT INTO concepto VALUES (4, '1.5.1.1.1.1.2.1', 'AUTOMATIZAN TAREAS', '');
INSERT INTO concepto VALUES (4, '1.5.1.1.1.1.2.1.1', 'AGIL Y EFICAZ', '');
INSERT INTO concepto VALUES (5, '1', 'INGENIERIA DE INFORMACIÓN', '');
INSERT INTO concepto VALUES (5, '1.1', 'TÉCNICAS', '');
INSERT INTO concepto VALUES (5, '1.1.1', 'DISEÑOS,ANALISIS Y PLANTEAMIENTOS', '');
INSERT INTO concepto VALUES (5, '1.1.1.1', 'SISTEMAS DE INFORMACIÓN', '');
INSERT INTO concepto VALUES (5, '1.1.1.1.1', 'CUMPLAN OBJETIVOS', '');
INSERT INTO concepto VALUES (5, '1.1.1.1.1.1', 'AUTOMATIZAR PROCESOS', '');
INSERT INTO concepto VALUES (5, '1.2', 'S. DE APOYO A EJECUTIVOS (ESS)', '');
INSERT INTO concepto VALUES (5, '1.2.1', 'S. DE ADMINISTRACIÓN (MIS/SIG)', '');
INSERT INTO concepto VALUES (5, '1.2.1.1', 'ORGANIZACIONALES', '');
INSERT INTO concepto VALUES (5, '1.2.1.1.1', 'ANÁLISIS DE DECISIONES', '');
INSERT INTO concepto VALUES (5, '1.2.1.1.1.1', 'BASES DE DATOS', '');
INSERT INTO concepto VALUES (5, '1.2.1.1.1.1.1', 'INFORMACIÓN', '');
INSERT INTO concepto VALUES (5, '1.2.2', 'S. DE ADMINISTRACIÓN (DSS)', '');
INSERT INTO concepto VALUES (5, '1.2.2.1', 'TOMA DE DECISIONES', '');
INSERT INTO concepto VALUES (5, '1.2.2.1.1', 'FASES', '');
INSERT INTO concepto VALUES (5, '1.2.3', 'SISTEMAS EXPERTOS', '');
INSERT INTO concepto VALUES (5, '1.2.3.1', 'CONOCIMIENTO', '');
INSERT INTO concepto VALUES (5, '1.2.3.1.1', 'PROBLEMAS', '');
INSERT INTO concepto VALUES (5, '1.2.4', 'SISTEMA DE CONOCIMIENTO (KWS Y OAS)', '');
INSERT INTO concepto VALUES (5, '1.2.4.1', 'AUTOMATIZAR PROCESOS', '');
INSERT INTO concepto VALUES (5, '1.2.4.1.1', 'CONOCIMIENTO', '');
INSERT INTO concepto VALUES (5, '1.2.5', 'SISTEMA DE PROCESAMIENTO DE TRANSACCIONES (TPS)', '');
INSERT INTO concepto VALUES (5, '1.2.5.1', 'PROCESAR DATOS', '');
INSERT INTO concepto VALUES (6, '1', 'TELECOMUNICACIONES Y PLANEACIÓN DE LOS SISTEMAS', '');
INSERT INTO concepto VALUES (6, '1.1', 'TRANSMITIR MENSAJES', '');
INSERT INTO concepto VALUES (6, '1.1.1', 'COMUNICACIÓN', '');
INSERT INTO concepto VALUES (6, '1.1.1.1', 'CORREO ELÉCTRONICO', '');
INSERT INTO concepto VALUES (6, '1.1.1.1.1', 'RADIO', '');
INSERT INTO concepto VALUES (6, '1.1.1.1.1.1', 'TELEFONIA', '');
INSERT INTO concepto VALUES (6, '1.1.1.1.1.1.1', 'COMUNICACIÓN DE VOZ', '');
INSERT INTO concepto VALUES (6, '1.1.1.1.1.1.1.1', 'SERVICIOS DE DATOS', '');
INSERT INTO concepto VALUES (6, '1.2', 'TELEFONICAS Y COMPUTACIONALES', '');
INSERT INTO concepto VALUES (6, '1.2.1', 'RED DIGITAL', '');
INSERT INTO concepto VALUES (6, '1.2.1.1', 'INTERNET', '');
INSERT INTO concepto VALUES (6, '1.2.1.1.1', 'FTP,WWW Y,CHAT', '');
INSERT INTO concepto VALUES (6, '1.2.1.1.1.1', 'SISTEMA DE INFORMACIÓN', '');
INSERT INTO concepto VALUES (6, '1.2.1.1.1.1.1', 'MUNDO', '');
INSERT INTO concepto VALUES (6, '1.3', 'RECEPTOR, TRANSMISOR, MEDIO DE TRANSMISIÓN Y CANAL', '');
INSERT INTO concepto VALUES (7, '1', 'APLICACIONES EMPRESARIALES A LAS TECNOLOGÍAS DE INFORMACIÓN', '');
INSERT INTO concepto VALUES (7, '1.1', 'PROCESOS', '');
INSERT INTO concepto VALUES (7, '1.1.1', 'SOPORTE Y TRATAMIENTO', '');
INSERT INTO concepto VALUES (7, '1.1.1.1', 'INFORMACIÓN', '');
INSERT INTO concepto VALUES (7, '1.1.1.1.1', 'BASES,DISEÑOS Y SISTEMAS', '');
INSERT INTO concepto VALUES (7, '1.2', 'TECNOLOGÍA DE INTELIGENCIA ARTIFICIAL', '');
INSERT INTO concepto VALUES (7, '1.2.1', 'CONOCIMIENTO', '');
INSERT INTO concepto VALUES (7, '1.2.1.1', 'FACTORES Y RELACIONES', '');
INSERT INTO concepto VALUES (7, '1.2.1.1.1', 'MUNDO REAL', '');
INSERT INTO concepto VALUES (7, '1.2.1.1.1.1', 'DATOS Y PROBLEMAS', '');
INSERT INTO concepto VALUES (7, '1.2.1.1.1.1.1', 'OBJETIVO PRINCIPAL', '');
INSERT INTO concepto VALUES (7, '1.3', 'REDES NEURONALES', '');
INSERT INTO concepto VALUES (7, '1.3.1', 'SISTEMA DE COMPUTACIÓN', '');
INSERT INTO concepto VALUES (7, '1.3.1.1', 'ELEMENTOS SIMPLES', '');
INSERT INTO concepto VALUES (7, '1.3.1.1.1', 'INFORMACIÓN', '');
INSERT INTO concepto VALUES (7, '1.3.1.1.1.1', 'PROGRAMAS INFORMATICOS', '');
INSERT INTO concepto VALUES (7, '1.4', 'ROBÓTICA', '');
INSERT INTO concepto VALUES (7, '1.4.1', 'DISEÑO', '');
INSERT INTO concepto VALUES (7, '1.4.1.1', 'MAQUINAS', '');
INSERT INTO concepto VALUES (7, '1.4.1.1.1', 'TAREAS REPETIDAS', '');
INSERT INTO concepto VALUES (7, '1.4.1.1.1.1', 'AGENTES INTELIGENTES', '');
INSERT INTO concepto VALUES (7, '1.4.1.1.1.1.1', 'ENTORNO', '');
INSERT INTO concepto VALUES (7, '1.4.1.1.1.1.1.1', 'FISICOS O VIRTUALES', '');
INSERT INTO concepto VALUES (7, '1.4.1.1.1.2', 'SISTEMAS EXPERTOS (S.E)', '');
INSERT INTO concepto VALUES (7, '1.4.1.1.1.2.1', 'CONOCIMIENTO', '');
INSERT INTO concepto VALUES (7, '1.4.1.1.1.2.1.1', 'PROCESOS DE RAZONAMIENTOS', '');
INSERT INTO concepto VALUES (7, '1.4.1.1.1.2.1.1.1', 'PROBLEMAS', '');
INSERT INTO concepto VALUES (8, '1', 'TEORIA GENERAL DE SISTEMAS EMPRESARIAL', '');
INSERT INTO concepto VALUES (8, '1.1', 'ACTIVIDAD', '');
INSERT INTO concepto VALUES (8, '1.1.1', 'PRODUCTIVIDAD Y COMPETITIVIDAD', '');
INSERT INTO concepto VALUES (8, '1.1.1.1', 'EMPRESAS', '');
INSERT INTO concepto VALUES (8, '1.2', 'FUNCIONES', '');
INSERT INTO concepto VALUES (8, '1.2.1', 'INTEGRAR Y AUTOMATIZAR', '');
INSERT INTO concepto VALUES (8, '1.2.1.1', 'PRÁCTICA DE NEGOCIO', '');
INSERT INTO concepto VALUES (8, '1.2.1.1.1', 'ASPECTOS', '');
INSERT INTO concepto VALUES (8, '1.2.1.1.1.1', 'OPERATIVOS Y PRODUCTIVOS', '');
INSERT INTO concepto VALUES (8, '1.2.1.1.1.1.1', 'AUMENTE', '');
INSERT INTO concepto VALUES (8, '1.2.1.1.1.1.1.1', 'CALIDAD Y ECONOMICA', '');
INSERT INTO concepto VALUES (8, '1.3', 'SISTEMAS ERP', '');
INSERT INTO concepto VALUES (8, '1.3.1', 'PARTES INTEGRADAS', '');
INSERT INTO concepto VALUES (8, '1.3.1.1', 'APLICACIÓN', '');
INSERT INTO concepto VALUES (8, '1.3.1.1.1', 'PRODUCCIÓN, COMPRAS Y LOGISTICA', '');
INSERT INTO concepto VALUES (8, '1.4', 'OBJETIVOS', '');
INSERT INTO concepto VALUES (8, '1.4.1', 'VISIÓN SISTÉMICA', '');
INSERT INTO concepto VALUES (8, '1.4.1.1', 'DESARROLLO EMPRESARIAL', '');
INSERT INTO concepto VALUES (8, '1.4.1.1.1', 'DESARROLLO TÉCNOLOGICO', '');
INSERT INTO concepto VALUES (8, '1.4.2', 'CONCEPTOS Y APLICACIONES', '');
INSERT INTO concepto VALUES (8, '1.4.2.1', 'SISTEMA', '');
INSERT INTO concepto VALUES (8, '1.4.2.1.1', 'PROCESOS', '');
INSERT INTO concepto VALUES (9, '1', 'SISTEMAS INFORMATICOS', '');
INSERT INTO concepto VALUES (9, '1.1', 'CONJUNTO', '');
INSERT INTO concepto VALUES (9, '1.1.1', 'ELEMENTOS', '');
INSERT INTO concepto VALUES (9, '1.1.1.1', 'HARDWARE Y SOFTWARE', '');
INSERT INTO concepto VALUES (9, '1.1.1.1.1', 'PROCESAMIENTO AUTOMATIZADO', '');
INSERT INTO concepto VALUES (9, '1.1.1.1.1.1', 'INFORMACIÓN', '');
INSERT INTO concepto VALUES (9, '1.2', 'SISTEMAS DE NEGOCIOS', '');
INSERT INTO concepto VALUES (9, '1.2.1', 'SOPORTE', '');
INSERT INTO concepto VALUES (9, '1.2.1.1', 'PROCESOS', '');
INSERT INTO concepto VALUES (9, '1.2.1.1.1', 'ACTIVIDADES CLAVES', '');
INSERT INTO concepto VALUES (9, '1.2.1.1.1.1', 'EMPRESA', '');
INSERT INTO concepto VALUES (9, '1.2.1.1.1.1.1', 'SISTEMAS DE INFORMACIÓN', '');
INSERT INTO concepto VALUES (9, '1.2.1.1.1.1.1.1', 'INFORMACIÓN,RECURSOS Y PERSONAS', '');
INSERT INTO concepto VALUES (9, '1.2.2', 'CORPORACIONES TRADICIONALES,FRANQUISIAS Y MERCADO EN RED', '');
INSERT INTO concepto VALUES (9, '1.3', 'TICS', '');
INSERT INTO concepto VALUES (9, '1.3.1', 'MEDIO DE INFORMACIÓN', '');
INSERT INTO concepto VALUES (10, '1', 'Numeros', '');
INSERT INTO concepto VALUES (10, '1.1', 'NATURALES', '');
INSERT INTO concepto VALUES (10, '1.2', 'RACIONALES', '');
INSERT INTO concepto VALUES (10, '1.3', 'ENTEROS', '');
INSERT INTO concepto VALUES (10, '1.4', 'IRRACIONALES', '');
INSERT INTO concepto VALUES (10, '1.5', 'IMAGINARIOS', '');
INSERT INTO concepto VALUES (12, '1', 'elmto1', '');
INSERT INTO concepto VALUES (12, '1.1', 'carro', '');
INSERT INTO concepto VALUES (12, '1.2', '', '');
INSERT INTO concepto VALUES (12, '1.3', 'gato', '');
INSERT INTO concepto VALUES (13, '1', 'elto1', '');
INSERT INTO concepto VALUES (13, '1.1', 'gato', '');
INSERT INTO concepto VALUES (13, '1.2', 'nariz', '');


--
-- Data for Name: grupo; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO grupo VALUES ('Grupo 1', 'Este es el grupo No. 1', 2);
INSERT INTO grupo VALUES ('g1', 'prueba', 3);


--
-- Data for Name: grupo_mapa_conceptual; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO grupo_mapa_conceptual VALUES (10, 2);
INSERT INTO grupo_mapa_conceptual VALUES (13, 3);


--
-- Data for Name: grupo_usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO grupo_usuario VALUES (2, 987654321);
INSERT INTO grupo_usuario VALUES (2, 111111);
INSERT INTO grupo_usuario VALUES (2, 222222);
INSERT INTO grupo_usuario VALUES (2, 333333);
INSERT INTO grupo_usuario VALUES (3, 11111);


--
-- Data for Name: historial_juego_respuesta; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO historial_juego_respuesta VALUES (1, 10, 222222, 105, '2013-01-21', '5/5', 2);


--
-- Data for Name: historial_mapa_conceptual; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: juego; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO juego VALUES ('StandAlone', 1);
INSERT INTO juego VALUES ('Sopa Letras', 2);


--
-- Data for Name: juego_mapa; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO juego_mapa VALUES (2, 1, 0, 0, 1);
INSERT INTO juego_mapa VALUES (2, 2, 0, 0, 1);
INSERT INTO juego_mapa VALUES (3, 1, 0, 0, 1);
INSERT INTO juego_mapa VALUES (3, 2, 0, 0, 1);
INSERT INTO juego_mapa VALUES (4, 1, 0, 0, 1);
INSERT INTO juego_mapa VALUES (4, 2, 0, 0, 1);
INSERT INTO juego_mapa VALUES (5, 1, 0, 0, 1);
INSERT INTO juego_mapa VALUES (5, 2, 0, 0, 1);
INSERT INTO juego_mapa VALUES (6, 1, 0, 0, 1);
INSERT INTO juego_mapa VALUES (6, 2, 0, 0, 1);
INSERT INTO juego_mapa VALUES (7, 1, 0, 0, 1);
INSERT INTO juego_mapa VALUES (7, 2, 0, 0, 1);
INSERT INTO juego_mapa VALUES (8, 1, 0, 0, 1);
INSERT INTO juego_mapa VALUES (8, 2, 0, 0, 1);
INSERT INTO juego_mapa VALUES (9, 1, 0, 0, 1);
INSERT INTO juego_mapa VALUES (9, 2, 0, 0, 1);
INSERT INTO juego_mapa VALUES (10, 1, 12600, 1, 1);
INSERT INTO juego_mapa VALUES (10, 2, 7260, 0, 1);
INSERT INTO juego_mapa VALUES (12, 1, 0, 0, 1);
INSERT INTO juego_mapa VALUES (12, 2, 0, 0, 1);
INSERT INTO juego_mapa VALUES (13, 1, 0, 0, 1);
INSERT INTO juego_mapa VALUES (13, 2, 0, 0, 1);


--
-- Data for Name: mapa_conceptual; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO mapa_conceptual VALUES (123456789, 1, 'UNIDAD OCHO', 20, 19, '1', 240, '2012-06-24 09:27:24', '2012-07-04 09:27:24', 2);
INSERT INTO mapa_conceptual VALUES (123456789, 1, 'Unidad uno', 39, 38, '0', 72, '2012-06-25 18:10:23', '2012-06-28 18:10:23', 3);
INSERT INTO mapa_conceptual VALUES (123456789, 1, 'UNIDAD DOS', 26, 25, '0', 120, '2012-06-25 19:49:27', '2012-06-30 19:49:27', 4);
INSERT INTO mapa_conceptual VALUES (123456789, 1, 'unidad tres', 44, 43, '0', 144, '2012-06-25 20:16:53', '2012-07-01 20:16:53', 5);
INSERT INTO mapa_conceptual VALUES (123456789, 1, 'Unidad Cuatro', 15, 14, '0', 168, '2012-06-25 20:31:48', '2012-07-02 20:31:48', 6);
INSERT INTO mapa_conceptual VALUES (123456789, 1, 'Unidad Cinco', 27, 26, '0', 144, '2012-06-25 21:00:49', '2012-07-01 21:00:49', 7);
INSERT INTO mapa_conceptual VALUES (123456789, 1, 'Unidad Seis', 22, 21, '0', 168, '2012-06-25 21:20:47', '2012-07-02 21:20:47', 8);
INSERT INTO mapa_conceptual VALUES (123456789, 1, 'Unidad Siete', 25, 24, '0', 144, '2012-06-25 21:45:24', '2012-07-01 21:45:24', 9);
INSERT INTO mapa_conceptual VALUES (987654321, 1, 'Números', 6, 5, '1', 1440, '2012-09-07 07:41:24', '2012-11-06 07:41:24', 10);
INSERT INTO mapa_conceptual VALUES (11111, 1, 'm1', 4, 3, '0', 1, '2013-01-21 14:51:55', '2013-01-21 15:51:55', 12);
INSERT INTO mapa_conceptual VALUES (11111, 1, 'm2', 3, 2, '1', 1, '2013-01-21 14:54:06', '2013-01-21 15:54:06', 13);


--
-- Data for Name: mapa_conceptual_tematica; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO mapa_conceptual_tematica VALUES (2, 2);
INSERT INTO mapa_conceptual_tematica VALUES (2, 3);
INSERT INTO mapa_conceptual_tematica VALUES (2, 4);
INSERT INTO mapa_conceptual_tematica VALUES (2, 5);
INSERT INTO mapa_conceptual_tematica VALUES (2, 6);
INSERT INTO mapa_conceptual_tematica VALUES (2, 7);
INSERT INTO mapa_conceptual_tematica VALUES (2, 8);
INSERT INTO mapa_conceptual_tematica VALUES (2, 9);
INSERT INTO mapa_conceptual_tematica VALUES (3, 10);
INSERT INTO mapa_conceptual_tematica VALUES (3, 13);


--
-- Data for Name: perfil; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO perfil VALUES ('Docente', 1);
INSERT INTO perfil VALUES ('Estudiante', 2);


--
-- Data for Name: relacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO relacion VALUES (2, '1', '1.1', 'es importante');
INSERT INTO relacion VALUES (2, '1.1', '1.1.1', 'los');
INSERT INTO relacion VALUES (2, '1.1', '1.1.2', 'que lo');
INSERT INTO relacion VALUES (2, '1', '1.2', 'sus características son');
INSERT INTO relacion VALUES (2, '1.2', '1.2.1', 'y de acuerdo a su');
INSERT INTO relacion VALUES (2, '1.2.1', '1.2.1.1', 'debe ser');
INSERT INTO relacion VALUES (2, '1.2.1', '1.2.1.2', 'debe ser');
INSERT INTO relacion VALUES (2, '1.2.1', '1.2.1.3', 'debe ser');
INSERT INTO relacion VALUES (2, '1', '1.3', 'asi mismo');
INSERT INTO relacion VALUES (2, '1.3', '1.3.1', 'que lo componen son');
INSERT INTO relacion VALUES (2, '1.3.1', '1.3.1.1', 'debe contener');
INSERT INTO relacion VALUES (2, '1.3.1', '1.3.1.2', 'de todos los aspectos como');
INSERT INTO relacion VALUES (2, '1.3.1', '1.3.1.3', 'y');
INSERT INTO relacion VALUES (2, '1.3.1', '1.3.1.4', 'del');
INSERT INTO relacion VALUES (2, '1.3', '1.3.2', 'También');
INSERT INTO relacion VALUES (2, '1.3.2', '1.3.2.1', 'en este se describen todos los');
INSERT INTO relacion VALUES (2, '1.3.2', '1.3.2.2', 'del');
INSERT INTO relacion VALUES (2, '1.3.2', '1.3.2.3', 'e');
INSERT INTO relacion VALUES (2, '1.3.2', '1.3.2.4', 'pra su posterior');
INSERT INTO relacion VALUES (3, '1', '1.1', 'se define como');
INSERT INTO relacion VALUES (3, '1.1', '1.1.1', 'que buscan un mismo');
INSERT INTO relacion VALUES (3, '1.1', '1.1.2', 'teniendo tres premisas');
INSERT INTO relacion VALUES (3, '1.1.2', '1.1.2.1', 'pueden ser');
INSERT INTO relacion VALUES (3, '1.1.2', '1.1.2.2', 'su función depende de su');
INSERT INTO relacion VALUES (3, '1', '1.2', 'sus clases son');
INSERT INTO relacion VALUES (3, '1.2', '1.2.1', '[Relacion]');
INSERT INTO relacion VALUES (3, '1.2.1', '1.2.1.1', 'constituidos por');
INSERT INTO relacion VALUES (3, '1.2', '1.2.2', 'asi mismo');
INSERT INTO relacion VALUES (3, '1.2.2', '1.2.2.1', 'según su estructura');
INSERT INTO relacion VALUES (3, '1.2.2.1', '1.2.2.1.1', 'se intercambia con su');
INSERT INTO relacion VALUES (3, '1.2.2.1', '1.2.2.1.2', 'y se modifica su');
INSERT INTO relacion VALUES (3, '1.2.2', '1.2.2.2', 'también puede ser');
INSERT INTO relacion VALUES (3, '1.2.2.2', '1.2.2.2.1', 'pero este no se modifica');
INSERT INTO relacion VALUES (3, '1.2.2.2.1', '1.2.2.2.1.1', 'sus características son');
INSERT INTO relacion VALUES (3, '1.2.2.2.1.1', '1.2.2.2.1.1.1', 'es donde se integran sus');
INSERT INTO relacion VALUES (3, '1.2.2.2.1', '1.2.2.2.1.2', 'y');
INSERT INTO relacion VALUES (3, '1.2.2.2.1.2', '1.2.2.2.1.2.1', 'los que');
INSERT INTO relacion VALUES (3, '1.2.2.2.1.2', '1.2.2.2.1.2.2', 'para su');
INSERT INTO relacion VALUES (3, '1.2.2.2.1', '1.2.2.2.1.3', '[Relacion]');
INSERT INTO relacion VALUES (3, '1.2.2.2.1.3', '1.2.2.2.1.3.1', 'que busca el');
INSERT INTO relacion VALUES (3, '1.2.2.2.1.3', '1.2.2.2.1.3.2', 'entre las partes del');
INSERT INTO relacion VALUES (3, '1.2.2.2.1.3', '1.2.2.2.1.3.3', 'y el');
INSERT INTO relacion VALUES (3, '1.2.2', '1.2.2.3', 'estos también pueden ser');
INSERT INTO relacion VALUES (3, '1.2.2.3', '1.2.2.3.1', 'se divide en');
INSERT INTO relacion VALUES (3, '1.2.2.3', '1.2.2.3.2', 'este también permite unir');
INSERT INTO relacion VALUES (3, '1.2.2.3.2', '1.2.2.3.2.1', 'como son');
INSERT INTO relacion VALUES (3, '1.2.2.3.2', '1.2.2.3.2.2', 'también');
INSERT INTO relacion VALUES (3, '1.2.2.3.2.2', '1.2.2.3.2.2.1', 'y se definen como los');
INSERT INTO relacion VALUES (3, '1.2.2.3.2', '1.2.2.3.2.3', '[Relacion]');
INSERT INTO relacion VALUES (4, '1', '1.1', 'es la constitución de');
INSERT INTO relacion VALUES (4, '1.1', '1.1.1', 'que');
INSERT INTO relacion VALUES (4, '1.1.1', '1.1.1.1', 'estudiando');
INSERT INTO relacion VALUES (4, '1.1.1.1', '1.1.1.1.1', 'en función de los');
INSERT INTO relacion VALUES (4, '1.1.1.1.1', '1.1.1.1.1.1', 'sus características son');
INSERT INTO relacion VALUES (4, '1', '1.2', 'sus niveles son');
INSERT INTO relacion VALUES (4, '1.2', '1.2.1', 'donde se encuentran los');
INSERT INTO relacion VALUES (4, '1.2.1', '1.2.1.1', 'ubicado en el sistema de');
INSERT INTO relacion VALUES (4, '1', '1.3', 'puede ser');
INSERT INTO relacion VALUES (4, '1.3', '1.3.1', 'como son sus');
INSERT INTO relacion VALUES (4, '1.3.1', '1.3.1.1', 'unido con el anterior en');
INSERT INTO relacion VALUES (4, '1.3.1.1', '1.3.1.1.1', 'son una');
INSERT INTO relacion VALUES (4, '1', '1.4', 'también el');
INSERT INTO relacion VALUES (4, '1.4', '1.4.1', 'donde se realizan las');
INSERT INTO relacion VALUES (4, '1.4.1', '1.4.1.1', 'este es');
INSERT INTO relacion VALUES (4, '1', '1.5', 'dando paso a');
INSERT INTO relacion VALUES (4, '1.5', '1.5.1', 'generando');
INSERT INTO relacion VALUES (4, '1.5.1', '1.5.1.1', 'construidos por');
INSERT INTO relacion VALUES (4, '1.5.1.1', '1.5.1.1.1', 'que se compone de');
INSERT INTO relacion VALUES (4, '1.5.1.1.1', '1.5.1.1.1.1', 'según su clasificación son');
INSERT INTO relacion VALUES (4, '1.5.1.1.1.1', '1.5.1.1.1.1.1', 'aquel que brinda');
INSERT INTO relacion VALUES (4, '1.5.1.1.1.1.1', '1.5.1.1.1.1.1.1', 'como es');
INSERT INTO relacion VALUES (4, '1.5.1.1.1.1', '1.5.1.1.1.1.2', 'también');
INSERT INTO relacion VALUES (4, '1.5.1.1.1.1.2', '1.5.1.1.1.1.2.1', 'las cuales son las que');
INSERT INTO relacion VALUES (4, '1.5.1.1.1.1.2.1', '1.5.1.1.1.1.2.1.1', 'haciendo el trabajo');
INSERT INTO relacion VALUES (5, '1', '1.1', 'es la aplicación de');
INSERT INTO relacion VALUES (5, '1.1', '1.1.1', 'integradas para la formación de');
INSERT INTO relacion VALUES (5, '1.1.1', '1.1.1.1', 'además de los');
INSERT INTO relacion VALUES (5, '1.1.1.1', '1.1.1.1.1', 'de forma que se');
INSERT INTO relacion VALUES (5, '1.1.1.1.1', '1.1.1.1.1.1', 'para');
INSERT INTO relacion VALUES (5, '1', '1.2', 'tipos de información son');
INSERT INTO relacion VALUES (5, '1.2', '1.2.1', 'apoyan a los');
INSERT INTO relacion VALUES (5, '1.2.1', '1.2.1.1', 'cumplen tareas');
INSERT INTO relacion VALUES (5, '1.2.1.1', '1.2.1.1.1', 'incluyendo');
INSERT INTO relacion VALUES (5, '1.2.1.1.1', '1.2.1.1.1.1', 'en este proceso se comparten');
INSERT INTO relacion VALUES (5, '1.2.1.1.1.1', '1.2.1.1.1.1.1', 'para interpretar y aplicar a la');
INSERT INTO relacion VALUES (5, '1.2', '1.2.2', 'y ser usada también en');
INSERT INTO relacion VALUES (5, '1.2.2', '1.2.2.1', 'este enfatiza su apoyo en la');
INSERT INTO relacion VALUES (5, '1.2.2.1', '1.2.2.1.1', 'en todas sus');
INSERT INTO relacion VALUES (5, '1.2', '1.2.3', 'también');
INSERT INTO relacion VALUES (5, '1.2.3', '1.2.3.1', 'los cuales usan el');
INSERT INTO relacion VALUES (5, '1.2.3.1', '1.2.3.1.1', 'para resolver');
INSERT INTO relacion VALUES (5, '1.2', '1.2.4', 'asi mismo');
INSERT INTO relacion VALUES (5, '1.2.4', '1.2.4.1', 'permiten');
INSERT INTO relacion VALUES (5, '1.2.4.1', '1.2.4.1.1', 'dando paso a la creación de');
INSERT INTO relacion VALUES (5, '1.2', '1.2.5', 'y por último');
INSERT INTO relacion VALUES (5, '1.2.5', '1.2.5.1', 'utilizados para');
INSERT INTO relacion VALUES (6, '1', '1.1', 'estas consisten en');
INSERT INTO relacion VALUES (6, '1.1', '1.1.1', 'cubriendo formas de');
INSERT INTO relacion VALUES (6, '1.1.1', '1.1.1.1', 'como son');
INSERT INTO relacion VALUES (6, '1.1.1.1', '1.1.1.1.1', 'asi mismo');
INSERT INTO relacion VALUES (6, '1.1.1.1.1', '1.1.1.1.1.1', 'y');
INSERT INTO relacion VALUES (6, '1.1.1.1.1.1', '1.1.1.1.1.1.1', 'manejando');
INSERT INTO relacion VALUES (6, '1.1.1.1.1.1.1', '1.1.1.1.1.1.1.1', 'a través de');
INSERT INTO relacion VALUES (6, '1', '1.2', 'tipos de redes');
INSERT INTO relacion VALUES (6, '1.2', '1.2.1', 'convergiendo a');
INSERT INTO relacion VALUES (6, '1.2.1', '1.2.1.1', 'basándose en');
INSERT INTO relacion VALUES (6, '1.2.1.1', '1.2.1.1.1', 'sus servicios son');
INSERT INTO relacion VALUES (6, '1.2.1.1.1', '1.2.1.1.1.1', 'estos son un');
INSERT INTO relacion VALUES (6, '1.2.1.1.1.1', '1.2.1.1.1.1.1', 'mas extensa del');
INSERT INTO relacion VALUES (6, '1', '1.3', 'sus principales elementos son');
INSERT INTO relacion VALUES (7, '1', '1.1', 'es el conjunto de');
INSERT INTO relacion VALUES (7, '1.1', '1.1.1', 'para  el');
INSERT INTO relacion VALUES (7, '1.1.1', '1.1.1.1', 'de la');
INSERT INTO relacion VALUES (7, '1.1.1.1', '1.1.1.1.1', 'como son');
INSERT INTO relacion VALUES (7, '1', '1.2', 'utilizan la');
INSERT INTO relacion VALUES (7, '1.2', '1.2.1', 'la cual se basa en el');
INSERT INTO relacion VALUES (7, '1.2.1', '1.2.1.1', 'incorporando');
INSERT INTO relacion VALUES (7, '1.2.1.1', '1.2.1.1.1', 'en el');
INSERT INTO relacion VALUES (7, '1.2.1.1.1', '1.2.1.1.1.1', 'aplicados a los');
INSERT INTO relacion VALUES (7, '1.2.1.1.1.1', '1.2.1.1.1.1.1', 'teniendo como');
INSERT INTO relacion VALUES (7, '1', '1.3', 'sus ramas se divide en');
INSERT INTO relacion VALUES (7, '1.3', '1.3.1', 'que son un');
INSERT INTO relacion VALUES (7, '1.3.1', '1.3.1.1', 'compuesto por');
INSERT INTO relacion VALUES (7, '1.3.1.1', '1.3.1.1.1', 'los cuales procesan');
INSERT INTO relacion VALUES (7, '1.3.1.1.1', '1.3.1.1.1.1', 'utilizados por los diferentes');
INSERT INTO relacion VALUES (7, '1', '1.4', 'también');
INSERT INTO relacion VALUES (7, '1.4', '1.4.1', 'estudia el');
INSERT INTO relacion VALUES (7, '1.4.1', '1.4.1.1', 'y construcción de');
INSERT INTO relacion VALUES (7, '1.4.1.1', '1.4.1.1.1', 'capaces de desempeñar');
INSERT INTO relacion VALUES (7, '1.4.1.1.1', '1.4.1.1.1.1', 'y también');
INSERT INTO relacion VALUES (7, '1.4.1.1.1.1', '1.4.1.1.1.1.1', 'que son capaces de percibir su');
INSERT INTO relacion VALUES (7, '1.4.1.1.1.1.1', '1.4.1.1.1.1.1.1', 'estos pueden ser');
INSERT INTO relacion VALUES (7, '1.4.1.1.1', '1.4.1.1.1.2', 'y');
INSERT INTO relacion VALUES (7, '1.4.1.1.1.2', '1.4.1.1.1.2.1', 'los cuales permiten capturar');
INSERT INTO relacion VALUES (7, '1.4.1.1.1.2.1', '1.4.1.1.1.2.1.1', 'imitanto');
INSERT INTO relacion VALUES (7, '1.4.1.1.1.2.1.1', '1.4.1.1.1.2.1.1.1', 'para la resolución de');
INSERT INTO relacion VALUES (8, '1', '1.1', 'es la');
INSERT INTO relacion VALUES (8, '1.1', '1.1.1', 'que busca mejorar la');
INSERT INTO relacion VALUES (8, '1.1.1', '1.1.1.1', 'de las');
INSERT INTO relacion VALUES (8, '1', '1.2', 'así mismo sus');
INSERT INTO relacion VALUES (8, '1.2', '1.2.1', 'son');
INSERT INTO relacion VALUES (8, '1.2.1', '1.2.1.1', 'asi mismo');
INSERT INTO relacion VALUES (8, '1.2.1.1', '1.2.1.1.1', 'asociadas con los');
INSERT INTO relacion VALUES (8, '1.2.1.1.1', '1.2.1.1.1.1', 'como son');
INSERT INTO relacion VALUES (8, '1.2.1.1.1.1', '1.2.1.1.1.1.1', 'de forma que');
INSERT INTO relacion VALUES (8, '1.2.1.1.1.1.1', '1.2.1.1.1.1.1.1', 'su');
INSERT INTO relacion VALUES (8, '1', '1.3', 'estos se aplican en los');
INSERT INTO relacion VALUES (8, '1.3', '1.3.1', 'están compuestas por');
INSERT INTO relacion VALUES (8, '1.3.1', '1.3.1.1', 'en una única');
INSERT INTO relacion VALUES (8, '1.3.1.1', '1.3.1.1.1', 'como son');
INSERT INTO relacion VALUES (8, '1', '1.4', 'sus');
INSERT INTO relacion VALUES (8, '1.4', '1.4.1', 'son facilitar una');
INSERT INTO relacion VALUES (8, '1.4.1', '1.4.1.1', 'para dar cumplimiento a un');
INSERT INTO relacion VALUES (8, '1.4.1.1', '1.4.1.1.1', 'mediante');
INSERT INTO relacion VALUES (8, '1.4', '1.4.2', 'introducir los');
INSERT INTO relacion VALUES (8, '1.4.2', '1.4.2.1', 'a la administración en el');
INSERT INTO relacion VALUES (8, '1.4.2.1', '1.4.2.1.1', 'asi mismo como en sus');
INSERT INTO relacion VALUES (9, '1', '1.1', 'es un');
INSERT INTO relacion VALUES (9, '1.1', '1.1.1', 'de');
INSERT INTO relacion VALUES (9, '1.1.1', '1.1.1.1', 'como son');
INSERT INTO relacion VALUES (9, '1.1.1.1', '1.1.1.1.1', 'los cuales están orientados al');
INSERT INTO relacion VALUES (9, '1.1.1.1.1', '1.1.1.1.1.1', 'de');
INSERT INTO relacion VALUES (9, '1', '1.2', 'se divide en');
INSERT INTO relacion VALUES (9, '1.2', '1.2.1', 'es aquel que da');
INSERT INTO relacion VALUES (9, '1.2.1', '1.2.1.1', 'a los');
INSERT INTO relacion VALUES (9, '1.2.1.1', '1.2.1.1.1', 'que contienen');
INSERT INTO relacion VALUES (9, '1.2.1.1.1', '1.2.1.1.1.1', 'de la');
INSERT INTO relacion VALUES (9, '1.2.1.1.1.1', '1.2.1.1.1.1.1', 'los cuales tienen los');
INSERT INTO relacion VALUES (9, '1.2.1.1.1.1.1', '1.2.1.1.1.1.1.1', 'como son');
INSERT INTO relacion VALUES (9, '1.2', '1.2.2', 'estos son divididos en');
INSERT INTO relacion VALUES (9, '1', '1.3', 'sus aplicaciones a las');
INSERT INTO relacion VALUES (9, '1.3', '1.3.1', 'sirven como un');
INSERT INTO relacion VALUES (10, '1', '1.1', 'pueden ser');
INSERT INTO relacion VALUES (10, '1', '1.2', 'pueden ser');
INSERT INTO relacion VALUES (10, '1', '1.3', 'pueden ser');
INSERT INTO relacion VALUES (10, '1', '1.4', 'pueden ser');
INSERT INTO relacion VALUES (10, '1', '1.5', 'pueden ser');
INSERT INTO relacion VALUES (12, '1', '1.1', 'es un');
INSERT INTO relacion VALUES (13, '1', '1.1', 'es un');
INSERT INTO relacion VALUES (13, '1', '1.2', 'tiene una');


--
-- Data for Name: resultado_pregunta; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO resultado_pregunta VALUES (222222, 10, '1', '1.2', true, 2);
INSERT INTO resultado_pregunta VALUES (222222, 10, '1', '1.4', true, 3);
INSERT INTO resultado_pregunta VALUES (222222, 10, '1', '1.3', true, 4);
INSERT INTO resultado_pregunta VALUES (222222, 10, '1', '1.5', true, 5);
INSERT INTO resultado_pregunta VALUES (222222, 10, '1', '1.1', true, 6);


--
-- Data for Name: tematica; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tematica VALUES ('Teoria General de Sistemas', 2);
INSERT INTO tematica VALUES ('Matemáticas', 3);


--
-- Data for Name: tipo_mapa; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_mapa VALUES ('Jerarquico', 1);


--
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO usuario VALUES (123456789, 1, 'Profesor', 'Prueba', '123456789', 'reiko.em@gmail.com');
INSERT INTO usuario VALUES (987654321, 1, 'Julio', 'Ferrer', '987654321', 'reiko.em@gmail.com');
INSERT INTO usuario VALUES (111111, 2, 'Eduard', 'Martínez', '111111', 'reiko.em@gmail.com');
INSERT INTO usuario VALUES (222222, 2, 'Oscar', 'Espitia', '222222', 'reiko.em@gmail.com');
INSERT INTO usuario VALUES (333333, 2, 'Julio', 'Galeano', '333333', 'reiko.em@gmail.com');
INSERT INTO usuario VALUES (11111, 1, 'jj', 'af', '11111', 'junqbano@gmail.com');


--
-- Name: id_tematica_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tematica
    ADD CONSTRAINT id_tematica_pk PRIMARY KEY (id_tematica);


--
-- Name: mapa_conceptual_tematica_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mapa_conceptual_tematica
    ADD CONSTRAINT mapa_conceptual_tematica_pk PRIMARY KEY (tematica_id_tematica, mapa_conceptual_id_mapa_conceptual);


--
-- Name: pk_concepto; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY concepto
    ADD CONSTRAINT pk_concepto PRIMARY KEY (mapa_conceptual_id_mapa_conceptual, id_concepto);


--
-- Name: pk_grupo; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grupo
    ADD CONSTRAINT pk_grupo PRIMARY KEY (id_grupo);


--
-- Name: pk_grupo_mapa_conceptual; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grupo_mapa_conceptual
    ADD CONSTRAINT pk_grupo_mapa_conceptual PRIMARY KEY (mapa_conceptual_id_mapa, grupo_id_grupo);


--
-- Name: pk_grupo_usuario; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grupo_usuario
    ADD CONSTRAINT pk_grupo_usuario PRIMARY KEY (grupo_id_grupo, usuario_id_usuario);


--
-- Name: pk_historial_mapa_conceptual; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY historial_mapa_conceptual
    ADD CONSTRAINT pk_historial_mapa_conceptual PRIMARY KEY (id_historial_mapa_conceptual);


--
-- Name: pk_juego; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY juego
    ADD CONSTRAINT pk_juego PRIMARY KEY (id_juego);


--
-- Name: pk_juego_mapa; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY juego_mapa
    ADD CONSTRAINT pk_juego_mapa PRIMARY KEY (mapa_conceptual_id_mapa_conceptual, juego_id_juego);


--
-- Name: pk_mapa_conceptual; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mapa_conceptual
    ADD CONSTRAINT pk_mapa_conceptual PRIMARY KEY (id_mapa_conceptual);


--
-- Name: pk_perfil; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY perfil
    ADD CONSTRAINT pk_perfil PRIMARY KEY (id_perfil);


--
-- Name: pk_relacion; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY relacion
    ADD CONSTRAINT pk_relacion PRIMARY KEY (concepto_mapa_conceptual_id_mapa_conceptual, concepto_id_concepto, id_concepto_hijo);


--
-- Name: pk_resultado_pregunta; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY resultado_pregunta
    ADD CONSTRAINT pk_resultado_pregunta PRIMARY KEY (id_resultado_pregunta);


--
-- Name: pk_tipo_mapa; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_mapa
    ADD CONSTRAINT pk_tipo_mapa PRIMARY KEY (id_tipo_mapa);


--
-- Name: pk_usuario; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT pk_usuario PRIMARY KEY (id_usuario);


--
-- Name: pkk_historial_juego_respuesta; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY historial_juego_respuesta
    ADD CONSTRAINT pkk_historial_juego_respuesta PRIMARY KEY (id_historial_juego_respuesta);


--
-- Name: nombre_grupo; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX nombre_grupo ON grupo USING btree (nombre_grupo);


--
-- Name: trigger_juego_mapa_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_juego_mapa_trigger AFTER INSERT ON mapa_conceptual FOR EACH ROW EXECUTE PROCEDURE trigger_juego_mapa();


--
-- Name: fk_concepto_mapa_conceptual; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY concepto
    ADD CONSTRAINT fk_concepto_mapa_conceptual FOREIGN KEY (mapa_conceptual_id_mapa_conceptual) REFERENCES mapa_conceptual(id_mapa_conceptual) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_grupo_usuario_grupo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_usuario
    ADD CONSTRAINT fk_grupo_usuario_grupo FOREIGN KEY (grupo_id_grupo) REFERENCES grupo(id_grupo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_grupo_usuario_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_usuario
    ADD CONSTRAINT fk_grupo_usuario_usuario FOREIGN KEY (usuario_id_usuario) REFERENCES usuario(id_usuario) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_historial_juego_respuesta_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY historial_juego_respuesta
    ADD CONSTRAINT fk_historial_juego_respuesta_usuario FOREIGN KEY (usuario_id_usuario) REFERENCES usuario(id_usuario) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_juego_mapa_juego; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY juego_mapa
    ADD CONSTRAINT fk_juego_mapa_juego FOREIGN KEY (juego_id_juego) REFERENCES juego(id_juego) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_juego_mapa_mapa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY juego_mapa
    ADD CONSTRAINT fk_juego_mapa_mapa FOREIGN KEY (mapa_conceptual_id_mapa_conceptual) REFERENCES mapa_conceptual(id_mapa_conceptual) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_mapa_conceptual; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_mapa_conceptual
    ADD CONSTRAINT fk_mapa_conceptual FOREIGN KEY (mapa_conceptual_id_mapa) REFERENCES mapa_conceptual(id_mapa_conceptual) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_mapa_conceptual_tipo_mapa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mapa_conceptual
    ADD CONSTRAINT fk_mapa_conceptual_tipo_mapa FOREIGN KEY (tipo_mapa_id_tipo_mapa) REFERENCES tipo_mapa(id_tipo_mapa) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_mapa_conceptual_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mapa_conceptual
    ADD CONSTRAINT fk_mapa_conceptual_usuario FOREIGN KEY (usuario_id_usuario) REFERENCES usuario(id_usuario) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_relacion_concepto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY relacion
    ADD CONSTRAINT fk_relacion_concepto FOREIGN KEY (concepto_mapa_conceptual_id_mapa_conceptual, concepto_id_concepto) REFERENCES concepto(mapa_conceptual_id_mapa_conceptual, id_concepto) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_resultado_pregunta_concepto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY resultado_pregunta
    ADD CONSTRAINT fk_resultado_pregunta_concepto FOREIGN KEY (relacion_concepto_mapa_conceptual_id_mapa_conceptual, relacion_concepto_id_concepto, relacion_id_concepto_hijo) REFERENCES relacion(concepto_mapa_conceptual_id_mapa_conceptual, concepto_id_concepto, id_concepto_hijo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_resultado_pregunta_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY resultado_pregunta
    ADD CONSTRAINT fk_resultado_pregunta_usuario FOREIGN KEY (usuario_id_usuario) REFERENCES usuario(id_usuario) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_usuario_perfil; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT fk_usuario_perfil FOREIGN KEY (perfil_id_perfil) REFERENCES perfil(id_perfil) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fkk_historial_juego_respuesta_juego_mapa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY historial_juego_respuesta
    ADD CONSTRAINT fkk_historial_juego_respuesta_juego_mapa FOREIGN KEY (juego_mapa_mapa_conceptual_id_mapa_conceptual, juego_mapa_juego_id_juego) REFERENCES juego_mapa(mapa_conceptual_id_mapa_conceptual, juego_id_juego) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: grupo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_mapa_conceptual
    ADD CONSTRAINT grupo FOREIGN KEY (grupo_id_grupo) REFERENCES grupo(id_grupo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: id_mapa_conceptual; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mapa_conceptual_tematica
    ADD CONSTRAINT id_mapa_conceptual FOREIGN KEY (mapa_conceptual_id_mapa_conceptual) REFERENCES mapa_conceptual(id_mapa_conceptual) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: id_tematica; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mapa_conceptual_tematica
    ADD CONSTRAINT id_tematica FOREIGN KEY (tematica_id_tematica) REFERENCES tematica(id_tematica) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

