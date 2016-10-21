<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>


<?php use_helper("Message"); ?>
<?php echo message(); ?>


<form action="" method="post">
  <fieldset>
    <legend>
      <?php echo libelle("msg_module_dossier_bpi_action_modifieraction") ?>
    </legend>
    <?php echo $objForm; ?>
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer"); ?>" />
    </div>
  </fieldset>
</form>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_annuler"), "dossier_bpi/actionsDossiers?".$strContenant."=".$idContenant, array("class" => "picto bt_retour")); ?>
</div>