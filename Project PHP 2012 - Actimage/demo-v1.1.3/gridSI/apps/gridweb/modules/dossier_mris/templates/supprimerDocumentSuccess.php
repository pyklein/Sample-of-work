<!-- Page de confirmation lors de la suppression d'un document -->

<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objContenant)) ?>


<?php echo libelle("msg_document_mip_confirmation_suppression",array($objDocument->getEstJoint() ? $objDocument->getFichierOrig() : $objDocument->getFichier())); ?>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_supprimer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerDocuments?".$strModelContenant."=" .$strIdContenant, array("class" => "picto bt_retour")); ?>
  </div>
</form>
