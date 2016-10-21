<?php

/**
 * Project filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterBaseTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class BaseFormFilterDoctrine extends sfFormFilterDoctrine {

  public function setup() {

  }

  public function getNomModeleRelatif($alias) {
    $table = Doctrine_Core::getTable($this->getModelName());
     if (!$table->hasRelation($alias))
    {
      throw new InvalidArgumentException(sprintf("Le  modèle '%s' n'a pas de relation '%s'.", $this->getModelName(), $alias));
    }
     $relation = $table->getRelation($alias);
    return array($relation['class'], $relation->getLocalFieldName());
  }

}
