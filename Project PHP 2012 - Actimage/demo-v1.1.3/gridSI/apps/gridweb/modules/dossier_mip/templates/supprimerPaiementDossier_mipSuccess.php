
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objPaiement->getDossier_mip())); ?>

<p><?php echo libelle("msg_dossier_mip_paiement_confiermer_suppression", array($objPaiement)); ?></p>
<p><?php echo libelle("msg_evenement_confirmation_suppression");?></p>

<form method="post" action="<?php echo url_for('dossier_mip/supprimerPaiementDossier_mip?paiement_id='.$objPaiement->getId())?>">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_supprimer"); ?>">
  </div>
</form>

<div class="left">
    <?php echo link_to(libelle("msg_dossier_mip_paiement_bouton_retour"),"dossier_mip/listerPaiementDossier_mips?dossier_mip=".$objPaiement->getDossier_mip()->getId(),array("class" => "picto bt_retour")); ?>
</div>