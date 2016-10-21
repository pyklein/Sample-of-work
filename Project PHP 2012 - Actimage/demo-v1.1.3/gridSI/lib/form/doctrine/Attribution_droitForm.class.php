<?php

/**
 * Attribution_droit form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Attribution_droitForm extends BaseAttribution_droitForm
{
  public $strEcheanceInitiale ;
  public $arrClassement = array();
  public function  __construct($object = null, $options = array(), $CSRFSecret = null,$arrClassement = array())
  {
    $this->arrClassement = $arrClassement;
    parent::__construct($object, $options, $CSRFSecret);
  }

  
  
  public function configure()
  {
    $objAttribution = $this->getObject();
    $objDossier = $objAttribution['Dossier_bpi'];
    
    //On met un delai de 4 mois pour l'echeance initiale si la date de declaration est renseignée
    $intDelaiEcheance = sfConfig::get("app_delai_apres_declaration_conforme");
    if($objDossier->getDate_declaration_conforme())
    {
      $this->strEcheanceInitiale = formatDate(date("Y-m-d",strtotime(date("Y-m-d", strtotime($objDossier->getDate_declaration_conforme())) . " +$intDelaiEcheance")));
    }
    
    $this->useFields(array('echeance_supplementaire','droits_attribues','date_decision_attribution','date_envoi_contrat','commentaire','contrat_id','redaction_brevet_lance','brevet_id'));
    
    $this->widgetSchema['echeance_initiale'] = new sfWidgetFormInputJQueryDate(array(), array('size'=>'10', 'value' => $this->strEcheanceInitiale));

    $this->widgetSchema['echeance_supplementaire'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['echeance_supplementaire']->setLabel(libelle("msg_libelle_echeance_supplementaire"));
    $this->setValidator('echeance_supplementaire', new gridValidatorDate(array('required' => false)));

    $this->widgetSchema['droits_attribues'] = new gridWidgetFormChoiceRadioAligne(array(
                            'choices'  => array('1' => libelle("msg_libelle_oui"),
                                '0' => libelle("msg_libelle_non")),
                          ));
    $this->widgetSchema['droits_attribues']->setLabel(libelle("msg_libelle_droits_attribues"));

    $this->widgetSchema['date_decision_attribution'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_decision_attribution']->setLabel(libelle("msg_libelle_date_decision_attribution"));
    $this->setValidator('date_decision_attribution', new gridValidatorDate(array('required' => false)));

    $this->widgetSchema['date_envoi_contrat'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_envoi_contrat']->setLabel(libelle("msg_libelle_date_envoi_contrat"));
    $this->setValidator('date_envoi_contrat', new gridValidatorDate(array('required' => false)));

    $this->widgetSchema['commentaire']->setLabel(libelle("msg_libelle_commentaire"));

    $this->widgetSchema['contrat_id'] = new gridWidgetFormContrat(array(
                'table_method' => array('method' => 'retrieveContratParClassementParDossierBpiId', 'parameters' => array($this->arrClassement, $objDossier->getId())),
                    )
    );

    $this->widgetSchema['contrat_id']->setLabel(libelle("msg_libelle_identification_contrat"));
 
    $this->widgetSchema['redaction_brevet_lance'] = new gridWidgetFormChoiceRadioAligne(array(
                            'choices'  => array('1'=>libelle("msg_libelle_oui"),
                                '0'=>libelle("msg_libelle_non")),
                          ));
    $this->widgetSchema['redaction_brevet_lance']->setLabel(libelle("msg_libelle_redaction_brevet"));
   

    $this->widgetSchema['brevet_id'] = new sfWidgetFormDoctrineChoiceParametered(
                  array('model' => 'Brevet',
                        'add_empty' => libelle("msg_libelle_aucun"),
                        'table_method' => array('method' => 'retrieveBrevetsActifsByDossierBpi',
                        'parameters' => array($objDossier->getId())),
                        
                      ));
   $this->widgetSchema['brevet_id']->setLabel(libelle("msg_libelle_identification_brevet"));

    $this->validatorSchema->setPostValidator(
              new sfValidatorCallback(array('callback' => array($this, 'validationDecision')))
           );
    
    $this->widgetSchema->setNameFormat('attribution_droit_form[%s]');
    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->disableCSRFProtection();
    parent::configure();
  }


   //Vérifier que le champ décision attribution soit coché à "Oui" pour pouvoir coché le champ "décision de redaction" à "OUI"
  public function validationDecision($validator, $values)
  {
    
    if ($values['droits_attribues'] == false && $values['redaction_brevet_lance'] == true)
    {
      //if(array_key_exists(Classement_invention_inventeurTable::HMA,$this->arrClassement) || array_key_exists(Classement_invention_inventeurTable::HMNA,$this->arrClassement))
	  if((array_key_exists(Classement_invention_inventeurTable::HMA,$this->arrClassement) && !array_key_exists(Classement_invention_inventeurTable::M,$this->arrClassement)) || array_key_exists(Classement_invention_inventeurTable::HMNA,$this->arrClassement))
      {
       $error = new sfValidatorError($validator, libelle('msg_erreur_decision__attribution_droit',array(libelle("msg_libelle_droits_attribues"))));
       throw new sfValidatorErrorSchema($validator, array('redaction_brevet_lance' => $error));
      }
    }
    return $values;
  }

}
