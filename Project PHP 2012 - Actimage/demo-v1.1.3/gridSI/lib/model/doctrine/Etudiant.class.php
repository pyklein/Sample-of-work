<?php

/**
 * Etudiant
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Etudiant extends BaseEtudiant
{

  public function  __toString()
  {
    return $this->getPrenom()." ".$this->getNom();
  }

  public function save(Doctrine_Connection $conn = null){
      if (array_key_exists('photographie', $this->getModified())) {
      $this->genererThumbnail();
    }
    parent::save($conn);
  }

   public function genererThumbnail() {
    $this->logDebug('genererThumbnail début');
    if ($this->getPhotographie() != null
            && strlen($this->getPhotographie()) > 0) {
      $arrThumbs = sfConfig::get("app_photos_thumbnails");

      $this->logDebug('genererThumbnail génération thumbnail');

      $utilPhoto = new UtilPhoto();
      $utilArbo = new ServiceArborescence();
      $utilPhoto->creerThumbnail($utilArbo->getRepertoirePhotosEtudiants() . $this->getPhotographie(),
              $arrThumbs["largeur"],
              $arrThumbs["hauteur"],
              $arrThumbs["postfix"]);
    }
    $this->logDebug('genererThumbnail fin');
  }

}