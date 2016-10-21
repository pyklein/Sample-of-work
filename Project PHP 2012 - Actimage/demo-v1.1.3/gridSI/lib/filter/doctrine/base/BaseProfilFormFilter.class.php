<?php

/**
 * Profil filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProfilFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'intitule'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'metier_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'), 'add_empty' => true)),
      'priorite'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'utilisateurs_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur')),
    ));

    $this->setValidators(array(
      'intitule'          => new sfValidatorPass(array('required' => false)),
      'code'              => new sfValidatorPass(array('required' => false)),
      'metier_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Metier'), 'column' => 'id')),
      'priorite'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'utilisateurs_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('profil_filters[%s]');

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
      ->leftJoin($query->getRootAlias().'.Utilisateur_profil Utilisateur_profil')
      ->andWhereIn('Utilisateur_profil.utilisateur_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Profil';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'intitule'          => 'Text',
      'code'              => 'Text',
      'metier_id'         => 'ForeignKey',
      'priorite'          => 'Number',
      'utilisateurs_list' => 'ManyKey',
    );
  }
}
