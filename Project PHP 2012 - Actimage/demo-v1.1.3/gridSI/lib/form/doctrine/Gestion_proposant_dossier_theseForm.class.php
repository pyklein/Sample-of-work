<?php

/**
 * Formulaire d'ajout d'un proposant pour un dossier de thèse
 *
 * @author Actimage
 */
class Gestion_proposant_dossier_theseForm extends BaseDossier_theseForm {

  public function configure() {

    $this->useFields(array('realise_par'));

    //on cherche le dossier_id
    $dossier_id = sfContext::getInstance()->getRequest()->getParameter('dossier_these_id');

    $this->widgetSchema['realise_par'] = new sfWidgetFormDoctrineChoiceParametered(array(
                'model' => 'Etudiant',
                'add_empty'=> false,
                'table_method' =>  array('method' => 'getEtudiantSansDossier', 'parameters' => array($dossier_id, 'these')),
                'order_by' => array('Nom', 'asc'),
                'label' => libelle('msg_libelle_realise_par')
          ));

    $this->disableLocalCSRFProtection();

    parent::configure();
    
  }

}
?>
