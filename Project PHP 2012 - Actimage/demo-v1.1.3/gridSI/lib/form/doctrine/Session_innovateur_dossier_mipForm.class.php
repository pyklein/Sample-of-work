<?php

/**
 * Session_innovateur_dossier_mip form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Session_innovateur_dossier_mipForm extends BaseSession_innovateur_dossier_mipForm {

  private $requeteDisponible;

  public function __construct($object = null, $options = array(), $CSRFSecret = null, $objRequeteInnovateursDisponibles = null) {
    $this->requeteDisponible = $objRequeteInnovateursDisponibles;
    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {
    $this->useFields(array(
        'innovateur_id',
        'nouveau_type_id'
    ));

    $this->widgetSchema['innovateur_id'] = new sfWidgetFormDoctrineChoice(array(
                'model' => 'Utilisateur',
                'query' => $this->requeteDisponible,
                'add_empty' => false
            ));

    $this->widgetSchema['nouveau_type_id'] = new sfWidgetFormDoctrineChoice(array(
                'model' => 'Type_innovateur',
                'add_empty' => false,
            ));

    $this->validatorSchema['innovateur_id'] = new sfValidatorDoctrineChoice(array(
                'model' => 'Utilisateur',
                'query' => $this->requeteDisponible
            ));
    $this->validatorSchema['nouveau_type_id'] = new sfValidatorDoctrineChoice(array(
                'model' => 'Type_innovateur',
                'required' => true
            ));
    $this->validatorSchema['innovateur_id'] = new sfValidatorDoctrineChoice(array(
                'model' => 'Utilisateur',
                'query' => $this->requeteDisponible
            ));

    $this->widgetSchema->setLabels(array(
        'innovateur_id' => libelle('msg_libelle_innovateur'),
        'nouveau_type_id' => libelle('msg_libelle_type')
    ));

    $this->widgetSchema->setNameFormat('session_innovateur_dossier_mip[%s]');
    $this->disableCSRFProtection();
    parent::configure();
  }

}
