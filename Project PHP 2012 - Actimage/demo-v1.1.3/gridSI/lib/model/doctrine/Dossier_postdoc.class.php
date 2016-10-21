<?php

/**
 * Dossier_postdoc
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Dossier_postdoc extends BaseDossier_postdoc {

  public function __toString() {
    return $this->getTitre();
  }

  public function getTypeDossier() {
    return Dossier_postdocTable::getInstance()->getTypeDossier();
  }

  /**
   *
   * @return Année de création sous forme de string
   */
  public function getAnnee()
  {
    return $this->getDateTimeObject('created_at')->format('Y');
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

      $strRepertoire = $utilArbo->getRepertoirePartageDocumentsPostdoc($this->getRepertoirePartage());
      try {
        // on vérifie si le repertoire existe déja
        $utilFichier->isExiste($strRepertoire);

      } catch (Exception $e) {}
      try {
       $utilFichier->creerRepertoire($strRepertoire);

      } catch (Exception $e){}

      $strRepertoire = $utilArbo->getRepertoireDocumentsDossierPostdoc($this->getRepertoirePartage());
      // il faut créer le repertoire
      try {
        // on vérifie si le repertoire existe déja
        $utilFichier->isExiste($strRepertoire);
      } catch (Exception $e) {
        $utilFichier->creerRepertoire($strRepertoire);
      }
    }

    //Mise à jour du champ repertoire_partagé
    $this->setRepertoirePartage($this->getNumeroAAfficher());

    parent::save($conn);

  }

  /**
   * Récupère le numero à afficher
   */
  public function getNumeroAAfficher()
  {
    if($this->getNumeroDefinitif()!= NULL)
    {
      return $this->getNumeroDefinitif();
    }
    else
    {
      return $this->getNumeroProvisoire();
    }
  }

    /**
   * Détermine si le dossier est une proposition ou non
   *
   * @return bool
   * @author Julien GAUTIER
   */
  public function isProposition()
  {
    return ($this->getStatutDossierPostdocId() == 1);
  }

}