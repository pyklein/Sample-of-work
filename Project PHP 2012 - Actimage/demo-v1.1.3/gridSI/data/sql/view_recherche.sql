
DROP TABLE IF EXISTS view_recherche;
DROP VIEW IF EXISTS view_recherche;


CREATE VIEW view_recherche AS

SELECT (id + (2 * 10000000)) AS id, id AS dossier_mip_id, NULL AS dossier_bpi_id, NULL AS dossier_ere_id, NULL AS dossier_postdoc_id, NULL AS dossier_these_id, 2 AS metier_id, titre, etat_partage_id, created_at
FROM dossier_mip

UNION

SELECT (id + (1 * 10000000)) AS id, NULL, id, NULL, NULL, NULL, 1 AS metier_id, titre, etat_partage_id, created_at
FROM dossier_bpi

UNION

SELECT (id + (3 * 11000000)) AS id, NULL, NULL, id, NULL, NULL, 3 AS metier_id, titre, etat_partage_id, created_at
FROM dossier_ere

UNION

SELECT (id + (3 * 12000000)) AS id, NULL, NULL, NULL, id, NULL, 3 AS metier_id, titre, etat_partage_id, created_at
FROM dossier_postdoc

UNION

SELECT (id + (3 * 13000000)) AS id, NULL, NULL, NULL, NULL, id, 3 AS metier_id, titre, etat_partage_id, created_at
FROM dossier_these
;
