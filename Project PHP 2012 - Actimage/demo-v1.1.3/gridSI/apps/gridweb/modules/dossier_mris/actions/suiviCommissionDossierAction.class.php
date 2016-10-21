<?php

/**
 * Suivi d'un dossier après commission : Liste et ajout de remarque
 *
 * @author Jihad
 */
class suiviCommissionDossierAction extends gridAction {

  public function execute($objRequeteWeb) {
    
    //On redirige si on a pas le bon parametre
    if ($objRequeteWeb->hasParameter('dossier_these_id')) {
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_these_id');
      $this->strModelContenant = 'Dossier_these';
    } elseif ($objRequeteWeb->hasParameter('dossier_ere_id')){
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_ere_id');
      $this->strModelContenant = 'Dossier_ere';
    } elseif ($objRequeteWeb->hasParameter('dossier_postdoc_id')){
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_postdoc_id');
      $this->strModelContenant = 'Dossier_postdoc';
    } else {
      $this->redirect("@non_autorise");
    }

    if($objRequeteWeb->hasParameter('commission_id'))
    {
      $this->strIdCommission = $objRequeteWeb->getParameter('commission_id');
    }
    else
    {
      $this->redirect("@non_autorise");
    }
 
    $this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
    $this->arrAvis = Avis_mrisTable::getInstance()->getAvisByDossierId($this->strIdContenant,  strtolower($this->strModelContenant));
//    $arrdatesExistant = Avis_mrisTable::getInstance()->getDateAvisByDossierId($this->strIdContenant,  strtolower($this->strModelContenant));

    $this->arrAnnee = array();
    foreach ($this->arrAvis as $cle => $objAvis)
    {
      $objAnnee = $objAvis->getDateTimeObject('date_avis')->format('Y');
      $this->arrAnnee[$cle] = $objAnnee;
    }

    if ($this->objDossier)
    {
      $objAvis = new Avis_mris();

      $objAvis->setDateAvis(date('Y-m-d', time()));
      $objAvis[strtolower($this->strModelContenant).'_id'] = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);

      $this->objFormAvis = new Avis_mrisForm($this->arrAnnee,$objAvis);
      if ($objRequeteWeb->isMethod('post'))
      {
        if($objRequeteWeb->hasParameter('enregistrer_retour'))
        {
          $this->objFormAvis->bind($objRequeteWeb->getParameter($this->objFormAvis->getName()));
          if ($this->objFormAvis->isValid())
          {
            try
            {
              $objAvis = $this->objFormAvis->save();
              $this->getUser()->setFlash("succes", libelle("msg_creation_avis_mris_succes"));
            }

            catch (Exception $ex)
            {
              $this->getUser()->setFlash("erreur", libelle("msg_creation_avis_mris_erreur", array($ex->getMessage())));
            }
            $this->redirect('dossier_mris/listerDossiersCommission?id='.$this->strIdCommission.'&EnCours=',true);

          }
        }

        else if($objRequeteWeb->hasParameter('enregistrer_suivant'))
        {
          //on cherche le dossier suivant
          $objDossierSuivant = Avis_mrisTable::getInstance()->retrieveDossierSuivantListeCommission($this->objDossier->getId(), $this->objDossier->getDomaineScientifiqueId(), $this->objDossier->getTable()->getTableName(),  $this->strIdCommission);

          //on vérifie s'il y a un dossier suivant sinon on redirige vers le listing
          if($objDossierSuivant == null)
          {
            $this->objFormAvis->bind($objRequeteWeb->getParameter($this->objFormAvis->getName()));
            if ($this->objFormAvis->isValid())
            {
              try
              {
                $objAvis = $this->objFormAvis->save();
                $this->getUser()->setFlash("succes", libelle("msg_creation_avis_mris_succes"));
              }

              catch (Exception $ex)
              {
                $this->getUser()->setFlash("erreur", libelle("msg_creation_avis_mris_erreur", array($ex->getMessage())));
              }

            $this->redirect('dossier_mris/listerDossiersCommission?id='.$this->strIdCommission.'&EnCours=',true);
            }

          }
          else
          {
            $this->objFormAvis->bind($objRequeteWeb->getParameter($this->objFormAvis->getName()));
            if ($this->objFormAvis->isValid())
            {
              try
              {
                $objAvis = $this->objFormAvis->save();
                $this->getUser()->setFlash("succes", libelle("msg_creation_avis_mris_succes"));
              }

              catch (Exception $ex)
              {
                $this->getUser()->setFlash("erreur", libelle("msg_creation_avis_mris_erreur", array($ex->getMessage())));
              }

              $this->redirect('dossier_mris/suiviCommissionDossier?'.  strtolower($this->strModelContenant).'_id='.$objDossierSuivant->getId().'&commission_id='.$this->strIdCommission);
            }
          }
        }
      }

      $objRemarque = new Remarque_mris();
      $objRemarque[$this->strModelContenant] = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);

      $this->objForm = new Remarque_mrisForm($objRemarque);
      if ($objRequeteWeb->isMethod('post') && $objRequeteWeb->hasParameter('remarque_mris'))
      {
        $this->processForm('creer', 'suiviCommissionDossier?'.strtolower($this->strModelContenant).'_id='.$this->strIdContenant.'&commission_id='.$this->strIdCommission);
      }
    }
    else
    {
      $this->redirect('@non_autorise');
    }
  }
}

?>
