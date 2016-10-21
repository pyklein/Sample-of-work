<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__).'/../../bootstrap/doctrine.php';

$objTest = new lime_test(2);

$arrIntervenantsOrdreAscNomPrenom = IntervenantTable::getInstance()->getIntervenantsOrdreAscNomPrenom();

$boolEstCorrect=true;
$nomPrecedent     = "";
$prenomPrecedent  = "";

foreach ($arrIntervenantsOrdreAscNomPrenom as $index => $objIntervenant)
{
  if ($index==0)
  {
    $nomPrecedent = $objIntervenant->getNom();
    $prenomPrecedent = $objIntervenant->getPrenom();
  } else
  {
    if (strcmp($nomPrecedent, $objIntervenant->getNom())>0)
    {
      $boolEstCorrect = false;
      break;
    } else if ((strcmp($nomPrecedent, $objIntervenant->getNom())==0) && (strcmp($prenomPrecedent, $objIntervenant->getPrenom())>0))
    {
      $boolEstCorrect = false;
      break;
    }

    $nomPrecedent = $objIntervenant->getNom();
    $prenomPrecedent = $objIntervenant->getPrenom();
  }
}

/*##################### TEST 1 ###############################*/
$objTest->ok($boolEstCorrect, "Les intervenant sont recupere en ordre ascendant de leur nom et leur prenom.");


//On presume que l'intervenant avec id=1 existe
$objIntervenant1 = IntervenantTable::getInstance()->getUnAvecId(1);

/*##################### TEST 2 ###############################*/
$objTest->is($objIntervenant1->getId(), 1, "L'intervenant avec ID=1 est bien recuperé.");


?>
