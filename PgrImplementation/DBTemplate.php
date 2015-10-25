<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 25/10/2015
 * Time: 11:15
 */

$creerDest = "CREATE TABLE {$this->getDestinationsTableName()}
(
    id integer NOT NULL DEFAULT nextval('destination_id_seq'::regclass),
  nom character varying(255),
  x integer,
  y integer,
  z integer,
  the_geom geometry,
  type character varying(50) DEFAULT 'Lieu'::character varying
)
WITH (
    OIDS=FALSE
);
ALTER TABLE {$this->getDestinationsTableName()}
  OWNER TO {$this->connexion->getUser()};";