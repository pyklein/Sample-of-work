
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossierMip)); ?>

<p><?php echo libelle("msg_budget_confirmation_suppression", array($objBudget)); ?></p>
<p><?php echo libelle("msg_evenement_confirmation_suppression");?></p>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_supprimer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/suiviFinancierDossier_mips?dossier_mip=".$idContenant, array("class" => "picto bt_retour")); ?>
  </div>
</form>