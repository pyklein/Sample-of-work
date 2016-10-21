<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridSetupTestFilter
 *
 * @author William
 */
class gridSetupTestFilter extends sfFilter{
  public function execute($filterChain){
    if ($this->isFirstCall()){
      $utilFichier = new UtilFichier();
      try {
        $strChemin = sfProjectConfiguration::getActive()->getRootDir()
                . DIRECTORY_SEPARATOR . 'apps'
                . DIRECTORY_SEPARATOR . 'gridweb'
                . DIRECTORY_SEPARATOR . 'modules'
                . DIRECTORY_SEPARATOR . 'sys'
                . DIRECTORY_SEPARATOR . 'setup.txt';
        $utilFichier->isExiste($strChemin);
      } catch(Exception $ex){
        $this->context->getUser()->setAuthenticated(false);
        $this->context->getUser()->clearCredentials();
        $this->context->getUser()->getAttributeHolder()->clear();
        
         $this->context->getController()->forward(sfConfig::get('sf_setup_module'), sfConfig::get('sf_setup_action'));
         throw new sfStopException();
      }

      try{
        UtilisateurTable::getInstance()->findOneById(1);
      }catch(Doctrine_Connection_Exception $ex){
        //logout de l'utilisateur
        $this->context->getUser()->setAuthenticated(false);
        $this->context->getUser()->clearCredentials();
        $this->context->getUser()->getAttributeHolder()->clear();

        if (sfConfig::get('sf_logging_enabled')){
           $this->context->getEventDispatcher()->notify(new sfEvent($this, 'application.log', array(sprintf('L\'action "%s/%s" ne peut être éxécutée car la base de données semble être indisponibe, redirection vers "%s/%s"', $this->context->getModuleName(), $this->context->getActionName(), sfConfig::get('sf_error_db_module'), sfConfig::get('sf_error_db_action')))));
        }

        $this->context->getController()->forward(sfConfig::get('sf_error_db_module'), sfConfig::get('sf_error_db_action'));
        throw new sfStopException();
      }
    }
    $filterChain->execute();
  }
}
?>
