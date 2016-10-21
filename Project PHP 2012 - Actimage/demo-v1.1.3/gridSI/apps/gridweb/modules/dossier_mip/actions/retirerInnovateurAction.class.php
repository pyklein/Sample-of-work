<?php
/**
 * Description of retirerInnovateurAction
 *
 * @author William
 */
class retirerInnovateurAction extends gridAction{

  public function  execute($request) {

    if (! ($request->hasParameter('dossier_mip') && $request->hasParameter('innovateur'))){
      $this->redirect("@non_autorise");
    }

    $strId = $request->getParameter('dossier_mip');
    $strToken = $this->getUser()->getAttribute('session_innovateurs_token');
    $strInnovateur = $request->getParameter('innovateur');
    //test coherance token
    if (strpos($strToken,"u".$this->getUser()->getUtilisateur()->getId()."d".$strId) === false){
      $this->getUser()->setFlash('warning', libelle('msg_dossier_mip_token_incoherant'));
      $this->redirect($this->getModuleName() . '/modifierInnovateurs?dossier_mip='.$strId);
    }
    //verification de l'existence de l'innovateur
    if (!UtilisateurTable::getInstance()->findOneById($strInnovateur)){
      $this->redirect('@non_autorise');
    }
    //creation objet session_innovateur_dossier_mip
    $objSessionInnovateur = Session_innovateur_dossier_mipTable::getInstance()->getSessionByUtilisateurIdAndToken($strInnovateur,$strToken);
    $objSessionInnovateur = ( count($objSessionInnovateur) == 0) ? new Session_innovateur_dossier_mip() : $objSessionInnovateur[0];
    $objSessionInnovateur->setTransactionToken($strToken);
    $objSessionInnovateur->setInnovateurId($strInnovateur);
    $objSessionInnovateur["nouveau_type_id"] = null;
    //sauvegarde objet session_innovateur_dossier_mip
    $objASauvegarder = clone $objSessionInnovateur;
    $objSessionInnovateur->delete();
    $objASauvegarder->save();
    //redirection
    $this->redirect($this->getModuleName() . '/modifierInnovateurs?dossier_mip='.$strId);
  }
}
?>
