
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossierMip)); ?>

<?php echo libelle("msg_remarque_mip_confirmation_suppression"); ?>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_supprimer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/listerRemarque_mips?dossier_mip=".$idContenant, array("class" => "picto bt_retour")); ?>
  </div>
</form>