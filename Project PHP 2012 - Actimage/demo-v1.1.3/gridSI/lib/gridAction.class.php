<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
sfContext::getInstance()->getConfiguration()->loadHelpers("Url");

/**
 * Classe regroupant des methodes utilisées en plusieurs endroits
 * Projet: GRID
 * module: lib
 * @author William Richards
 */
abstract class gridAction extends sfAction {

  /**
   *  Methode regroupant la logique de validation et enregistrement des formulaires.
   * @param string $strAction      creer/modifier (permet d'acceder aux messages judicieux)
   * @param string $strRedirection String de redirection vers lequel revenir après traitement, si non spécifié et $boolRedirect = true, redirige vers [module]/lister[modèle]s
   * @param bool   $boolRedirect   Doit on rediriger après traitement? true par défaut
   * @param bool   $boolAvecMessage Avec ou sans message flash true par défaut
   * @param Form   $form            La form a process
   * @param array  $files           Les fichiers associés à la form
   * @return bool                  Succes ou non de l'enregistrement (utilisé pour les formulaires en popup)
   * Auteurs: William Richards
   */
  public function processForm($strAction, $strRedirection = '', $boolRedirect = true, $boolAvecMessage = true, $form = null, $files = null) {
    
    
    $objForm = $form == null ? $this->objForm : $form;
    $arrFiles = $files == null ? $this->arrFiles : $files;


    $logger = $this->getLogger();
    $request = $this->getRequest();
    $objForm->bind($request->getParameter($objForm->getName()), $arrFiles);
    $strNomModel = $objForm->getModelName();

    //Cas de redirection par défaut
    if ($strRedirection == '') {
      $strRedirection = 'lister' . $strNomModel . 's';
    }

    $logger->debug("{gridAction} processForm début, modèle : " . $strNomModel . " action : " . $strAction);

    if ($objForm->isValid()) {
      try {
        $objReferentiel = $objForm->save();
        //sauvegarde en session de l'Id du dernier objet enregistré.
        if (is_object($objReferentiel))
          $this->getUser()->setAttribute('IdDerniereSauvegarde', $objReferentiel->getId());
      } catch (Exception $ex) {

        if ($boolAvecMessage) {
          $this->getUser()->setFlash("erreur", libelle("msg_" . strtolower($strNomModel) . "_" . $strAction . "_erreur", array($ex->getMessage())));
        }
        $logger->err("{gridAction} Exception remontée par processForm (modèle : " . $strNomModel . " action : " . $strAction . ") " . $ex->getTraceAsString());
        if ($boolRedirect) {
          $this->redirect($this->getModuleName() . "/" . $strRedirection);
        }
        return false;
      }
      if ($boolAvecMessage) {
        $this->getUser()->setFlash("succes", libelle("msg_" . strtolower($strNomModel) . "_" . $strAction . "_succes", array($objReferentiel)), true);
      }
      $logger->debug("{gridAction} processForm réussi, modèle : " . $strNomModel . " action : " . $strAction);
      if ($boolRedirect) {
        $this->redirect($this->getModuleName() . "/" . $strRedirection);
      }
      return true;
    } else {
      //cas sans redirection
      $logger->debug("{gridAction} processForm invalide, modèle : " . $strNomModel . " action : " . $strAction);
      if ($boolAvecMessage) {
        $this->getUser()->setFlash("erreur", libelle("msg_" . strtolower($strNomModel) . "_" . $strAction . "_invalide"));
      }
      return false;
    }
  }

  /**
   *  Methode regroupant la logique d'activation/désactivation des éléments du référentiel.
   * @param string $id              Id de l'objet à activer/désactiver
   * @param string $strNomModel     Nom du modèle de l'objet à activer/désactiver
   * @param string $idModeleParent  Identifiant de l'objet contenant lorsqu'on active/désactive un objet rattaché à un autre
   * @param string $strModeleParent Nom du modèle parent
   * @param string $strRedirection  Action de redirection. /listerXXXXs si null
   * Auteurs: William Richards
   */
  public function changerActivation($id, $strNomModel, $idModeleParent = null, $strModeleParent = null, $strRedirection = null) {
    $logger = $this->getLogger();
    $logger->debug('{gridAction} changerActivation début, modèle : ' . $strNomModel);
    //Récupération de l'enregistrement
    $objReferentiel = Doctrine_Core::getTable($strNomModel)->findOneById($id);
    //Verification de l'existence de l'objet
    if (!$objReferentiel) {
      $this->redirect("@non_autorise");
    }

    //Détermination du statut actuel
    if ($objReferentiel->getEstActif()) {
      //cas Actif
      //est désactivable?
      if ($objReferentiel->estDesactivable()) {
        //cas Désactivable : désactivation et sauvegarde
        $objReferentiel->setEstActif(false);
        try {
          $objReferentiel->save();
          $this->getUser()->setFlash("succes", libelle("msg_" . strtolower($strNomModel) . "_desactiver_succes", array($objReferentiel)));
          $logger->debug('{gridAction} désactivation réussie, modèle : ' . $strNomModel);
        } catch (Exception $ex) {
          $this->getUser()->setFlash("erreur", libelle("msg_" . strtolower($strNomModel) . "_desactiver_erreur", array($id, $ex->getMessage())));
          $logger->debug('{gridAction} Exception remontée par changerActivation, (modèle : ' . $strNomModel . ") " . $ex->getTraceAsString());
        }
      } else {
        //cas non Désactivable : Informe l'utilisateur
        $this->getUser()->setFlash("erreur", libelle("msg_" . strtolower($strNomModel) . "_non_desactivable", array($objReferentiel)));
        $logger->debug('{gridAction} désactivation impossible, modèle : ' . $strNomModel);
      }
    } else {
      //cas Desactivé
      //est activable?
      if ($objReferentiel->estActivable()) {
        //cas Activable : activation et sauvegarde
        $objReferentiel->setEstActif(true);
        try {
          $objReferentiel->save();
          $this->getUser()->setFlash("succes", libelle("msg_" . strtolower($strNomModel) . "_activer_succes", array($objReferentiel)));
          $logger->debug('{gridAction} activation réussie, modèle : ' . $strNomModel);
        } catch (Exception $ex) {
          $this->getUser()->setFlash("erreur", libelle("msg_" . strtolower($strNomModel) . "_activer_erreur", array($id, $ex->getMessage())));
          $logger->debug('{gridAction} Exception remontée par changerActivation, (modèle : ' . $strNomModel . ") " . $ex->getTraceAsString());
        }
      } else {
        //cas non Activable : Informe l'utilisateur
        $this->getUser()->setFlash("erreur", libelle("msg_" . strtolower($strNomModel) . "_non_activable", array($objReferentiel)));
        $logger->debug('{gridAction} activation impossible, modèle : ' . $strNomModel);
      }
    }
    //retour à la liste
    if ($strRedirection != null){
      $this->redirect($this->getModuleName() . "/".$strRedirection);
    }

    if ($idModeleParent == null) {
      $this->redirect($this->getModuleName() . "/lister" . $strNomModel . "s");
    } else {
      if ($strModeleParent == null) {
        $this->redirect($this->getModuleName() . "/lister" . $strNomModel . "s?id=" . $idModeleParent);
      } else {
        $this->redirect($this->getModuleName() . "/lister" . $strNomModel . "s?" . $strModeleParent . "=" . $idModeleParent);
      }
    }
  }

  /**
   *  Methode permettant l'initialisation de paginateurs ainsi que de gérer les préférences de l'utilisateur
   * quand au nombre de resultats par page. La méthode initialise un paginateur par défaut (id = 0) et l'affecte dans l'action ($this->objPager)
   * Si une id != 0 est spécifiée, le pager sera retourné par la méthode.
   * @param DoctrineRequest $objRequeteDoctrine   requête Doctrine générée par l'action
   * @param string          $strNomModel          nom du modèle paginé
   * @param bool            $boolStrict           limite ou non le pager dans un objet contenant du modèle listé
   * @param Integer         $intIdPager           Identifiant du pager à initialiser
   * @param Integer         $intMaxParPage        Valeure par défaut de max par page (10 si null)
   * @return DoctrinePager  Un paginateur initialisé
   * Auteurs: William Richards
   */
  public function processPager($objRequeteDoctrine, $strNomModel, $boolStrict = true, $intIdPager = 0,$intMaxParPage = null) {
    $objRequeteWeb = $this->getRequest();
    $logger = $this->getLogger();
    $logger->debug('{gridAction} processPager début, modèle :' . $strNomModel);
    $arrParametres = $objRequeteWeb->getParameterHolder()->getAll();
    $intPage = null;
    $strFiltre = null;
    $strResultats= null;
    //création de l'url de base pour redirection ou pagination
    $strRedirection = "";
      $intCompte = 0;
      foreach ($arrParametres as $key => $value) {
        //determination de la page demandée
        if ($key == 'page'. '_' . $intIdPager) {
          $intPage = $value;
        }//extraction des parametres de requête utiles
        elseif ($key == 'module') {
          $strModule = $value;
        } elseif ($key == 'action') {
          $strAction = $value;
        } elseif ($key == 'resultats'.$intIdPager) {
          $strResultats = $value;
        } elseif ($key == strtolower($strNomModel) . '_filters') {
          $strFiltre = $value;
        } elseif ($boolStrict) {
          if ($intCompte != 0) {
            $strRedirection = $strRedirection . '&';
          }
          $strRedirection = $strRedirection . $key . '=' . $value;
          $intCompte++;
        }
      }
    

    $intPage = ($intPage != null) ? $intPage : $this->getUser()->getAttributeAction('page_' . strtolower($strNomModel) . '_' . $intIdPager, 1);


    //enregistrement des paramètres en cas de changement de la part de l'utilisateur.
    if (($objRequeteWeb->isMethod('post')) && ( $strFiltre != null || $strResultats != null)) {
      if ($strResultats != null) {
        $this->getUser()->setAttributeAction('pagination_' . strtolower($strNomModel) . '_' . $intIdPager, $strResultats);
      }
      $logger->debug('{gridAction} processPager redirection, modèle :' . $strNomModel);
      //redirection vers URL générale, les parametres filtres sont conservés, paginateur en page 1
      $this->getUser()->setAttributeAction('page_' . strtolower($strNomModel) . '_' . $intIdPager, 1);
      $this->strUrlRedirection = array($strModule . "/" . $strAction, $strRedirection);
      $this->redirect($this->strUrlRedirection[0].'?'.$this->strUrlRedirection[1]);
    }
    //population des valeures pour affichage
    $this->arrNombres = explode(',', sfConfig::get('app_choix_pagination'));
    if (!isset($this->intSelectionne)){
      $this->intSelectionne = array();
    }
    $this->intSelectionne[$intIdPager] = $this->getUser()->getAttributeAction('pagination_' . strtolower($strNomModel) . '_' . $intIdPager, ($intMaxParPage != null ? $intMaxParPage : 10));
    $this->strModule = $this->getModuleName();
    //fin de configuration du paginateur
    $objPager = new sfDoctrinePager($strNomModel, $this->intSelectionne[$intIdPager]);
    $objPager->setPage($intPage);
    $objPager->setQuery($objRequeteDoctrine);
    $objPager->init();
    //Gestion des cas ou la liste change pour eviter l'affichage de pages vides
    if ($objPager->count() % $objPager->getMaxPerPage() == 0
            && $intPage > $objPager->count() / $objPager->getMaxPerPage()) {
      $this->getUser()->setAttributeAction('page_' . strtolower($strNomModel) . '_' . $intIdPager, $intPage - 1);
      $this->strUrlRedirection = array($strModule . "/" . $strAction, $strRedirection);
      $this->redirect($this->strUrlRedirection[0].'?'.$this->strUrlRedirection[1]);
    }
    $this->getUser()->setAttributeAction('page_' . strtolower($strNomModel) . '_' . $intIdPager, $intPage);

    //génération des arguments link_to(), $strUrlRedirection à passer au partial _pagination
    $this->strUrlRedirection = array($strModule . "/" . $strAction, $strRedirection);

    //affectation du pager par défaut de l'action
    if ($intIdPager == 0)  {
     $this->objPager = $objPager;
     $this->intSelectionne = $this->getUser()->getAttributeAction('pagination_' . strtolower($strNomModel) . '_' . $intIdPager, ($intMaxParPage != null ? $intMaxParPage : 10));
    }

    $logger->debug('{gridAction} processPager fin, modèle :' . $strNomModel);
    return $objPager;
  }

  /**
   * @deprecated Utiliser processFiltre($strRelation)!
   *  Methode gerant la navigation sur les pages de liste possédant un filtre par entité relative (gère également l'enregistrement
   * du filtre en session et son application ou non selon les cas d'utilisation
   * @param string    $strModeleRelatif   Nom du modèle par lequel filtrer les resultats
   * Auteurs: William Richards
   */
  public function processFiltreParRelation($strModeleRelatif = null) {
    $logger = $this->getLogger();
    $objRequeteWeb = $this->getRequest();
    $objFormeFiltre = $this->objFormFiltre;
    $this->objModeleRelatif = false;
    $strModele = $objFormeFiltre->getModelName();
    $logger->debug('{gridAction} processFiltreParRelation début, modèle : ' . $strModele . ' modèle relatif : ' . $strModeleRelatif);
    //cas : navigation 'POST'
    if ($objRequeteWeb->isMethod('post') && $objRequeteWeb->hasParameter($objFormeFiltre->getName())) {
      if ($objRequeteWeb->hasParameter('reset')) {
        $logger->debug('{gridAction} processFiltreParRelation cas POST Reset, modèle : ' . $strModele . ' modèle relatif : ' . $strModeleRelatif);

        $objRequeteWeb->getParameterHolder()->remove('reset');
        $objFormeFiltre->bind($objFormeFiltre->getDefaults());

        $this->getUser()->setAttributeAction('filtre_' . strtolower($strModele) . 's', $objFormeFiltre->getValues());
      } else {
        $logger->debug('{gridAction} processFiltreParRelation cas POST filtre, modèle : ' . $strModele . ' modèle relatif : ' . $strModeleRelatif);

        $objFormeFiltre->bind($objRequeteWeb->getParameter($objFormeFiltre->getName()));
        $this->getUser()->setAttributeAction('filtre_' . strtolower($strModele) . 's', ($objRequeteWeb->getParameter($objFormeFiltre->getName())));
      }
      $this->intModeleRelatifId = $objFormeFiltre->getValue(strtolower($strModeleRelatif) . '_id');

      $objRequeteDoctrine = $objFormeFiltre->buildQuery($objFormeFiltre->getValues());
      if ($this->intModeleRelatifId) {
        $this->objModeleRelatif = Doctrine_Core::getTable($strModele)->findOneById($this->intModeleRelatifId);
      }
      $objRequeteDoctrine = Doctrine_Core::getTable($strModele)->retrieveQuery($objRequeteDoctrine);
    } else {
      $logger->debug('{gridAction} processFiltreParRelation cas GET/filtre vide/POST paginateur, modèle : ' . $strModele . ' modèle relatif : ' . $strModeleRelatif);



      //cas : navigation 'GET'
      $this->intModeleRelatifId = $objRequeteWeb->getParameter($strModeleRelatif, false);
      if ($this->intModeleRelatifId) {
        //cas : navigation depuis gestion entité relative
        $this->objModeleRelatif = Doctrine_Core::getTable($strModeleRelatif)->findOneById($this->intModeleRelatifId);
        //verification de l'existence de l'objet contenant/relatif (protection 'attaques' pas URL)
        if (!$this->objModeleRelatif) {
          $this->redirect("@non_autorise");
        }
        $this->getUser()->setAttributeAction('filtre_' . strtolower($strModele) . 's', array(strtolower($strModeleRelatif) . '_id' => $this->intModeleRelatifId));
        $objRequeteDoctrine = Doctrine_Core::getTable($strModele)->retrieveByRelationId($this->intModeleRelatifId);
        $this->objFormFiltre->bind(array(strtolower($strModeleRelatif) . '_id' => $this->intModeleRelatifId));
      } else {
        //cas : navigation depuis menu principal ou redirection après action/pagination
        if ($this->getUser()->hasAttributeAction('filtre_' . strtolower($strModele) . 's')) {
          //cas : filtre en session
          $arrFiltreUtilisateur = $this->getUser()->getAttributeAction('filtre_' . strtolower($strModele) . 's');
          $objFormeFiltre->bind($arrFiltreUtilisateur);
          if ($strModeleRelatif != '' && $arrFiltreUtilisateur[strtolower($strModeleRelatif) . '_id'] != '') {
            $this->intModeleRelatifId = $arrFiltreUtilisateur[strtolower($strModeleRelatif) . '_id'];
            $this->objModeleRelatif = Doctrine_Core::getTable($strModeleRelatif)->findOneById($this->intModeleRelatifId);
          }
          $objRequeteDoctrine = $objFormeFiltre->buildQuery($objFormeFiltre->getValues());
        } else {
          //cas : pas de filtre ou filtre vide en session
          $objRequeteDoctrine = null;
        }
      }
      $objRequeteDoctrine = Doctrine_Core::getTable($strModele)->retrieveQuery($objRequeteDoctrine);
    }
    $logger->debug('{gridAction} processFiltreParRelation fin, modèle : ' . $strModele . ' modèle relatif : ' . $strModeleRelatif);
    return $objRequeteDoctrine;
  }
  
  /**
   * Permet le chargement de thumbnails
   * @param string $strPath Chemin du repertoire dans lequel se trouve le fichier 
   * @param string $strFichier Nom complet du fichier
   */
  public function chargerThumbnail($strPath,$strFichier) {
    $utilFichier = new UtilFichier();

    // onconstruit le nom du fichier thumbnail
    $arrThumbs = sfConfig::get("app_photos_thumbnails");
    $strThumbNom = $utilFichier->getFilename($strFichier);
    $strThumbNom .= "." . $arrThumbs["postfix"];
    $strThumbNom .= "." . $utilFichier->getExtension($strFichier);

    // On demande le fichier
    $this->redirect("interface/telechargerPhoto?path=" . $strPath . "&fichier=" . $strThumbNom);

    if (sfContext::hasInstance()) {
      sfContext::getInstance()->getLogger()->debug('chargerThumbnail->execute() End');
    }
  }

  /**
   * Gère la mise en session, récupération, réinitialisation des filtres
   * @param string $strRelation     si donné et valide, gère les cas de listes d'éléments filtrés dans un élément contenant donné
   * @return Doctrine_query  requête doctrine issue du filtre
   * @author William RICHARDS
   */
  public function processFiltre($strRelation = null) {
    $logger = $this->getLogger();
    $objRequeteWeb = $this->getRequest();
    $objFormeFiltre = $this->objFormFiltre;
    $this->objModeleRelatif = false;
    $this->intModeleRelatifId = false;
    $strModele = $objFormeFiltre->getModelName();

    try {
      $arrModeleRelatif = $objFormeFiltre->getNomModeleRelatif($strRelation);
      $strModeleRelatif = $arrModeleRelatif[0];
      $strNomColonne = $arrModeleRelatif[1];
    } catch (Exception $ex) {
      $strModeleRelatif = false;
    }
    $logger->debug('{gridAction} processFiltre début, modèle : ' . $strModele . (!$strModeleRelatif ? '' : (' modèle relatif : ' . $strModeleRelatif)));
    //cas : navigation 'POST'
    if ($objRequeteWeb->isMethod('post') && $objRequeteWeb->hasParameter($objFormeFiltre->getName())) {
      if ($objRequeteWeb->hasParameter('reset')) {
        $logger->debug('{gridAction} processFiltre cas POST Reset, modèle : ' . $strModele . (!$strModeleRelatif ? '' : (' modèle relatif : ' . $strModeleRelatif)));

        $objRequeteWeb->getParameterHolder()->remove('reset');
        $objFormeFiltre->bind($objFormeFiltre->getDefaults());
        $this->getUser()->setAttributeAction('filtre_' . strtolower($strModele) . 's', $objFormeFiltre->getValues());
      } else {
        $logger->debug('{gridAction} processFiltre cas POST filtre, modèle : ' . $strModele . (!$strModeleRelatif ? '' : (' modèle relatif : ' . $strModeleRelatif)));

        $objFormeFiltre->bind($objRequeteWeb->getParameter($objFormeFiltre->getName()));
        $this->getUser()->setAttributeAction('filtre_' . strtolower($strModele) . 's', ($objRequeteWeb->getParameter($objFormeFiltre->getName())));
      }
      if ($strModeleRelatif) {
        $this->intModeleRelatifId = $objFormeFiltre->getValue($strNomColonne);
        if ($this->intModeleRelatifId) {
          $this->objModeleRelatif = Doctrine_Core::getTable($strModele)->findOneById($this->intModeleRelatifId);
        }
      }
    } else {
      $logger->debug('{gridAction} processFiltre cas GET/filtre vide/POST paginateur, modèle : ' . $strModele . (!$strModeleRelatif ? '' : (' modèle relatif : ' . $strModeleRelatif)));
      //cas : navigation 'GET'
      if ($this->getUser()->hasAttributeAction('filtre_' . strtolower($strModele) . 's')) {
        //cas : filtre en session
        $arrFiltreUtilisateur = $this->getUser()->getAttributeAction('filtre_' . strtolower($strModele) . 's');
      } else {
        $arrFiltreUtilisateur = (!$strModeleRelatif) ? $objFormeFiltre->getDefaults() : $arrFiltreUtilisateur = array(strtolower($strNomColonne) => '');
      }
      $objFormeFiltre->bind($arrFiltreUtilisateur);
      //  avec relation
      if ($strModeleRelatif) {
        $this->intModeleRelatifId = $objRequeteWeb->getParameter(strtolower($strModeleRelatif), false);
        if ($this->intModeleRelatifId) {
          //cas : navigation depuis gestion entité relative
          $this->objModeleRelatif = Doctrine_Core::getTable($strModeleRelatif)->findOneById($this->intModeleRelatifId);
          //verification de l'existence de l'objet contenant/relatif (protection 'attaques' par URL)
          if (!$this->objModeleRelatif) {
            $this->redirect("@non_autorise");
          }
          $this->getUser()->setAttributeAction('filtre_' . strtolower($strModele) . 's', array($strNomColonne => $this->intModeleRelatifId));
          $this->objFormFiltre->bind(array($strNomColonne => $this->intModeleRelatifId));
        } else {
          //cas : navigation depuis menu principal ou redirection après action/pagination
          if ($arrFiltreUtilisateur[$strNomColonne] != '') {
            $this->intModeleRelatifId = $arrFiltreUtilisateur[$strNomColonne];
            $this->objModeleRelatif = Doctrine_Core::getTable($strModeleRelatif)->findOneById($this->intModeleRelatifId);
          }
        }
      }
    }
    $logger->debug('{gridAction} processFiltre fin, modèle : ' . $strModele . (!$strModeleRelatif ? '' : (' modèle relatif : ' . $strModeleRelatif)));
    $objRequeteDoctrine = $objFormeFiltre->buildQuery($objFormeFiltre->getValues());
    return $objRequeteDoctrine;
  }

}

?>
