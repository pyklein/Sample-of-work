<?php
/**
 * Description of sfDoctrineRelationPager
 *
 * @author Simeon Petev
 */
class sfDoctrineRelationPager extends sfPager
{
  protected
    $object              = null,
    $objectRelationMethodName    = null,
    $tableMethodCalled   = false;


  /**
   * Construction du pageur
   *
   * @param <type> $class voir sfPager
   * @param object $object Objet du model relationel construit avec Doctrine
   * @param String $objectRelationMethodName Le nom de la methode de l'objet qui
   *                  retourne une Doctrine_Collection avec des objet en relation
   *                  avec l'objet courrant
   * @param <type> $maxPerPage voir sfPager
   *
   * @author Simeon PETEV
   */
  public function __construct($class, $object, $objectRelationMethodName, $maxPerPage = 10)
  {
    parent::__construct($class, $maxPerPage);

    $this->objectRelationMethodName = $objectRelationMethodName;
    $this->object = $object;
  }


    /**
   * Get the name of the table method used to retrieve the query object for the pager
   *
   * @return string $tableMethodName
   */
  public function getObjectRelationMethodName()
  {
    return $this->objectRelationMethodName;
  }

  /**
   * Set the name of the table method used to retrieve the query object for the pager
   *
   * @param string $tableMethodName
   * @return void
   */
  public function setObjectRelationMethodName($objectRelationMethodName)
  {
    $this->objectRelationMethodName = $objectRelationMethodName;
  }


  /**
   * @see sfPager
   */
  public function init()
  {
    $this->resetIterator();

    //appelle la methode de recuperation de resultats
    $resultats = $this->object->__call($this->objectRelationMethodName,array());
    $count = count($resultats);

    $this->setNbResults($count);

    if (0 == $this->getPage() || 0 == $this->getMaxPerPage() || 0 == $this->getNbResults())
    {
      $this->setLastPage(0);
    }
    else
    {
      $offset = ($this->getPage() - 1) * $this->getMaxPerPage();

      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }
  }

  /**
   * Retrieve the object for a certain offset
   *
   * @param integer $offset
   *
   * @return Doctrine_Record
   */
  protected function retrieveObject($offset)
  {
    $resultats = $this->object->__call($this->objectRelationMethodName,array());

    return $resultats[$offset];
  }

  /**
   * Get all the results for the pager instance
   *
   * @param mixed $hydrationMode A hydration mode identifier
   *
   * @return Doctrine_Collection|array
   */
  public function getResults($hydrationMode = null)
  {
    $arrResultats = $this->object->__call($this->objectRelationMethodName,array());
    $arrResultats = $arrResultats->getData();
    $arrResultatInteressant = array_chunk($arrResultats,  $this->maxPerPage);
    return $arrResultatInteressant[$this->getPage()-1];
  }

  /**
   * @see sfPager
   */
  protected function initializeIterator()
  {
    parent::initializeIterator();

    if ($this->results instanceof Doctrine_Collection)
    {
      $this->results = $this->results->getData();
    }
  }
}
?>
