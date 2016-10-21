<?php

/**
 * Classe intermédiaire entre les classes BaseModel et sfDoctrineRecord
 *
 * @author William
 */
abstract class gridDoctrine_Record extends sfDoctrineRecord {

  public function getClass(){
    return get_class($this);
  }

  public function __toString(){
    try {
      return $this->getIntitule();
    } catch (Exception $ex) {
      return parent::__toString();
    }
  }

  /**
   *  Placeholder au cas où une logique d'activation/désactivation est à implémenter
   * @return boolean condition activable ou pas
   */
  public function estActivable() {
    return true;
  }

  /**
   *  Placeholder au cas où une logique d'activation/désactivation est à implémenter
   * @return boolean condition désactivable ou pas
   */
  public function estDesactivable() {
    return true;
  }


  /**
   *  Methodes de log, verifient l'existance du contexte symfony avant logger le message
   * en y prefixant la classe appelant
   * @param string $message
   */
  public function log($message) {
    $message = '{' . get_class($this) . '} ' . $message;
    if ($this->canLog()) {
      sfContext::getInstance()->getLogger()->log($message);
    }
  }

  public function logAlert($message) {
    $message = '{' . get_class($this) . '} ' . $message;
    if ($this->canLog()) {
      sfContext::getInstance()->getLogger()->alert($message);
    }
  }

  public function logCrit($message) {
    $message = '{' . get_class($this) . '} ' . $message;
    if ($this->canLog()) {
      sfContext::getInstance()->getLogger()->crit($message);
    }
  }

  public function logDebug($message) {
    $message = '{' . get_class($this) . '} ' . $message;
    if ($this->canLog()) {
      sfContext::getInstance()->getLogger()->debug($message);
    }
  }

  public function logEmerg($message) {
    $message = '{' . get_class($this) . '} ' . $message;
    if ($this->canLog()) {
      sfContext::getInstance()->getLogger()->emerg($message);
    }
  }

  public function logErreur($message) {
    $message = '{' . get_class($this) . '} ' . $message;
    if ($this->canLog()) {
      sfContext::getInstance()->getLogger()->err($message);
    }
  }

  public function logInfo($message) {
    $message = '{' . get_class($this) . '} ' . $message;
    if ($this->canLog()) {
      sfContext::getInstance()->getLogger()->info($message);
    }
  }

  public function logWarning($message) {
    $message = '{' . get_class($this) . '} ' . $message;
    if ($this->canLog()) {
      sfContext::getInstance()->getLogger()->warning($message);
    }
  }

  public function logNotice($message) {
    $message = '{' . get_class($this) . '} ' . $message;
    if ($this->canLog()) {
      sfContext::getInstance()->getLogger()->notice($message);
    }
  }

  private function canLog() {
    return sfContext::hasInstance();
  }

}

?>
