<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of creerOrganismeAction
 *
 * @author William
 */
class creerOrganismeAction extends gridAction{
    public function execute($objRequeteWeb){
      $objOrganisme = new Organisme();
       $strRedirection = '';
      if ($objRequeteWeb->hasParameter('type_organisme')){
        $strIdType = $objRequeteWeb->getParameter('type_organisme');
        $objOrganisme['Type_organisme'] = (Organisme_mindefTable::getInstance()->findOneById($strIdType));
        $strRedirection = '?type_organisme='.$strIdType;

      }
      $this->objForm = new OrganismeForm($objOrganisme);
      if ($objRequeteWeb->isMethod('post')){
        $this->processForm('creer','listerOrganismes'.$strRedirection);
      }
    }
}
?>
