<?php
/**Tests unitatires pour EtudiantForm (Onglet Informations générales)
 * Projet : GRID
 * Module : referentiel_mris
 * Date de création : 01/04/2011
 * Auteur: Jihad Sahebdin
 */

//include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/doctrine.php');


$idCivilite = 3;
$objTest = new lime_test(7);

$objEtudiantFormValide = new EtudiantForm();
$objEtudiantFormValide->bind(array(
    'civilite_id'=>$idCivilite,
    'nom'=>'testnom',
    'prenom'=>'testprenom',
    'email' =>'testnom.testprenom@actimage.com'
    ));
$objTest->ok($objEtudiantFormValide->isValid(),'EtudiantForm: Valide');

//Creation d'un étudiant sans nom
$objEtudiantFormSansNom = new EtudiantForm();
$objEtudiantFormSansNom->bind(array(
    'civilite_id'=>$idCivilite,
    'prenom'=>'testprenom',
    'email' =>'testnom.testprenom@actimage.com'
    ));

$objTest->cmp_ok($objEtudiantFormSansNom->isValid(),'==',false,'EtudiantForm: Pas de nom => Invalide');

//Creation d'un étudiant avec date de naissance valide
$objEtudiantFormDateValide = new EtudiantForm();
$objEtudiantFormDateValide->bind(array(
    'civilite_id'=>$idCivilite,
    'nom'=>'testnom',
    'prenom'=>'testprenom',
    'date_naissance'=>'01/01/2011',
    'email' =>'testnom.testprenom@actimage.com'
    ));
$objTest->ok($objEtudiantFormDateValide->isValid(),'EtudiantForm: Date de naissance valide');

//Creation d'un étudiant avec date de naissance invalide
$objEtudiantFormDateInValide = new EtudiantForm();
$objEtudiantFormDateInValide->bind(array(
    'civilite_id'=>$idCivilite,
    'nom'=>'testnom',
    'prenom'=>'testprenom',
    'date_naissance'=>'01/13/2011',
    'email' =>'testnom.testprenom@actimage.com'
    ));
$objTest-> cmp_ok($objEtudiantFormDateInValide->isValid(),'==',false,'EtudiantForm: Date de naissance invalide');

//Creation d'un étudiant avec email invalide
$objEtudiantFormEmailInValide = new EtudiantForm();
$objEtudiantFormEmailInValide->bind(array(
    'civilite_id'=>$idCivilite,
    'nom'=>'testnom',
    'prenom'=>'testprenom',
    'email' =>'testnom.testprenom'
    ));
$objTest-> cmp_ok($objEtudiantFormEmailInValide->isValid(),'==',false,'EtudiantForm: Email invalide');

//Creation d'un étudiant avec code postal invalide
$objEtudiantFormCodeInValide = new EtudiantForm();
$objEtudiantFormCodeInValide->bind(array(
    'civilite_id'=>$idCivilite,
    'nom'=>'testnom',
    'prenom'=>'testprenom',
    'email' =>'testnom.testprenom',
    'code_postal'=>'1'
    ));
$objTest-> cmp_ok($objEtudiantFormCodeInValide->isValid(),'==',false,'EtudiantForm: Code postal invalide');

//Creation d'un étudiant avec telephone invalide
$objEtudiantFormTelephoneInValide = new EtudiantForm();
$objEtudiantFormTelephoneInValide->bind(array(
    'civilite_id'=>$idCivilite,
    'nom'=>'testnom',
    'prenom'=>'testprenom',
    'email' =>'testnom.testprenom',
    'telephone_fixe'=>'azerty'
    ));
$objTest-> cmp_ok($objEtudiantFormTelephoneInValide->isValid(),'==',false,'EtudiantForm: Telephone invalide');


