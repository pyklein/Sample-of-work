<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php echo libelle("msg_remarque_mris_confirmation_suppression",array($objRemarque->getRaw('contenu'))); ?>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_supprimer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerRemarque_mris?".$strContenant."=".$idContenant, array("class" => "picto bt_retour")); ?>
  </div>
</form>