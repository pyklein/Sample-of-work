<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Documents_mris_jointForm
 * @param String    $strTypeDossier   type du dossier auquel le document est attaché (format : dossier_[type])
 * @author William
 */
class Document_mris_referenceForm extends BaseDocument_mrisForm {

  private $strTypeDossier;
  public $nomWidgetType;

  public function __construct($strTypeDossier, $object = null, $options = array(), $CSRFSecret = null) {
    $this->strTypeDossier = $strTypeDossier;
    $this->nomWidgetType = explode('_', $this->strTypeDossier);
    $this->nomWidgetType = 'type_document_'.$this->nomWidgetType[1].'_id';
    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {
    //reconstruction de nom de modèle relatif
    $arr = explode('_',$this->nomWidgetType);
    $strNomModele = strtoupper($arr[0][0]).substr($arr[0], 1).'_'.$arr[1].'_'.$arr[2];

    $this->useFields(array('fichier', 'titre', $this->nomWidgetType, 'autre_type'));

    $this->widgetSchema['titre'] = new sfWidgetFormInput(array(), array('size' => '33',));

    $this->widgetSchema[$this->nomWidgetType] = new sfWidgetFormDoctrineChoice(array(
                'model' => $this->getRelatedModelName($strNomModele),
                'add_empty' => libelle("msg_libelle_autre_type"),
            ));

    $this->widgetSchema['fichier'] = new sfWidgetFormInput(array('label' => libelle("msg_libelle_nom_fichier")));

    $this->widgetSchema[$this->nomWidgetType]->setLabel(libelle("msg_libelle_documents_type_id"));
    $this->widgetSchema['autre_type']->setLabel(libelle("msg_libelle_autre_type"));

    $this->validatorSchema[$this->nomWidgetType] = new sfValidatorDoctrineChoice(array(
        'required' => false,
        'model'    => $this->getRelatedModelName($strNomModele)
    ));

    $this->configurerValidateurs();


    $this->disableCSRFProtection();
    parent::configure();
  }

  private function configurerValidateurs() {
    $utilPhp = new ServiceFichier();

    $this->validatorSchema['fichier'] = new sfValidatorString(array('required' => true));
    $this->validatorSchema->setPostValidator(
            new sfValidatorCallback(array('callback' => array($this, 'validationType')))
    );
  }

  //Vérifier que le champ autre ne soit pas vide quand l'utilisateur choisit "Autre" comme type de document
  public function validationType($validator, $values) {
    if ($values[$this->nomWidgetType] == "" && $values['autre_type'] == false) {
      $error = new sfValidatorError($validator, libelle('msg_document_erreur_type'));
      throw new sfValidatorErrorSchema($validator, array('autre_type' => $error));
    }
    return $values;
  }

  public function save($con = null) {
    //Si le type de document a été precisé dans la liste déroulante, on efface ce qu'il y a dans le champ Autre
    if ($this->values[$this->nomWidgetType]) {
      $this->values['autre_type'] = "";
    }

    return parent::save($con);
  }

}

?>
