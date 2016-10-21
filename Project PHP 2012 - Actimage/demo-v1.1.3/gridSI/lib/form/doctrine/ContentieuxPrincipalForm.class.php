<?php

/**
 * Formulaire principale pour la gestion des contentieux
 *
 * @author Alexandre WETTA
 */
class ContentieuxPrincipalForm extends BaseDossier_bpiForm {

  public function __construct($partInventiveId, $object = null, $options = array(), $CSRFSecret = null) {

    $this->partInventiveId = $partInventiveId;

    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {

    $this->useFields(array());

    $objContentieuxInvention = ContentieuxTable::getInstance()->retrieveContentieuxBypartInventiveId($this->partInventiveId, 'invention');
    //si le contentieux n'existe pas
    if ($objContentieuxInvention == null) {
      $objContentieuxInvention = new Contentieux();
      $objContentieuxInvention->setPartInventiveId($this->partInventiveId);
      $objContentieuxInvention->setTypeContentieuxId(Type_contentieuxTable::INVENTION);
    }
    $contentieuxInventionForm = new ContentieuxForm($objContentieuxInvention);

    $objContentieuxDroits = ContentieuxTable::getInstance()->retrieveContentieuxBypartInventiveId($this->partInventiveId, 'droits');
    //si le contentieux n'existe pas
    if ($objContentieuxDroits == null) {
      $objContentieuxDroits = new Contentieux();
      $objContentieuxDroits->setPartInventiveId($this->partInventiveId);
      $objContentieuxDroits->setTypeContentieuxId(Type_contentieuxTable::DROITS);
    }
    $contentieuxDroitsForm = new ContentieuxForm($objContentieuxDroits);

    $objContentieuxExploitation = ContentieuxTable::getInstance()->retrieveContentieuxBypartInventiveId($this->partInventiveId, 'exploitation');
    //si le contentieux n'existe pas
    if ($objContentieuxExploitation == null) {
      $objContentieuxExploitation = new Contentieux();
      $objContentieuxExploitation->setPartInventiveId($this->partInventiveId);
      $objContentieuxExploitation->setTypeContentieuxId(Type_contentieuxTable::EXPLOITATION_INTERNE);
    }
    $contentieuxExploitationForm = new ContentieuxForm($objContentieuxExploitation);


    $this->embedForm('contentieux_invention', $contentieuxInventionForm);
    $this->embedForm('contentieux_droits', $contentieuxDroitsForm);
    $this->embedForm('contentieux_exploitation', $contentieuxExploitationForm);

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

}
?>
