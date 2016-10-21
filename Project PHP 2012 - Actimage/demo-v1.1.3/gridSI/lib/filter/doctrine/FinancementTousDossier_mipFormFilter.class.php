<?php

/**
 * Description of FinancementTousDossier_mipFormFilter
 *
 * @author Simeon Petev
 */
class FinancementTousDossier_mipFormFilter extends BaseFinancementFormFilter
{
  public function configure()
  {
    $this->useFields(array());
    
    $arrAnnees = FinancementTable::getInstance()->getAnneesFinancementsOrdreDesc();

    $this->setWidget('annee', new sfWidgetFormChoice(array('choices' => $arrAnnees)));

    if (count($arrAnnees) > 0)
    {
      $this->setDefault('annee', current($arrAnnees));
    } else
    {
      $this->setDefault('annee', '0');
    }

    $this->validatorSchema['annee'] = new sfValidatorPass();

    $this->disableCSRFProtection();
  }
}
?>
