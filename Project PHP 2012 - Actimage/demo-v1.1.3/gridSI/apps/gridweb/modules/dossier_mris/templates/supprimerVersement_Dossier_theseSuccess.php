<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<p><?php echo libelle("msg_versement_confirmation"); ?></p>
<p><?php echo libelle("msg_versement_confirmation_suppression"); ?></p>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_confirmer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/modifierFinancement_Dossier_these?dossier_id=" . $idContenant, array("class" => "picto bt_retour")); ?>
  </div>
</form>