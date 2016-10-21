<?php

/**
 * Type_contrat form base class.
 *
 * @method Type_contrat getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseType_contratForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'intitule'     => new sfWidgetFormInputText(),
      'abreviation'  => new sfWidgetFormInputText(),
      'contrat_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Contrat')),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'intitule'     => new sfValidatorString(array('max_length' => 255)),
      'abreviation'  => new sfValidatorString(array('max_length' => 255)),
      'contrat_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Contrat', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('type_contrat[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Type_contrat';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['contrat_list']))
    {
      $this->setDefault('contrat_list', $this->object->Contrat->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveContratList($con);

    parent::doSave($con);
  }

  public function saveContratList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['contrat_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Contrat->getPrimaryKeys();
    $values = $this->getValue('contrat_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Contrat', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Contrat', array_values($link));
    }
  }

}
