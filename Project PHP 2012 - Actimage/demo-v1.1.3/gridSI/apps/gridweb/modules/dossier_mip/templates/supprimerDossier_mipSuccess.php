<?php echo libelle("msg_dossier_mip_confirmation_suppression", array($objDossierMip->getNumero())); ?>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_supprimer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/listerDossier_mips", array("class" => "picto bt_retour")); ?>
  </div>
</form>