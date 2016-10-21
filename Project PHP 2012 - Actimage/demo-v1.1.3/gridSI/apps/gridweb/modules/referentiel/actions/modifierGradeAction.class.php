<?php

/**
 * Description of modifierGradeAction
 *
 * @author William
 */
class modifierGradeAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($objRequeteWeb) {
    $objGrade = GradeTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objGrade || !$objGrade['Organisme_mindef']->getEstActif()){
      $this->redirect("@non_autorise");
    }
    $this->objForm = new GradeForm($objGrade);
    if ($objRequeteWeb->isMethod('post')) {
      $this->processForm('modifier');
    }
  }

}

?>
