<?php use_helper("Message"); ?>

<?php echo message(); ?>

<!--Initialisation de variables-->
<?php $strStatutDossierTable = "Statut_".  strtolower($strModelContenant)."Table";?>

<div class="reduit">
  <!-- Cas où le statut est "Proposition" -->
  <?php if($objDossier['statut_'.strtolower($strModelContenant).'_id'] == $strStatutDossierTable::PROPOSITION ): ?>
    <p><?php echo libelle("msg_libelle_titre_dossier",array($objDossier->getTitre())) ?></p>
    <p><?php echo libelle("msg_libelle_objet_dossier",array($objDossier->getRaw('objet')))  ?></p>
    <p><?php echo libelle("msg_libelle_etudiant_dossier",array($objDossier->getEtudiant()->getNom(),$objDossier->getEtudiant()->getPrenom()))  ?></p>

    <p class="underline"><?php echo libelle("msg_libelle_action_proposition") ?></p>
    <p><?php echo link_to(libelle("msg_libelle_valider_proposition"),"dossier_mris/validerProposition?".strtolower($strModelContenant)."=" . $objDossier->getId(),array("class" => "picto bt_valider")) ?></p>
    <p><?php echo link_to(libelle("msg_libelle_refuser_proposition"),"dossier_mris/refuserProposition?".strtolower($strModelContenant)."=" . $objDossier->getId(),array("class" => "picto bt_refuser"))  ?></p>
    <p><?php echo link_to(libelle("msg_libelle_attente_proposition"),"dossier_mris/miseEnAttenteProposition?".strtolower($strModelContenant)."=" . $objDossier->getId(),array("class" => "picto bt_attente")) ?></p>
  <?php endif; ?>

  <!-- Cas où le statut est "Validé" -->
  <?php if($objDossier['statut_'.strtolower($strModelContenant).'_id'] == $strStatutDossierTable::VALIDE ): ?>
    <p><?php echo libelle("msg_message_dossier_valider",array($objDossier->getNumeroAAfficher(),$objDossier->getTitre()) ) ?></p>
    <p class="underline"><?php echo libelle("msg_libelle_documents_telechargeables") ?></p>
      <p><?php echo link_to(libelle("msg_libelle_lettre_notification"),"dossier_mris/genererDocumentsValidationDossier?id=".$objDossier->getId()."&type=".$objDossier->getTypeDossier()."&acceptation=true",array("class" => "picto bt_telecharger"))?></p>
    <p><?php echo link_to(libelle("msg_libelle_attestation"),"dossier_mris/genererDocumentsValidationDossier?id=".$objDossier->getId()."&type=".$objDossier->getTypeDossier()."&attestation=true",array("class" => "picto bt_telecharger")) ?>
  <?php endif; ?>

  <!-- Cas où le statut est "Refusé" -->
  <?php if($objDossier['statut_'.strtolower($strModelContenant).'_id'] == $strStatutDossierTable::REFUSE): ?>
    <p><?php echo libelle("msg_message_dossier_refuser",array($objDossier->getNumeroAAfficher(),$objDossier->getTitre()) ) ?></p>

    <p class="underline"><?php echo libelle("msg_libelle_documents_telechargeables") ?></p>
    <p><?php echo link_to(libelle("msg_libelle_lettre_notification"),"dossier_mris/genererDocumentsValidationDossier?id=".$objDossier->getId()."&type=".$objDossier->getTypeDossier()."&refus=true",array("class" => "picto bt_telecharger")) ?></p>
    <br>
    <p class="underline"><?php echo libelle("msg_libelle_action_proposition") ?></p>
    <p><?php echo link_to(libelle("msg_libelle_valider_proposition"),"dossier_mris/validerProposition?".strtolower($strModelContenant)."=" . $objDossier->getId(),array("class" => "picto bt_valider")) ?>
  <?php endif; ?>

  <!-- Cas où le statut est "Mis en attente" -->
  <?php if($objDossier['statut_'.strtolower($strModelContenant).'_id'] == $strStatutDossierTable::MIS_EN_ATTENTE): ?>
    <p><?php echo libelle("msg_message_dossier_attente",array($objDossier->getNumeroAAfficher(),$objDossier->getTitre()) ) ?></p>
      <form method="post" action="">
        <?php echo $objForm['classement']->renderRow(); ?>
        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_modifier"); ?>">
        </div>
      </form>

    <p class="underline"><?php echo libelle("msg_libelle_documents_telechargeables") ?></p>
    <p><?php echo link_to(libelle("msg_libelle_lettre_notification"),"dossier_mris/genererDocumentsValidationDossier?id=".$objDossier->getId()."&type=".$objDossier->getTypeDossier()."&attente=true",array("class" => "picto bt_telecharger"))?></p>
    <br>

    <p class="underline"><?php echo libelle("msg_libelle_action_proposition") ?></p>
    <p><?php echo link_to(libelle("msg_libelle_valider_proposition"),"dossier_mris/validerProposition?".strtolower($strModelContenant)."=" . $objDossier->getId(),array("class" => "picto bt_valider")) ?></p>
    <p><?php echo link_to(libelle("msg_libelle_refuser_proposition"),"dossier_mris/refuserProposition?".strtolower($strModelContenant)."=" . $objDossier->getId(),array("class" => "picto bt_refuser"))  ?></p>
  <?php endif; ?>

</div>
<?php include_partial('autreActionsMris',array('strNomModel' => $strModelContenant,'id' => $objDossier->getId())) ?>

<hr class="clear">
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/lister".$strModelContenant."s", array("class" => "picto bt_retour")); ?>
</div>