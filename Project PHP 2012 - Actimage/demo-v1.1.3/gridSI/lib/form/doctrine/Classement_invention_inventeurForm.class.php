<?php

/**
 * Classement_invention_inventeur form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Classement_invention_inventeurForm extends BaseClassement_invention_inventeurForm {

  public function configure() {
    $this->useFields(array(
        'concerne_id',
        'classement_propose_id',
        'classement_hierarchie_id',
        'classement_autorite_id',
        'classement_final_id'));

    $this->setWidgets(array(
        'concerne_id' => new sfWidgetFormReadOnly(
                array(//options
                    'content' => array(
                        'model' => 'Inventeur',
                        'method' => 'getNom'))
        ),
        'classement_propose_id' => new gridWidgetClassementChoice(),
        'classement_hierarchie_id' => new gridWidgetClassementChoice(),
        'classement_autorite_id' => new gridWidgetClassementChoice(),
        'classement_final_id' => new gridWidgetClassementChoice(),
    ));

    $this->setValidators(array(
        'concerne_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Concerne'))),
        'classement_autorite_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_autorite'))),
        'classement_hierarchie_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_hierarchie'))),
        'classement_propose_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_propose'))),
        'classement_final_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_final'))),
    ));

    //cas autorité et hierarchie identique (même entité mindef)
    $objDossier = $this->getObject();
    $objDossier = $objDossier['Dossier_bpi'];
    if ($objDossier->getAutoriteDecisionId() == $objDossier->getHierarchieLocaleId()) {
      unset($this['classement_hierarchie_id']);
    }


    parent::configure();
  }
}
