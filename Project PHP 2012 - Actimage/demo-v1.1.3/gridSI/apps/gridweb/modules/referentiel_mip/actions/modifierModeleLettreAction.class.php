<?php

/**
 * Modification des modèles de lettres
 * @author Gabor JAGER
 */
class modifierModeleLettreAction extends gridAction
{
  private $logger;
  private $arrSucces = array();
  private $arrErreurs = array();
  
  public function preExecute()
  {
    $this->logger = sfContext::getInstance()->getLogger();
    parent::preExecute();
  }

  public function execute($request)
  {
    $this->objForm = array();
    
    $utilPhp = new ServiceFichier();
    $this->strLimiteUpload = $utilPhp->getMaxUploadSizeEnFormatHumain();

    $this->traiterFormulaire(Modele_lettreTable::MIP_LETTRE_PROJET_UN_INNOVATEUR);
    $this->traiterFormulaire(Modele_lettreTable::MIP_LETTRE_PROJET_PLUSIEURS_INNOVATEURS);
    $this->traiterFormulaire(Modele_lettreTable::MIP_LETTRE_SOUTIEN_UN_INNOVATEUR);
    $this->traiterFormulaire(Modele_lettreTable::MIP_LETTRE_SOUTIEN_PLUSIEURS_INNOVATEURS);
    $this->traiterFormulaire(Modele_lettreTable::MIP_LETTRE_CLOTURE_UN_INNOVATEUR_EM);
    $this->traiterFormulaire(Modele_lettreTable::MIP_LETTRE_CLOTURE_UN_INNOVATEUR_MINDEF);
    $this->traiterFormulaire(Modele_lettreTable::MIP_LETTRE_CLOTURE_PLUSIEURS_INNOVATEURS_MINDEF);
    $this->traiterFormulaire(Modele_lettreTable::MIP_LETTRE_ACCUSE_RECEPTION_VISITE);

    if (count($this->arrSucces) > 0)
    {
      $this->getUser()->setFlash("succes", $this->arrSucces);
    }
    if (count($this->arrErreurs) > 0)
    {
      $this->getUser()->setFlash("erreur", $this->arrErreurs);
    }

    if (count($this->arrErreurs) > 0 || count($this->arrSucces) > 0)
    {
      $this->redirect($this->getModuleName()."/".$this->getActionName());
    }
  }

  /**
   * Permet de traiter un formulaire
   * @param string $strCle Clé de formulaire
   */
  private function traiterFormulaire($strCle)
  {
    $request = $this->getRequest();
    
    $objModeleLettre = Modele_lettreTable::getInstance()->getModeleLettreParCle($strCle);

    if (!$objModeleLettre)
    {
      $objModeleLettre = new Modele_lettre();
      $objModeleLettre->setCle($strCle);
    }

    $this->objForm[$strCle] = new Modele_lettreForm($strCle, $objModeleLettre);
    
    if ($request->isMethod('post'))
    {
      $this->arrFiles = $request->getFiles($this->objForm[$strCle]->getName());
      $this->arrValeurs = $request->getParameter($this->objForm[$strCle]->getName());

      // formulaire avec contenu
      if ((isset($this->arrFiles["fichier"]) && $this->arrFiles["fichier"]["size"] > 0) || isset($this->arrValeurs["fichier_delete"]))
      {
        $this->objForm[$strCle]->bind($this->arrValeurs, $this->arrFiles);
        if ($this->objForm[$strCle]->isValid())
        {
          try
          {
            $objReferentiel = $this->objForm[$strCle]->save();
            if ($this->arrFiles["fichier"]["size"] > 0 && !isset($this->arrValeurs["fichier_delete"]))
            {
              $this->arrSucces[] = libelle("msg_libelle_enregistrer_fichier_succes", array($this->objForm[$strCle]->getObject()->getFichierOrig()));

              $objDocumentService = new ServiceDocumentMip();
              $arrRapport = $objDocumentService->validerModele($strCle);

              $arrWarning = array();

              // il y a des variables en plus
              if (count($arrRapport["plus"]) > 0)
              {
                $arrWarning[] = libelle("msg_libelle_modele_variables_enplus", array($this->objForm[$strCle]->getObject()->getFichierOrig(), implode(", ", $arrRapport["plus"])));
              }

              // il y a des variables manquants
              if (count($arrRapport["manque"]) > 0)
              {
                $arrWarning[] = libelle("msg_libelle_modele_variables_manque", array($this->objForm[$strCle]->getObject()->getFichierOrig(), implode(", ", $arrRapport["manque"])));
              }

              // message warning
              if (count($arrWarning) > 0)
              {
                $this->getUser()->setFlash("warning", $arrWarning);
              }
            }

            else if (isset($this->arrValeurs["fichier_delete"]))
            {
              $this->arrSucces[] = libelle("msg_libelle_supprimer_fichier_succes", array($this->objForm[$strCle]->getObject()->getFichierOrig()));
            }
          }
          catch (Exception $ex)
          {
            $this->arrErreurs[] = $ex->getMessage();
            $this->arrErreurs[] = libelle("msg_libelle_erreur_enregistrement");
            $this->logger->err(__CLASS__."->".__FUNCTION__."() - Erreur: " . $ex->getTraceAsString());
          }
        }
      }

      // formulaire vide
      else
      {
        // NOP
      }
    }
  }
}
