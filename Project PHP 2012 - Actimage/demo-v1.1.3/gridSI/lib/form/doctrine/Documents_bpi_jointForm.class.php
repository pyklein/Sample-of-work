<?php

/**
 * Formulaire pour l'ajout et la modification d'un document joint
 * @package    gridSI
 * @subpackage form
 * @author     Jihad Sahebdin
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Documents_bpi_jointForm extends BaseDocuments_bpiForm
{

  public function configure()
  {
    $this->useFields(array('fichier','titre', 'statut_dossier_bpi_id', 'est_invisible'));

    $this->configurerValidateurs();
    $this->configurerLabels();

    if (!$this->getObject()->isNew()){
      //On empèche la modification du fichier en edition
      unset($this['fichier']);
    }

    parent::configure();
  }

  private function configurerLabels()
  {
    $this->widgetSchema['titre'] = new sfWidgetFormInput(array(),array('size' => '33',));

    $this->widgetSchema['statut_dossier_bpi_id'] = new sfWidgetFormDoctrineChoice(array(
        'model'=>$this->getRelatedModelName('Statut_dossier_bpi'),
        'add_empty' => false
    ));

    $this->widgetSchema['fichier'] = new sfWidgetFormInputFileEditableJQuery(array(
                'with_delete' => false,
                'label' => libelle("msg_libelle_fichier"),
                'file_src' => "",
                'is_image' => false,
                'extensions' => sfConfig::get("app_extensions_bureau").", ".sfConfig::get("app_extensions_autres"),
                'template' => "%input% <br>"
            ));


    $this->widgetSchema['statut_dossier_bpi_id'] -> setLabel(libelle("msg_libelle_statut_associe"));
    $this->widgetSchema['est_invisible'] -> setLabel(libelle("msg_libelle_invisible"));

  }

  private function configurerValidateurs()
  {
    $utilPhp = new ServiceFichier();
    $utilArbo = new ServiceArborescence();

    $this->validatorSchema['fichier'] = new gridValidatorFile(
            array('required' => true,
                'path' => $utilArbo->getRepertoireDocumentsDossierBPI($this->getObject()->getDossier_bpi()->getNumero()),
                'max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                'fichier_tous' => true
                ),
            array('required'=> libelle("msg_libelle_fichier_requis"),
                  'max_size'=> libelle("msg_libelle_taille_max_fichier",array($utilPhp->getMaxUploadSizeEnBytes()/(1024*1024)))
                    ));
  }


  public function  save($con = null)
  {
    //on enregistre le nom original du fichier
    if ($this->getObject()->isNew())
    {
      $this->getObject()->setFichierOrig($this->taintedFiles['fichier']['name']);
    }

    return parent::save($con);
  }
}
