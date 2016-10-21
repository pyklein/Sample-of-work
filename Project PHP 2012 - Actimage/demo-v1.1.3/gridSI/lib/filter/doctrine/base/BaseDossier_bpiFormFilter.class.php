<?php

/**
 * Dossier_bpi filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDossier_bpiFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'titre'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'               => new sfWidgetFormFilterInput(),
      'date_predeclaration'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'date_declaration_conforme' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'est_brevetable'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'numero'                    => new sfWidgetFormFilterInput(),
      'est_actif'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'est_clos'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'date_cloture'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'commentaire_cloture'       => new sfWidgetFormFilterInput(),
      'date_reouverture'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'commentaire_reouverture'   => new sfWidgetFormFilterInput(),
      'autorite_decision_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AutoriteDecision'), 'add_empty' => true)),
      'hierarchie_locale_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HierarchieLocale'), 'add_empty' => true)),
      'etat_partage_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'add_empty' => true)),
      'statut_declaration_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_declaration'), 'add_empty' => true)),
      'statut_dossier_bpi_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_dossier_bpi'), 'add_empty' => true)),
      'date_classement'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'date_classement_cnis'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'commentaire_classement'    => new sfWidgetFormFilterInput(),
      'repertoire_partage'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'est_classifie'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'inventeurs_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Inventeur')),
      'dossiers_mip_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_mip')),
    ));

    $this->setValidators(array(
      'titre'                     => new sfValidatorPass(array('required' => false)),
      'description'               => new sfValidatorPass(array('required' => false)),
      'date_predeclaration'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'date_declaration_conforme' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'est_brevetable'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'numero'                    => new sfValidatorPass(array('required' => false)),
      'est_actif'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'est_clos'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'date_cloture'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'commentaire_cloture'       => new sfValidatorPass(array('required' => false)),
      'date_reouverture'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'commentaire_reouverture'   => new sfValidatorPass(array('required' => false)),
      'autorite_decision_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('AutoriteDecision'), 'column' => 'id')),
      'hierarchie_locale_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('HierarchieLocale'), 'column' => 'id')),
      'etat_partage_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Etat_partage'), 'column' => 'id')),
      'statut_declaration_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Statut_declaration'), 'column' => 'id')),
      'statut_dossier_bpi_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Statut_dossier_bpi'), 'column' => 'id')),
      'date_classement'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'date_classement_cnis'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'commentaire_classement'    => new sfValidatorPass(array('required' => false)),
      'repertoire_partage'        => new sfValidatorPass(array('required' => false)),
      'est_classifie'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
      'inventeurs_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Inventeur', 'required' => false)),
      'dossiers_mip_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_mip', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dossier_bpi_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addInventeursListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Part_inventive Part_inventive')
      ->andWhereIn('Part_inventive.inventeur_id', $values)
    ;
  }

  public function addDossiersMIPListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Dossier_mip_dossier_bpi Dossier_mip_dossier_bpi')
      ->andWhereIn('Dossier_mip_dossier_bpi.dossier_bpi_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Dossier_bpi';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'titre'                     => 'Text',
      'description'               => 'Text',
      'date_predeclaration'       => 'Date',
      'date_declaration_conforme' => 'Date',
      'est_brevetable'            => 'Boolean',
      'numero'                    => 'Text',
      'est_actif'                 => 'Boolean',
      'est_clos'                  => 'Boolean',
      'date_cloture'              => 'Date',
      'commentaire_cloture'       => 'Text',
      'date_reouverture'          => 'Date',
      'commentaire_reouverture'   => 'Text',
      'autorite_decision_id'      => 'ForeignKey',
      'hierarchie_locale_id'      => 'ForeignKey',
      'etat_partage_id'           => 'ForeignKey',
      'statut_declaration_id'     => 'ForeignKey',
      'statut_dossier_bpi_id'     => 'ForeignKey',
      'date_classement'           => 'Date',
      'date_classement_cnis'      => 'Date',
      'commentaire_classement'    => 'Text',
      'repertoire_partage'        => 'Text',
      'est_classifie'             => 'Boolean',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'created_by'                => 'ForeignKey',
      'updated_by'                => 'ForeignKey',
      'inventeurs_list'           => 'ManyKey',
      'dossiers_mip_list'         => 'ManyKey',
    );
  }
}
