
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objFinancement->getDossier_mip())); ?>

<p><?php echo libelle("msg_dossier_mip_financement_confiermer_suppression", array($objFinancement)); ?></p>
<p><?php echo libelle("msg_evenement_confirmation_suppression");?></p>

<form method="post" action="<?php echo url_for('dossier_mip/supprimerFinancementDossier_mip?financement_id='.$objFinancement->getId())?>">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_supprimer"); ?>">
  </div>
</form>

<div class="left">
    <?php echo link_to(libelle("msg_dossier_mip_financement_bouton_retour"),"dossier_mip/listerFinancementDossier_mips?dossier_mip=".$objFinancement->getDossier_mip()->getId(),array("class" => "picto bt_retour")); ?>
</div>