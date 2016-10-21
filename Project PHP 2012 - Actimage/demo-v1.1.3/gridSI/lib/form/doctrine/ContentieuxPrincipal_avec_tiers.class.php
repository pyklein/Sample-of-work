<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContentieuxPrincipal_avec_tiers
 *
 * @author Antonin KALK
 */
class ContentieuxPrincipal_avec_tiers extends BaseDossier_bpiForm {

  public function __construct($object = null, $options = array(), $CSRFSecret = null) {
    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {

    $this->useFields(array());

    $objContentieuxContrat = Contentieux_avec_tiersTable::getInstance()->retrieveContentieuxAvecTiers('contrat');
    //si le contentieux n'existe pas
    if ($objContentieuxContrat == null) {
      $objContentieuxContrat = new Contentieux_avec_tiers();
      $objContentieuxContrat->setTypeContentieuxTiersId(Type_contentieux_tiersTable::CONTRAT);
    }
    $contentieuxContratForm = new Contentieux_avec_tiersForm($objContentieuxContrat);

    $objContentieuxAbsenceContrat = Contentieux_avec_tiersTable::getInstance()->retrieveContentieuxAvecTiers('absence_contrat');
    //si le contentieux n'existe pas
    if ($objContentieuxAbsenceContrat == null) {
      $objContentieuxAbsenceContrat = new Contentieux_avec_tiers();
      $objContentieuxAbsenceContrat->setTypeContentieuxTiersId(Type_contentieux_tiersTable::ABSENCECONTRAT);
    }
    $contentieuxAbsenceContratForm = new Contentieux_avec_tiersForm($objContentieuxAbsenceContrat);

    $this->embedForm('contentieux_contrat', $contentieuxContratForm);
    $this->embedForm('contentieux_absence_contrat', $contentieuxAbsenceContratForm);

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

}
?>
