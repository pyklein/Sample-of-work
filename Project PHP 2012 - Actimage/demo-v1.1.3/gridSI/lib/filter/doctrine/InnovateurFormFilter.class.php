<?php

/**
 * Fitre pour les innovateurs
 *
 * @author Actimage
 */
class InnovateurFormFilter extends BaseUtilisateurFormFilter {

  public function configure() {
    
    $this->useFields(array('est_actif', 'organisme_mindef_id', 'entite_id', 'grade_id'));
    
    $this->setWidget('nom_prenom_email', new sfWidgetFormFilterInput(array(
                'with_empty' => false)));
    
    $this->setWidget('telephone', new sfWidgetFormFilterInput(array(
                'with_empty' => false)));
    
    $this->setWidget('est_actif', new sfWidgetFormChoice(array(
                'choices' => array('' => libelle('msg_libelle_tous'), 1 => libelle('msg_libelle_actif'), 0 => libelle('msg_libelle_inactif'))
            )));
    
     $this->setWidget('organisme_mindef_id', new gridWidgetFormOrganismeMindef());
     
     $this->setWidget('entite_id', new gridWidgetFormEntite());
     $this->setWidget('grade_id' ,new gridWidgetFormGrade());
     
    //validateurs
    $this->validatorSchema['nom_prenom_email'] = new sfValidatorPass();
    $this->validatorSchema['telephone'] = new sfValidatorPass();
    $this->validatorSchema['organisme_mindef_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme_mindef'), 'column' => 'id'));
    $this->validatorSchema['entite_id'] =  new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Entite'), 'column' => 'id'));
    $this->validatorSchema['grade_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Grade'), 'column' => 'id'));
    
    //labels
    $this->widgetSchema->setLabels(array(
        'nom_prenom_email' => libelle("msg_libelle_nom_prenom_email"),
        'telephone' => libelle("msg_libelle_telephone_filtre"),
        'est_actif' => libelle("msg_libelle_etat"),
        'organisme_mindef_id' => libelle("msg_libelle_org_mindef"),
        'entite_id' => libelle('msg_libelle_entite'),
        'grade_id' => libelle('msg_libelle_grade'),
    ));

    //rangement des champs dans l'ordre
    $this->widgetSchema->setPositions(array('nom_prenom_email', 'telephone', 'est_actif', 'organisme_mindef_id', 'entite_id', 'grade_id'));

    $this->widgetSchema->setNameFormat('innovateur_filters[%s]');
    
    $this->disableLocalCSRFProtection();
  }

  public function getFields() {
    $fields = parent::getFields();
    $fields['nom_prenom_email'] = 'Text';
    $fields['telephone'] = 'Text';

    return $fields;
  }

  protected function addNomPrenomEmailColumnQuery($query, $field, $value) {
    if ($value['text'] != '') {
      UtilisateurTable::getInstance()->appliquerFiltreNomPrenomEmail($query, $value['text']);
    }
  }

  protected function addTelephoneColumnQuery($query, $field, $value) {
    if ($value['text'] != '') {
      UtilisateurTable::getInstance()->appliquerFiltreTelephone($query, $value['text']);
    }
  }

}
?>
