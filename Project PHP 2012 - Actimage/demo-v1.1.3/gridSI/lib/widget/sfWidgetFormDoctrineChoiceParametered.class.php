<?php


/**
 * Description of sfWidgetFormDoctrineChoiceParametered
 * Widget permettant le passage de parametres à la 'table_method' 
 * @author William
 */
class sfWidgetFormDoctrineChoiceParametered extends sfWidgetFormDoctrineChoice {

  public function getChoices() {
    $choices = array();
    if (false !== $this->getOption('add_empty')) {
      $choices[''] = true === $this->getOption('add_empty') ? '' : $this->translate($this->getOption('add_empty'));
    }

    if (null === $this->getOption('table_method')) {
      $query = null === $this->getOption('query') ? Doctrine_Core::getTable($this->getOption('model'))->createQuery() : $this->getOption('query');
      if ($order = $this->getOption('order_by')) {
        $query->addOrderBy($order[0] . ' ' . $order[1]);
      }
      $objects = $query->execute();
    } else {
      $results = $this->callTableMethod();
      if ($results instanceof Doctrine_Query) {
        $objects = $results->execute();
      } else if ($results instanceof Doctrine_Collection) {
        $objects = $results;
      } else if ($results instanceof Doctrine_Record) {
        $objects = new Doctrine_Collection($this->getOption('model'));
        $objects[] = $results;
      } else {
        $objects = array();
      }
    }

    $method = $this->getOption('method');
    $keyMethod = $this->getOption('key_method');

    foreach ($objects as $object) {
      $choices[$object->$keyMethod()] = $object->$method();
    }

    return $choices;
  }

  /**
   * Gets result for 'choices' from the Table class of model
   *
   * @return mixed Result of table method [Doctrine_Query, Doctrine_Collection, Doctrine_Record]
   */
  private function callTableMethod() {
    $tableMethod = $this->getOption('table_method');
    if (is_array($tableMethod)) {
      $results = call_user_func_array(array(Doctrine::getTable($this->getOption('model')),
                  $tableMethod['method']),
                      $tableMethod['parameters']);
    } else {
      $results = Doctrine::getTable($this->getOption('model'))->$tableMethod();
    }

    return $results;
  }

}

?>
