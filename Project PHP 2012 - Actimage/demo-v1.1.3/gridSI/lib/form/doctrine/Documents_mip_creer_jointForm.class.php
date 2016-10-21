<?php

/**
 * Formulaire pour la création de document joint
 *
 * @package    gridSI
 * @subpackage form
 * @author     Jihad Sahebdin
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Documents_mip_creer_jointForm extends BaseDocuments_mipForm
{

  public function configure()
  {
    $this->useFields(array('fichier','titre', 'documents_mip_type_id', 'autre_type'));

    $this->configurerValidateurs();
    $this->configurerLabels();

    $this->disableCSRFProtection();
    
    parent::configure();
  }
  
  private function configurerLabels()
  {
    $this->widgetSchema['titre'] = new sfWidgetFormInput(array(),array('size' => '33',));
    
    $this->widgetSchema['documents_mip_type_id'] = new sfWidgetFormDoctrineChoice(array(
        'model'=>$this->getRelatedModelName('Documents_mip_type'),
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
  
    $this->widgetSchema['documents_mip_type_id'] -> setLabel(libelle("msg_libelle_type_document"));
    $this->widgetSchema['autre_type'] -> setLabel(libelle("msg_libelle_autre_type"));
    
  }

  private function configurerValidateurs()
  {
    $utilPhp = new ServiceFichier();
    $utilArbo = new ServiceArborescence();

    $this->validatorSchema['fichier'] = new gridValidatorFile(
            array('required' => true,
                'path' => $utilArbo->getRepertoireDocumentsDossierMIP($this->getObject()->getDossier_mip()->getNumero()),
                'max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                'fichier_tous' => true
                ),
            array('required'=> libelle("msg_libelle_fichier_requis"),
                  'max_size'=> libelle("msg_libelle_taille_max_fichier",array($utilPhp->getMaxUploadSizeEnBytes()/(1024*1024)))
                    ));

    $this->validatorSchema->setPostValidator(
              new sfValidatorCallback(array('callback' => array($this, 'validationType')))
           );
  }

 //Vérifier que le champ autre ne soit pas vide quand l'utilisateur choisit "Autre" comme type de document
  public function validationType($validator, $values)
  {
    if ($values['documents_mip_type_id'] == "" && $values['autre_type'] == false)
    {
       $error = new sfValidatorError($validator, libelle('msg_documents_mip_erreur_type'));
       throw new sfValidatorErrorSchema($validator, array('autre_type' => $error));
    }
    return $values;
  }

  public function  save($con = null)
  {
    //on enregistre le nom original du fichier
    if ($this->getObject()->isNew())
    {
      $this->getObject()->setFichierOrig($this->taintedFiles['fichier']['name']);
    }
    
    //Si le type de document a été precisé dans la liste déroulante, on efface ce qu'il y a dans le champ Autre
    if ($this->values['documents_mip_type_id'])
    {
      $this->values['autre_type'] = "";
    }
    return parent::save($con);
  }
}
