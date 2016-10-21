<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<p><?php echo libelle("msg_action_bpi_confirmation_suppression"); ?></p>
<p><?php echo libelle("msg_action_bpi_confirmer_suppression"); ?></p>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_confirmer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_annuler"), "dossier_bpi/actionsDossiers?dossier_bpi=".$idContenant, array("class" => "picto bt_retour")); ?>
  </div>
</form>