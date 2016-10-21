<?php use_helper("Message"); ?>
<?php echo message(); ?>


<div id="titre_evaluation_dossier">
  <?php echo libelle("msg_libelle_evaluation_dossier_numero", array($objDossier->getNumeroAAfficher())); ?>
</div>
<br />
<div class="sous_titre_evaluation_dossier">
  <?php echo libelle("msg_libelle_titre_dossier", array($objDossier->getTitre())); ?>
</div>
<div class="sous_titre_evaluation_dossier">
  <?php echo libelle("msg_libelle_objet_dossier", array($objDossier->getRaw('objet'))); ?>
</div>
<div class="sous_titre_evaluation_dossier">
  <?php echo libelle("msg_libelle_etudiant", array($objDossier->getEtudiant())); ?>
</div>
<br />

<?php
if($boolListeCommission){
  include_partial('dossier_mris/onglet_evaluation_dossiers', array('strListe'=> 'liste_commission' ,'strModelContenant' => strtolower($strModelContenant),  'strId' => $strId, 'ongletActif' => 2)) ;
}else if($boolListeDossier){
  include_partial('dossier_mris/onglet_evaluation_dossiers', array('strListe'=> 'liste_dossier', 'strModelContenant' => strtolower($strModelContenant),  'strId' => $strId, 'ongletActif' => 2)) ;
}
?>
<div>
  <div id="zone_cadre" class="reduit">
    <?php if(isset($commissionId)):?>
    <?php  if($boolInvitationExiste){ ?>
    <form action="" method="post" >
      <?php
     
        foreach($arrInvitations as $invitation){
         if($invitation->getServiceId() != null) echo libelle("msg_libelle_notes_evaluation_pour", array($invitation->getService()->getIntitule(), $invitation->getService()->getOrganisme()->getIntitule()));
         if($invitation->getLaboratoireId() != null) echo libelle("msg_libelle_notes_evaluation_pour", array($invitation->getLaboratoire()->getIntitule(), $invitation->getLaboratoire()->getOrganisme()->getIntitule()));

         foreach($arrNotes as $note){
           echo $objForm['Invitation'.$invitation->getId()]['Evaluation'.$note->getId()]['valeur_note_id']->renderRow() ;
         }
         echo $objForm['Invitation'.$invitation->getId()]['valeur_note_id']->renderRow() ;
        }
      ?>
      <?php if(!$boolListeDossier):?>
        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_revenir_dosssier"); ?>" name="enregistrer_retour"/>
          <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_passer_dossier_suivant"); ?>" name="enregistrer_suivant"/>
        </div>
      <?php else:?>
        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer"); ?>" name="enregistrer"/>
        </div>
      <?php endif;?>

    </form>
    <?php }else{  echo libelle("msg_evaluation_commission_aucune_invitation"); } ?>
    <?php else:
      {
        echo libelle("msg_libelle_aucune_commission_selection");
      }
    ?>
    <?php endif;?>

  </div>

  <?php include_partial('autreActionsMris',array('strNomModel'=> $strModelContenant, 'id' => $strId, 'boolEstDansEvaluation' => true)) ?>
</div>
<hr class="clear"/>
<div class="left">
    <?php if(!$boolListeDossier && isset($commissionId)){
      echo link_to(libelle("msg_bouton_retour_dossier"), "dossier_mris/listerDossiersCommission?id=".$commissionId."&proposition=true", array("class" => "picto bt_retour"));
    }else{
      echo link_to(libelle("msg_bouton_retour_dossier"), "dossier_mris/lister".$strModelContenant."s", array("class" => "picto bt_retour"));
    }
    ?>
  </div>