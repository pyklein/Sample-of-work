<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
/**
 * Notification filter form.
 * @author     Jihad Sahebdin
 */
class NotificationFormFilter extends BaseNotificationFormFilter
{
  public function configure()
  {
    $this->setWidgets(array(
      'metier_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'),
                                                          'add_empty' => libelle('msg_libelle_tous'),
                                                          'method' => 'getIntitule',
                                                          'label' => libelle('msg_libelle_metier_concerne'))),
    ));

    $this->setValidators(array(
      'metier_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Metier'), 'column' => 'id')),
    ));

    $this->widgetSchema['validite'] = new sfWidgetFormSelect(array(
      'choices' => array('' => libelle("msg_libelle_tous"), 
                          0 => libelle("msg_libelle_passee"),
                          1 => libelle("msg_libelle_en_cours"),
                          2 => libelle("msg_libelle_a_venir"))
    ));

    $this->widgetSchema->setLabels(array(
      'validite'  => libelle("msg_libelle_validite"),
    ));


    $this->setValidators(array(
      'validite' => new sfValidatorPass(),
      'metier_id'   => new sfValidatorPass()
    ));


    $this->widgetSchema->setNameFormat('notification_filters[%s]');

    $this->disableLocalCSRFProtection();

  }

  /*
   * Ajout du champ validité dans les filtres
   */
  public function getFields()
  {
    $champs = parent::getFields();
    $champs['validite'] = 'validite';
    return $champs;
  }

  public function addValiditeColumnQuery($requete,$champ,$valeur)
  {
    NotificationTable::getInstance()->getNotificationParValidite($requete,$valeur);
  }
}
