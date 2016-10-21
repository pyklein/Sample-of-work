<?php
/**
 * Description of retirerInnovateurAction
 *
 * @author William
 */
class retirerInventeurAction extends gridAction{

  public function  execute($request) {

    if (! ($request->hasParameter('dossier_bpi') && $request->hasParameter('inventeur'))){
      $this->redirect("@non_autorise");
    }

    $strId = $request->getParameter('dossier_bpi');
    $strToken = $this->getUser()->getAttribute('session_situation_inventeurs_token');
    $strInventeur = $request->getParameter('inventeur');
    //test coherance token
    if (strpos($strToken,"u".$this->getUser()->getUtilisateur()->getId()."d".$strId) === false){
      $this->getUser()->setFlash('warning', libelle('msg_dossier_bpi_token_incoherant'));
      $this->redirect($this->getModuleName() . '/modifierSituation_inventeurs?dossier_bpi='.$strId);
    }
    //verification de l'existence de l'inventeur
    if (!InventeurTable::getInstance()->findOneById($strInventeur)){
      $this->redirect('@non_autorise');
    }
    //creation objet session_inventeur_dossier_bpi
    $objSessionInventeur = Session_situation_inventeursTable::getInstance()->getSessionByInventeurIdAndToken($strInventeur,$strToken);
    $objSessionInventeur = $objSessionInventeur == false ? new Session_situation_inventeurs() : $objSessionInventeur[0];
    $objSessionInventeur->setTransactionToken($strToken);
    $objSessionInventeur->setInventeurId($strInventeur);
    $objSessionInventeur->setPartInventive(0);

    //sauvegarde objet session_inventeur_dossier_bpi
    $objSessionInventeur->save();

    //redirection
    $this->redirect($this->getModuleName() . '/modifierSituation_inventeurs?dossier_bpi='.$strId);
  }
}
?>
