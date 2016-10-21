<?php
/**
 * Description of retirerInnovateurAction
 *
 * @author William
 */
class retirerOrganismeAction extends gridAction{

  public function  execute($request) {

    if (! ($request->hasParameter('dossier_these') && $request->hasParameter('organisme'))){
      $this->redirect("@non_autorise");
    }

    $strId = $request->getParameter('dossier_these');
    $strToken = $this->getUser()->getAttribute('session_cofinance_mris_token');
    $strOrganisme = $request->getParameter('organisme');
    //test coherance token
    if (strpos($strToken,"u".$this->getUser()->getUtilisateur()->getId()."d".$strId) === false){
      $this->getUser()->setFlash('warning', libelle('msg_dossier_these_token_incoherant'));
      $this->redirect($this->getModuleName() . '/modifierCofinance_these?dossier_these='.$strId);
    }
    //verification de l'existence de l'organisme
    if (!OrganismeTable::getInstance()->findOneById($strOrganisme)){
      $this->redirect('@non_autorise');
    }
    //creation objet session_organisme_dossier_these
    $objSessionCofinance = Session_cofinance_theseTable::getInstance()->getSessionByOrganismeIdAndToken($strOrganisme,$strToken);
    $objSessionCofinance = $objSessionCofinance == false ? new Session_cofinance_these() : $objSessionCofinance[0];
    $objSessionCofinance->setTransactionToken($strToken);
    $objSessionCofinance->setOrganismeId($strOrganisme);
    $objSessionCofinance->setPartCofinance(0);

    //sauvegarde objet session_organisme_dossier_these
    $objSessionCofinance->save();

    //redirection
    $this->redirect($this->getModuleName() . '/modifierCofinance_these?dossier_these='.$strId);
  }
}
?>
