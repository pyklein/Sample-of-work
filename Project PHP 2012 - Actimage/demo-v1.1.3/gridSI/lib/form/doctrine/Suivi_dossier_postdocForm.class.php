<?php

/**
 * Suivi_dossier_postdoc form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Suivi_dossier_postdocForm extends BaseSuivi_dossier_postdocForm
{
  public function configure()
  {
    $this->useFields(array('type_suivi_postdoc_id','descriptif','date_demande','date_echeance', 'date_reception'));

    $this->widgetSchema['type_suivi_postdoc_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_suivi_postdoc'), 'add_empty' => false));
    $this->widgetSchema['type_suivi_postdoc_id']->setLabel(libelle("msg_libelle_type_suivi_postdoc"));

    $this->widgetSchema['descriptif'] = new sfWidgetFormInputText();
    $this->widgetSchema['descriptif']->setLabel(libelle("msg_libelle_descriptif_postdoc"));
    $this->validatorSchema['descriptif'] = new sfValidatorString(array('required' => true),array('required' => libelle("msg_suivi_champ_requis",array(libelle("msg_libelle_descriptif_postdoc")))));

    $this->widgetSchema['date_demande'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_demande']->setLabel(libelle("msg_libelle_date_demande_postdoc"));
    $this->validatorSchema['date_demande'] = new gridValidatorDate( array('required' => true),array('required' => libelle("msg_suivi_champ_requis",array(libelle("msg_libelle_date_demande_postdoc")))));

    $this->widgetSchema['date_echeance'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_echeance']->setLabel(libelle("msg_libelle_date_echeance_postdoc"));
    $this->validatorSchema['date_echeance'] = new gridValidatorDate( array('required' => true),array('required' => libelle("msg_suivi_champ_requis",array(libelle("msg_libelle_date_echeance_postdoc")))));

    $this->widgetSchema['date_reception'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_reception']->setLabel(libelle("msg_libelle_date_reception_postdoc"));
    $this->validatorSchema['date_reception'] = new gridValidatorDate( array('required' => false),array('required' => libelle("msg_suivi_champ_requis",array(libelle("msg_libelle_date_reception_postdoc")))));

    //Validateur pour s'assurer que la date de réception n'est pas inferieur à la date d'envoi
//    $this->validatorSchema->setPostValidator(
//      new sfValidatorSchemaCompare('date_reception', sfValidatorSchemaCompare::GREATER_THAN_EQUAL , 'date_demande',
//        array(),
//        array('invalid' => libelle('msg_suivi_erreur_date_1'))
//      )
//    );

    $this->disableLocalCSRFProtection();
    parent::configure();
  }
}
