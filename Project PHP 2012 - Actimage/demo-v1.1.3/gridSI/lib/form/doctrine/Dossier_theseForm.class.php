<?php

/**
 * Dossier_these form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Dossier_theseForm extends BaseDossier_theseForm {

  protected $utilArbo;

  public function  __construct($object = null, $options = array(), $CSRFSecret = null) {
    $this->utilArbo = new ServiceArborescence();
    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {
    $this->useFields(array('numero', 'titre', 'objet', 'domaine_scientifique_id', 'etat_partage_id',
        'organisme_mindef_id', 'organisme_id', 'fichier_pdf', 'fichier_editable', 'classement', 'type_convention_organisme_id',
        'cotutelle', 'cooperation'));

    $this->setWidget('domaine_scientifique_id', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Domaine_scientifique',
                        'method' => 'getIntitule',
                        'order_by' => array('intitule', 'ASC'),
                        'add_empty' => libelle('msg_libelle_aucun'))));


    $this->setWidget('organisme_mindef_id', new gridWidgetFormOrganismeMindef());
    $this->setWidget('organisme_id', new gridWidgetFormOrganisme());
    $this->setWidget('cotutelle', new sfWidgetFormInputCheckboxUnchecked());
    $this->setWidget('cooperation', new sfWidgetFormInputCheckboxUnchecked());

    $type_dossier = 'Dossier_these';
    $this->widgetSchema['type_convention_organisme_id'] = new sfWidgetFormDoctrineChoiceParametered(array(
                'model' => $this->getRelatedModelName('Type_convention_organisme'),
                'add_empty' => false,
                'table_method' => array('method' => 'retrieveTypeConventionByTypeDossier', 'parameters' => array($type_dossier)),
                'method' => 'afficheConventionPourThese'
            ));


    $this->widgetSchema['etat_partage_id']->setOption('add_empty', false);

    $this->widgetSchema['numero'] = new sfWidgetFormInputText();

    $this->widgetSchema['objet'] = new sfWidgetFormTextareaCKEditor();

     //lien de téléchargement
    if(strlen($this->getObject()->getFichierPdf()) > 0){
      $strfichierPdfLien =  url_for('referentiel_mris/telechargerFichierDossierMris?id='.$this->getObject()->getId().
              "&type_dossier=".$this->getObject()->getTypeDossier()."&type_fichier=pdf", true);
    }else{
      $strfichierPdfLien = "";
    }
    

    $this->widgetSchema['fichier_pdf'] = new sfWidgetFormInputFileEditableJQuery(array(
                'with_delete' => true,
                'label' => libelle("msg_libelle_fichier_pdf"),
                'delete_label' => libelle('msg_utilisateur_libelle_supp_fichier'),
                'file_src' => '',
                'is_image' => false,
                'extensions' => sfConfig::get("app_extensions_pdf"),
                'edit_mode' => !$this->isNew() && strlen($this->getObject()->getFichierPdf()) > 0,
                'template' => '%input% <br>
                      %delete_label% : <a href="'. $strfichierPdfLien .'">' . $this->getObject()->getFichierPdfOrig() . '</a> %delete% <br>
                      '
            ));

    //lien de téléchargement
    if(strlen($this->getObject()->getFichierEditable()) > 0){
      $strfichierEditableLien =  url_for('referentiel_mris/telechargerFichierDossierMris?id='.$this->getObject()->getId().
              "&type_dossier=".$this->getObject()->getTypeDossier()."&type_fichier=editable", true);
    }else{
      $strfichierEditableLien = "";
    }


    $this->widgetSchema['fichier_editable'] = new sfWidgetFormInputFileEditableJQuery(array(
                'with_delete' => true,
                'label' => libelle("msg_libelle_fichier_editable"),
                'delete_label' => libelle('msg_utilisateur_libelle_supp_fichier'),
                'file_src' => '',
                'is_image' => false,
                'extensions' => sfConfig::get("app_extensions_editables"),
                'edit_mode' => !$this->isNew() && strlen($this->getObject()->getFichierEditable()) > 0,
                'template' => '%input% <br>
                      %delete_label% : <a href="'. $strfichierEditableLien .'">' . $this->getObject()->getFichierEditableOrig() . '</a> %delete% <br>
                      '
            ));

    $this->setLibelles();

    $this->configurerValidateurs();


    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  /**
   * set les différents libellés des champs
   *
   * @author     Actimage
   */
  protected function setLibelles() {

    $this->widgetSchema->setLabels(array(
        'numero' => libelle("msg_libelle_numero"),
        'titre' => libelle("msg_libelle_titre"),
        'objet' => libelle("msg_libelle_objet"),
        'domaine_scientifique_id' => libelle("msg_libelle_domaine_scientifique"),
        'statut_dossier_these_id' => libelle("msg_libelle_statut"),
        'realise_par' => libelle("msg_libelle_realise_par"),
        'pilote_par' => libelle("msg_libelle_pilote"),
        'type_convention_organisme_id' => libelle("msg_convention_libelle_type"),
        'cotutelle' => libelle("msg_libelle_cotutelle"),
        'cooperation' => libelle("msg_libelle_cooperation"),
    ));
  }

  /**
   * set les différents validateurs des champs
   *
   * @author     Actimage
   */
  private function configurerValidateurs() {

    $utilPhp = new ServiceFichier();

    $this->validatorSchema['fichier_pdf_delete'] = new sfValidatorBoolean();
    $this->validatorSchema['fichier_editable_delete'] = new sfValidatorBoolean();

    $this->validatorSchema['fichier_pdf'] = new gridValidatorFile(
            array('max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                  'fichier_pdf' => true,
                  'path' => $this->utilArbo->getRepertoireDossiersThese(),
                  'required' => false
                  ),
            array('max_size' => libelle("msg_libelle_taille_max_fichier", array($utilPhp->getMaxUploadSizeEnFormatHumain())))
    );
    
    $this->validatorSchema['fichier_editable'] = new gridValidatorFile(
                    array('required' => false,
                        'path' => $this->utilArbo->getRepertoireDossiersThese(),
                        'max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                        'fichier_editable' => true,
                    ),
                    array('max_size' => libelle("msg_libelle_taille_max_fichier", array($utilPhp->getMaxUploadSizeEnFormatHumain())))
    );

    $this->validatorSchema['titre'] = new sfValidatorString(array('required' => true),
                    array('required' => libelle("msg_dossier_these_titre_requis")));

    $this->validatorSchema['objet'] = new gridValidatorTextarea(array('required'=>false));
    
  }

}
