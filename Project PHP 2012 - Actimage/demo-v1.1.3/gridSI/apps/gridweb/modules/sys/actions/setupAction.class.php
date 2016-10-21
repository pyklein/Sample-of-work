<?php

/**
 * Description of setupAction
 *
 * @author William
 */
class setupAction extends gridAction{
  
  public function execute($request) {
    if ($request->isMethod('post')){
      $sFichier = new UtilFichier();
      $strChemin = sfContext::getInstance()->getModuleDirectory() .DIRECTORY_SEPARATOR . "setup.txt";
      try {
        $sFichier->isExiste($strChemin);
      }catch(Exception $ex){
        chdir(sfConfig::get('sf_root_dir'));
        $task = new SetupGridTask(sfContext::getInstance()->getEventDispatcher(), new
        sfFormatter());
        try {
        $task->run(array(), array('confirm' => 0));
        } catch(Exception $ex) {
          $this->getUser()->setFlash('erreur', libelle('msg_sys_erreur_installation',array($ex->getMessage())));
        }
        $handle = fopen($strChemin, "x");
        fclose($handle);
        $this->getUser()->setFlash('succes', libelle('msg_sys_succes_installation',array($ex->getMessage())));

        $this->redirect('@seconnecter');
      }
    }
  }
}
?>
