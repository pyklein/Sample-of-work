<?php

/**
 * Dossier_postdoc form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Dossier_postdocForm extends BaseDossier_postdocForm
{
  protected $utilArbo;

  public function  __construct($object = null, $options = array(), $CSRFSecret = null) {
    $this->utilArbo = new ServiceArborescence();
    parent::__construct($object, $options, $CSRFSecret);
  }
  
  public function configure()
  {
    $this->useFields(array(
        'numero_provisoire',
        'numero_definitif',
        'titre',
        'objet',
        'domaine_scientifique_id',
        'organisme_mindef_id',
        'organisme_id',
        'fichier_pdf',
        'fichier_editable',
        'etat_partage_id',
        'cotutelle',
        'cooperation',));

    $this->configurerValidateurs();
    $this->configurerLabels();
    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  private function configurerLabels()
  {
    $this->widgetSchema['objet'] = new sfWidgetFormTextareaCKEditor();
    $this->widgetSchema['etat_partage_id']->setOption('add_empty', false);

    $this->setWidget('domaine_scientifique_id', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Domaine_scientifique',
                        'method' => 'getIntitule',
                        'order_by' => array('intitule', 'ASC'),
                        'add_empty' => libelle('msg_libelle_aucun'))));

    $this->setWidget('organisme_mindef_id', new gridWidgetFormOrganismeMindef());

    $this->setWidget('organisme_id', new gridWidgetFormOrganisme());
    $this->setWidget('cotutelle', new sfWidgetFormInputCheckboxUnchecked());
    $this->setWidget('cooperation', new sfWidgetFormInputCheckboxUnchecked());

    //lien de téléchargement
    if(strlen($this->getObject()->getFichierPdf()) > 0){
      $strfichierPdfLien =  url_for('referentiel_mris/telechargerFichierDossierMris?id='.$this->getObject()->getId().
              "&type_dossier=".$this->getObject()->getTypeDossier()."&type_fichier=pdf", true);
    }else{
      $strfichierPdfLien = "";
    }

    $this->widgetSchema['fichier_pdf'] = new sfWidgetFormInputFileEditableJQuery(
            array('file_src'=>'',
                  'label'       => libelle("msg_libelle_fichier_pdf"),
                  'with_delete' => true,
                  'delete_label' => libelle('msg_utilisateur_libelle_supp_fichier'),
                  'is_image' => false,
                  'extensions' => sfConfig::get("app_extensions_pdf"),
                  'edit_mode' => !$this->isNew() && (strlen($this->getObject()->getFichierPdf())>0),
                  'template'  => '%input% <br>
                      %delete_label% : <a href="'. $strfichierPdfLien .'">' . $this->getObject()->getFichierPdfOrig() . '</a> %delete% <br>
                      <label></label>'
                    ));

    //lien de téléchargement
    if(strlen($this->getObject()->getFichierEditable()) > 0){
      $strfichierEditableLien =  url_for('referentiel_mris/telechargerFichierDossierMris?id='.$this->getObject()->getId().
              "&type_dossier=".$this->getObject()->getTypeDossier()."&type_fichier=editable", true);
    }else{
      $strfichierEditableLien = "";
    }


    $this->widgetSchema['fichier_editable'] = new sfWidgetFormInputFileEditableJQuery(
            array('file_src'=>'',
                  'label'       => libelle("msg_libelle_fichier_editable"),
                  'with_delete' => true,
                  'delete_label' => libelle('msg_utilisateur_libelle_supp_fichier'),
                  'is_image' => false,
                  'extensions' => sfConfig::get("app_extensions_editables"),
                  'edit_mode' => !$this->isNew() && (strlen($this->getObject()->getFichierEditable())>0),
                  'template'  => '%input% <br>
                      %delete_label% : <a href="'. $strfichierEditableLien .'">' . $this->getObject()->getFichierEditableOrig() . '</a> %delete% <br>
                      <label></label>'
                    ));

    


    $this->widgetSchema['numero_provisoire']->setLabel(libelle("msg_libelle_numero_provisoire"));
    $this->widgetSchema['numero_definitif']->setLabel(libelle("msg_libelle_numero_definitif"));
    $this->widgetSchema['titre']->setLabel(libelle("msg_libelle_titre"));
    $this->widgetSchema['objet']->setLabel(libelle("msg_libelle_objet"));
    $this->widgetSchema['domaine_scientifique_id']->setLabel(libelle("msg_libelle_domaine_scientifique"));
    $this->widgetSchema['organisme_mindef_id']->setLabel(libelle("msg_libelle_org_mindef"));
    $this->widgetSchema['organisme_id']->setLabel(libelle("msg_libelle_organisme"));
    $this->widgetSchema['etat_partage_id']->setLabel(libelle("msg_libelle_etat_partage"));
    $this->widgetSchema['cotutelle']->setLabel(libelle("msg_libelle_cotutelle"));
    $this->widgetSchema['cooperation']->setLabel(libelle("msg_libelle_cooperation"));

  }

  private function configurerValidateurs()
  {
    $utilPhp = new ServiceFichier();

    $this->validatorSchema['titre'] = new sfValidatorString(
            array('max_length' => 255,
                  'required' => true),
            array('required' => libelle("msg_dossier_postdoc_champ_requis",array(libelle("msg_libelle_titre")))));
    
    $this->validatorSchema['fichier_pdf_delete'] = new sfValidatorBoolean();
    $this->validatorSchema['fichier_pdf'] = new gridValidatorFile(
            array('max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                  'fichier_pdf' => true,
                  'path' => $this->utilArbo->getRepertoireDossiersPostdoc(),
                  'required' => false
                  ),
            array('max_size' => libelle("msg_libelle_taille_max_fichier", array($utilPhp->getMaxUploadSizeEnFormatHumain())))
    );

    $this->validatorSchema['fichier_editable_delete'] = new sfValidatorBoolean();
    $this->validatorSchema['fichier_editable'] = new gridValidatorFile(
            array('max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                  'fichier_editable' => true,
                  'path' => $this->utilArbo->getRepertoireDossiersPostdoc(),
                  'required' => false
                  ),
            array('max_size' => libelle("msg_libelle_taille_max_fichier", array($utilPhp->getMaxUploadSizeEnFormatHumain())))
    );
    
    $this->validatorSchema['objet'] = new gridValidatorTextarea(array('required'=>false));

    
  }

  public function  save($con = null) {

    // s'il y a un changement de numéro, on copie le dossier de la convention s'il existe
    if($this->getObject()->getNumeroAAfficher() != $this->values['numero_provisoire'] &&
            $this->getObject()->getNumeroAAfficher() != $this->values['numero_definitif']){

      $utilArbo = new ServiceArborescence();
      
      if($this->values['numero_definitif'] != null){
        $strDestination = $utilArbo->getRepertoireConventionDossierPostdoc($this->values['numero_definitif']) ;
      }else if($this->values['numero_provisoire']!= null){
        $strDestination = $utilArbo->getRepertoireConventionDossierPostdoc($this->values['numero_provisoire']) ;
      }

      //on crée le nouveau répertoire
      $utilFichier = new UtilFichier();
      $utilFichier->moveRepertoire($utilArbo->getRepertoireConventionDossierPostdoc($this->getObject()->getNumeroAAfficher()), $strDestination) ;

    }

    parent::save($con);
  }
}
