<?php

/**
 * Utilisateur filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUtilisateurFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'civilite_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'), 'add_empty' => true)),
      'nom'                         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom_jeunefille'              => new sfWidgetFormFilterInput(),
      'prenom'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'                       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email2'                      => new sfWidgetFormFilterInput(),
      'email_perso'                 => new sfWidgetFormFilterInput(),
      'mot_de_passe'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_naissance'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'date_deces'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'adresse_perso'               => new sfWidgetFormFilterInput(),
      'adresse_perso2'              => new sfWidgetFormFilterInput(),
      'adresse_perso3'              => new sfWidgetFormFilterInput(),
      'code_postal_perso'           => new sfWidgetFormFilterInput(),
      'complement_adresse_perso'    => new sfWidgetFormFilterInput(),
      'ville_perso_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'telephone_fixe'              => new sfWidgetFormFilterInput(),
      'telephone_mobile'            => new sfWidgetFormFilterInput(),
      'telephone_autre'             => new sfWidgetFormFilterInput(),
      'telephone_fixe_perso'        => new sfWidgetFormFilterInput(),
      'telephone_mobile_perso'      => new sfWidgetFormFilterInput(),
      'fax'                         => new sfWidgetFormFilterInput(),
      'photographie'                => new sfWidgetFormFilterInput(),
      'photographie_orig'           => new sfWidgetFormFilterInput(),
      'est_actif'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'uid'                         => new sfWidgetFormFilterInput(),
      'entite_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'add_empty' => true)),
      'entite_ancienne_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EntiteAncienne'), 'add_empty' => true)),
      'organisme_mindef_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => true)),
      'grade_id'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Grade'), 'add_empty' => true)),
      'statut_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut'), 'add_empty' => true)),
      'est_utilisateur_ldap'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'profils_list'                => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Profil')),
      'domaines_scientifiques_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Domaine_scientifique')),
    ));

    $this->setValidators(array(
      'civilite_id'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Civilite'), 'column' => 'id')),
      'nom'                         => new sfValidatorPass(array('required' => false)),
      'nom_jeunefille'              => new sfValidatorPass(array('required' => false)),
      'prenom'                      => new sfValidatorPass(array('required' => false)),
      'email'                       => new sfValidatorPass(array('required' => false)),
      'email2'                      => new sfValidatorPass(array('required' => false)),
      'email_perso'                 => new sfValidatorPass(array('required' => false)),
      'mot_de_passe'                => new sfValidatorPass(array('required' => false)),
      'date_naissance'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'date_deces'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'adresse_perso'               => new sfValidatorPass(array('required' => false)),
      'adresse_perso2'              => new sfValidatorPass(array('required' => false)),
      'adresse_perso3'              => new sfValidatorPass(array('required' => false)),
      'code_postal_perso'           => new sfValidatorPass(array('required' => false)),
      'complement_adresse_perso'    => new sfValidatorPass(array('required' => false)),
      'ville_perso_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ville'), 'column' => 'id')),
      'telephone_fixe'              => new sfValidatorPass(array('required' => false)),
      'telephone_mobile'            => new sfValidatorPass(array('required' => false)),
      'telephone_autre'             => new sfValidatorPass(array('required' => false)),
      'telephone_fixe_perso'        => new sfValidatorPass(array('required' => false)),
      'telephone_mobile_perso'      => new sfValidatorPass(array('required' => false)),
      'fax'                         => new sfValidatorPass(array('required' => false)),
      'photographie'                => new sfValidatorPass(array('required' => false)),
      'photographie_orig'           => new sfValidatorPass(array('required' => false)),
      'est_actif'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'uid'                         => new sfValidatorPass(array('required' => false)),
      'entite_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Entite'), 'column' => 'id')),
      'entite_ancienne_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('EntiteAncienne'), 'column' => 'id')),
      'organisme_mindef_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme_mindef'), 'column' => 'id')),
      'grade_id'                    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Grade'), 'column' => 'id')),
      'statut_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Statut'), 'column' => 'id')),
      'est_utilisateur_ldap'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'                  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'                  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
      'profils_list'                => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Profil', 'required' => false)),
      'domaines_scientifiques_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Domaine_scientifique', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('utilisateur_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addProfilsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Utilisateur_profil Utilisateur_profil')
      ->andWhereIn('Utilisateur_profil.profil_id', $values)
    ;
  }

  public function addDomainesScientifiquesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Utilisateur_domaine_scientifique Utilisateur_domaine_scientifique')
      ->andWhereIn('Utilisateur_domaine_scientifique.domaine_scientifique_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Utilisateur';
  }

  public function getFields()
  {
    return array(
      'id'                          => 'Number',
      'civilite_id'                 => 'ForeignKey',
      'nom'                         => 'Text',
      'nom_jeunefille'              => 'Text',
      'prenom'                      => 'Text',
      'email'                       => 'Text',
      'email2'                      => 'Text',
      'email_perso'                 => 'Text',
      'mot_de_passe'                => 'Text',
      'date_naissance'              => 'Date',
      'date_deces'                  => 'Date',
      'adresse_perso'               => 'Text',
      'adresse_perso2'              => 'Text',
      'adresse_perso3'              => 'Text',
      'code_postal_perso'           => 'Text',
      'complement_adresse_perso'    => 'Text',
      'ville_perso_id'              => 'ForeignKey',
      'telephone_fixe'              => 'Text',
      'telephone_mobile'            => 'Text',
      'telephone_autre'             => 'Text',
      'telephone_fixe_perso'        => 'Text',
      'telephone_mobile_perso'      => 'Text',
      'fax'                         => 'Text',
      'photographie'                => 'Text',
      'photographie_orig'           => 'Text',
      'est_actif'                   => 'Boolean',
      'uid'                         => 'Text',
      'entite_id'                   => 'ForeignKey',
      'entite_ancienne_id'          => 'ForeignKey',
      'organisme_mindef_id'         => 'ForeignKey',
      'grade_id'                    => 'ForeignKey',
      'statut_id'                   => 'ForeignKey',
      'est_utilisateur_ldap'        => 'Boolean',
      'created_at'                  => 'Date',
      'updated_at'                  => 'Date',
      'created_by'                  => 'ForeignKey',
      'updated_by'                  => 'ForeignKey',
      'profils_list'                => 'ManyKey',
      'domaines_scientifiques_list' => 'ManyKey',
    );
  }
}
