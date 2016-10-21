<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossier)); ?>


<?php echo libelle("msg_remarque_bpi_confirmation_suppression"); ?>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_supprimer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerRemarque_bpis?".$strContenant."=".$idContenant, array("class" => "picto bt_retour")); ?>
  </div>
</form>