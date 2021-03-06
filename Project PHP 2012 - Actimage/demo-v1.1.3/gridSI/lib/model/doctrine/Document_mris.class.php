<?php

/**
 * Document_mris
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     William Richards
 */
class Document_mris extends BaseDocument_mris {

  public function  __toString() {
    return $this->getTitre();
  }
  /**
   *  Renvoie l'objet type de document du document.
   * @return type de document (these/ere/postdoc)
   */
  public function getDocument_type() {
    return $this['Type_document_'.$this->getTypeDossier()];
  }

  public function getDocument_type_id() {
    return $this->getDocument_type()->getId();
  }

  public function getTypeDossier(){
    if ($this->getDossierTheseId() != null) {
      return 'these';
    } elseif ($this->getDossierEreId() != null) {
      return 'ere';
    } elseif ($this->getDossierPostdocId() != null) {
      return 'postdoc';
    }
  }

  public function getDossier(){
    $get = "getDossier_".$this->getTypeDossier();
    return $this->$get();
  }

  public function  delete(Doctrine_Connection $conn = null) {
    if ($this->getEstJoint()){
      $utilFichier = new UtilFichier();
      $utilArbo = new ServiceArborescence();
      $strMethodeArbo = 'getRepertoireDocumentsDossier'.ucfirst($this->getTypeDossier());
      $utilFichier->supprimerFichier($utilArbo->$strMethodeArbo($this->getDossier()->getNumeroAAfficher()).$this->getFichier(),false);
    }
    parent::delete($conn);
  }
}