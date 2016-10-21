<?php

if (sfContext::hasInstance()) {
  sfContext::getInstance()->getConfiguration()->loadHelpers("Format");
  sfContext::getInstance()->getConfiguration()->loadHelpers("Url");
}

/**
 * Dossier_mip form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Dossier_mipForm extends BaseDossier_mipForm {

  public function configure() {
    $utilPhp = new ServiceFichier();
    $objUtilArbo = new ServiceArborescence();

    $this->useFields(array('numero', 'created_at', 'titre', 'acronyme', 'descriptif', 'pilote_id',
        'organisme_mindef_id', 'niveau_protection_id', 'statut_dossier_mip_id',
        'etat_partage_id', 'est_publie', 'dossier_vivant', 'photographie'));

    $this->widgetSchema['numero'] = new sfWidgetFormReadOnly();
    $this->widgetSchema['created_at'] = new sfWidgetFormReadOnly();
    
    $this->widgetSchema['est_publie'] = new gridWidgetFormChoiceRadioAligne(
                    array(
                        'choices' => array(
                            true  => libelle('msg_libelle_publie'),
                            false => libelle('msg_libelle_non_publie')),
            ));
    
    $this->widgetSchema['dossier_vivant'] = new sfWidgetFormInputCheckboxUnchecked();
    $this->widgetSchema['descriptif'] = new sfWidgetFormTextarea;
    //$this->widgetSchema['descriptif'] = new sfWidgetFormInputEmail();

    
    $this->widgetSchema['organisme_mindef_id'] = new gridWidgetFormOrganismeMindef(array("model" => $this->getRelatedModelName('Organisme_mindef'), "popup" => true));


    $this->widgetSchema['etat_partage_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'add_empty' => false));

    $this->widgetSchema['niveau_protection_id'] = new sfWidgetFormDoctrineChoice(
                    array('model' => $this->getRelatedModelName('Niveau_protection')));

    $this->widgetSchema['statut_dossier_mip_id'] = new gridWidgetFormStatutDossierMip(array('model' => 'Statut_dossier_mip','popup'=>true));

    $this->widgetSchema['photographie'] = new sfWidgetFormInputFileEditableJQuery(array(
                'with_delete' => true,
                'label' => libelle("msg_libelle_fichier"),
                'delete_label' => libelle('msg_utilisateur_libelle_supp_fichier'),
                'file_src' => url_for("dossier_mip/chargerThumbnailDossier_mip?path=" . bin2hex($objUtilArbo->getRepertoireDossiersMIP()). "&fichier=" . $this->getObject()->getPhotographie()),
                'is_image' => true,
                'extensions' => sfConfig::get("app_extensions_images"),
                'edit_mode' => !$this->isNew() && (strlen($this->getObject()->getPhotographie()) > 0),
                'template' => "%input% <br>
                      %delete_label% : %delete% <br>
                      <label></label>&nbsp;&nbsp;&nbsp;
                      <a id=\"img_photographie\" href=\"" . url_for("interface/telechargerPhoto?path=" . bin2hex($objUtilArbo->getRepertoireDossiersMIP()). "&fichier=" . $this->getObject()->getPhotographie())  . "\" target=\"_blank\">%file%</a>",
            ));

    $this->widgetSchema['pilote_id'] = new gridWidgetFormPilote(array(
                'model' => $this->getRelatedModelName('Pilote'),
                'popup' => true
                    )
    );

    $this->validatorSchema['pilote_id'] = new sfValidatorDoctrineChoice(array(
                'model' => $this->getRelatedModelName('Pilote'),
                'required' => false
            ),
            array('required' => libelle("msg_dossier_mip_pilote_requis")));

    $this->validatorSchema['dossier_vivant'] = new sfValidatorBoolean();
    $this->validatorSchema['photographie_delete'] = new sfValidatorBoolean();

    $this->validatorSchema['organisme_mindef_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef')),
            array('required' => libelle('msg_dossier_mip_org_mindef_requis')));

    $this->validatorSchema['photographie'] = new gridValidatorFile(
            array('max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                  'fichier_images' => true,
                  'path' => $objUtilArbo->getRepertoireDossiersMIP(),
                  'required' => false
                  ),
            array('max_size' => libelle("msg_libelle_taille_max_fichier", array($utilPhp->getMaxUploadSizeEnFormatHumain())))
    );

    $this->validatorSchema['statut_dossier_mip_id'] = new sfValidatorDoctrineChoice(
                    array('required' => true, 'model' => 'Statut_dossier_mip'),
                    array('required' => libelle("msg_dossier_mip_statut_requis")));

    $this->validatorSchema['titre'] = new sfValidatorString(array('required' => true),
                    array('required' => libelle("msg_dossier_mip_titre_requis")));

    $this->validatorSchema['descriptif'] = new gridValidatorTextarea(array('required'=>false));
    
    $this->validatorSchema->setPostValidator(new sfValidatorDoctrineUnique(array('column' => 'numero', 'model' => 'dossier_mip',
                'throw_global_error' => false, 'primary_key' => 'id'),
                    array('invalid' => libelle('msg_dossier_mip_numero_unique'))));

    $this->widgetSchema->setLabels(array(
        'numero' => libelle("msg_dossier_mip_libelle_numero"),
        'created_at' => libelle("msg_libelle_date_creation"),
        'titre' => libelle("msg_libelle_titre"),
        'acronyme' => libelle("msg_libelle_acronyme"),
        'descriptif' => libelle("msg_libelle_descriptif"),
        'pilote_id' => libelle("msg_libelle_pilote"),
        'organisme_mindef_id' => libelle("msg_libelle_armee"),
        'niveau_protection_id' => libelle("msg_libelle_classification"),
        'statut_dossier_mip_id' => libelle("msg_libelle_statut_dossier"),
        'etat_partage_id' => libelle("msg_libelle_etat_partage"),
        'est_publie' => libelle("msg_libelle_est_publie")
    ));
    
    if ($this->getObject()->isNew()) {
      unset($this['numero']);
      unset($this['created_at']);
    }

    if (!sfContext::getInstance()->getUser()->hasCredential('SUP-MIP')) {
      unset($this['pilote_id']);
    }

    if ($this->getObject()->estPreProjet()){
      unset($this['numero']);
      unset($this['niveau_protection_id']);
      unset($this['etat_partage_id']);
      unset($this['est_publie']);
      unset($this['photographie']);
      unset($this['statut_dossier_mip_id']);
    }

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  protected function removeFile($field) {
    // on supprime le thumbnail
    $utilArbo = new ServiceArborescence();
    $utilFichier = new UtilFichier();
    $strNomImageThumb = nomImageThumbnail($utilArbo->getRepertoireDossiersMIP() . $this->getObject()->getPhotographie());
    $utilFichier->supprimerFichier($strNomImageThumb);

    parent::removeFile($field);
  }

}
