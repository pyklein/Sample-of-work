<?php

/**
 * Pré-creation formulaire de l'inventeur
 * @author Gabor JAGER
 */
class InventeurPreCreerForm extends BaseInventeurForm
{
  public function configure()
  {
    $this->useFields(array('nom', 'est_exterieur'));

    // nom
    $this->widgetSchema['nom']->setLabel(libelle("msg_libelle_nom"));
    $this->validatorSchema['nom']->setMessage('required', libelle('msg_form_error_champ_obligatoire'));
    $this->validatorSchema['nom']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    $this->widgetSchema['est_exterieur'] = new gridWidgetFormChoiceRadioAligne(array(
                                                'choices' => $this->getProfilsChoix()));
    $this->widgetSchema['est_exterieur']->setLabel(libelle("msg_libelle_profil"));
    $this->validatorSchema['est_exterieur'] = new sfValidatorChoice(array('choices' => array_keys($this->getProfilsChoix()),
                                                                          'required' => true),
                                                                    array('required'=> libelle('msg_form_error_champ_obligatoire'),
                                                                          'invalid'=> libelle('msg_form_error_champ_invalide')));

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  /**
   * Permet de recuperer le tableau de choix des profils
   * @return array
   * @author Gabor JAGER
   */
  private function getProfilsChoix()
  {
    $arrRetour = array();
    $arrRetour[0] = libelle("msg_libelle_inventeur_mindef");
    $arrRetour[1] = libelle("msg_libelle_coinventeur_exterieur");

    return $arrRetour;
  }
}
