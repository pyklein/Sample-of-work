<?php
/**
 * Evaluation finale d'un dossier Mris
 *
 * @author Actimage
 */
class Evaluation_Finale_Dossier_MrisForm extends BaseEvaluationForm {

  public function  configure() {

     $this->useFields(array('valeur_note_id'));

     $this->widgetSchema['valeur_note_id'] = new gridWidgetFormValeurNote();
     $this->widgetSchema->setLabels(array(
        'valeur_note_id'                => libelle("msg_libelle_evaluation_finale"),
    ));
     
    $this->disableLocalCSRFProtection();
    parent::configure();
  }
    
}
?>
