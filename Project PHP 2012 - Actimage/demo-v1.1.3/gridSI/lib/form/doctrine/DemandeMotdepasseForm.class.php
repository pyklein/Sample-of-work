<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Formulaire pour réinitialiser le mot de passe d'un utilisateur
 * @author Jihad
 */
class DemandeMotdepasseForm extends BaseUtilisateurForm
{

  public function configure()
  {
    $this->useFields(array('email'));
    
    $this->setWidgets(array(
      'email'        => new sfWidgetFormInputEmail()
    ));

    $this->disableCSRFProtection();
    
    $this->validatorSchema['email'] = new sfValidatorEmail(array('max_length' => 255, 'required' => true),
                                                            array('required' => libelle('msg_form_error_champ_obligatoire'),
                                                                  'invalid' => libelle('msg_form_error_champ_email_invalide')));
    
    $this->widgetSchema['email']->setLabel(libelle("msg_utilisateur_libelle_email"));

    // validateur de mail 
    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'checkMail'))));

    $this->widgetSchema->setNameFormat('demande_mot_de_passe[%s]');

    parent::configure();

  }

  /**
   * Permet de valider si l'adresse mail existe ou pas
   * @param object $validator
   * @param string[] $values
   * @return string[]
   */
  public function checkMail($validator, $values)
  {

    if ($values['email'] != "")
    {
      $objUtilisateur = UtilisateurTable::getInstance()->getUtilisateurParMail($values['email']);

      if (!$objUtilisateur || !$objUtilisateur->getEstActif())
      {
        $error = new sfValidatorError($validator, libelle('msg_utilisateur_reinit_email_inconnu'));
        // throw an error bound to the val field
        throw new sfValidatorErrorSchema($validator, array('email' => $error));
      }
    }
    
    return $values;
  }
}
