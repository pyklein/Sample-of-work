<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<p><?php echo libelle("msg_suivi_postdoc_confirmation_suppression",array($objSuivi->getType_suivi_postdoc() , $objSuivi->getDescriptif())); ?></p>
<p><?php echo libelle("msg_suivi_postdoc_confirmer"); ?></p>

<form method="post" action="">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_confirmer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerSuivi_".$strModelContenant."s?".  strtolower($strModelContenant)."_id=".$idContenant, array("class" => "picto bt_retour")); ?>
  </div>
</form>