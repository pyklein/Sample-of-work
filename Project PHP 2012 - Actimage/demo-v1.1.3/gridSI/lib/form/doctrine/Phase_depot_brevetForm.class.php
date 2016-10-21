<?php

/**
 * Phase_depot_brevet form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Phase_depot_brevetForm extends BasePhase_depot_brevetForm
{
  public function configure()
  {
    $this->useFields(array(
        'intitule',
        'abreviation',
        'phase_depot_brevet_id'
    ));

    $this->widgetSchema['phase_depot_brevet_id'] = new sfWidgetFormDoctrineChoice(array(
                'model' => $this->getRelatedModelName('PhaseDepotBrevet'),
                'table_method' => 'retrevePhasesParcoursProfondeur',
                'method' => 'getIntituleDansArbre',
                'add_empty' =>false,
                    )
    );

    $this->configurerValidateurs();
    $this->configurerLabels();
    $this->disableCSRFProtection();

    parent::configure();
  }

  private function configurerLabels()
  {
    $this->widgetSchema['intitule'] -> setLabel(libelle("msg_libelle_intitule"));
    $this->widgetSchema['abreviation'] -> setLabel(libelle("msg_libelle_abreviation"));
    $this->widgetSchema['phase_depot_brevet_id']->setLabel(libelle("msg_libelle_precedent_phase_depot_brevet"));

    $this->widgetSchema->moveField('phase_depot_brevet_id',sfWidgetFormSchema::FIRST );
  }

  private function configurerValidateurs()
  {
    $this->setValidator('intitule',
            new sfValidatorString( array(
                'required' => true) ,
                 array('required' => libelle("msg_referentiel_intitule_requis") ) ));

 $this->validatorSchema['abreviation']->setMessage('required',  libelle('msg_referentiel_abreviation_requis'));

    $this->validatorSchema->setPostValidator(
              new sfValidatorCallback(array('callback' => array($this, 'validationActifPere')))
           );
  }

  public function validationActifPere($validator, $values)
  {
    $intIdPere = $values['phase_depot_brevet_id'];
    $objPere = null;

    if ($intIdPere)
    {
      $objPere = Phase_depot_brevetTable::getInstance()->findOneById($intIdPere);

      if ($objPere)
      {
        /*if (!$objPere->getEstActif() || !$objPere->getEstActifPere())
        {
          $error = new sfValidatorError($validator, libelle('msg_phase_depot_brevet_erreur_actif',array($objPere->getIntitule())));
          throw new sfValidatorErrorSchema($validator, array('phase_depot_brevet_id' => $error));
        } else*/ if ($this->getObject()->estAncesteurDe($objPere->getId()))
        {
          $error = new sfValidatorError($validator, libelle('msg_phase_depot_brevet_erreur_decendance',array($this->getObject()->getIntitule())));
          throw new sfValidatorErrorSchema($validator, array('phase_depot_brevet_id' => $error));
        }
        
      }

    }

    return $values;
  }

  public function  save($con = null)
  {
    $idPereSubmite = $this->getValue('phase_depot_brevet_id');

    if ($idPereSubmite)
    {
      $objParent = Phase_depot_brevetTable::getInstance()->findOneById($idPereSubmite);
    }

    //Si le pere existe dans la base de données
    if ($idPereSubmite)
    {
      //On propage son statut dans la branche modifié
      $this->getObject()->setEstActifPere($objParent->getEstActif());

      $this->getObject()->notifierChangementActivation();

      parent::save($con);
    } else if (strlen($this->taintedValues['phase_depot_brevet_id'])==0) //Si une valeur vide est submité
    {
      //On met a jour l'arbre si le neud courrant devient root
      $this->getObject()->setEstActifPere($this->getObject()->getEstActif());

      $this->getObject()->notifierChangementActivation();

      parent::save($con);
      
      /*$this->getConnection()->beginTransaction();

      //On recupere le root acctuel
      $objRoot = Phase_depot_brevetTable::getInstance()->findRoot();

      //Il devient un deuxieme root
      parent::save($con);

      //On ecrase l'anncien root, s'il existe et qui devient enfant
      if ($objRoot)
      {
        $objRoot->setPhaseDepotBrevetId($this->getObject()->getId());

        $objRoot->save();
      }

      $this->getConnection()->commit();*/
    } else
    {
      parent::save();
    }
  }
}
