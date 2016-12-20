--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.15
-- Dumped by pg_dump version 9.5.1

-- Started on 2016-12-20 12:49:23

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

DROP DATABASE a2015u54;
--
-- TOC entry 2226 (class 1262 OID 1404784)
-- Name: a2015u54; Type: DATABASE; Schema: -; Owner: a2015u54
--

CREATE DATABASE a2015u54 WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8';


ALTER DATABASE a2015u54 OWNER TO a2015u54;

\connect a2015u54

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 6 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- TOC entry 2227 (class 0 OID 0)
-- Dependencies: 6
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- TOC entry 1 (class 3079 OID 11793)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2229 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- TOC entry 609 (class 1247 OID 1972553)
-- Name: t_classe; Type: TYPE; Schema: public; Owner: a2015u54
--

CREATE TYPE t_classe AS ENUM (
    'business',
    'economy'
);


ALTER TYPE t_classe OWNER TO a2015u54;

--
-- TOC entry 243 (class 1255 OID 1973570)
-- Name: check_posti_prenotazione(); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION check_posti_prenotazione() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE 

temp_posti integer := NEW.num_posti_prenotati;
    BEGIN

	

	IF (TG_OP = 'UPDATE') THEN

		IF( (NEW.classe = OLD.classe) AND (NEW.id_volo_pianificato = OLD.id_volo_pianificato)) THEN
			temp_posti := NEW.num_posti_prenotati - OLD.num_posti_prenotati;
		END IF;

	END IF;		

        IF (TG_OP = 'UPDATE' OR TG_OP = 'INSERT') THEN

		IF( NEW.classe = 'economy' )THEN
			IF (temp_posti > (SELECT liberi_economy FROM voli_posti_2 WHERE id_volo_pianificato = NEW.id_volo_pianificato LIMIT 1)) THEN
				RAISE EXCEPTION 'il volo non ha altri % posti liberi in classe economy', temp_posti;
			END IF;
		ELSIF (NEW.classe = 'business') THEN
			IF (temp_posti > (SELECT liberi_business FROM voli_posti_2 WHERE id_volo_pianificato = NEW.id_volo_pianificato LIMIT 1) )THEN
				RAISE EXCEPTION 'il volo non ha altri % posti liberi in classe economy', temp_posti;
			END IF;
		ELSE
			RAISE EXCEPTION '% classe sconosciuta', NEW.classe;
		END IF;

		RETURN NEW;

        END IF;

	
    
    END;
$$;


ALTER FUNCTION public.check_posti_prenotazione() OWNER TO a2015u54;

--
-- TOC entry 238 (class 1255 OID 1980123)
-- Name: check_utente(); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION check_utente() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    BEGIN

	IF (TG_OP = 'UPDATE') THEN

		IF( NEW.username != OLD.username ) THEN
			IF ((SELECT COUNT(id) FROM utenti WHERE username = NEW.username  LIMIT 1) > 0) THEN
				RAISE EXCEPTION 'usernamme % gia in uso', NEW.username;
			END IF;
		END IF;

		RETURN NEW;

	END IF;		

        IF (TG_OP = 'INSERT') THEN

		
			IF ((SELECT COUNT(id) FROM utenti WHERE username = NEW.username  LIMIT 1) > 0) THEN
				RAISE EXCEPTION 'usernamme % gia in uso', NEW.username;
			END IF;
		
	

		RETURN NEW;

        END IF;

	
    
    END;
$$;


ALTER FUNCTION public.check_utente() OWNER TO a2015u54;

--
-- TOC entry 224 (class 1255 OID 1973558)
-- Name: elimina_aeroplani(integer[]); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION elimina_aeroplani(ids integer[]) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    DELETE FROM tipi_aeroplani
       WHERE id = ANY(elimina_aeroplani.ids);
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.elimina_aeroplani(ids integer[]) OWNER TO a2015u54;

--
-- TOC entry 223 (class 1255 OID 1972917)
-- Name: elimina_aeroporti(character varying[]); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION elimina_aeroporti(ids character varying[]) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    DELETE FROM aeroporti
       WHERE sigla = ANY(elimina_aeroporti.ids);
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.elimina_aeroporti(ids character varying[]) OWNER TO a2015u54;

--
-- TOC entry 226 (class 1255 OID 1973561)
-- Name: elimina_compagnie(integer[]); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION elimina_compagnie(ids integer[]) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    DELETE FROM compagnie
       WHERE id  = ANY  (elimina_compagnie.ids);
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.elimina_compagnie(ids integer[]) OWNER TO a2015u54;

--
-- TOC entry 240 (class 1255 OID 1980126)
-- Name: elimina_prenotazioni(integer[]); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION elimina_prenotazioni(ids integer[]) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    DELETE FROM prenotazioni
       WHERE id = ANY  (elimina_prenotazioni.ids);
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.elimina_prenotazioni(ids integer[]) OWNER TO a2015u54;

--
-- TOC entry 228 (class 1255 OID 1973567)
-- Name: elimina_tratte(text[]); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION elimina_tratte(ids text[]) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    DELETE FROM voli
       WHERE codice = ANY (elimina_tratte.ids);
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.elimina_tratte(ids text[]) OWNER TO a2015u54;

--
-- TOC entry 241 (class 1255 OID 1980115)
-- Name: elimina_utenti(integer[]); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION elimina_utenti(ids integer[]) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    DELETE FROM utenti
       WHERE id = ANY (elimina_utenti.ids);
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.elimina_utenti(ids integer[]) OWNER TO a2015u54;

--
-- TOC entry 230 (class 1255 OID 1973569)
-- Name: elimina_voli(integer[]); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION elimina_voli(ids integer[]) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    DELETE FROM voli_pianificati
       WHERE id = ANY  (elimina_voli.ids);
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.elimina_voli(ids integer[]) OWNER TO a2015u54;

--
-- TOC entry 237 (class 1255 OID 1973578)
-- Name: get_prenotazione(integer, integer); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION get_prenotazione(p_id_utente integer, p_id_prenotazione integer) RETURNS record
    LANGUAGE sql
    AS $$SELECT prenotazioni.*, 
aeroporti_citta_da.nome AS nome_aeroporto_partenza,
aeroporti_citta_a.nome as nome_aeroporto_arrivo, 
aeroporti_citta_da.code2 as code2_da, 
aeroporti_citta_a.code2 as code2_a,
aeroporti_citta_da.paese as name_da, 
aeroporti_citta_a.paese as name_a, 
aeroporti_citta_da.citta as city_name_da, 
aeroporti_citta_a.citta as city_name_a,
voli.prezzo_economy,
voli.prezzo_business 
FROM prenotazioni 
                LEFT JOIN voli_pianificati ON voli_pianificati.id = prenotazioni.id_volo_pianificato 
                LEFT JOIN voli ON voli.codice = voli_pianificati.codice_volo 
                LEFT JOIN compagnie ON compagnie.id = voli.cod_compagnia 
                LEFT JOIN tipi_aeroplani ON tipi_aeroplani.id = voli.tipo_aeroplano 
                LEFT JOIN aeroporti_citta_old AS aeroporti_citta_da ON aeroporti_citta_da.sigla = voli.aeroporto_partenza 
                LEFT JOIN aeroporti_citta_old AS aeroporti_citta_a ON aeroporti_citta_a.sigla = voli.aeroporto_arrivo 
                WHERE prenotazioni.id_utente = p_id_utente 
AND prenotazioni.id = p_id_prenotazione LIMIT 1$$;


ALTER FUNCTION public.get_prenotazione(p_id_utente integer, p_id_prenotazione integer) OWNER TO a2015u54;

--
-- TOC entry 225 (class 1255 OID 1973559)
-- Name: modifica_aeroplano(integer, character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION modifica_aeroplano(id integer, nome character varying, posti_economy integer, posti_business integer) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    UPDATE tipi_aeroplani
       SET nome      = modifica_aeroplano.nome,
           posti_economy          = modifica_aeroplano.posti_economy,
           posti_business            = modifica_aeroplano.posti_business
     WHERE tipi_aeroplani.id = modifica_aeroplano.id;
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.modifica_aeroplano(id integer, nome character varying, posti_economy integer, posti_business integer) OWNER TO a2015u54;

--
-- TOC entry 222 (class 1255 OID 1972914)
-- Name: modifica_aeroporto(character varying, character varying, integer, character varying); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION modifica_aeroporto(sigla character varying, nome character varying, id_citta integer, old_sigla character varying) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    UPDATE aeroporti
       SET sigla      = upper(modifica_aeroporto.sigla),
           nome          = modifica_aeroporto.nome,
           id_citta            = modifica_aeroporto.id_citta
     WHERE aeroporti.sigla = upper(modifica_aeroporto.old_sigla);
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.modifica_aeroporto(sigla character varying, nome character varying, id_citta integer, old_sigla character varying) OWNER TO a2015u54;

--
-- TOC entry 227 (class 1255 OID 1973562)
-- Name: modifica_compagnia(integer, character varying, character); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION modifica_compagnia(id integer, nome character varying, nazionalita character) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    UPDATE compagnie
       SET nome          = modifica_compagnia.nome,
           nazionalita            = modifica_compagnia.nazionalita
     WHERE modifica_compagnia.id = compagnie.id;
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.modifica_compagnia(id integer, nome character varying, nazionalita character) OWNER TO a2015u54;

--
-- TOC entry 239 (class 1255 OID 1980125)
-- Name: modifica_prenotazione(integer, integer, integer, t_classe, integer); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION modifica_prenotazione(id integer, id_volo_pianificato integer, id_utente integer, classe t_classe, num_posti_prenotati integer) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    UPDATE prenotazioni
       SET id_volo_pianificato          = modifica_prenotazione.id_volo_pianificato,
           id_utente            = modifica_prenotazione.id_utente,
           classe = modifica_prenotazione.classe,
           num_posti_prenotati = modifica_prenotazione.num_posti_prenotati
     WHERE modifica_prenotazione.id = prenotazioni.id;
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.modifica_prenotazione(id integer, id_volo_pianificato integer, id_utente integer, classe t_classe, num_posti_prenotati integer) OWNER TO a2015u54;

--
-- TOC entry 244 (class 1255 OID 1980129)
-- Name: modifica_utente(character varying, character varying, character varying, character varying, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION modifica_utente(nome character varying, cognome character varying, indirizzo character varying, telefono character varying, carta_credito character varying, username character varying, passwd character varying, user_level integer, id integer) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    UPDATE utenti
       SET nome          = modifica_utente.nome,
           cognome            = modifica_utente.cognome,
           indirizzo = modifica_utente.indirizzo,
           telefono = modifica_utente.telefono,
           carta_credito          = modifica_utente.carta_credito,
           username            = LOWER(modifica_utente.username),
           passwd = COALESCE(modifica_utente.passwd,utenti.passwd),
           user_level = modifica_utente.user_level
     WHERE modifica_utente.id = utenti.id;
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.modifica_utente(nome character varying, cognome character varying, indirizzo character varying, telefono character varying, carta_credito character varying, username character varying, passwd character varying, user_level integer, id integer) OWNER TO a2015u54;

--
-- TOC entry 229 (class 1255 OID 1973568)
-- Name: modifica_volo(text, text, integer, character varying, character varying, integer, real, real, integer); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION modifica_volo(old_codice text, codice text, cod_compagnia integer, aeroporto_partenza character varying, aeroporto_arrivo character varying, durata_volo integer, prezzo_economy real, prezzo_business real, tipo_aeroplano integer) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    UPDATE voli
       SET codice      = upper(modifica_volo.codice),
           cod_compagnia          = modifica_volo.cod_compagnia,
           aeroporto_partenza            = modifica_volo.aeroporto_partenza,
           aeroporto_arrivo          = modifica_volo.aeroporto_arrivo,
           durata_volo            = modifica_volo.durata_volo,
           prezzo_economy          = modifica_volo.prezzo_economy,
	prezzo_business =  modifica_volo.prezzo_business,
           tipo_aeroplano            = modifica_volo.tipo_aeroplano
           
     WHERE voli.codice = upper(modifica_volo.old_codice);
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.modifica_volo(old_codice text, codice text, cod_compagnia integer, aeroporto_partenza character varying, aeroporto_arrivo character varying, durata_volo integer, prezzo_economy real, prezzo_business real, tipo_aeroplano integer) OWNER TO a2015u54;

--
-- TOC entry 231 (class 1255 OID 1973572)
-- Name: modifica_volo_pianificato(integer, integer, integer, text, timestamp without time zone, integer); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION modifica_volo_pianificato(id integer, gate integer, ritardo integer, codice_volo text, data_ora timestamp without time zone, cancellato integer) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
    UPDATE voli_pianificati
       SET	 gate          = modifica_volo_pianificato.gate,
			ritardo            = modifica_volo_pianificato.ritardo,
			codice_volo          = upper(modifica_volo_pianificato.codice_volo),
			data_ora          = modifica_volo_pianificato.data_ora,
			cancellato =  modifica_volo_pianificato.cancellato  
     WHERE voli_pianificati.id = modifica_volo_pianificato.id;
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.modifica_volo_pianificato(id integer, gate integer, ritardo integer, codice_volo text, data_ora timestamp without time zone, cancellato integer) OWNER TO a2015u54;

--
-- TOC entry 242 (class 1255 OID 1980149)
-- Name: nuova_compagnia(integer, character); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION nuova_compagnia(nome integer, nazionalita character) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
	 
	 INSERT INTO utenti(nome,nazionalita) 
	 VALUES (nuova_compagnia.nome,UPPER(nuova_compagnia.nazionalita));
	 	 
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.nuova_compagnia(nome integer, nazionalita character) OWNER TO a2015u54;

--
-- TOC entry 233 (class 1255 OID 1980325)
-- Name: nuova_prenotazione(integer, date, integer, integer, integer, t_classe); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION nuova_prenotazione(id integer, data_prenotazione date, num_posti_prenotati integer, id_utente integer, id_volo_pianificato integer, classe t_classe) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
BEGIN
	 
	INSERT INTO prenotazioni(data_prenotazione,id_volo_pianificato,id_utente,classe,num_posti_prenotati) 
	VALUES(nuova_prenotazione.data_prenotazione,
	
	nuova_prenotazione.id_volo_pianificato,
	nuova_prenotazione.id_utente,
	nuova_prenotazione.classe,
	nuova_prenotazione.num_posti_prenotati
	
	);
	 
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.nuova_prenotazione(id integer, data_prenotazione date, num_posti_prenotati integer, id_utente integer, id_volo_pianificato integer, classe t_classe) OWNER TO a2015u54;

--
-- TOC entry 235 (class 1255 OID 1980322)
-- Name: nuova_tratta(text, integer, character varying, character varying, integer, real, real, integer); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION nuova_tratta(codice text, cod_compagnia integer, aeroporto_partenza character varying, aeroporto_arrivo character varying, durata_volo integer, prezzo_business real, prezzo_economy real, tipo_aeroplano integer) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
BEGIN
	 
	 INSERT INTO voli(codice,cod_compagnia,aeroporto_partenza,aeroporto_arrivo,durata_volo,prezzo_economy,prezzo_business,tipo_aeroplano)
	 VALUES (UPPER(nuova_tratta.codice),nuova_tratta.cod_compagnia,nuova_tratta.aeroporto_partenza,
	 nuova_tratta.aeroporto_arrivo,nuova_tratta.durata_volo,nuova_tratta.prezzo_economy,nuova_tratta.prezzo_business,nuova_tratta.tipo_aeroplano);
	 
	 
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.nuova_tratta(codice text, cod_compagnia integer, aeroporto_partenza character varying, aeroporto_arrivo character varying, durata_volo integer, prezzo_business real, prezzo_economy real, tipo_aeroplano integer) OWNER TO a2015u54;

--
-- TOC entry 234 (class 1255 OID 1980326)
-- Name: nuovo_aeroplano(character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION nuovo_aeroplano(nome character varying, posti_economy integer, posti_business integer) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
BEGIN
	 INSERT INTO tipi_aeroplani(nome,posti_economy,posti_business) 
	 VALUES (nuovo_aeroplano.nome,nuovo_aeroplano.posti_economy,nuovo_aeroplano.posti_business);
		 
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.nuovo_aeroplano(nome character varying, posti_economy integer, posti_business integer) OWNER TO a2015u54;

--
-- TOC entry 232 (class 1255 OID 1980323)
-- Name: nuovo_aeroporto(character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION nuovo_aeroporto(sigla character varying, nome character varying, id_citta integer) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
BEGIN
	
	 INSERT INTO aeroporti(sigla,nome,id_citta) VALUES (UPPER(nuovo_aeroporto.sigla),nuovo_aeroporto.nome,nuovo_aeroporto.id_citta);
	 
	 
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.nuovo_aeroporto(sigla character varying, nome character varying, id_citta integer) OWNER TO a2015u54;

--
-- TOC entry 236 (class 1255 OID 1980148)
-- Name: nuovo_utente(character varying, character varying, character varying, character varying, character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION nuovo_utente(nome character varying, cognome character varying, indirizzo character varying, telefono character varying, carta_credito character varying, username character varying, passwd character varying, user_level integer) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$

BEGIN
	 
	 INSERT INTO utenti(nome,cognome,indirizzo,telefono,carta_credito,username,passwd,user_level) 
	 VALUES (nuovo_utente.nome,nuovo_utente.cognome,nuovo_utente.indirizzo,nuovo_utente.telefono,nuovo_utente.carta_credito,
	 LOWER(nuovo_utente.username),nuovo_utente.passwd,nuovo_utente.user_level);
	 	 
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.nuovo_utente(nome character varying, cognome character varying, indirizzo character varying, telefono character varying, carta_credito character varying, username character varying, passwd character varying, user_level integer) OWNER TO a2015u54;

--
-- TOC entry 245 (class 1255 OID 1980812)
-- Name: nuovo_volo(integer, integer, text, timestamp without time zone, integer); Type: FUNCTION; Schema: public; Owner: a2015u54
--

CREATE FUNCTION nuovo_volo(gate integer, ritardo integer, codice_volo text, data_ora timestamp without time zone, cancellato integer) RETURNS boolean
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
BEGIN
	 
	 INSERT INTO voli_pianificati(gate,codice_volo,data_ora,ritardo,cancellato)
	 VALUES (
nuovo_volo.gate,
UPPER(nuovo_volo.codice_volo),
nuovo_volo.data_ora,
nuovo_volo.ritardo,
nuovo_volo.cancellato);
	 
    RETURN FOUND;
END;
$$;


ALTER FUNCTION public.nuovo_volo(gate integer, ritardo integer, codice_volo text, data_ora timestamp without time zone, cancellato integer) OWNER TO a2015u54;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 178 (class 1259 OID 1972533)
-- Name: tipi_aeroplani; Type: TABLE; Schema: public; Owner: a2015u54
--

CREATE TABLE tipi_aeroplani (
    id integer NOT NULL,
    nome character varying(30),
    posti_economy integer,
    posti_business integer
);


ALTER TABLE tipi_aeroplani OWNER TO a2015u54;

--
-- TOC entry 177 (class 1259 OID 1972531)
-- Name: aeroplani_id_seq; Type: SEQUENCE; Schema: public; Owner: a2015u54
--

CREATE SEQUENCE aeroplani_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aeroplani_id_seq OWNER TO a2015u54;

--
-- TOC entry 2230 (class 0 OID 0)
-- Dependencies: 177
-- Name: aeroplani_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: a2015u54
--

ALTER SEQUENCE aeroplani_id_seq OWNED BY tipi_aeroplani.id;


--
-- TOC entry 179 (class 1259 OID 1972539)
-- Name: aeroporti; Type: TABLE; Schema: public; Owner: a2015u54
--

CREATE TABLE aeroporti (
    sigla character varying(3) NOT NULL,
    nome character varying(20),
    id_citta integer NOT NULL
);


ALTER TABLE aeroporti OWNER TO a2015u54;

--
-- TOC entry 171 (class 1259 OID 1404788)
-- Name: city; Type: TABLE; Schema: public; Owner: a2015u54
--

CREATE TABLE city (
    id integer NOT NULL,
    name text NOT NULL,
    countrycode character(3) NOT NULL,
    district text NOT NULL,
    population integer NOT NULL
);


ALTER TABLE city OWNER TO a2015u54;

--
-- TOC entry 172 (class 1259 OID 1404794)
-- Name: country; Type: TABLE; Schema: public; Owner: a2015u54
--

CREATE TABLE country (
    code character(3) NOT NULL,
    name text NOT NULL,
    continent text NOT NULL,
    region text NOT NULL,
    surfacearea real NOT NULL,
    indepyear smallint,
    population integer NOT NULL,
    lifeexpectancy real,
    gnp numeric(10,2),
    gnpold numeric(10,2),
    localname text NOT NULL,
    governmentform text NOT NULL,
    headofstate text,
    capital integer,
    code2 character(2) NOT NULL,
    CONSTRAINT country_continent_check CHECK ((((((((continent = 'Asia'::text) OR (continent = 'Europe'::text)) OR (continent = 'North America'::text)) OR (continent = 'Africa'::text)) OR (continent = 'Oceania'::text)) OR (continent = 'Antarctica'::text)) OR (continent = 'South America'::text)))
);


ALTER TABLE country OWNER TO a2015u54;

--
-- TOC entry 193 (class 1259 OID 1972888)
-- Name: cities_countries; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW cities_countries AS
 SELECT city.id AS id_citta,
    city.name AS nome_citta,
    city.countrycode AS id_paese,
    country.name AS nome_paese,
    country.code2
   FROM (city
     LEFT JOIN country ON ((city.countrycode = country.code)));


ALTER TABLE cities_countries OWNER TO a2015u54;

--
-- TOC entry 194 (class 1259 OID 1972892)
-- Name: aeroporti_citta; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW aeroporti_citta AS
 SELECT aeroporti.sigla,
    aeroporti.nome,
    aeroporti.id_citta,
    cities_countries.nome_citta,
    cities_countries.id_paese,
    cities_countries.nome_paese,
    cities_countries.code2
   FROM (aeroporti
     LEFT JOIN cities_countries ON ((aeroporti.id_citta = cities_countries.id_citta)));


ALTER TABLE aeroporti_citta OWNER TO a2015u54;

--
-- TOC entry 185 (class 1259 OID 1972673)
-- Name: aeroporti_citta_old; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW aeroporti_citta_old AS
 SELECT aeroporti.sigla,
    aeroporti.nome,
    aeroporti.id_citta,
    city.name AS citta,
    city.countrycode AS id_paese,
    country.name AS paese,
    country.code2
   FROM ((aeroporti
     LEFT JOIN city ON ((aeroporti.id_citta = city.id)))
     LEFT JOIN country ON ((city.countrycode = country.code)));


ALTER TABLE aeroporti_citta_old OWNER TO a2015u54;

--
-- TOC entry 182 (class 1259 OID 1972568)
-- Name: voli; Type: TABLE; Schema: public; Owner: a2015u54
--

CREATE TABLE voli (
    codice text NOT NULL,
    cod_compagnia integer NOT NULL,
    aeroporto_partenza character varying(3) NOT NULL,
    durata_volo integer,
    prezzo_business real,
    prezzo_economy real,
    tipo_aeroplano integer,
    aeroporto_arrivo character varying(3) NOT NULL
);


ALTER TABLE voli OWNER TO a2015u54;

--
-- TOC entry 2231 (class 0 OID 0)
-- Dependencies: 182
-- Name: COLUMN voli.durata_volo; Type: COMMENT; Schema: public; Owner: a2015u54
--

COMMENT ON COLUMN voli.durata_volo IS 'in minuti';


--
-- TOC entry 187 (class 1259 OID 1972679)
-- Name: voli_pianificati; Type: TABLE; Schema: public; Owner: a2015u54
--

CREATE TABLE voli_pianificati (
    id integer NOT NULL,
    gate integer,
    ritardo integer DEFAULT 0 NOT NULL,
    codice_volo text,
    data_ora timestamp without time zone,
    cancellato integer DEFAULT 0 NOT NULL
);


ALTER TABLE voli_pianificati OWNER TO a2015u54;

--
-- TOC entry 206 (class 1259 OID 1980358)
-- Name: arrivi_partenze_aeroporti; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW arrivi_partenze_aeroporti AS
 SELECT aeroporti.sigla,
    aeroporti.nome,
    ( SELECT count(voli_pianificati.id) AS count
           FROM voli_pianificati
          WHERE (voli_pianificati.codice_volo IN ( SELECT voli.codice
                   FROM voli
                  WHERE ((voli.aeroporto_partenza)::text = (aeroporti.sigla)::text)))) AS partiti,
    ( SELECT count(voli_pianificati.id) AS count
           FROM voli_pianificati
          WHERE (voli_pianificati.codice_volo IN ( SELECT voli.codice
                   FROM voli
                  WHERE ((voli.aeroporto_arrivo)::text = (aeroporti.sigla)::text)))) AS arrivati
   FROM aeroporti;


ALTER TABLE arrivi_partenze_aeroporti OWNER TO a2015u54;

--
-- TOC entry 184 (class 1259 OID 1972655)
-- Name: compagnie; Type: TABLE; Schema: public; Owner: a2015u54
--

CREATE TABLE compagnie (
    id integer NOT NULL,
    nome character varying(30) NOT NULL,
    nazionalita character(3) NOT NULL
);


ALTER TABLE compagnie OWNER TO a2015u54;

--
-- TOC entry 204 (class 1259 OID 1980348)
-- Name: compagnie_countries; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW compagnie_countries AS
 SELECT compagnie.id,
    compagnie.nome,
    country.name AS paese,
    country.code2
   FROM (compagnie
     LEFT JOIN country ON ((compagnie.nazionalita = country.code)));


ALTER TABLE compagnie_countries OWNER TO a2015u54;

--
-- TOC entry 183 (class 1259 OID 1972653)
-- Name: compagnie_id_seq; Type: SEQUENCE; Schema: public; Owner: a2015u54
--

CREATE SEQUENCE compagnie_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE compagnie_id_seq OWNER TO a2015u54;

--
-- TOC entry 2232 (class 0 OID 0)
-- Dependencies: 183
-- Name: compagnie_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: a2015u54
--

ALTER SEQUENCE compagnie_id_seq OWNED BY compagnie.id;


--
-- TOC entry 173 (class 1259 OID 1404801)
-- Name: countrylanguage; Type: TABLE; Schema: public; Owner: a2015u54
--

CREATE TABLE countrylanguage (
    countrycode character(3) NOT NULL,
    language text NOT NULL,
    isofficial boolean NOT NULL,
    percentage real NOT NULL
);


ALTER TABLE countrylanguage OWNER TO a2015u54;

--
-- TOC entry 181 (class 1259 OID 1972546)
-- Name: prenotazioni; Type: TABLE; Schema: public; Owner: a2015u54
--

CREATE TABLE prenotazioni (
    id integer NOT NULL,
    data_prenotazione date,
    num_posti_prenotati integer,
    id_utente integer,
    id_volo_pianificato integer,
    classe t_classe
);


ALTER TABLE prenotazioni OWNER TO a2015u54;

--
-- TOC entry 176 (class 1259 OID 1972502)
-- Name: utenti; Type: TABLE; Schema: public; Owner: a2015u54
--

CREATE TABLE utenti (
    id integer NOT NULL,
    nome character varying(30),
    cognome character varying(30),
    indirizzo character varying(30),
    telefono character varying(15),
    carta_credito character varying(30),
    username character varying(30),
    passwd character varying(40),
    user_level integer DEFAULT 0 NOT NULL
);


ALTER TABLE utenti OWNER TO a2015u54;

--
-- TOC entry 200 (class 1259 OID 1980143)
-- Name: datatable_prenotazioni; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW datatable_prenotazioni AS
 SELECT prenotazioni.id,
    prenotazioni.data_prenotazione,
    prenotazioni.num_posti_prenotati,
    prenotazioni.id_utente,
    prenotazioni.id_volo_pianificato,
    prenotazioni.classe,
    voli_pianificati.codice_volo,
    concat(utenti.nome, ' ', utenti.cognome) AS nome
   FROM ((prenotazioni
     LEFT JOIN utenti ON ((prenotazioni.id_utente = utenti.id)))
     LEFT JOIN voli_pianificati ON ((prenotazioni.id_volo_pianificato = voli_pianificati.id)));


ALTER TABLE datatable_prenotazioni OWNER TO a2015u54;

--
-- TOC entry 197 (class 1259 OID 1980103)
-- Name: voli_posti_3; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW voli_posti_3 AS
 SELECT prenotazioni.id_volo_pianificato,
    count(*) AS num_prenotazioni,
    sum(
        CASE
            WHEN (prenotazioni.classe = 'business'::t_classe) THEN prenotazioni.num_posti_prenotati
            ELSE 0
        END) AS prenotati_business,
    sum(
        CASE
            WHEN (prenotazioni.classe = 'economy'::t_classe) THEN prenotazioni.num_posti_prenotati
            ELSE 0
        END) AS prenotati_economy,
    tipi_aeroplani.posti_business,
    tipi_aeroplani.posti_economy
   FROM (((voli_pianificati
     JOIN prenotazioni ON ((voli_pianificati.id = prenotazioni.id_volo_pianificato)))
     JOIN voli ON ((voli.codice = voli_pianificati.codice_volo)))
     JOIN tipi_aeroplani ON ((tipi_aeroplani.id = voli.tipo_aeroplano)))
  GROUP BY prenotazioni.id_volo_pianificato, tipi_aeroplani.posti_business, tipi_aeroplani.posti_economy;


ALTER TABLE voli_posti_3 OWNER TO a2015u54;

--
-- TOC entry 192 (class 1259 OID 1972870)
-- Name: voli_posti_2; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW voli_posti_2 AS
 SELECT voli_posti_3.id_volo_pianificato,
    voli_posti_3.num_prenotazioni,
    voli_posti_3.prenotati_business,
    voli_posti_3.prenotati_economy,
    voli_posti_3.posti_business,
    voli_posti_3.posti_economy,
    (voli_posti_3.posti_business - voli_posti_3.prenotati_business) AS liberi_business,
    (voli_posti_3.posti_economy - voli_posti_3.prenotati_economy) AS liberi_economy
   FROM voli_posti_3;


ALTER TABLE voli_posti_2 OWNER TO a2015u54;

--
-- TOC entry 199 (class 1259 OID 1980135)
-- Name: datatable_voli; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW datatable_voli AS
 SELECT voli_pianificati.id,
    voli_pianificati.codice_volo,
    voli_pianificati.data_ora,
    voli_pianificati.gate,
    voli_pianificati.ritardo,
    voli_pianificati.cancellato,
    COALESCE(posti.prenotati_business, (0)::bigint) AS prenotati_business,
    COALESCE(posti.prenotati_economy, (0)::bigint) AS prenotati_economy
   FROM (voli_pianificati
     LEFT JOIN voli_posti_2 posti ON ((posti.id_volo_pianificato = voli_pianificati.id)));


ALTER TABLE datatable_voli OWNER TO a2015u54;

--
-- TOC entry 190 (class 1259 OID 1972852)
-- Name: passeggeri_voli; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW passeggeri_voli AS
 SELECT vp.codice_volo,
    count(*) AS totpasseggeri,
    v.aeroporto_partenza
   FROM prenotazioni p,
    voli_pianificati vp,
    voli v
  WHERE ((p.id_volo_pianificato = vp.id) AND (vp.codice_volo = v.codice))
  GROUP BY vp.codice_volo, v.aeroporto_partenza;


ALTER TABLE passeggeri_voli OWNER TO a2015u54;

--
-- TOC entry 205 (class 1259 OID 1980352)
-- Name: pian_voli_tipi_posti; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW pian_voli_tipi_posti AS
 SELECT voli_pianificati.id,
    voli_pianificati.gate,
    voli_pianificati.ritardo,
    voli_pianificati.codice_volo,
    voli_pianificati.data_ora,
    voli_pianificati.cancellato,
    COALESCE(voli_posti_2.prenotati_business, (0)::bigint) AS prenotati_business,
    COALESCE(voli_posti_2.prenotati_economy, (0)::bigint) AS prenotati_economy,
    tipi_aeroplani.posti_economy,
    tipi_aeroplani.posti_business,
    COALESCE(voli_posti_2.liberi_economy, (tipi_aeroplani.posti_economy)::bigint) AS liberi_economy,
    COALESCE(voli_posti_2.liberi_business, (tipi_aeroplani.posti_business)::bigint) AS liberi_business,
    voli.prezzo_business,
    voli.prezzo_economy
   FROM (((voli_pianificati
     LEFT JOIN voli ON ((voli.codice = voli_pianificati.codice_volo)))
     LEFT JOIN tipi_aeroplani ON ((tipi_aeroplani.id = voli.tipo_aeroplano)))
     LEFT JOIN voli_posti_2 ON ((voli_posti_2.id_volo_pianificato = voli_pianificati.id)));


ALTER TABLE pian_voli_tipi_posti OWNER TO a2015u54;

--
-- TOC entry 180 (class 1259 OID 1972544)
-- Name: prenotazioni_id_seq; Type: SEQUENCE; Schema: public; Owner: a2015u54
--

CREATE SEQUENCE prenotazioni_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE prenotazioni_id_seq OWNER TO a2015u54;

--
-- TOC entry 2233 (class 0 OID 0)
-- Dependencies: 180
-- Name: prenotazioni_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: a2015u54
--

ALTER SEQUENCE prenotazioni_id_seq OWNED BY prenotazioni.id;


--
-- TOC entry 198 (class 1259 OID 1980109)
-- Name: prenotazioni_voli_aeroporti; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW prenotazioni_voli_aeroporti WITH (security_barrier='true') AS
 SELECT prenotazioni.id,
    prenotazioni.data_prenotazione,
    prenotazioni.num_posti_prenotati,
    prenotazioni.id_utente,
    prenotazioni.id_volo_pianificato,
    prenotazioni.classe,
    aeroporti_citta_da.nome AS nome_aeroporto_partenza,
    aeroporti_citta_a.nome AS nome_aeroporto_arrivo,
    aeroporti_citta_da.code2 AS code2_da,
    aeroporti_citta_a.code2 AS code2_a,
    aeroporti_citta_da.paese AS name_da,
    aeroporti_citta_a.paese AS name_a,
    aeroporti_citta_da.citta AS city_name_da,
    aeroporti_citta_a.citta AS city_name_a,
    voli.prezzo_economy,
    voli.prezzo_business
   FROM ((((((prenotazioni
     LEFT JOIN voli_pianificati ON ((voli_pianificati.id = prenotazioni.id_volo_pianificato)))
     LEFT JOIN voli ON ((voli.codice = voli_pianificati.codice_volo)))
     LEFT JOIN compagnie ON ((compagnie.id = voli.cod_compagnia)))
     LEFT JOIN tipi_aeroplani ON ((tipi_aeroplani.id = voli.tipo_aeroplano)))
     LEFT JOIN aeroporti_citta_old aeroporti_citta_da ON (((aeroporti_citta_da.sigla)::text = (voli.aeroporto_partenza)::text)))
     LEFT JOIN aeroporti_citta_old aeroporti_citta_a ON (((aeroporti_citta_a.sigla)::text = (voli.aeroporto_arrivo)::text)));


ALTER TABLE prenotazioni_voli_aeroporti OWNER TO a2015u54;

--
-- TOC entry 209 (class 1259 OID 1980813)
-- Name: realtime; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW realtime AS
 SELECT voli_pianificati.id,
    voli_pianificati.gate,
    voli_pianificati.ritardo,
    voli_pianificati.codice_volo,
    voli_pianificati.data_ora,
    voli.durata_volo,
    da_city.name AS da_citta,
    da_country.name AS da_paese,
    a_city.name AS a_citta,
    a_country.name AS a_paese
   FROM (((((((voli_pianificati
     LEFT JOIN voli ON ((voli.codice = voli_pianificati.codice_volo)))
     LEFT JOIN aeroporti da_aeroporti ON (((da_aeroporti.sigla)::text = (voli.aeroporto_partenza)::text)))
     LEFT JOIN aeroporti a_aeroporti ON (((a_aeroporti.sigla)::text = (voli.aeroporto_arrivo)::text)))
     LEFT JOIN city da_city ON ((da_aeroporti.id_citta = da_city.id)))
     LEFT JOIN city a_city ON ((a_aeroporti.id_citta = a_city.id)))
     LEFT JOIN country da_country ON ((da_city.countrycode = da_country.code)))
     LEFT JOIN country a_country ON ((a_city.countrycode = a_country.code)))
  WHERE ((voli_pianificati.data_ora < ('now'::text)::timestamp without time zone) AND (('now'::text)::timestamp without time zone < (voli_pianificati.data_ora + (concat('\', ((voli.durata_volo + voli_pianificati.ritardo) * 60), '\'))::interval)));


ALTER TABLE realtime OWNER TO a2015u54;

--
-- TOC entry 174 (class 1259 OID 1404807)
-- Name: regionwithpop; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW regionwithpop AS
 SELECT country.region,
    sum(country.population) AS sum
   FROM country
  GROUP BY country.region;


ALTER TABLE regionwithpop OWNER TO a2015u54;

--
-- TOC entry 201 (class 1259 OID 1980327)
-- Name: stat_aeroplani; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW stat_aeroplani AS
 SELECT tipi_aeroplani.nome,
    voli.tipo_aeroplano,
    sum(COALESCE(t.count, (0)::bigint)) AS c
   FROM ((voli
     LEFT JOIN ( SELECT voli_pianificati.codice_volo,
            count(voli_pianificati.codice_volo) AS count
           FROM voli_pianificati
          GROUP BY voli_pianificati.codice_volo) t ON ((t.codice_volo = voli.codice)))
     JOIN tipi_aeroplani ON ((tipi_aeroplani.id = voli.tipo_aeroplano)))
  GROUP BY voli.tipo_aeroplano, tipi_aeroplani.nome
 HAVING (sum(COALESCE(t.count, (0)::bigint)) > (0)::numeric);


ALTER TABLE stat_aeroplani OWNER TO a2015u54;

--
-- TOC entry 189 (class 1259 OID 1972848)
-- Name: stat_num_voli_compagnie; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW stat_num_voli_compagnie AS
 SELECT v.aeroporto_partenza,
    v.cod_compagnia,
    count(*) AS numvoli
   FROM voli v
  GROUP BY v.aeroporto_partenza, v.cod_compagnia;


ALTER TABLE stat_num_voli_compagnie OWNER TO a2015u54;

--
-- TOC entry 202 (class 1259 OID 1980332)
-- Name: stat_maggiore_compagnia_aeroporto; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW stat_maggiore_compagnia_aeroporto AS
 SELECT max(stat_num_voli_compagnie.numvoli) AS max,
    stat_num_voli_compagnie.aeroporto_partenza,
    stat_num_voli_compagnie.cod_compagnia
   FROM stat_num_voli_compagnie
  GROUP BY stat_num_voli_compagnie.aeroporto_partenza, stat_num_voli_compagnie.cod_compagnia;


ALTER TABLE stat_maggiore_compagnia_aeroporto OWNER TO a2015u54;

--
-- TOC entry 203 (class 1259 OID 1980336)
-- Name: stat_passeggeri_trasportati_aeroporto; Type: TABLE; Schema: public; Owner: a2015u54
--

CREATE TABLE stat_passeggeri_trasportati_aeroporto (
    sigla character varying(3),
    sum numeric,
    nome character varying(20)
);


ALTER TABLE stat_passeggeri_trasportati_aeroporto OWNER TO a2015u54;

--
-- TOC entry 188 (class 1259 OID 1972707)
-- Name: tabellone; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW tabellone AS
 SELECT voli_pianificati.id,
    voli_pianificati.gate,
    voli_pianificati.ritardo,
    voli_pianificati.codice_volo,
    voli_pianificati.data_ora,
    voli.aeroporto_partenza,
    voli.aeroporto_arrivo,
    voli.cod_compagnia
   FROM (voli_pianificati
     LEFT JOIN voli ON ((voli.codice = voli_pianificati.codice_volo)))
  WHERE (voli_pianificati.data_ora > ('now'::text)::timestamp without time zone)
 LIMIT 5;


ALTER TABLE tabellone OWNER TO a2015u54;

--
-- TOC entry 207 (class 1259 OID 1980362)
-- Name: tratte_prenotazioni; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW tratte_prenotazioni AS
 SELECT voli_pianificati.codice_volo,
    sum(prenotazioni.num_posti_prenotati) AS prenotazioni
   FROM (voli_pianificati
     JOIN prenotazioni ON ((prenotazioni.id_volo_pianificato = voli_pianificati.id)))
  GROUP BY voli_pianificati.codice_volo;


ALTER TABLE tratte_prenotazioni OWNER TO a2015u54;

--
-- TOC entry 196 (class 1259 OID 1973579)
-- Name: tratte_preferite; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW tratte_preferite AS
 SELECT voli.codice,
    voli.aeroporto_partenza,
    voli.aeroporto_arrivo,
    ae_ci_da.code2 AS code2_da,
    ae_ci_a.code2 AS code2_a,
    ae_ci_da.nome_citta AS citta_da,
    ae_ci_a.nome_citta AS citta_a,
    ae_ci_da.nome AS aero_da,
    ae_ci_a.nome AS aero_a
   FROM (((voli
     JOIN ( SELECT tratte_prenotazioni.codice_volo,
            tratte_prenotazioni.prenotazioni
           FROM tratte_prenotazioni
         LIMIT 5) kk ON ((voli.codice = kk.codice_volo)))
     JOIN aeroporti_citta ae_ci_da ON (((ae_ci_da.sigla)::text = (voli.aeroporto_partenza)::text)))
     JOIN aeroporti_citta ae_ci_a ON (((ae_ci_a.sigla)::text = (voli.aeroporto_arrivo)::text)));


ALTER TABLE tratte_preferite OWNER TO a2015u54;

--
-- TOC entry 208 (class 1259 OID 1980367)
-- Name: tratte_voli; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW tratte_voli AS
 SELECT voli.codice,
    ( SELECT count(voli_pianificati.id) AS count
           FROM voli_pianificati
          WHERE (voli_pianificati.codice_volo = voli.codice)) AS voli
   FROM voli;


ALTER TABLE tratte_voli OWNER TO a2015u54;

--
-- TOC entry 175 (class 1259 OID 1972500)
-- Name: utenti_id_seq; Type: SEQUENCE; Schema: public; Owner: a2015u54
--

CREATE SEQUENCE utenti_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE utenti_id_seq OWNER TO a2015u54;

--
-- TOC entry 2234 (class 0 OID 0)
-- Dependencies: 175
-- Name: utenti_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: a2015u54
--

ALTER SEQUENCE utenti_id_seq OWNED BY utenti.id;


--
-- TOC entry 195 (class 1259 OID 1973563)
-- Name: voli_compagnie_aeroplani; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW voli_compagnie_aeroplani AS
 SELECT voli.codice,
    voli.cod_compagnia,
    voli.aeroporto_partenza,
    voli.durata_volo,
    voli.prezzo_business,
    voli.prezzo_economy,
    voli.tipo_aeroplano,
    voli.aeroporto_arrivo,
    tipi_aeroplani.nome AS nome_aeroplano,
    compagnie.nome AS nome_compagnia
   FROM ((voli
     LEFT JOIN compagnie ON ((voli.cod_compagnia = compagnie.id)))
     LEFT JOIN tipi_aeroplani ON ((voli.tipo_aeroplano = tipi_aeroplani.id)));


ALTER TABLE voli_compagnie_aeroplani OWNER TO a2015u54;

--
-- TOC entry 186 (class 1259 OID 1972677)
-- Name: voli_pianificati_id_seq; Type: SEQUENCE; Schema: public; Owner: a2015u54
--

CREATE SEQUENCE voli_pianificati_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE voli_pianificati_id_seq OWNER TO a2015u54;

--
-- TOC entry 2235 (class 0 OID 0)
-- Dependencies: 186
-- Name: voli_pianificati_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: a2015u54
--

ALTER SEQUENCE voli_pianificati_id_seq OWNED BY voli_pianificati.id;


--
-- TOC entry 191 (class 1259 OID 1972866)
-- Name: voli_posti; Type: VIEW; Schema: public; Owner: a2015u54
--

CREATE VIEW voli_posti AS
 SELECT prenotazioni.id_volo_pianificato,
    count(*) AS num_prenotazioni,
    sum(
        CASE
            WHEN (prenotazioni.classe = 'business'::t_classe) THEN prenotazioni.num_posti_prenotati
            ELSE 0
        END) AS prenotati_business,
    sum(
        CASE
            WHEN (prenotazioni.classe = 'economy'::t_classe) THEN prenotazioni.num_posti_prenotati
            ELSE 0
        END) AS prenotati_economy
   FROM (prenotazioni
     RIGHT JOIN voli_pianificati ON ((voli_pianificati.id = prenotazioni.id_volo_pianificato)))
  GROUP BY prenotazioni.id_volo_pianificato;


ALTER TABLE voli_posti OWNER TO a2015u54;

--
-- TOC entry 2042 (class 2604 OID 1972658)
-- Name: id; Type: DEFAULT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY compagnie ALTER COLUMN id SET DEFAULT nextval('compagnie_id_seq'::regclass);


--
-- TOC entry 2041 (class 2604 OID 1972549)
-- Name: id; Type: DEFAULT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY prenotazioni ALTER COLUMN id SET DEFAULT nextval('prenotazioni_id_seq'::regclass);


--
-- TOC entry 2040 (class 2604 OID 1972536)
-- Name: id; Type: DEFAULT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY tipi_aeroplani ALTER COLUMN id SET DEFAULT nextval('aeroplani_id_seq'::regclass);


--
-- TOC entry 2038 (class 2604 OID 1972505)
-- Name: id; Type: DEFAULT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY utenti ALTER COLUMN id SET DEFAULT nextval('utenti_id_seq'::regclass);


--
-- TOC entry 2043 (class 2604 OID 1972682)
-- Name: id; Type: DEFAULT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY voli_pianificati ALTER COLUMN id SET DEFAULT nextval('voli_pianificati_id_seq'::regclass);


--
-- TOC entry 2057 (class 2606 OID 1972538)
-- Name: aeroplani_pkey; Type: CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY tipi_aeroplani
    ADD CONSTRAINT aeroplani_pkey PRIMARY KEY (id);


--
-- TOC entry 2059 (class 2606 OID 1972543)
-- Name: aeroporto_pkey; Type: CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY aeroporti
    ADD CONSTRAINT aeroporto_pkey PRIMARY KEY (sigla);


--
-- TOC entry 2047 (class 2606 OID 1404812)
-- Name: city_pkey; Type: CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY city
    ADD CONSTRAINT city_pkey PRIMARY KEY (id);


--
-- TOC entry 2049 (class 2606 OID 1404814)
-- Name: country_pkey; Type: CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY country
    ADD CONSTRAINT country_pkey PRIMARY KEY (code);


--
-- TOC entry 2051 (class 2606 OID 1404816)
-- Name: countrylanguage_pkey; Type: CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY countrylanguage
    ADD CONSTRAINT countrylanguage_pkey PRIMARY KEY (countrycode, language);


--
-- TOC entry 2070 (class 2606 OID 1972575)
-- Name: pk_codice_volo; Type: CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY voli
    ADD CONSTRAINT pk_codice_volo PRIMARY KEY (codice);


--
-- TOC entry 2073 (class 2606 OID 1972660)
-- Name: pk_id_compagnia; Type: CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY compagnie
    ADD CONSTRAINT pk_id_compagnia PRIMARY KEY (id);


--
-- TOC entry 2076 (class 2606 OID 1972685)
-- Name: pk_id_volo_pianificato; Type: CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY voli_pianificati
    ADD CONSTRAINT pk_id_volo_pianificato PRIMARY KEY (id);


--
-- TOC entry 2064 (class 2606 OID 1972551)
-- Name: prenotazioni_pkey; Type: CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY prenotazioni
    ADD CONSTRAINT prenotazioni_pkey PRIMARY KEY (id);


--
-- TOC entry 2053 (class 2606 OID 1972857)
-- Name: unique_username; Type: CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY utenti
    ADD CONSTRAINT unique_username UNIQUE (username);


--
-- TOC entry 2055 (class 2606 OID 1972507)
-- Name: utenti_pkey; Type: CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY utenti
    ADD CONSTRAINT utenti_pkey PRIMARY KEY (id);


--
-- TOC entry 2065 (class 1259 OID 1972646)
-- Name: fki_aero_sigl_voli_arri; Type: INDEX; Schema: public; Owner: a2015u54
--

CREATE INDEX fki_aero_sigl_voli_arri ON voli USING btree (aeroporto_arrivo);


--
-- TOC entry 2066 (class 1259 OID 1972603)
-- Name: fki_aero_sigl_voli_part; Type: INDEX; Schema: public; Owner: a2015u54
--

CREATE INDEX fki_aero_sigl_voli_part ON voli USING btree (aeroporto_partenza);


--
-- TOC entry 2060 (class 1259 OID 1972652)
-- Name: fki_city_id_aero_citt; Type: INDEX; Schema: public; Owner: a2015u54
--

CREATE INDEX fki_city_id_aero_citt ON aeroporti USING btree (id_citta);


--
-- TOC entry 2067 (class 1259 OID 1972672)
-- Name: fki_comp_id_voli_comp; Type: INDEX; Schema: public; Owner: a2015u54
--

CREATE INDEX fki_comp_id_voli_comp ON voli USING btree (cod_compagnia);


--
-- TOC entry 2071 (class 1259 OID 1972666)
-- Name: fki_coun_id_comp_nazi; Type: INDEX; Schema: public; Owner: a2015u54
--

CREATE INDEX fki_coun_id_comp_nazi ON compagnie USING btree (nazionalita);


--
-- TOC entry 2061 (class 1259 OID 1972562)
-- Name: fki_pre_idu_ute_id; Type: INDEX; Schema: public; Owner: a2015u54
--

CREATE INDEX fki_pre_idu_ute_id ON prenotazioni USING btree (id_utente);


--
-- TOC entry 2068 (class 1259 OID 1972581)
-- Name: fki_tipi_id_voli_tipo; Type: INDEX; Schema: public; Owner: a2015u54
--

CREATE INDEX fki_tipi_id_voli_tipo ON voli USING btree (tipo_aeroplano);


--
-- TOC entry 2074 (class 1259 OID 1972694)
-- Name: fki_voli_codi_vpia_codi; Type: INDEX; Schema: public; Owner: a2015u54
--

CREATE INDEX fki_voli_codi_vpia_codi ON voli_pianificati USING btree (codice_volo);


--
-- TOC entry 2062 (class 1259 OID 1972700)
-- Name: fki_vpia_id_pren_idvp; Type: INDEX; Schema: public; Owner: a2015u54
--

CREATE INDEX fki_vpia_id_pren_idvp ON prenotazioni USING btree (id_volo_pianificato);


--
-- TOC entry 2215 (class 2618 OID 1980339)
-- Name: _RETURN; Type: RULE; Schema: public; Owner: a2015u54
--

CREATE RULE "_RETURN" AS
    ON SELECT TO stat_passeggeri_trasportati_aeroporto DO INSTEAD  SELECT aeroporti.sigla,
    sum(passeggeri_voli.totpasseggeri) AS sum,
    aeroporti.nome
   FROM (passeggeri_voli
     LEFT JOIN aeroporti ON (((passeggeri_voli.aeroporto_partenza)::text = (aeroporti.sigla)::text)))
  GROUP BY aeroporti.sigla;


--
-- TOC entry 2090 (class 2620 OID 1973571)
-- Name: check_posti_prenotazione; Type: TRIGGER; Schema: public; Owner: a2015u54
--

CREATE TRIGGER check_posti_prenotazione BEFORE INSERT OR UPDATE ON prenotazioni FOR EACH ROW EXECUTE PROCEDURE check_posti_prenotazione();


--
-- TOC entry 2089 (class 2620 OID 1980124)
-- Name: check_utente; Type: TRIGGER; Schema: public; Owner: a2015u54
--

CREATE TRIGGER check_utente BEFORE INSERT OR UPDATE ON utenti FOR EACH ROW EXECUTE PROCEDURE check_utente();


--
-- TOC entry 2077 (class 2606 OID 1404827)
-- Name: city_countrycode_fkey; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY city
    ADD CONSTRAINT city_countrycode_fkey FOREIGN KEY (countrycode) REFERENCES country(code);


--
-- TOC entry 2078 (class 2606 OID 1404817)
-- Name: country_capital_fkey; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY country
    ADD CONSTRAINT country_capital_fkey FOREIGN KEY (capital) REFERENCES city(id);


--
-- TOC entry 2079 (class 2606 OID 1404822)
-- Name: countrylanguage_countrycode_fkey; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY countrylanguage
    ADD CONSTRAINT countrylanguage_countrycode_fkey FOREIGN KEY (countrycode) REFERENCES country(code);


--
-- TOC entry 2083 (class 2606 OID 1980453)
-- Name: fk_aero_sigl_voli_arri; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY voli
    ADD CONSTRAINT fk_aero_sigl_voli_arri FOREIGN KEY (aeroporto_arrivo) REFERENCES aeroporti(sigla) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2084 (class 2606 OID 1980458)
-- Name: fk_aero_sigl_voli_part; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY voli
    ADD CONSTRAINT fk_aero_sigl_voli_part FOREIGN KEY (aeroporto_partenza) REFERENCES aeroporti(sigla) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2080 (class 2606 OID 1980493)
-- Name: fk_city_id_aero_citt; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY aeroporti
    ADD CONSTRAINT fk_city_id_aero_citt FOREIGN KEY (id_citta) REFERENCES city(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2085 (class 2606 OID 1980463)
-- Name: fk_comp_id_voli_comp; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY voli
    ADD CONSTRAINT fk_comp_id_voli_comp FOREIGN KEY (cod_compagnia) REFERENCES compagnie(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2087 (class 2606 OID 1980478)
-- Name: fk_coun_id_comp_nazi; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY compagnie
    ADD CONSTRAINT fk_coun_id_comp_nazi FOREIGN KEY (nazionalita) REFERENCES country(code) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2081 (class 2606 OID 1980483)
-- Name: fk_pre_idu_ute_id; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY prenotazioni
    ADD CONSTRAINT fk_pre_idu_ute_id FOREIGN KEY (id_utente) REFERENCES utenti(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2086 (class 2606 OID 1980468)
-- Name: fk_tipi_id_voli_tipo; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY voli
    ADD CONSTRAINT fk_tipi_id_voli_tipo FOREIGN KEY (tipo_aeroplano) REFERENCES tipi_aeroplani(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2088 (class 2606 OID 1980473)
-- Name: fk_voli_codi_vpia_codi; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY voli_pianificati
    ADD CONSTRAINT fk_voli_codi_vpia_codi FOREIGN KEY (codice_volo) REFERENCES voli(codice) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2082 (class 2606 OID 1980488)
-- Name: fk_vpia_id_pren_idvp; Type: FK CONSTRAINT; Schema: public; Owner: a2015u54
--

ALTER TABLE ONLY prenotazioni
    ADD CONSTRAINT fk_vpia_id_pren_idvp FOREIGN KEY (id_volo_pianificato) REFERENCES voli_pianificati(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2228 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2016-12-20 12:49:25

--
-- PostgreSQL database dump complete
--

