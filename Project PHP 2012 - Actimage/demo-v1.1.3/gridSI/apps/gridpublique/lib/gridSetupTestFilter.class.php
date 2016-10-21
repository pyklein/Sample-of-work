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
      
      if (false){
         $this->context->getController()->forward(sfConfig::get('sf_setup_module'), sfConfig::get('sf_setup_action'));
         throw new sfStopException();
      }

      try{
        UtilisateurTable::getInstance()->findOneById(1);
      }catch(Doctrine_Connection_Exception $ex){

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
