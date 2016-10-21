<?php use_helper("Message"); ?>
<?php echo message(); ?>

<fieldset>
  <legend>
    <?php echo libelle('msg_module_referentiel_mris_action_creerconvention_organisme'); ?>
  </legend>

  <form action="<?php echo url_for('referentiel_mris/creerConvention_organisme') ?>" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php include_partial('convention_organismeForm', array('objForm' => $objForm)) ?>

    <div class="boutons">
      <input type="submit" value="<?php echo libelle('msg_bouton_ajouter'); ?>" />
    </div>
  </form>
</fieldset>

<?php echo link_to_grid(libelle("msg_convention_bouton_retour"),'referentiel_mris/listerConvention_organismes', array('class'=>'picto bt_retour'))  ?>
