<?php

/**
 * Intervenant form base class.
 *
 * @method Intervenant getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseIntervenantForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'civilite_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'), 'add_empty' => false)),
      'nom'                        => new sfWidgetFormInputText(),
      'prenom'                     => new sfWidgetFormInputText(),
      'titre'                      => new sfWidgetFormInputText(),
      'est_participant_commission' => new sfWidgetFormInputCheckbox(),
      'est_responsable'            => new sfWidgetFormInputCheckbox(),
      'email'                      => new sfWidgetFormInputText(),
      'email2'                     => new sfWidgetFormInputText(),
      'adresse'                    => new sfWidgetFormInputText(),
      'adresse2'                   => new sfWidgetFormInputText(),
      'adresse3'                   => new sfWidgetFormInputText(),
      'code_postal'                => new sfWidgetFormInputText(),
      'complement_adresse'         => new sfWidgetFormInputText(),
      'ville_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'telephone_fixe'             => new sfWidgetFormInputText(),
      'telephone_mobile'           => new sfWidgetFormInputText(),
      'fax'                        => new sfWidgetFormInputText(),
      'est_actif'                  => new sfWidgetFormInputCheckbox(),
      'adresse_etrangere'          => new sfWidgetFormTextarea(),
      'pays_id'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'add_empty' => true)),
      'organisme_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'service_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'laboratoire_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'add_empty' => true)),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'created_by'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'commission_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Commission')),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'civilite_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'))),
      'nom'                        => new sfValidatorString(array('max_length' => 255)),
      'prenom'                     => new sfValidatorString(array('max_length' => 255)),
      'titre'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'est_participant_commission' => new sfValidatorBoolean(array('required' => false)),
      'est_responsable'            => new sfValidatorBoolean(array('required' => false)),
      'email'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email2'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse2'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse3'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'code_postal'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'complement_adresse'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ville_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'required' => false)),
      'telephone_fixe'             => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'telephone_mobile'           => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fax'                        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'est_actif'                  => new sfValidatorBoolean(array('required' => false)),
      'adresse_etrangere'          => new sfValidatorString(array('required' => false)),
      'pays_id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'required' => false)),
      'organisme_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'required' => false)),
      'service_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'required' => false)),
      'laboratoire_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
      'created_by'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'commission_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Commission', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('intervenant[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Intervenant';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['commission_list']))
    {
      $this->setDefault('commission_list', $this->object->Commission->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCommissionList($con);

    parent::doSave($con);
  }

  public function saveCommissionList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['commission_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Commission->getPrimaryKeys();
    $values = $this->getValue('commission_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Commission', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Commission', array_values($link));
    }
  }

}
