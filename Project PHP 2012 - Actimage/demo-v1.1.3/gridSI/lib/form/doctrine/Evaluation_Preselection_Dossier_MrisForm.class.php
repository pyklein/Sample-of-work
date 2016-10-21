<?php

/**
 * Description of Evaluation_Preselection_Dossier_MrisForm
 *
 * @author Actimage
 */
class Evaluation_Preselection_Dossier_MrisForm extends BaseEvaluationForm {

  public function __construct($userId, $existenceEvaluation, $objDossier, $arrNotes, $object = null, $options = array(), $CSRFSecret = null) {

    $this->userId = $userId;
    $this->existenceEvaluation = $existenceEvaluation;
    $this->objDossier = $objDossier;
    $this->arrNotes = $arrNotes;

    $this->strTypeDossier = $this->objDossier->getTable()->getTableName();

    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {

    $this->useFields(array('valeur_note_id'));


    foreach ($this->arrNotes as $note) {

      //on cherche l'évaluation à afficher
       $arrEvaluation = EvaluationTable::getInstance()->getEvaluationPreselectionByNoteIdAndDossierId($note->getId(), $this->objDossier->getId(), $this->strTypeDossier);
       foreach ($arrEvaluation as $objEval){
         $objEvaluation = $objEval;
       }
      //si il n'y a pas d'objEvaluation, on va en créer un
      if($arrEvaluation->count() != 1){
        $objEvaluation = new Evaluation();
        $objEvaluation->setNoteId($note->getId());
        $objEvaluation = $this->setTypeDossier($objEvaluation);
      }
      
      $objEvaluation->setEstPreselection(true);
      //on crée le nouveau formulaire
      $form = new MiniForm_Evaluation_Dossier_MrisForm($note, $objEvaluation);
      $this->embedForm('Evaluation' . $note->getId(), $form, null);
    }

    $this->widgetSchema['valeur_note_id'] = new gridWidgetFormValeurNote();
    $this->widgetSchema['valeur_note_id']->setLabel(libelle('msg_libelle_evaluation_globale'));

    $this->widgetSchema->setNameFormat('evaluation_preselection_dossier_mris[%s]');

    $this->validatorSchema->setOption('allow_extra_fields', true);

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  protected function setTypeDossier($objEvaluation) {


    if ($this->strTypeDossier == 'dossier_these'){
      $objEvaluation->setDossierTheseId($this->objDossier->getId());
    }

    if ($this->strTypeDossier == 'dossier_postdoc'){
      $objEvaluation->setDossierPostdocId($this->objDossier->getId());
    }
    
    if ($this->strTypeDossier == 'dossier_ere'){
      $objEvaluation->setDossierEreId($this->objDossier->getId());
    }

    return $objEvaluation;
  }

}
?>
