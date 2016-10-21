<?php

/**
 * Evenement_mris form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Jihad
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Evenement_mrisForm extends BaseEvenement_mrisForm
{
  private $strTypeDossier;
  public $nomWidgetType;

  public function __construct($strTypeDossier, $object = null, $options = array(), $CSRFSecret = null) {
    $this->strTypeDossier = $strTypeDossier;
    $this->nomWidgetType = explode('_', $this->strTypeDossier);
    $this->nomWidgetType = 'type_evenement_'.$this->nomWidgetType[1].'_id';
    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure()
  {
    //reconstruction de nom de modèle relatif
    $arr = explode('_',$this->nomWidgetType);
    $strNomModele = strtoupper($arr[0][0]).substr($arr[0], 1).'_'.$arr[1].'_'.$arr[2];
   
    $this->useFields(array($this->nomWidgetType,'date_evenement','description'));


    $this->widgetSchema[$this->nomWidgetType] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName($strNomModele), 'add_empty' => false));
    $this->widgetSchema[$this->nomWidgetType]->setLabel(libelle("msg_libelle_evenement_type"));

    $this->widgetSchema['date_evenement'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_evenement']->setLabel(libelle("msg_libelle_date_evenement"));
    $this->setValidator('date_evenement', new gridValidatorDate(array('required' => true),array('required' => libelle("msg_remarque_champ_requis",array(libelle("msg_libelle_date_evenement"))))));
    
    $this->widgetSchema['description'] = new sfWidgetFormTextareaCKEditor();
    $this->widgetSchema['description']->setLabel(libelle("msg_libelle_description_evenement"));
    $this->setValidator('description',new gridValidatorTextarea(array('required' => true),array('required'=> libelle("msg_remarque_champ_requis",array(libelle("msg_libelle_description_evenement"))))));
    parent::configure();
  }
  
}
