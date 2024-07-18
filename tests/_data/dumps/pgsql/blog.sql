--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3 (Debian 16.3-1.pgdg120+1)
-- Dumped by pg_dump version 16.3 (Debian 16.3-1.pgdg120+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: author; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.author (
    id bigint NOT NULL,
    name character varying(255)
);


ALTER TABLE public.author OWNER TO root;

--
-- Name: id_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.id_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.id_id_seq OWNER TO root;

--
-- Name: id_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.id_id_seq OWNED BY public.author.id;


--
-- Name: post; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.post (
    id bigint NOT NULL,
    author_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    body text NOT NULL
);


ALTER TABLE public.post OWNER TO root;

--
-- Name: post_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.post_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.post_id_seq OWNER TO root;

--
-- Name: post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.post_id_seq OWNED BY public.post.id;


--
-- Name: author id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.author ALTER COLUMN id SET DEFAULT nextval('public.id_id_seq'::regclass);


--
-- Name: post id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.post ALTER COLUMN id SET DEFAULT nextval('public.post_id_seq'::regclass);


--
-- Data for Name: author; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.author (id, name) FROM stdin;
\.


--
-- Data for Name: post; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.post (id, author_id, name, body) FROM stdin;
\.


--
-- Name: id_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.id_id_seq', 1, false);


--
-- Name: post_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.post_id_seq', 1, false);


--
-- Name: author id_pk; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.author
    ADD CONSTRAINT id_pk PRIMARY KEY (id);


--
-- Name: post post_pk; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.post
    ADD CONSTRAINT post_pk PRIMARY KEY (id);


--
-- Name: post post_author_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.post
    ADD CONSTRAINT post_author_id_fk FOREIGN KEY (author_id) REFERENCES public.author(id);


--
-- PostgreSQL database dump complete
--

SET search_path TO public
