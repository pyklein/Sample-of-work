<?php

/**
 * Transfert_cloture form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Actimage
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Transfert_clotureForm extends BaseTransfert_clotureForm {

  public function configure() {

   $this->useFields(array(
       'date_transfert',
       'date_cloture',
       'reference_transfert',
       'reference_cloture',
       'destination_autre'
   ));

    $this->widgetSchema['date_transfert'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_cloture'] = new sfWidgetFormInputJQueryDate();
    //on ajoute le champ "destination_autre_autre" pour le selectbox "destination_autre"
    $this->widgetSchema['destination_autre_autre'] = new sfWidgetFormInputText(array(), array("class" => "autre"));

    //on récupère le dossier MIP en fonction de l'id de l'URL
    $dossierMipId = sfContext::getInstance()->getRequest()->getParameter('id');
    $objDossierMip = Dossier_mipTable::getInstance()->findOneById($dossierMipId);

    //get de l'organisme MINDEF du dossier MIP
    $objOrgMindef = Organisme_mindefTable::getInstance()->findOneById($objDossierMip->getOrganismeMindefId());
    //recup des entités
    $arrEntites = $objOrgMindef->getEntitesOrgMindef($objOrgMindef->getId());

    //on verifie qu'il existe des entités pour cet organisme Mindef
    if(count($arrEntites) != 0){
      foreach ($arrEntites as $entite) {
        $arrChoicesDest[$entite->getNomHierarchique()] = $entite->getNomHierarchique();
      }
    

      //si la valeur du champ destination_autre existe dans le tableau des entités,
      //alors le champ texte "destination_autre_autre" sera vide
      //sinon on le remplit avec la valeur du champ "destination_autre" et on met le selectBox sur "autre"
      if (array_key_exists($this->getObject()->getDestinationAutre(), $arrChoicesDest)) {
        $arrChoicesDest["Autre"] = libelle('msg_libelle_autre');
        $arrChoicesDest[""] = libelle('msg_libelle_aucun');
      } else {
        $arrAucun = array("" => libelle('msg_libelle_aucun'));
        $arrAutre = array("Autre" => libelle('msg_libelle_autre'));
        $arrChoicesDest = $arrAutre + $arrAucun + $arrChoicesDest;
        $this->widgetSchema['destination_autre_autre']->setAttribute('value', $this->getObject()->getDestinationAutre());
      }

    }else{
      //si il n'y a pas d'entités on remplit le selectBox avec "autre" et "aucun"
      $arrChoicesDest[""] = libelle('msg_libelle_aucun');
      $arrChoicesDest["Autre"] = libelle('msg_libelle_autre');
    }


    $this->widgetSchema['destination_autre'] = new sfWidgetFormChoice(
                    array(
                        'choices' => $arrChoicesDest,
                        'expanded' => false,
                    ),
                    array(
                        'class' => 'autre'
                    )
    );


    //set des validators
    $this->setValidator('date_transfert',
            new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                'with_time' => false,
                'required' => false,
                    ),
                    array('bad_format' => libelle('msg_gestion_calendrier_bad_format'))
            )
    );


    $this->setValidator('date_cloture',
            new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                'with_time' => false,
                'required' => false,
                    ),
                    array('bad_format' => libelle('msg_gestion_calendrier_bad_format'))
            )
    );


    //set des labels
    $this->widgetSchema->setLabels(array(
        'date_transfert' => libelle('msg_gestion_calendrier_transfert_date_transfert'),
        'reference_transfert' => libelle('msg_gestion_calendrier_transfert_ref_transfert'),
        'destination_autre' => libelle('msg_gestion_calendrier_transfert_dest_autre'),
        'destination_autre_autre' => libelle('msg_gestion_calendrier_transfert_dest_autre_autre'),
        'date_cloture' => libelle('msg_gestion_calendrier_transfert_date_cloture'),
        'reference_cloture' => libelle('msg_gestion_calendrier_transfert_ref_cloture')
    ));

    $this->validatorSchema->setOption('allow_extra_fields', true);

//    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'checkDestinationAutre'))));

    $this->disableLocalCSRFProtection();

    parent::configure();
  }

  /**
   * Permet de vérifier que le selectBox "destination_autre" = autre lorsqu'on entre quelquechose dans "destination_autre_autre"
   * @param object $validator
   * @param string[] $values
   * @return string[]
   */
  public function checkDestinationAutre($validator, $values, $arguments) {
//    var_dump($values);
//    die();
    if ($values['destination_autre_autre'] != "" && $values['destination_autre'] != "Autre") {
      $error = new sfValidatorError($validator, libelle('msg_gestion_calendrier_destination_autre_autre_erreur'));
      // throw an error bound to the val field
      throw new sfValidatorErrorSchema($validator, array('destination_autre_autre' => $error));
    }

    return $values;
  }

}
