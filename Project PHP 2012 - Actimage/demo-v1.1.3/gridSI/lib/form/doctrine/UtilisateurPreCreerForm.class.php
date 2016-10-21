<?php
if (sfContext::hasInstance())
{
  sfContext::getInstance()->getConfiguration()->loadHelpers(array("Format","Url","Partial"));
}
else
{
  $configuration = ProjectConfiguration::getApplicationConfiguration('gridweb', 'prod', true);
  $context = sfContext::createInstance($configuration);
  $configuration->loadHelpers(array("Format","Url","Partial"));
}

/**
 * Description of UtilisateurPreCreerForm
 *
 * @author Simeon Petev
 */
class UtilisateurPreCreerForm extends BaseUtilisateurForm
{
  private $intIdUtilisateur;
  
  /**
   * Construit la forme en prenant compte les dtroit de l'utilisateur
   *
   * @param <type> $object
   * @param <type> $options
   * @param <type> $CSRFSecret
   * @param integer $intIdUsr L'id de l'utilisateur actuellement logué. Si aucun
   *                          id n'est specifié, droit d'admin son appliqués
   * @return ProfilsUtilisateurForm
   */
  public function  __construct($object = null, $options = array(), $CSRFSecret = null, $intIdUsr=0)
  {
    parent::__construct($object, $options, $CSRFSecret);

    $this->intIdUtilisateur = $intIdUsr;

    $this->configure();

    return $this;
  }
  
  public function  configure()
  {
    if (sfContext::hasInstance())
        sfContext::getInstance()->getLogger()->debug('UtilisateurPreCreerForm->configure() Start');

    $this->useFields(array('email','profils_list'));
    unset($this['_csrf_token']);

    $this->configureWidgets();
    
    $this->configureLibelles();

    $this->configureValidateurs();

    $this->disableCSRFProtection();

    parent::configure();

    if (sfContext::hasInstance())
        sfContext::getInstance()->getLogger()->debug('UtilisateurPreCreerForm->configure() Fin');
  }

  private function configureWidgets()
  {
    $this->widgetSchema['profils_list'] = new sfWidgetFormDoctrineChoice(
            array('model' => $this->getRelatedModelName('Profils'),
                  'multiple' => true,
                  'expanded' => true,
                  'query' => ProfilTable::getInstance()->getQueryProfilsGerablesParCetUtilisateur($this->intIdUtilisateur))
            );

    $this->widgetSchema['email'] = new sfWidgetFormInputEmail();


  }

  private function configureLibelles()
  {
    $this->widgetSchema['profils_list'] ->setLabel(libelle("msg_libelle_profil"));
    $this->widgetSchema['email']        ->setLabel(libelle('msg_utilisateur_libelle_email_connexion'));
  }


  private function configureValidateurs()
  {
    $this->validatorSchema['profils_list'] = new sfValidatorDoctrineChoice(
            array('model' => $this->getRelatedModelName('Profils'),
                  'multiple' => true,
                  'required' => true),
            array('required' => libelle("msg_utilisateur_profil_requis")));

    $this->setValidator('email',new sfValidatorAnd(array(new sfValidatorEmail(array(),array('invalid'=> libelle('msg_utilisateur_valid_email_format'))),
                                                           new sfValidatorDoctrineUnique(array('model'=>'Utilisateur','column'=>'email', 'throw_global_error'=>true),array('invalid'=> libelle('msg_utilisateur_valid_email_unique')))),
                                                     array('required' => true),
                                                     array('required'=>  libelle('msg_utilisateur_valid_email_requis'))
                                                    )
                          );
  }
}
?>
