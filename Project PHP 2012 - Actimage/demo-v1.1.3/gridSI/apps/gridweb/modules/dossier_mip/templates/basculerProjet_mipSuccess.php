<!-- Page de confirmation lors de la bascule d'un Projet -->

<?php echo libelle("msg_dossier_mip_confirmation_bascule",array($objDossier->getTitre())); ?>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_basculer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/modifierDossier_mip?id=" .$objDossier->getId(), array("class" => "picto bt_retour")); ?>
  </div>
</form>
