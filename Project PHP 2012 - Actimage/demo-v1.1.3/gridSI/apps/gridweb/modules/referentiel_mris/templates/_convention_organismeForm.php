<?php use_stylesheets_for_form($objForm) ?>
<?php use_javascripts_for_form($objForm) ?>
<?php use_helper("Message"); ?>
<?php echo message();?>


  <?php if (!$objForm->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="post" />
  <?php endif; ?>

  <fieldset>
    <legend>
      <?php echo libelle('msg_convention_fieldset_description'); ?>
    </legend>

    <?php echo $objForm['numero_convention']->renderRow(); ?>
    <?php echo $objForm['type_convention_organisme_id']->renderRow(); ?>
    <?php echo $objForm['organisme_id']->renderRow(); ?>
    <?php echo $objForm['montant']->renderRow(); ?>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_reperes_temporels'); ?>
    </legend>

    <?php echo $objForm['date_signature']->renderRow(); ?>
    <?php echo $objForm['date_notification']->renderRow(); ?>
    <?php echo $objForm['date_prise_effet']->renderRow(); ?>
    <?php echo $objForm['date_fin_effet']->renderRow(); ?>
    <?php echo $objForm['date_archivage']->renderRow(); ?>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle('msg_convention_fieldset_convention'); ?>
    </legend>

    <?php echo $objForm['fichier']->renderRow(); ?>
  </fieldset>
