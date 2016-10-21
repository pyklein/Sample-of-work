<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__).'/../../bootstrap/doctrine.php';

$objTest = new lime_test(2);

//Dans la base de données doit exister au moins un entré
$objEntite_1 = EntiteTable::getInstance()->getQueryObject()->fetchOne();

//Dans la base de données doit exister au moins deux entrés
//On recupere un deuxieme entré avec un organisme different
$objEntite_2 = EntiteTable::getInstance()->getQueryObject()
                                            ->addWhere("id != ?",$objEntite_1->getId())
                                            ->andWhere("organisme_mindef_id != ?",$objEntite_1->getOrganismeMindefId())
                                            ->fetchOne();

$objTest->ok(EntiteTable::getInstance()->estCompatibleEntiteAvecOrganismeMindef($objEntite_1->getId(),$objEntite_1->getOrganismeMindefId()));

$objTest->ok(!EntiteTable::getInstance()->estCompatibleEntiteAvecOrganismeMindef($objEntite_1->getId(),$objEntite_2->getOrganismeMindefId()));

//Test si on a pu obtenir un objet de la base de données
//if (($objOrgMindef_1->getId()==null) || (empty ($objOrgMindef_1->getId())))
//{
//  $objOrgMindef_1 = new Organisme_mindef();
//
//  $objOrgMindef_1->setIntitule("Intitule_1");
//  $objOrgMindef_1->setAbreviation("ABR_1");
//  $objOrgMindef_1->setEstActif(true);
//
//  try
//  {
//    $objOrgMindef_1->save();
//  } catch (Exception $ex)
//  {
//    //On fail le test
//    $objTest->fail("Table Organisme_mindef et impossible de sauveguarder l'objet de test");
//
//    //On efface toutes les exceptions pour continuer
//    while ($ex->getPrevious()) {;}
//  }
//}

?>
