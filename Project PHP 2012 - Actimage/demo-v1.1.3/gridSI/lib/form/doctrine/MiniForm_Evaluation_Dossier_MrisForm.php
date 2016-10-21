<?php

/**
 * formulaire imbriqué pour évaluation des dossiers MRIS
 *
 * @author Actimage
 */
class MiniForm_Evaluation_Dossier_MrisForm extends BaseEvaluationForm {

  public function  __construct($objNote, $object = null, $options = array(), $CSRFSecret = null) {
    
    $this->objNote = $objNote ;

    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {

    $this->useFields(array('valeur_note_id'));

    $this->widgetSchema['valeur_note_id'] = new gridWidgetFormValeurNote();
    $this->widgetSchema['valeur_note_id']->setLabel($this->objNote->getIntitule());

    $this->widgetSchema->setNameFormat('miniForm_evaluation_dossier[%s]');
    
    $this->validatorSchema->setOption('allow_extra_fields', true);

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

}
?>
