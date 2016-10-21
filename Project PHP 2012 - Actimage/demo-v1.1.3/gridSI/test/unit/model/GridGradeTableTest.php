<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');


$objTest = new lime_test();

//test de la methode proxy getByRelationId($id)
$gradeOrg1 = creerGrade('Commandant', 'CDT');
$gradeOrg2 = creerGrade('Adjudant', 'ADJ');
$gradeOrg3 = creerGrade('Aspirant', 'ASP');

$org1 = creerOrg('Armee de terre', 'ADT');
$org2 = creerOrg("Armee de l'air", 'ADA');
$org3 = creerOrg('Marine', 'MAR');
$gradeOrg1['Organisme_mindef'] = $org1;
$gradeOrg2['Organisme_mindef'] = $org2;
$gradeOrg3['Organisme_mindef'] = $org3;
$org1->save();
$org2->save();
$org3->save();
$gradeOrg1->save();
$gradeOrg2->save();
$gradeOrg3->save();

$orgMarine = Organisme_mindefTable::getInstance()->findOneByAbreviation('MAR');
$gradeMarine = GradeTable::getInstance()->retrieveByRelationId($orgMarine->getId())->execute();

$strAbreviatonGradeMarine = $gradeMarine[0]->getAbreviation();
if (!$strAbreviatonGradeMarine){
  $strAbreviatonGradeMarine = $objEmailsRecuperes->getAbreviation();
}
$objTest->is($strAbreviatonGradeMarine,'ASP','La methode recupere bien le grade attendu');

//foreach( GradeTable::getInstance()->findAll() as $obj){
//   $obj->delete();
//}
//foreach( Organisme_mindefTable::getInstance()->findAll() as $obj){
//   $obj->delete();
//}


function creerGrade($strIntitule,$strAbreviation){
  $objGrade = new Grade();
  $objGrade->setIntitule($strIntitule);
  $objGrade->setAbreviation($strAbreviation);
  return $objGrade;
}
function creerOrg($strIntitule,$strAbreviation){
  $objOrg = new Organisme_mindef();
  $objOrg->setIntitule($strIntitule);
  $objOrg->setAbreviation($strAbreviation);
  return $objOrg;
}
?>