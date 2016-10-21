<?php use_helper("Message"); ?>
<?php echo message(); ?>

<form action="<?php echo url_for('referentiel_mris/modifierConvention_organisme?id='.$objForm->getObject()->getId()) ?>" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php include_partial('convention_organismeForm', array('objForm' => $objForm)) ?>

  <div class="boutons">
    <input type="submit" value="<?php echo libelle('msg_bouton_enregistrer'); ?>" />
  </div>
</form>

<?php echo link_to_grid(libelle("msg_convention_bouton_retour"),'referentiel_mris/listerConvention_organismes', array('class'=>'picto bt_retour'))  ?>
