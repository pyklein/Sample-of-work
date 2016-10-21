<?php
/**Tests unitatires pour EtudiantFormationForm (Onglet Formations et diplomes dans la modification d'un etudiant)
 * Projet : GRID
 * Module : referentiel_mris
 * Date de création : 01/04/2011
 * Auteur: Jihad Sahebdin
 */

//include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/doctrine.php');



$objTest = new lime_test(3);

//Modification d'un étudiant avec des champs valides
$objEtudiantFormValide = new EtudiantFormationForm();
$objEtudiantFormValide->bind(array(
    'type_cursus'=>'Université',
    'autre_cursus'=>'BTS',
    'a_master'=>true
    ));
$objTest->ok($objEtudiantFormValide->isValid(),'EtudiantFormationForm: Valide');

//Modification d'un étudiant avec des champs valides en choisissant 'Autre' comme type de formation
$objEtudiantFormValideAutre = new EtudiantFormationForm();
$objEtudiantFormValideAutre->bind(array(
    'type_cursus'=>'Autre',
    'autre_cursus'=>'BTS',
    'a_master'=>true
    ));
$objTest->ok($objEtudiantFormValideAutre->isValid(),'EtudiantFormationForm: Valide avec Autre selectionné comme type de cursus (On est obligé de remplir le champ Autre)');

//Modification d'un étudiant invalide en choisissant 'Autre' sans le preciser dans le champ Autre
$objEtudiantFormInvalideAutre = new EtudiantFormationForm();
$objEtudiantFormInvalideAutre->bind(array(
    'type_cursus'=>'Autre',
    'a_master'=>true
    ));
$objTest->cmp_ok($objEtudiantFormInvalideAutre->isValid(),'==',false,'EtudiantFormationForm: Invalide avec Autre selectionné comme type de cursus sans avoir remplit le champ Autre)');



//Creation d'un étudiant sans nom
//$objEtudiantFormSansNom = new EtudiantForm();
//$objEtudiantFormSansNom->bind(array(
//    'civilite_id'=>$idCivilite,
//    'prenom'=>'testprenom',
//    'email' =>'testnom.testprenom@actimage.com'
//    ));
//
//$objTest->cmp_ok($objEtudiantFormSansNom->isValid(),'==',false,'EtudiantForm: Pas de nom => Invalide');

