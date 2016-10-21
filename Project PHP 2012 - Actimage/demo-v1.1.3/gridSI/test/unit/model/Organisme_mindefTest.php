<?php



/**Tests unitaires pour organisme_mindef
 * Projet : GRID
 * Module : referentiel
 * Date de création : 09/03/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');
require_once(dirname(__FILE__) . '/../../../config/ProjectConfiguration.class.php');
    $configuration = ProjectConfiguration::getApplicationConfiguration('gridweb', $options['env'], true);

    sfContext::createInstance($configuration);
    $configuration->loadHelpers(array("libelle"));
if (!sfContext::hasInstance()){
  sfContext::createInstance($configuration);
}

$objTest = new lime_test(3);

$objOrganismeValide = creerOrganisme_mindef('Marine', 'MA');
$objOrganismeInvalide = creerOrganisme_mindef(null, null);

$objTest->comment('Test de la validation des organismes mindef');


$arrayOrgMinValide = array('intitule'=> 'Direction generale',
                      'abreviation' => 'ABR'
                      );

$arrayOrgMinSansIntitule = array('intitule'=> '',
                      'abreviation' => 'ABR'
                      );

$arrayOrgMinSansAbreviation = array('intitule'=> 'Direction generale',
                      'abreviation' => ''
                      );

$testOrgMinForm =  new Organisme_mindefForm();

// formulaire avec des données valides
$testOrgMinForm->bind($arrayOrgMinValide);
//var_dump($testOrgMinForm->getErrorSchema()->count());

$objTest->is($testOrgMinForm->isValid(), true, 'Le formulaire est valide avec des donnees valides');

// fomulaire avec des données invalides
$testOrgMinForm->bind($arrayOrgMinSansIntitule);
$objTest->is($testOrgMinForm->isValid(), false, 'Le formulaire est invalide sans intitule');

// fomulaire avec des données invalides
$testOrgMinForm->bind($arrayOrgMinSansAbreviation);
$objTest->is($testOrgMinForm->isValid(), false, 'Le formulaire est invalide sans abreviation');


function creerOrganisme_mindef($intitule, $abreviation){
  $objOrganisme_mindef = new Organisme_mindef();
  $objOrganisme_mindef->setIntitule($intitule);
  $objOrganisme_mindef->setAbreviation($abreviation);
  $objOrganisme_mindef->setEstActif(true);
  return $objOrganisme_mindef;
}
?>
