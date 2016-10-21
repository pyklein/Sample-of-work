<?php

/**
 * Formulaire principal pour l'évaluation des dossiers postdoc
 *
 * @author Actimage
 */
class Evaluation_Selection_Dossier_Postdoc_Formulaire_PrincipaleForm extends BaseDossier_postdocForm{
  public function  __construct($strModelContenant, $arrNotes,$objDossier, $userId, $arrInvitations, $object = null, $options = array(), $CSRFSecret = null) {

    $this->strModelContenant = $strModelContenant ;
    $this->arrNotes = $arrNotes ;
    $this->objDossier = $objDossier ;
    $this->userId = $userId ;
    $this->arrInvitations =  $arrInvitations ;

    parent::__construct($object, $options, $CSRFSecret);
  }

  public function  configure() {

    $this->useFields(array());

    foreach ($this->arrInvitations as $invitation) {
        //on regarde s'il y a déjà une evaluation globale pour le dossier pour cette invitation
        $queryEvaluationsCheck = EvaluationTable::getInstance()->getQueryEvaluationSelectionByTypeDossierAndEstGlobal($this->strModelContenant, $this->objDossier->getId(), $invitation->getId());
        $arrEvaluationsCheck = EvaluationTable::getInstance()->getEvaluationSelectionByTypeDossierAndEstGlobal($this->strModelContenant, $this->objDossier->getId(), $invitation->getId());

        //on inclut l'objet evaluation dans la bonne variable
        $objEvaluation = $arrEvaluationsCheck[0];

        //si on n'a pas trouvé d'objEvaluation, on va en créer un
        if ($queryEvaluationsCheck->count() == 0) {
          $objEvaluation = new Evaluation();
        }

        //on set l'objet Evaluation
        $objEvaluation->setEstGlobale(true);
        $objEvaluation->setEstPreselection(false);
        $objEvaluation->setInvitationId($invitation->getId());
        if ($this->strModelContenant == 'Dossier_postdoc') $objEvaluation->setDossierPostdocId($this->objDossier->getId());


        //on imbrique les formulaires d'évaluation
        $evalForm =  new Evaluation_Selection_Dossier_MrisForm($invitation->getId(),$this->userId, $this->objDossier, $this->arrNotes, $objEvaluation);
        $this->embedForm('Invitation'. $invitation->getId(), $evalForm);

      }

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

}
?>

