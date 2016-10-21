<?php

/**
 * Dossier_postdoc filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Dossier_postdocFormFilter extends BaseDossier_postdocFormFilter
{
  public function configure() {

    $this->useFields(array());

    $this->setWidget('annee', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Dossier_postdoc',
                        'table_method' => 'getAnneesDossiers',
                        'method' => 'getAnnee',
                        'add_empty' => libelle('msg_libelle_toutes'))));


    $this->setWidget('nom_prenom_email', new sfWidgetFormFilterInput(array(
                'with_empty' => false)));

    $this->widgetSchema->setPositions(array('annee', 'nom_prenom_email'));


    //validateurs
    $this->validatorSchema['annee'] = new sfValidatorPass();

    $this->validatorSchema['nom_prenom_email'] = new sfValidatorPass();

    //labels
     $this->widgetSchema->setLabels(array(
        'annee' => libelle("msg_libelle_annee"),
        'nom_prenom_email' => libelle("msg_libelle_nom_prenom_email"),
         ));

    $this->disableLocalCSRFProtection();
  }

   protected function addNomPrenomEmailColumnQuery($query, $field, $value) {
    if ($value['text'] != '') {
      Dossier_postdocTable::getInstance()->appliquerFiltreNomPrenomEmail($query, $value['text']);
    }
  }

  protected function addAnneeColumnQuery($query, $field, $value) {
    Dossier_postdocTable::getInstance()->appliquerFiltreAnnee($query, $value);
  }
}
