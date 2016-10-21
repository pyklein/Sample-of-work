<?php
/**
 * Components de supervision
 * @author Gabor JAGER
 */
class voirTachesComponent extends sfComponent
{
  /**
   * Permet de visualiser les tâches
   * @param sfWebRequest $request
   * @author Gabor JAGER
   */
  public function execute($request)
  {
    $this->arrTaches = TacheTable::getInstance()->getTaches();
  }
}
