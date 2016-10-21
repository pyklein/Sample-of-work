<?php

/**
 * Base project form.
 * 
 * @package    gridSI
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
  
  /**
   * Traitement automatique les libellés des champs obligatoires
   * @author Gabor JAGER
   */
  public function configure()
  {
//    $this->disableLocalCSRFProtection();

    $arrFields = $this->widgetSchema->getFields();

    // pour chaque champ obligatoire on rejoute * dans la libelle
    foreach ($this->getRequiredFields() as $strCle)
    {
      $arrFields[$strCle]->setLabel($arrFields[$strCle]->getLabel()."*");
    }

  }

  /**
   * Permet de détecter les champs obligatoires
   * @return boolean[] tableau des champs "required"
   * @author Gabor JAGER
   */
  private function getRequiredFields()
  {
    $arrRetour = array();

    foreach ($this->validatorSchema->getFields() as $strCle => $objValidateur)
    {
      $arrOptions = $this->validatorSchema[$strCle]->getOptions();
      if ($arrOptions["required"] == true)
      {
        $arrRetour[] = $strCle;
      }
    }

    return $arrRetour;
  }


  public function  bind(array $taintedValues = null, array $taintedFiles = null) {
    $cleanedValues =  $this->filtrerReadOnly($taintedValues); 
    parent::bind($cleanedValues, $taintedFiles);
  }


  private function filtrerReadOnly($values = null){
    foreach($this->getReadOnlyFields() as $strNomWidget){
      $obj = $this->getObject(); 
      $values[$strNomWidget] = $obj[$strNomWidget];
    } 
    return $values;
  }

  private function getReadOnlyFields(){
    $arrRetour = array();
    foreach ($this->widgetSchema->getFields() as $strClef => $objWidget){
      if (is_a($objWidget, 'sfWidgetFormReadOnly')){
       $arrRetour[] = $strClef;
      }
    }
    return $arrRetour;
  }
}
