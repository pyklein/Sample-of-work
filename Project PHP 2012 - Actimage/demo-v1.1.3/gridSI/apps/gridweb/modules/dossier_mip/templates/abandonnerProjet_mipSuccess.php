<!-- Page de confirmation lors de l'abandon d'un Projet -->

<?php echo libelle("msg_dossier_mip_confirmation_abandon",array($objDossier->getTitre())); ?>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_abandonner"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/modifierDossier_mip?id=" .$objDossier->getId(), array("class" => "picto bt_retour")); ?>
  </div>
</form>
