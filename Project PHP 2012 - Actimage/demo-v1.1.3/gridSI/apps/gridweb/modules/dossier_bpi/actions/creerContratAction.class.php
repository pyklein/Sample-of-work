<?php

/**
 * Description of creerContratAction
 *
 * @author Simeon Petev
 */
class creerContratAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $idDossier = $this->getRequest()->getParameter('dossier_bpi_id');

    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById(($idDossier) ? $idDossier : 0);

    if (($this->objDossier == null) || ($this->objDossier->getId()==0))
    {
      if ($idDossier != null)
      {
        $this->getUser()->setFlash("erreur", libelle('msg_dossier_bpi_droit'));
      }

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN PAR REDIRECTION; ");
      $this->redirect(url_for('dossier_bpi/listerDossier_bpis'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $srvToken = new ServiceToken();
    $objTabSessionSignataires = null;
    $strToken = '';

    if (!$srvToken->hasToken('creer_contrat_dossier'))
    {
      $strToken = $srvToken->creerToken('creer_contrat_dossier', $this->objDossier->getId());
    } else
    {
      $strToken = $srvToken->getToken('creer_contrat_dossier');
    }

    $this->objFormContrat = new ContratForm();
    $this->objFormSignataire = new Session_contrat_signataireForm();

    if ($request->isMethod('get'))
    {
      //Netoyage de la table de session avant le debut de la création
      if (!Session_contrat_signataireTable::getInstance()->netoyerSessionParToken($strToken))
      {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Effacement des entrés avec token ".$strToken." de la table de session; ");
      }
    }

    if ($request->isMethod('post'))
    {
      if ($request->hasParameter('ajouter_signataire_submit'))
      {
        $arrValsSublit = $request->getParameter($this->objFormSignataire->getName());
        $arrValsSublit['transaction_token'] = $strToken;

        $this->objFormSignataire->bind($arrValsSublit);

        if ($this->objFormSignataire->isValid())
        {
          try {
            $this->objFormSignataire->save();
          } catch (Exception $exc) {
            $this->getUser()->setFlash('erreur', 'msg_contrat_session_err');
            $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur sauveguarde signataire en session; ");
          }
        }
      } else if ($request->hasParameter('supprimer_signataire_submit'))
      {
        $arrValsSublit = $request->getParameter('supprimer_signataire_submit');

        foreach ($arrValsSublit as $key => $value)
        {
          $idSessionSignataire = $key;
        }

        $objSessionSignataire = Session_contrat_signataireTable::getInstance()->findOneById($idSessionSignataire);

        try {
            $objSessionSignataire->delete();
          } catch (Exception $exc) {
            $this->getUser()->setFlash('erreur', 'msg_contrat_session_err');
            $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur effacement signataire de session; ");
          }
      } else
      {
        $hasError = false;

        $arrValeursSumbit = $request->getParameter($this->objFormContrat->getName());

        $this->getRequest()->offsetUnset($this->objFormContrat->getName());

        $arrValeursSumbit['dossier_bpi_id'] = $this->objDossier->getId();

        $this->getRequest()->setParameter($this->objFormContrat->getName(), $arrValeursSumbit);

        //On remplie la variable objForm utilise pour sauveguarder les objets
        $this->objForm = $this->objFormContrat;

        $this->objFormContrat->getConnection()->beginTransaction();

        //Si la suaveguard de la forme reussi..
        if ($this->processForm('creer','',false))
        {
          $arrSignatairesSesion = Session_contrat_signataireTable::getInstance()->findByTransactionToken($strToken);

          //...on sauveguard les signataires
          foreach ($arrSignatairesSesion as $objSignataireSession)
          {
            $objSignataire = new Signataire();

            $objSignataire->setContratId($this->objFormContrat->getObject()->getId());
            $objSignataire->setOrganismeId($objSignataireSession->getOrganisme()->getId());
            $objSignataire->setServiceId($objSignataireSession->getServiceId());

            try {
              $objSignataire->save();
            } catch (Exception $exc) {
              $hasError = true;
              $this->getUser()->setFlash('erreur', libelle('msg_contrat_signataire_err_save'));
              $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur sauveguarde signataires; ");
            }
          }
        } else
        {
          $hasError = true;
        }

        $this->objFormContrat->getConnection()->commit();

        if (!$hasError)
        {
          //Netoyage de la table de session avan le debut de la creation
          if (!Session_contrat_signataireTable::getInstance()->netoyerSessionParToken($strToken))
          {
            $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Effacement des entrés avec token ".$strToken." de la table de session; ");
          }

          $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");
          $this->redirect(url_for('dossier_bpi/listerContrats?dossier_bpi_id='.$this->objDossier->getId()));
        }
      }

      $this->objFormContrat->bind($request->getParameter($this->objFormContrat->getName()));

      if ($request->hasParameter('ajouter_signataire_submit') || $request->hasParameter('supprimer_signataire_submit'))
      {
        $this->objFormContrat->resetErrorSchema();
      }
    }

    $this->arrSignataires = Session_contrat_signataireTable::getInstance()->findByTransactionToken($strToken);

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  postExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::postExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
}
?>
