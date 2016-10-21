<?php

/**
 * Formulaire de modèle de lettre
 * @author Gabor JAGER
 */
class Modele_lettreForm extends BaseModele_lettreForm
{
  /**
   * Clé de formulaire
   * @var string
   */
  private $strCle;

  /**
   * Constructeur.
   * Permet de passe la clé au formulaire
   * @param string $strCle
   * @param <type> $object
   * @param <type> $options
   * @param <type> $CSRFSecret
   * @author Gabor JAGER
   */
  public function  __construct($strCle, $object = null, $options = array(), $CSRFSecret = null)
  {
    $this->strCle = $strCle;
    parent::__construct($object, $options, $CSRFSecret);
  }

  /**
   * Configuration de formulaire
   * @author Gabor JAGER
   */
  public function configure()
  {
    $this->useFields(array('fichier'));

    $utilPhp = new ServiceFichier();

    $this->widgetSchema['fichier'] = new sfWidgetFormInputFileEditableJQuery(array(
      'label'     => libelle("msg_libelle_nom_fichier"),
      'avec_javascript' => false,
      'with_delete' => true,
      'delete_label' => libelle('msg_libelle_supprimer'),
      'file_src'  => url_for("referentiel_mip/chargerModeleLettre?cle=".$this->getObject()->getCle()),
      'is_image'  => false,
      'extensions' => sfConfig::get("app_extensions_rtf"),
      'edit_mode' => !$this->isNew() && (strlen($this->getObject()->getFichier())>0),
      'template'  => "%input% <br />
                      %delete_label% : %delete% <br />
                      <label></label>&nbsp;&nbsp;
                      <a href=\"".url_for("referentiel_mip/chargerModeleLettre?cle=".$this->getObject()->getCle())."\" target=\"_blank\" class=\"picto_small bt_export_rtf_small\">".$this->getObject()->getFichierOrig()."</a>
                      ",
    ));
    $utilArbo = new ServiceArborescence();
    $this->validatorSchema['fichier'] = new gridValidatorFile(
                                          array('required' => false,
                                                'path' => $utilArbo->getRepertoireModelesDocuments(),
                                                'max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                                                'fichier_rtf' => true
                                          ));
    $this->validatorSchema['fichier']->setMessage('max_size', libelle('msg_libelle_taille_max_fichier', array($utilPhp->getMaxUploadSizeEnFormatHumain())));
    $this->validatorSchema['fichier_delete'] = new sfValidatorBoolean();

    $this->disableCSRFProtection();

    parent::configure();

    $this->widgetSchema->setNameFormat('modele_lettre_'.$this->strCle.'[%s]');

  }

  /**
   * Permet de sauvegarder automatiquement le nom d'original de fichier
   * @param mixed $con
   * @return mixed l'objet sauvegardé
   * @author Gabor JAGER
   */
  public function save($con = null)
  {
    if (isset($this->taintedFiles['fichier']['name']) && $this->taintedFiles['fichier']['name'] != "")
    {
      $this->getObject()->setFichierOrig($this->taintedFiles['fichier']['name']);
    }

    return parent::save($con);
  }
}
