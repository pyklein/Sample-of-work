<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objContenant)); ?>

<!-- Page de confirmation lors de la suppression d'un document -->
<?php echo libelle("msg_document_bpi_confirmation_suppression",array($objDocument->getFichier())); ?>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_supprimer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerDocuments_bpis?dossier_bpi=" .$idContenant, array("class" => "picto bt_retour")); ?>
  </div>
</form>
