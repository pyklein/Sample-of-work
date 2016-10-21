
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objEngagement->getDossier_mip())); ?>

<p><?php echo libelle("msg_dossier_mip_engagement_confiermer_suppression", array($objEngagement)); ?></p>
<p><?php echo libelle("msg_evenement_confirmation_suppression");?></p>

<form method="post" action="<?php echo url_for('dossier_mip/supprimerEngagementDossier_mip?engagement_id='.$objEngagement->getId())?>">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_supprimer"); ?>">
  </div>
</form>

<div class="left">
    <?php echo link_to(libelle("msg_dossier_mip_engagement_bouton_retour"),"dossier_mip/listerEngagementDossier_mips?dossier_mip=".$objEngagement->getDossier_mip()->getId(),array("class" => "picto bt_retour")); ?>
</div>