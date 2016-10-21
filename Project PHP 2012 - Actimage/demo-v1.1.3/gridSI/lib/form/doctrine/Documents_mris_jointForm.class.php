<?php

/**
 * Description of Documents_mris_jointForm
 *
 * @author William
 */
class Document_mris_jointForm extends BaseDocument_mrisForm {

  private $strTypeDossier;
  private $arrTypeDossier;
  public $nomWidgetType;

  public function __construct($strTypeDossier, $object = null, $options = array(), $CSRFSecret = null) {
    $this->strTypeDossier = $strTypeDossier;
    $this->arrTypeDossier = explode('_', $this->strTypeDossier);
    $this->nomWidgetType = 'type_document_'.$this->arrTypeDossier[1].'_id';
    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {
    //reconstruction de nom de modèle relatif
    $strNomModele = 'Type_document_'.$this->arrTypeDossier[1];
    
    $this->useFields(array('fichier', 'titre', $this->nomWidgetType, 'autre_type'));

    $this->widgetSchema['titre'] = new sfWidgetFormInput(array(), array('size' => '33',));

    $this->widgetSchema[$this->nomWidgetType] = new sfWidgetFormDoctrineChoice(array(
                'model' => $this->getRelatedModelName($strNomModele),
                'add_empty' => libelle("msg_libelle_autre_type"),
            ));

    $this->widgetSchema['fichier'] = new sfWidgetFormInputFileEditableJQuery(array(
                'with_delete' => false,
                'label' => libelle("msg_libelle_fichier"),
                'file_src' => "",
                'is_image' => false,
                'extensions' => sfConfig::get("app_extensions_bureau").", ".sfConfig::get("app_extensions_autres"),
                'template' => "%input% <br>"
            ));

    $this->widgetSchema[$this->nomWidgetType]->setLabel(libelle("msg_libelle_documents_type_id"));
    $this->widgetSchema['autre_type']->setLabel(libelle("msg_libelle_autre_type"));

    $this->validatorSchema[$this->nomWidgetType] = new sfValidatorDoctrineChoice(array(
        'required' => false,
        'model'    => $this->getRelatedModelName($strNomModele)
    ));

    $this->configurerValidateurs();

    if (!$this->getObject()->isNew()){
      //On empèche la modification du fichier en edition
      unset($this['fichier']);
    }

    $this->disableCSRFProtection();
    parent::configure();
  }

  private function configurerValidateurs() {
    $utilPhp = new ServiceFichier();
    $utilArbo = new ServiceArborescence();
    $strMethodeArbo = "getRepertoireDocumentsDossier" . ucfirst($this->arrTypeDossier[1]);
    $doc = $this->getObject();

    $this->validatorSchema['fichier'] = new gridValidatorFile(
                    array('required' => true,
                        'path' => $utilArbo->$strMethodeArbo($doc[ucfirst($this->strTypeDossier)]->getNumeroAAfficher()),
                        'max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                        'fichier_tous' => true
                    ),
                    array(
                        'required' => libelle("msg_libelle_fichier_requis"),
                        'max_size' => libelle("msg_libelle_taille_max_fichier", array($utilPhp->getMaxUploadSizeEnBytes() / (1024 * 1024))),
            ));
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
    //on enregistre le nom original du fichier
    if ($this->getObject()->isNew()){
      $this->getObject()->setFichierOrig($this->taintedFiles['fichier']['name']);
    }
    //Si le type de document a été precisé dans la liste déroulante, on efface ce qu'il y a dans le champ Autre
    if ($this->values[$this->nomWidgetType]) {
      $this->values['autre_type'] = "";
    }

    parent::save($con);
  }

}

?>
