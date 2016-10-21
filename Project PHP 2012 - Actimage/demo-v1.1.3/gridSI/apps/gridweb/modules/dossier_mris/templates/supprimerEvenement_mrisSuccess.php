<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<p><?php echo libelle("msg_evenement_mris_confirmation_suppression"); ?></p>
<p><?php echo libelle("msg_evenement_confirmation_suppression"); ?></p>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_confirmer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerEvenement_mris?".$strContenant."=".$idContenant, array("class" => "picto bt_retour")); ?>
  </div>
</form>