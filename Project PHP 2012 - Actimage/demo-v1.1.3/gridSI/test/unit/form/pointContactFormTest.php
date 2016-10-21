<?php


require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(3);

$arrFormulaireValide = array("email" => 'william.richards@actimage.com',
                        "telephone" => '03 88 88 88 88',
                        "ville_id" => '1',
                        "code_postal" => '67100');
$arrFormulaireInvalide = array('email' => 'william.richards@actimage.com',
                        'telephone' => '03 AB CD 88 88',
                        'ville_id' => '1',
                        'code_postal' => '67100');
$arrFormulaireIncomplet = array('telephone' => '03 88 88 88 88',
                        'code_postal' => '67100');

$objFormValide = new Point_contactForm();
$objFormInvalide = new Point_contactForm();
$objFormIncomplet = new Point_contactForm();

$objFormValide->bind($arrFormulaireValide);
$objFormInvalide->bind($arrFormulaireInvalide);
$objFormIncomplet->bind($arrFormulaireIncomplet);


$objTest->ok($objFormValide->isValid(), "données valides");
$objTest->ok(! $objFormInvalide->isValid(), "données invalides");
$objTest->ok(! $objFormIncomplet->isValid(), "données incomplètes");

?>
