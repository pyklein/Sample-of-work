<?php

/**
 * Dossier_postdoc filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDossier_postdocFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'numero_provisoire'         => new sfWidgetFormFilterInput(),
      'numero_definitif'          => new sfWidgetFormFilterInput(),
      'titre'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'objet'                     => new sfWidgetFormFilterInput(),
      'fichier_editable'          => new sfWidgetFormFilterInput(),
      'fichier_editable_orig'     => new sfWidgetFormFilterInput(),
      'fichier_pdf'               => new sfWidgetFormFilterInput(),
      'fichier_pdf_orig'          => new sfWidgetFormFilterInput(),
      'classement'                => new sfWidgetFormFilterInput(),
      'est_actif'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cotutelle'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cooperation'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'statut_dossier_postdoc_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_dossier_postdoc'), 'add_empty' => true)),
      'domaine_scientifique_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Domaine_scientifique'), 'add_empty' => true)),
      'organisme_mindef_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => true)),
      'organisme_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'realise_par'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etudiant'), 'add_empty' => true)),
      'pilote_par'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PilotePar'), 'add_empty' => true)),
      'etat_partage_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'add_empty' => true)),
      'mis_en_attente_le'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'repertoire_partage'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'laboratoires_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Laboratoire')),
      'avis_mris_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Avis_mris')),
    ));

    $this->setValidators(array(
      'numero_provisoire'         => new sfValidatorPass(array('required' => false)),
      'numero_definitif'          => new sfValidatorPass(array('required' => false)),
      'titre'                     => new sfValidatorPass(array('required' => false)),
      'objet'                     => new sfValidatorPass(array('required' => false)),
      'fichier_editable'          => new sfValidatorPass(array('required' => false)),
      'fichier_editable_orig'     => new sfValidatorPass(array('required' => false)),
      'fichier_pdf'               => new sfValidatorPass(array('required' => false)),
      'fichier_pdf_orig'          => new sfValidatorPass(array('required' => false)),
      'classement'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'est_actif'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cotutelle'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cooperation'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'statut_dossier_postdoc_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Statut_dossier_postdoc'), 'column' => 'id')),
      'domaine_scientifique_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Domaine_scientifique'), 'column' => 'id')),
      'organisme_mindef_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme_mindef'), 'column' => 'id')),
      'organisme_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme'), 'column' => 'id')),
      'realise_par'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Etudiant'), 'column' => 'id')),
      'pilote_par'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PilotePar'), 'column' => 'id')),
      'etat_partage_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Etat_partage'), 'column' => 'id')),
      'mis_en_attente_le'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'repertoire_partage'        => new sfValidatorPass(array('required' => false)),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
      'laboratoires_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Laboratoire', 'required' => false)),
      'avis_mris_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Avis_mris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dossier_postdoc_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addLaboratoiresListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.Dossier_postdoc_laboratoire Dossier_postdoc_laboratoire')
      ->andWhereIn('Dossier_postdoc_laboratoire.laboratoire_id', $values)
    ;
  }

  public function addAvisMrisListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.Avis_mris_dossier_postdoc Avis_mris_dossier_postdoc')
      ->andWhereIn('Avis_mris_dossier_postdoc.avis_mris_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Dossier_postdoc';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'numero_provisoire'         => 'Text',
      'numero_definitif'          => 'Text',
      'titre'                     => 'Text',
      'objet'                     => 'Text',
      'fichier_editable'          => 'Text',
      'fichier_editable_orig'     => 'Text',
      'fichier_pdf'               => 'Text',
      'fichier_pdf_orig'          => 'Text',
      'classement'                => 'Number',
      'est_actif'                 => 'Boolean',
      'cotutelle'                 => 'Boolean',
      'cooperation'               => 'Boolean',
      'statut_dossier_postdoc_id' => 'ForeignKey',
      'domaine_scientifique_id'   => 'ForeignKey',
      'organisme_mindef_id'       => 'ForeignKey',
      'organisme_id'              => 'ForeignKey',
      'realise_par'               => 'ForeignKey',
      'pilote_par'                => 'ForeignKey',
      'etat_partage_id'           => 'ForeignKey',
      'mis_en_attente_le'         => 'Date',
      'repertoire_partage'        => 'Text',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'created_by'                => 'ForeignKey',
      'updated_by'                => 'ForeignKey',
      'laboratoires_list'         => 'ManyKey',
      'avis_mris_list'            => 'ManyKey',
    );
  }
}
