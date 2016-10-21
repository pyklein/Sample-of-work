<?php use_helper("Message"); ?>

<?php echo message(); ?>

<p><?php echo libelle("msg_message_confirmation_validation",array($objDossier->getNumeroAAfficher(),$objDossier->getTitre())) ?></p>
<p><?php echo libelle("msg_message_operation_irreversible") ?></p>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_confirmer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_annuler"), "dossier_mris/validerDossier?".strtolower($strModelContenant)."=".$strIdContenant, array("class" => "picto bt_retour")); ?>
  </div>
</form>

