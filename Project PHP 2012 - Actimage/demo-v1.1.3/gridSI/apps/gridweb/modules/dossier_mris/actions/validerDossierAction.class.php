<?php

/**
 * Validation d'un dossier
 *
 * @author Jihad 
 */
class validerDossierAction extends gridAction {

  public function execute($objRequeteWeb) {
  
    //On redirige si on a pas le bon parametre
    if ($objRequeteWeb->hasParameter('dossier_these'))
    {
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_these');
      $this->strModelContenant = 'Dossier_these';
    } 
    elseif ($objRequeteWeb->hasParameter('dossier_ere'))
    {
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_ere');
      $this->strModelContenant = 'Dossier_ere';
    } 
    elseif ($objRequeteWeb->hasParameter('dossier_postdoc'))
    {
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_postdoc');
      $this->strModelContenant = 'Dossier_postdoc';
    } 
    else
    {
      $this->redirect("@non_autorise");
    }

    if ((!$this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant)))
    {
      $this->redirect('@non_autorise');
    }

    $form = $this->strModelContenant."_classementForm";
    $this->objForm = new $form($this->objDossier);
    

    if ($objRequeteWeb->isMethod('post'))
    {
      $this->objForm->bind($objRequeteWeb->getPostParameter($this->objForm->getName()), array());
      if($this->objForm->isValid())
      {
        $this->objDossier = $this->objForm->save();
      }
    }
  }

}

?>
