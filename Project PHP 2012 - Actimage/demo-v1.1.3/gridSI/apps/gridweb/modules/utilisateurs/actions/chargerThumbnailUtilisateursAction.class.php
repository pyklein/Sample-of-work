<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Url");
/**
 * Description of chargerThumbnailUtilisateursAction
 *
 * @author Simeon Petev
 */
class chargerThumbnailUtilisateursAction extends gridAction
{
  public function preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    if ($this->request->hasParameter('id'))
    {
      if (!$this->getUser()->getUtilisateur()->isPeutGererUtilisateurAvecId($this->request->getParameter('id')))
      {
        $this->getUser()->setFlash("erreur", libelle("msg_utilisateur_droit_photo"));

        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

        $this->redirect(url_for("utilisateurs/listerUtilisateurs"));
      }
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
  
  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ ; ");
    $this->chargerThumbnail($request->getParameter("path"), $request->getParameter("fichier"));
  }
}
?>
