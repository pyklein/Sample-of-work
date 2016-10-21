<?php
/**
 * Liste de resultat de la recherche transversale
 * @author Gabor JAGER
 */
class listerView_recherchesAction extends gridAction
{
  /**
   *
   * @var sfLogger
   */
  private $logger;
  
  public function preExecute()
  {
    if (sfContext::hasInstance())
    {
      $this->logger = $this->getLogger();
    }
  }
  
  public function execute($objRequete)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() Start");
    }

    $this->objFormFiltre = new View_rechercheFormFilter();

    $objRequeteDoctrine = $this->processFiltre();
    $objRequeteDoctrine = View_rechercheTable::getInstance()->getRequeteListe($objRequeteDoctrine);
    $this->processPager($objRequeteDoctrine, 'View_recherche');

    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() End");
    }
  }
}
