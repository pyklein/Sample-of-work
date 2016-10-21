<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Format");
/**
 * Form pour la gestion du calendrier pour un dossier MIP
 *
 * @package    gridSI
 * @subpackage form
 * @author     Actimage
 */
class Gestion_calendrierForm extends BaseDossier_mipForm {

  public function configure()
  {

    $this->useFields(array());

    //on imbrique les formulaires
    $this->embedRelation('Rendez_vous');
    $this->embedRelation('Echeance');
    $this->embedRelation('Avis_etatmajor');
    $this->embedRelation('Remise_documents');
    $this->embedRelation('Soutien');
    $this->embedRelation('Transfert_cloture');

    $this->widgetSchema->setNameFormat('gestion_calendrier[%s]');

    $this->disableLocalCSRFProtection();

  }

 /**
 * formatage de la date FR (jj/mm/aaaa) vers une date format Anglais (aaaa/mm/jj) pour insertion dans BDD
 * Si la date est mal formatée la fonction renvoie NULL
 *
 * @return     Date format (aaaa/mm/jj)
 * @author     Actimage
 */
  protected function formatDateFrEn($inputDate){

    if(preg_match('#^\d{2}/\d{2}/\d{4}$#',$inputDate)){
      list($day, $month, $year) = explode('/', $inputDate);

      $formattedDate = $year.'-'.$month.'-'.$day ;

      return $formattedDate ;

    }else{
      return null;
    }
  }

  public function  bind(array $taintedValues = null, array $taintedFiles = null) {

    //gestion de la destination transfert du formulaire "transfert/clôture"
    //si le selectBox est = "autre" alors on transfert la valeur de "destination_autre_autre" vers "destination_autre"
   /* if($taintedValues['Transfert_cloture']['destination_autre'] == 'Autre'){
      $taintedValues['Transfert_cloture']['destination_autre'] = $taintedValues['Transfert_cloture']['destination_autre_autre'];
    }*/

    //fusion de la date et de l'heure pour le champ "date_rdv"
    //formattage de la date format FR vers le format EN
    $formattedDate = $this->formatDateFrEn($taintedValues['Rendez_vous']['date_rdv_date']);
    //si la formattedDate n'est pas null alors on fusionne les 2 : date + heure 
    if($formattedDate != null){
      $formattedDate = $formattedDate. " " .$taintedValues['Rendez_vous']['date_rdv_heure'];
      $taintedValues['Rendez_vous']['date_rdv'] = $formattedDate ;
    }

    //on remplit les champs pour ajouter le dossierId
    $dossierId = sfContext::getInstance()->getRequest()->getParameter('id');
    $taintedValues['Rendez_vous']['dossier_mip_id'] = $dossierId ;
    $taintedValues['Echeance']['dossier_mip_id'] = $dossierId ;
    $taintedValues['Avis_etatmajor']['dossier_mip_id'] = $dossierId ;
    $taintedValues['Remise_documents']['dossier_mip_id'] = $dossierId ;
    $taintedValues['Soutien']['dossier_mip_id'] = $dossierId ;
    $taintedValues['Transfert_cloture']['dossier_mip_id'] = $dossierId ;

    parent::bind($taintedValues, $taintedFiles);
  }

}
?>
