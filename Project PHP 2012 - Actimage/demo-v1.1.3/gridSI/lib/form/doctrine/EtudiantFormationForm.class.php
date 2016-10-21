<?php

/**
 * EtudiantFormationForm: Onglet Formations et diplômes dans la modification d'un étudiant
 *
 * @package    gridSI
 * @subpackage form
 * @author     Jihad Sahebdin
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EtudiantFormationForm extends EtudiantForm
{
  public function configure()
  {
    $this->useFields(array('type_cursus_id','autre_cursus','a_master','mention','description_formation'));

    $utilPhp = new ServiceFichier();
    $this->configurerValidateurs();
    $this->configurerLabels();
    $this->widgetSchema->setNameFormat('etudiantFormation_forms[%s]');
    $this->validatorSchema->setOption('allow_extra_fields',true);

    $this->disableCSRFProtection();
 
//   parent::configure();
  }

  private function configurerLabels()
  {
    $this->widgetSchema['type_cursus_id'] = new sfWidgetFormDoctrineChoice(array(
        'model' => $this->getRelatedModelName('Type_cursus'),
        'add_empty' => 'Autre'));

    $this->widgetSchema->setHelp('a_master',libelle("msg_libelle_diplome_obtenu"));

    $this->widgetSchema['description_formation'] = new sfWidgetFormTextareaCKEditor();


    $this->widgetSchema['type_cursus_id']->setLabel(libelle("msg_libelle_etudiant_type_cursus"));
    $this->widgetSchema['autre_cursus']->setLabel(libelle("msg_libelle_etudiant_autre_cursus"));
    $this->widgetSchema['a_master']->setLabel(libelle("msg_libelle_etudiant_a_master"));
    $this->widgetSchema['mention']->setLabel(libelle("msg_libelle_etudiant_mention"));
    $this->widgetSchema['description_formation']->setLabel(libelle("msg_libelle_etudiant_dscription_formation"));

  }

  private function configurerValidateurs()
  {
    $this->validatorSchema['description_formation'] = new gridValidatorTextarea(array('required'=>false));
    $this->validatorSchema->setPostValidator(
              new sfValidatorCallback(array('callback' => array($this, 'validationType')))
           );
  }

  //Vérifier que le champ autre ne soit pas vide quand l'utilisateur choisit "Autre" comme type de cursus
  public function validationType($validator, $values)
  {
    if ($values['type_cursus_id'] == "" && $values['autre_cursus'] == false)
    {
       $error = new sfValidatorError($validator, libelle('msg_etudiant_erreur_type_cursus'));
       throw new sfValidatorErrorSchema($validator, array('autre_cursus' => $error));
    }
    return $values;
  }

  public function  save($con = null)
  {
    //Si le type de cursus a été precisé dans la liste déroulante, on efface ce qu'il y a dans le champ Autre_cursus
    if ($this->values['type_cursus_id'])
    {
      $this->values['autre_cursus'] = "";
    }
    return parent::save($con);
  }
}
