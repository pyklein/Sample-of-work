<?php use_helper("Message"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objContenant)); ?>

<?php echo message(); ?>

<form action="" method="post">
  <fieldset>
    <legend>
      <?php echo libelle("msg_module_dossier_mip_action_modifierbudget") ?>
    </legend>
    <?php echo $objForm; ?>
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_modifier"); ?>" />
    </div>
  </fieldset>
</form>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/suiviFinancierDossier_mips?dossier_mip=".$idContenant, array("class" => "picto bt_retour")); ?>
</div>
