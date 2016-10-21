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
 * Utilisateur form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Utilisateur_PopupForm extends BaseUtilisateurForm
{
 
  public function configure()
  {
    $this->useFields(array('civilite_id','nom','prenom','email'));

    $this->widgetSchema['email']= new sfWidgetFormInputEmail();
    $this->widgetSchema['email2']= new sfWidgetFormInputEmail();
    $this->widgetSchema['civilite_id']->setLabel(libelle("msg_utilisateur_libelle_civilite"));
    $this->widgetSchema['nom']->setLabel(libelle("msg_libelle_nom"));
    $this->widgetSchema['prenom']->setLabel(libelle("msg_utilisateur_libelle_prenom"));
    $this->widgetSchema['email']->setLabel(libelle("msg_utilisateur_libelle_email"));
    $this->widgetSchema['email2']->setLabel(libelle("msg_utilisateur_libelle_email_pro"));
  
    $this->validatorSchema['email']= new sfValidatorEmail(array('required' => true),array('invalid'=>libelle("msg_form_error_champ_email_invalide"),'required'=>  libelle('msg_utilisateur_valid_email_requis')));
    $this->validatorSchema['email2']= new sfValidatorEmail(array('required' => false),array('invalid'=>libelle("msg_form_error_champ_email_invalide")));
    $this->validatorSchema['nom']->setMessage('required', libelle("msg_utilisateur_valid_nom"));
    $this->validatorSchema['prenom']->setMessage('required', libelle("msg_utilisateur_valid_prenom"));

    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'validerDependences'))));

    
    $this->disableCSRFProtection();

    parent::configure();
  }

  public function validerDependences($validator, $values)
  {
    $arrErreurs = array();

    //Valider e-mail
    if ((strcmp($this->getObject()->getEmail(), $values['email'])!=0) &&
        (UtilisateurTable::getInstance()->findOneByEmail($values['email'])))
    {
      $error = new sfValidatorError($validator, libelle('msg_utilisateur_valid_email_unique'));
      $this->putErreur($arrErreurs, 'email', $error);
    }

    // s'il y a des erreurs on balance l'exception
    if (count($arrErreurs) > 0)
    {
      throw new sfValidatorErrorSchema($validator, $arrErreurs);
    }

    return $values;
  }

  /**
   * Permet de rajouter un erreur aux erreur schema
   * @param array $arrErreurs tableauy des erreurs déjà detectés
   * @param string $strChamp nom du champ
   * @param sfValidatorError $objErreur
   * @author Gabor JAGER
   */
  private function putErreur(&$arrErreurs, $strChamp, $objErreur)
  {
    if (!isset($arrErreurs[$strChamp]))
    {
      $arrErreurs[$strChamp] = $objErreur;
    }

    else if (!is_array($arrErreurs[$strChamp]))
    {
      $arrErreurs[$strChamp] = array($arrErreurs[$strChamp], $objErreur);
    }

    else
    {
      $arrErreurs[$strChamp] = array_push($arrErreurs[$strChamp], $objErreur);
    }
  }


  public function save($con = null) {

    $strMotDePasseClaire = "";
    $boolEstNouveau = $this->isNew();

    //Detection de creation d'Utilisateur et de sauvegarde d'informations
    if (isset($this->defaults['mot_de_passe']))
    {

      $objUtilMotDePasse = new UtilMotDePasse(sfConfig::get("app_mot_de_passe_longueur"), sfConfig::get("app_mot_de_passe_alphabet"));

      $strMotDePasseClaire = $objUtilMotDePasse->getMotDePasseAleatoire();

      $this->values['mot_de_passe'] = sha1($strMotDePasseClaire);
    }


    //on sauvegarde le nouvel utilisateur
    $objPilote = parent::save($con);

    //on crée et sauvegarde le profil de l'utilisateur
    $objUtilisateur_profil = new Utilisateur_profil();
    $objUtilisateur_profil->setUtilisateurId($objPilote->getId());
    $objUtilisateur_profil->setProfilId(ProfilTable::USR_MIP);
    $objUtilisateur_profil->save();

    //Detection de creation d'Utilisateur et envoie de mail
    if (!empty($strMotDePasseClaire)&&($boolEstNouveau))
    {
      try
      {
        //Envoi d'un mail à l'utilisateur contenant le mot de passe en clair
        $gestionnaireMail = new GestionnaireMail();
        $strContenuMail =  get_partial('email/contenuMailCreationCompteUtilisateur',array('utilisateur' => $this->getObject(),'motdepasse' => $strMotDePasseClaire));
        $gestionnaireMail->envoyerMailNouvelUtilisateur($this->getObject(), $strContenuMail, sfContext::getInstance()->getUser()->getUtilisateur());

      } catch(Exception $ex)
      {
        sfContext::getInstance()->getUser()->setFlash("erreur", libelle('msg_utilisateur_creer_succes_erreur_mail',array($this->getObject()->getNom(),$ex->getMessage())));
      }
    }
  }
}
