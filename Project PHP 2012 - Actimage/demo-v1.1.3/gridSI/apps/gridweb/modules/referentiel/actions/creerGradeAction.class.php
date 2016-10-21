<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of creerGradeAction
 *
 * @author William
 */
class creerGradeAction extends gridAction{
    public function execute($objRequeteWeb){
      $objGrade = new Grade();
      if ($objRequeteWeb->hasParameter('organisme_mindef')){
        $objGrade['Organisme_mindef'] = (Organisme_mindefTable::getInstance()->findOneById($objRequeteWeb->getParameter('organisme_mindef')));
        if(!$objGrade['Organisme_mindef'] || !$objGrade['Organisme_mindef']->getEstActif()){
          $this->redirect('@non_autorise');
        }
      }
      $this->objForm = new GradeForm($objGrade);
      if ($objRequeteWeb->isMethod('post')){
        $this->processForm('creer','listerGrades?organisme_mindef='.$objGrade['Organisme_mindef']->getId());
      }
    }
}
?>
