<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__).'/../../bootstrap/doctrine.php';

$objTest = new lime_test(8);

//On recupere un utilisateur sans entité
$objUtilisateurSansEntite = UtilisateurTable::getInstance()->getQueryObject()
                                                              ->where("entite_id IS NULL")
                                                              ->fetchOne();

//On recupere un utilisateur avec entité
$objUtilisateurAvecEntite = UtilisateurTable::getInstance()->getQueryObject()
                                                              ->where("entite_id IS NOT NULL")
                                                              ->fetchOne();

//On recupere l'entite concerné
$objEntiteConcerne = EntiteTable::getInstance()->getQueryObject()
                                                   ->where("id = ?",$objUtilisateurAvecEntite->getEntiteId())
                                                   ->fetchOne();

/*##################### TEST 1 ###############################*/
$objTest->is(strcmp($objUtilisateurAvecEntite->getEntite()->getIntitule(), $objEntiteConcerne->getIntitule()), 0, "L'intitule de l'entite de l'utilisateur correspond.");


/*##################### TEST 2 ###############################*/
$objTest->is(strcmp($objUtilisateurSansEntite->getEntite()->getIntitule(), ""), 0, "L'intitule de l'entite de l'utilisateur sans entite est un string vide.");

/*##################### TEST 3 ###############################*/
$objTest->is(strcmp($objUtilisateurAvecEntite->getAbreviationEntite(), $objEntiteConcerne->getAbreviation()), 0, "L'abreviation de l'entite de l'utilisateur correspond.");


/*##################### TEST 4 ###############################*/
$objTest->is(strcmp($objUtilisateurSansEntite->getEntite()->getIntitule(), ""), 0, "L'abreviation de l'entite de l'utilisateur sans entite est un string vide.");


//On recupere un utilisateur sans organisme MINDEF
$objUtilisateurSansOrganisme = UtilisateurTable::getInstance()->getQueryObject()
                                                              ->where("organisme_mindef_id IS NULL")
                                                              ->fetchOne();

//On recupere un utilisateur avec organisme MINDEF
$objUtilisateurAvecOrganisme = UtilisateurTable::getInstance()->getQueryObject()
                                                              ->where("organisme_mindef_id IS NOT NULL")
                                                              ->fetchOne();

//On recupere l'organisme MINDEF concerné
$objOrganismeConcerne = Organisme_mindefTable::getInstance()->getQueryObject()
                                                   ->where("id = ?",$objUtilisateurAvecOrganisme->getOrganismeMindefId())
                                                   ->fetchOne();

/*##################### TEST 5 ###############################*/
$objTest->is(strcmp($objUtilisateurAvecOrganisme->getOrganisme_mindef()->getIntitule(), $objOrganismeConcerne->getIntitule()), 0, "L'intitule de l'organisme MINDEF de l'utilisateur correspond.");


/*##################### TEST 6 ###############################*/
$objTest->is(strcmp($objUtilisateurSansOrganisme->getOrganisme_mindef()->getIntitule(), ""), 0, "L'intitule de l'entite de l'utilisateur sans organisme MINDEF est un string vide.");

/*##################### TEST 7 ###############################*/
$objTest->is(strcmp($objUtilisateurAvecOrganisme->getAbreviationOrganismeMindef(), $objOrganismeConcerne->getAbreviation()), 0, "L'abreviation de l'organisme MINDEF de l'utilisateur correspond.");


/*##################### TEST 8 ###############################*/
$objTest->is(strcmp($objUtilisateurSansEntite->getAbreviationOrganismeMindef(), ""), 0, "L'abreviation de l'entite de l'utilisateur sans organisme MINDEF est un string vide.");
?>
