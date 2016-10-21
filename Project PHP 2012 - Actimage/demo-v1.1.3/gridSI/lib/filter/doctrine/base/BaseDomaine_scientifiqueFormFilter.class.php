<?php

/**
 * Domaine_scientifique filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDomaine_scientifiqueFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'intitule'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'est_actif'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'utilisateurs_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur')),
    ));

    $this->setValidators(array(
      'intitule'          => new sfValidatorPass(array('required' => false)),
      'est_actif'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'utilisateurs_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('domaine_scientifique_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addUtilisateursListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.Utilisateur_domaine_scientifique Utilisateur_domaine_scientifique')
      ->andWhereIn('Utilisateur_domaine_scientifique.utilisateur_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Domaine_scientifique';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'intitule'          => 'Text',
      'est_actif'         => 'Boolean',
      'utilisateurs_list' => 'ManyKey',
    );
  }
}
