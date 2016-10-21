<?php
/**Tests unitatires pour la creation de document référencé
 * Projet : GRID
 * Module : notification
 * Date de création : 04/03/2011
 * Auteur: Jihad Sahebdin
 */

//include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(1);

$objDocumentReferenceFormValide = new Documents_mip_creer_referenceForm();
$objDocumentReferenceFormValide->bind(array(
    'fichier'=>'fichierTest',
    'titre'=>'titre test',
    'documents_mip_type_id'=>'2'
    ));
$objTest->cmp_ok($objDocumentReferenceFormValide->isValid(),'==',true,'Document_mip_creer_referenceForm: Valide');
