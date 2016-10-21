<?php

/**
 * View_recherche filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class View_rechercheFormFilter extends BaseView_rechercheFormFilter
{
  private $arrMetierFiltre = array();

  /**
   * Constructeur
   * @param array $defaults
   * @param array $options
   * @param string $CSRFSecret
   */
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
  {
    $objUser = sfContext::getInstance()->getUser();

    // administrateur
    if ($objUser->isAdministrateur())
    {
      $this->arrMetierFiltre = array(MetierTable::BPI, MetierTable::MIP, MetierTable::MRIS);
    }

    // pas administrateur
    else
    {
      // super-utilisateurs et utilisateurs BPI
      if ($objUser->hasCredential("SUP-BPI") || $objUser->hasCredential("USR-BPI"))
      {
        $this->arrMetierFiltre = array_merge($this->arrMetierFiltre, array(MetierTable::MIP, MetierTable::MRIS));
      }

      // super-utilisateurs et utilisateurs MIP
      if ($objUser->hasCredential("SUP-MIP") || $objUser->hasCredential("USR-MIP"))
      {
        $this->arrMetierFiltre = array_merge($this->arrMetierFiltre, array(MetierTable::BPI, MetierTable::MRIS));
      }

      // super-utilisateurs et utilisateurs MRIS
      if ($objUser->hasCredential("SUP-MRIS") || $objUser->hasCredential("USR-MRIS"))
      {
        $this->arrMetierFiltre = array_merge($this->arrMetierFiltre, array(MetierTable::BPI, MetierTable::MIP));
      }
    }

    $this->arrMetierFiltre = count($this->arrMetierFiltre) == 0 ? null : array_unique($this->arrMetierFiltre);

    parent::__construct($defaults, $options, $CSRFSecret);
  }

  /**
   * Configuration de formulaire
   */
  public function configure()
  {
    $this->useFields(array('titre', 'metier_id', 'created_at'));

    // created_at
    $this->widgetSchema['created_at'] = new sfWidgetFormFilterDate(array(
                                            'from_date' => new sfWidgetFormInputJQueryDate(),
                                            'to_date' => new sfWidgetFormInputJQueryDate(),
                                            'with_empty' => false,
                                            'template'   => "%from_date% <strong>". libelle("msg_remarque_et_le")."</strong> : %to_date%"
                                        ));
    $this->widgetSchema['created_at']->setLabel(libelle("msg_libelle_cree_entre"));
    $this->validatorSchema['created_at'] = new sfValidatorDateRange(array(
                                                'from_date' => new sfValidatorDate(
                                                                      array(
                                                                        'required' => false,
                                                                        'date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~'
                                                                      ),
                                                                      array('bad_format' => libelle('msg_valorisation_date_invalide'))
                                                                  ),
                                                'to_date' => new sfValidatorDate(
                                                                      array(
                                                                        'required' => false,
                                                                        'date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~'
                                                                      ),
                                                                      array('bad_format' => libelle('msg_valorisation_date_invalide'))
                                                                  ),
                                                'required' => false
                                            ),
                                            array(
                                                'invalid' => libelle('msg_remarque_mip_date_incoherente')
                                            ));

    // intitulé
    $this->widgetSchema['titre'] = new sfWidgetFormFilterInput(array("with_empty" => false));
    $this->widgetSchema['titre']->setLabel(libelle("msg_libelle_intitule"));
    $this->validatorSchema['titre'] = new sfValidatorPass(array('required' => false));

    // metier
    $this->widgetSchema['metier_id'] = new sfWidgetFormDoctrineChoice(array(
                                              'model' => 'Metier',
                                              'query' => MetierTable::getInstance()->getMetiersSansAdministrateurQuery($this->arrMetierFiltre),
                                              'method' => 'getIntitule',
                                              'add_empty' => libelle('msg_libelle_tous'),
                                              'label' => libelle('msg_libelle_metier_concerne')
                                          ));
    $this->validatorSchema['metier_id'] = new sfValidatorDoctrineChoice(array(
                                              'required' => false,
                                              'query' => MetierTable::getInstance()->getMetiersSansAdministrateurQuery($this->arrMetierFiltre),
                                              'model' => 'Metier',
                                              'column' => 'id'
                                          ));

    // numero de dossier
    $this->widgetSchema['numero_dossier'] = new sfWidgetFormFilterInput(array("with_empty" => false));
    $this->widgetSchema['numero_dossier']->setLabel(libelle("msg_libelle_numero_dossier"));
    $this->validatorSchema['numero_dossier'] = new sfValidatorPass(array('required' => false));

    // numero de dossier
    $this->widgetSchema['nom_prenom_email'] = new sfWidgetFormFilterInput(array("with_empty" => false));
    $this->widgetSchema['nom_prenom_email']->setLabel(libelle("msg_libelle_nom_prenom_email"));
    $this->validatorSchema['nom_prenom_email'] = new sfValidatorPass(array('required' => false));

    // organisme mindef
    $this->widgetSchema['organisme_mindef_id'] = new gridWidgetFormOrganismeMindef(array("model" => 'Organisme_mindef', "add_empty" => libelle('msg_libelle_tous')));
    $this->widgetSchema['organisme_mindef_id']->setLabel(libelle("msg_libelle_org_mindef"));
    $this->validatorSchema['organisme_mindef_id'] = new sfValidatorDoctrineChoice(array(
                                                        'required' => false,
                                                        'model' => 'Organisme_mindef',
                                                        'column' => 'id'
                                                    ));

    // organisme
    $this->widgetSchema['organisme_id'] = new gridWidgetFormOrganisme(array("model" => 'Organisme', "add_empty" => libelle('msg_libelle_tous')));
    $this->widgetSchema['organisme_id']->setLabel(libelle("msg_libelle_organisme"));
    $this->validatorSchema['organisme_id'] = new sfValidatorDoctrineChoice(array(
                                                        'required' => false,
                                                        'model' => 'Organisme',
                                                        'column' => 'id'
                                                    ));

    $this->disableLocalCSRFProtection();
  }

  /**
   * Surcharge pour traiter correctement l'intervalle de la date de création
   * @param array $values
   * @return Doctrine_Query
   */
  public function dobuildQuery(array $values)
  {
    // si filtre par date, ajout d'un jour à la date max (pour inclure date sup)
    if (array_key_exists('created_at', $values))
    {
      if ($values['created_at'] != null)
      {
        $dateMax = $values['created_at'];
        $dateMax = new DateTime($dateMax['to']);
        $dateMax->modify('+1 day');
        $values['created_at']['to'] = $dateMax->format('Y-m-d');
      }
    }
    
    return parent::dobuildQuery($values);
  }

  /**
   * Surcharge pour traiter les extra-fields
   * @return string[]
   */
  public function getFields()
  {
    $arrFields = parent::getFields();

    $arrFields["numero_dossier"]      = "Text";
    $arrFields["nom_prenom_email"]    = "Text";
    $arrFields["organisme_mindef_id"] = "ForeignKey";
    $arrFields["organisme_id"]        = "ForeignKey";

    return $arrFields;
  }

  /**
   * Appliquer le filtre numero de dossier
   * @param Doctrine_Query $query
   * @param <type> $field
   * @param array $value
   */
  protected function addNumeroDossierColumnQuery($query, $field, $value)
  {
    if ($value['text'] != '')
    {
      View_rechercheTable::getInstance()->appliquerFiltreNumeroDossier($query, $value['text']);
    }
  }

  /**
   * Appliquer le filtre nom/prénom/e-mail
   * @param Doctrine_Query $query
   * @param <type> $field
   * @param array $value
   */
  protected function addNomPrenomEmailColumnQuery($query, $field, $value)
  {
    if ($value['text'] != '')
    {
      View_rechercheTable::getInstance()->appliquerFiltreNomPrenomEmail($query, $value['text']);
    }
  }

  /**
   * Appliquer le filtre organisme MINDEF
   * @param Doctrine_Query $query
   * @param <type> $field
   * @param array $value
   */
  protected function addOrganismeMindefIdColumnQuery($query, $field, $value)
  {
    if ($value['text'] != '')
    {
      View_rechercheTable::getInstance()->appliquerFiltreOrganismeMindef($query, $value['text']);
    }
  }

  /**
   * Appliquer le filtre organisme
   * @param Doctrine_Query $query
   * @param <type> $field
   * @param array $value
   */
  protected function addOrganismeIdColumnQuery($query, $field, $value)
  {
    if ($value['text'] != '')
    {
      View_rechercheTable::getInstance()->appliquerFiltreOrganisme($query, $value['text']);
    }
  }
}
