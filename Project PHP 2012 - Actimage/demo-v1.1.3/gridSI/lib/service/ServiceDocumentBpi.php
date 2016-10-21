<?php

/**
 * Description of ServiceDocumentBpi
 *
 * @author Simeon Petev
 */
class ServiceDocumentBpi extends ServiceDocument
{
  /**
   * Generation des lettres d'accompagnement de licence
   *
   * @param integer $intContratId Id du contrat
   * @param integer $intOrganismeId Id de l'organisme
   * @return string
   *
   * @author Simeon PETEV
   */
  public function creerDocumentLettreAccompagnementLicence($intContratId, $intOrganismeId) {

    $objUtilArbo = new ServiceArborescence();

    $arrVariables = array();


    //recherche de l'organisme
    $objOrganisme = OrganismeTable::getInstance()->findOneById($intOrganismeId);
    if (!$objOrganisme) {
      throw new Exception("L'organisme n'existe pas.");
    }

    //Recheche du contrat
    $objContrat = ContratTable::getInstance()->findOneById($intContratId);
    if (!$objContrat) {
      throw new Exception("Le contrat n'existe pas.");
    }

    $arrVariables["DATE_EN_COURS"]  = date('d/m/Y');
    $arrVariables["NUM_DOSSIER"]    = $objContrat->getDossier_bpi()->getNumero();
    $arrVariables["NOM_INVENTION"]  = $objContrat->getDossier_bpi()->getTitre();
    $arrVariables["NOM_ORGANISME"]  = $objOrganisme->getIntitule();
    $arrVariables["DATE_INVENTION"] = $objContrat->getDossier_bpi()->getDateTimeObject('date_predeclaration')->format('d/m/Y');


    // prefixe de fichier généré
    $strFichierPrefixe = "lettre_accompagnement_licence";

    // modèle utilisé
    $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreAccompagnementLicence();

    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }

  /**
   * Generation des lettres d'accompagnement de copropriété
   *
   * @param integer $intContratId Id du contrat
   * @param integer $intOrganismeId Id de l'organisme
   * @return string
   *
   * @author Simeon PETEV
   */
  public function creerDocumentLettreAccompagnementCopropriete($intContratId, $intOrganismeId) {

    $objUtilArbo = new ServiceArborescence();

    $arrVariables = array();


    //recherche de l'organisme
    $objOrganisme = OrganismeTable::getInstance()->findOneById($intOrganismeId);
    if (!$objOrganisme) {
      throw new Exception("L'organisme n'existe pas.");
    }

    //Recheche du contrat
    $objContrat = ContratTable::getInstance()->findOneById($intContratId);
    if (!$objContrat) {
      throw new Exception("Le contrat n'existe pas.");
    }

    $arrVariables["DATE_EN_COURS"]      = date('d/m/Y');
    $arrVariables["NUM_DOSSIER"]        = $objContrat->getDossier_bpi()->getNumero();
    $arrVariables["NOM_INVENTION"]      = $objContrat->getDossier_bpi()->getTitre();
    $arrVariables["NOM_ORGANISME"]      = $objOrganisme->getIntitule();
    $arrBrevets = $objContrat->getBrevet();
    $arrVariables["NUM_BREVET"]         = $arrBrevets[0]->getNumeroPublication();
    $arrVariables["DATE_DEPOT_BREVET"]  = $arrBrevets[0]->getDateTimeObject('date_depot')->format('d/m/Y');



    // prefixe de fichier généré
    $strFichierPrefixe = "lettre_accompagnement_copropriete";

    // modèle utilisé
    $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreAccompagnementCopropriete();

    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }

  /**
   * Génere la lettre de dépot de brevet Hors DGA
   * @param string $inventeurId   ID de l'inventeur
   * @param string $brevetId      ID du brevet
   * @param string $dossierId     ID du dossier
   * @return string
   * @author Alexandre WETTA
   */
  public function creerLettreDepotBrevetHorsDga($inventeurId, $brevetId, $dossierId){
    
    //initialisation de variables
    $objUtilArbo = new ServiceArborescence();
    $arrVariables = array();

    //date du jour
    $arrVariables['DATE'] = date('d/m/Y');


    //brevet
    $objBrevet = BrevetTable::getInstance()->findOneById($brevetId);
    if (!$objBrevet) {
      throw new Exception("Le brevet n'existe pas.");
    }
    $arrVariables['TITRE_BREVET'] = $objBrevet->getTitre();

    //dossier
    $objDossier = Dossier_bpiTable::getInstance()->findOneById($dossierId);
    if(!$objDossier){
      throw new Exception("Le dossier n'existe pas.");
    }
    $arrVariables['NUMERO_DOSSIER'] = $objDossier->getNumero();

    //inventeurs
    $strInventeur = "" ;
    $arrPartInventive = Part_inventiveTable::getInstance()->findByDossierBpiId($dossierId);
    $arrInventeursId = array() ;
    foreach($arrPartInventive as $objPartInventive){
      $arrInventeursId[] = $objPartInventive->getInventeurId();
    }

    //on compte le nombre d'inventeur
    $nbrInv = 0 ;
    $nbrInv = count($arrInventeursId);
    if($nbrInv == 0){
      throw new Exception("Il n'y a pas d'inventeur.");
    }

    //s'il y a un seul inventeur, sinon on fait une liste des inventeurs
    if($nbrInv == 1){
      $objInventeur = InventeurTable::getInstance()->findOneById($arrInventeursId[0]);
      $strInventeur .= $objInventeur->getCivilite()->getAbreviation() . " " . $objInventeur->getPrenom(). " " . $objInventeur->getNom() ;
    }else{

      for ($i = 0; $i < $nbrInv; $i++) {
        $objInventeur = InventeurTable::getInstance()->findOneById($arrInventeursId[$i]);
        if($i == $nbrInv-1){
          $strInventeur .= " et ".$objInventeur->getCivilite()->getAbreviation() . " " . $objInventeur->getPrenom(). " " . $objInventeur->getNom() ;
        }else if($i == 0){
          $strInventeur .= $objInventeur->getCivilite()->getAbreviation() . " " . $objInventeur->getPrenom(). " " . $objInventeur->getNom() ;
        }else{
          $strInventeur .= ", ".$objInventeur->getCivilite()->getAbreviation() . " " . $objInventeur->getPrenom(). " " . $objInventeur->getNom() ;
        }
      }
      
    }

    $arrVariables['INVENTEURS'] = $strInventeur ;

    //adresse de l'inventeur ciblé
    $strAdresseInventeurCible= "";
    $objInventeurCible = InventeurTable::getInstance()->findOneById($inventeurId);
    
    $strCivPrenomNomInvCible = $objInventeurCible->getCivilite()->getIntitule() . " " . $objInventeurCible->getPrenom() ." ". $objInventeurCible->getNom();

    $strAdresseInventeurCible = libelle_rtf('msg_rtf_adresse_inventeur',
            array($strCivPrenomNomInvCible,$objInventeurCible->getAdressePerso(), $objInventeurCible->getCodePostalPerso(), $objInventeurCible->getVille()->getNom())
            );

    $arrVariables['INVENTEUR_CIBLE'] = $strAdresseInventeurCible;

    // prefixe de fichier généré
    $strFichierPrefixe = "lettre_Depot_HorsDGA";
    
    // modèle utilisé
    $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreDepotBrevetHorsDga();

    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }


  /**
   * Génere la lettre de dépot de brevet DGA
   * @param string $brevetId  ID du brevet
   * @param string $dossierId ID du dossier
   * @return string
   * @author Alexandre WETTA
   */
  public function creerLettreDepotBrevetDga($brevetId, $dossierId) {

    //initialisation de variables
    $objUtilArbo = new ServiceArborescence();
    $utilDate = new UtilDate();
    $arrVariables = array();

    //date du jour
    $arrVariables['DATE'] = date('d/m/Y');

    //dossier
    $objDossier = Dossier_bpiTable::getInstance()->findOneById($dossierId);

    $arrVariables['NUMERO_DOSSIER'] = $objDossier->getNumero();

    //brevets
    $objBrevet = BrevetTable::getInstance()->findOneById($brevetId);

    $arrVariables['TITRE_BREVET'] = $objBrevet->getTitre();
    if ($objBrevet->getDateDepot() != null) {
      $arrVariables['DATE_DEPOT_BREVET'] = $utilDate->afficheDateFrComplete($objBrevet->getDateTimeObject('date_depot')->format('d/m/Y')) ;
    } else {
      $arrVariables['DATE_DEPOT_BREVET'] = 'JJ/MM/AAAA';
    }
    $arrVariables['NUMERO_DEPOT_BREVET'] = $objBrevet->getNumeroPublication();


     //inventeurs
    $strInventeur = "" ;
    $arrPartInventive = Part_inventiveTable::getInstance()->findByDossierBpiId($dossierId);
    $arrInventeursId = array() ;
    foreach($arrPartInventive as $objPartInventive){
      $arrInventeursId[] = $objPartInventive->getInventeurId();
    }

    //on compte le nombre d'inventeur
    $nbrInv = 0 ;
    $nbrInv = count($arrInventeursId);
    if($nbrInv == 0){
      throw new Exception("Il n'y a pas d'inventeur.");
    }

    //s'il y a un seul inventeur, sinon on fait une liste des inventeurs
    if($nbrInv == 1){
      $objInventeur = InventeurTable::getInstance()->findOneById($arrInventeursId[0]);
      $strInventeur .= $objInventeur->getCivilite()->getAbreviation() . " " . $objInventeur->getPrenom(). " " . $objInventeur->getNom() ;
    }else{

      for ($i = 0; $i < $nbrInv; $i++) {
        $objInventeur = InventeurTable::getInstance()->findOneById($arrInventeursId[$i]);
        if($i == $nbrInv-1){
          $strInventeur .= " et ".$objInventeur->getCivilite()->getAbreviation() . " " . $objInventeur->getPrenom(). " " . $objInventeur->getNom() ;
        }else if($i == 0){
          $strInventeur .= $objInventeur->getCivilite()->getAbreviation() . " " . $objInventeur->getPrenom(). " " . $objInventeur->getNom() ;
        }else{
          $strInventeur .= ", ".$objInventeur->getCivilite()->getAbreviation() . " " . $objInventeur->getPrenom(). " " . $objInventeur->getNom() ;
        }
      }

    }

    $arrVariables['INVENTEURS'] = $strInventeur ;


    // prefixe de fichier généré
    $strFichierPrefixe = "lettre_Depot_DGA";

    // modèle utilisé
    $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreDepotBrevetDga();

    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }
}
?>
