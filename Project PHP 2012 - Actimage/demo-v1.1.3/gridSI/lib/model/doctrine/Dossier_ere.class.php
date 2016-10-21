<?php

/**
 * Dossier_ere
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     William RICHARDS
 */
class Dossier_ere extends BaseDossier_ere {

  public function __toString() {
    return $this->getTitre();
  }

  public function getTypeDossier() {
    return Dossier_ereTable::getInstance()->getTypeDossier();
  }

  /**
   *
   * @return Année de création sous forme de string
   */
  public function getAnnee() {
    return $this->getDateTimeObject('created_at')->format('Y');
  }

  /**
   * Surcharge de save() => création du répertoire partagé pour les fichiers référencés
   */
  public function save(Doctrine_Connection $conn = null) {

    if ($this->isNew()) {
      $utilFichier = new UtilFichier();
      $utilArbo = new ServiceArborescence();

      $strRepertoire = $utilArbo->getRepertoirePartageDocumentsEre($this->getNumeroDefinitif());

      try {
        // on vérifie si le repertoire existe déja
        $utilFichier->isExiste($strRepertoire);
      } catch (Exception $e) {}
      try {
       $utilFichier->creerRepertoire($strRepertoire);
      } catch (Exception $e){}
      

      $strRepertoire = $utilArbo->getRepertoireDocumentsDossierEre($this->getNumeroAAfficher());
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
  public function getNumeroAAfficher() {
    if ($this->getNumeroDefinitif() != NULL) {
      return $this->getNumeroDefinitif();
    } else {
      return $this->getNumeroProvisoire();
    }
  }

  /**
   * Détermine si le dossier est une proposition ou non
   *
   * @return bool
   * @author Julien GAUTIER
   */
  public function isProposition() {
    return ($this->getStatutDossierEreId() == 1);
  }

}