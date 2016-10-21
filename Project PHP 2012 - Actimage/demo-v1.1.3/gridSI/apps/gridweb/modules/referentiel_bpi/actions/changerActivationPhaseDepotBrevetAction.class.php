<?php

/**
 * Description of changeractivationPhaseDepotBrevetAction
 *
 * @author Simeon Petev
 */
class changerActivationPhaseDepotBrevetAction extends gridAction
{
  /**
   */
  public function preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function execute($request) 
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $this->changerActivation($request->getParameter('id'),'Phase_depot_brevet');

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  /**
   */
  public function postExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::postExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  /**
   *@see gridAction->changerActivation()
   */
  public function changerActivation($id, $strNomModel, $idModeleParent = null, $strModeleParent = null, $strRedirection = null) {
    $logger = $this->getLogger();
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
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
          $objReferentiel->notifierChangementActivation();
          $objReferentiel->save();
          $this->getUser()->setFlash("succes", libelle("msg_" . strtolower($strNomModel) . "_desactiver_succes", array($objReferentiel)));
        } catch (Exception $ex) {
          $this->getUser()->setFlash("erreur", libelle("msg_" . strtolower($strNomModel) . "_desactiver_erreur", array($id, $ex->getMessage())));
          $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Desactive erreur; ");
        }
      } else {
        //cas non Désactivable : Informe l'utilisateur
        $this->getUser()->setFlash("erreur", libelle("msg_" . strtolower($strNomModel) . "_non_desactivable", array($objReferentiel)));
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur chanchement activation impossible; ");
      }
    } else {
      //cas Desactivé
      //est activable?
      if ($objReferentiel->estActivable()) {
        //cas Activable : activation et sauvegarde
        $objReferentiel->setEstActif(true);
        try {
          $objReferentiel->notifierChangementActivation();
          $objReferentiel->save();
          $this->getUser()->setFlash("succes", libelle("msg_" . strtolower($strNomModel) . "_activer_succes", array($objReferentiel)));
        } catch (Exception $ex) {
          $this->getUser()->setFlash("erreur", libelle("msg_" . strtolower($strNomModel) . "_activer_erreur", array($id, $ex->getMessage())));
          $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur changement activation; ");
        }
      } else {
        //cas non Activable : Informe l'utilisateur
        $this->getUser()->setFlash("erreur", libelle("msg_" . strtolower($strNomModel) . "_non_activable", array($objReferentiel)));
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur changement activation; ");
      }
    }
    //retour à la liste
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
}
?>
