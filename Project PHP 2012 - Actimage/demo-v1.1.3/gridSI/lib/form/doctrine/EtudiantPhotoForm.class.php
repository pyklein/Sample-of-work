<?php

/**
 * EtudiantPhotoForm :onglet Photographie dans la modification d'un étudiant
 *
 * @package    gridSI
 * @subpackage form
 * @author     Jihad Sahebdin
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EtudiantPhotoForm extends BaseEtudiantForm
{
  public function configure()
  {
    $utilPhp = new ServiceFichier();
    $utilArbo = new ServiceArborescence();
    $strChemin =  $utilArbo->getRepertoirePhotosEtudiants();


    $this->useFields(array('photographie'));

    $this->widgetSchema->setNameFormat('etudiantPhoto_forms[%s]');

    $this->widgetSchema['photographie'] = new sfWidgetFormInputFileEditableJQuery(array(
      'label'     => libelle('msg_etudiant_libelle_fichier'),
      'with_delete' => true,
      'delete_label' => libelle('msg_etudiant_libelle_supp_fichier'),
      'file_src'  => url_for("referentiel_mris/chargerThumbnailEtudiant?fichier=".$this->getObject()->getPhotographie(). "&path=" . bin2hex($strChemin)),
      'is_image'  => true,
      'extensions' => sfConfig::get("app_extensions_images"),
      'edit_mode' => !$this->isNew() && (strlen($this->getObject()->getPhotographie())>0),
      'template'  => "%input% <br>
                      %delete_label% : %delete% <br>
                      <label></label>&nbsp;&nbsp;&nbsp;
                      <a id=\"img_photographie\" href=\"".url_for("interface/telechargerPhoto?fichier=".$this->getObject()->getPhotographie()."&path=" . bin2hex($strChemin))."\" target=\"_blank\">%file%</a>",
    ));
    
    $this->validatorSchema['photographie_delete'] = new sfValidatorBoolean();
    $this->setValidator('photographie', new gridValidatorFile(
            array('max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                  'fichier_images' => true,
                  'path' => $strChemin,
                  'required' => false
                  ),
            array('max_size' => libelle("msg_libelle_taille_max_fichier", array($utilPhp->getMaxUploadSizeEnFormatHumain()))))
    );
    
    $this->validatorSchema['photographie']->setMessage('max_size', libelle('msg_libelle_taille_max_fichier',array($utilPhp->getMaxUploadSizeEnBytes()/(1024*1024))));
    $this->validatorSchema['photographie']->setMessage('mime_types', libelle('msg_utilisateur_valid_file_type'));

    $this->disableCSRFProtection();
    parent::configure();

  }
  
  public function  save($con = null)
  {
    if ($this->values['photographie'])
    {
      $this->values['photographie_orig'] = $this->values['photographie']->getOriginalName();
    }
    return parent::save($con);
  }

  protected function removeFile($field)
  {
    // on supprime le thumbnail
    $utilFichier = new UtilFichier();
    $strNomImageThumb = nomImageThumbnail(sfConfig::get('app_photos_etudiant_repertoire').$this->getObject()->getPhotographie());
    $utilFichier->supprimerFichier($strNomImageThumb);

    parent::removeFile($field);
  }
}
