<?php

/**
 * Dossier_bpi
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Actimage
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Dossier_bpi extends BaseDossier_bpi {

  public function __toString() {
    return $this->getTitre();
  }


  /**
   * Surcharge de fonction "save"
   * Permet de créer le dossier automatiquement s'il faut
   * @param Doctrine_Connection $conn
   */
  public function save(Doctrine_Connection $conn = null)
  {

    if ($this->isNew())
    {
      $utilFichier = new UtilFichier();
      $utilArbo = new ServiceArborescence();
      
      $strRepertoire = $utilArbo->getRepertoirePartageDocumentsBpi($this->getNumero());
      
      try {
        // on vérifie si le repertoire existe déja
        $utilFichier->isExiste($strRepertoire);

      } catch (Exception $e) {}
      try {
       $utilFichier->creerRepertoire($strRepertoire);

      } catch (Exception $e){}
      
      $strRepertoire = $utilArbo->getRepertoireDocumentsDossierBpi($this->getNumero());
      // il faut créer le repertoire
      try {
        // on vérifie si le repertoire existe déja
        $utilFichier->isExiste($strRepertoire);
      } catch (Exception $e) {
        $utilFichier->creerRepertoire($strRepertoire);
      }
      
    }

    //Mise à jour du champ repertoire_partagé
    $this->setRepertoirePartage($this->getNumero());

    parent::save($conn);

  }

  /**
   *
   * @return Année de création sous forme de string
   */
  public function getAnnee() {
    return $this->getDateTimeObject('created_at')->format('Y');
  }

}