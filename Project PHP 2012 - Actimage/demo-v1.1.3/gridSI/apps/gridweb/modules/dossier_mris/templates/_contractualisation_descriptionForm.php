<?php use_stylesheets_for_form($objForm) ?>

<?php if(!$conventionCollective): ?>
  <fieldset>
    <legend>
      <?php echo libelle('msg_convention_fieldset_description'); ?>
    </legend>

    <?php echo $objForm['numero_convention']->renderRow(); ?>
    <?php echo $objForm['type_convention_organisme_id']->renderRow(); ?>
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

<?php endif; ?>


<?php if($conventionCollective): ?>

<p>
  <?php echo libelle("msg_contractualisation_convention_collective_description", array($objDossier->getOrganisme(), $objDossier)); ?>
</p>

<p>
  <?php echo link_to_grid( libelle("msg_libelle_modifier_convention_collective"), "referentiel_mris/modifierConvention_organisme?id=".$objForm->getObject()->getId(),  array("class" => "picto bt_modifier")); ?>
  <?php
  if($objForm->getObject()->getFichier()){
    echo " - ".link_to_grid( libelle("msg_libelle_telecharger_convention_signee"), "referentiel_mris/telechargerConvention_organisme?id=".$objForm->getObject()->getId(), array("class" => "picto bt_telecharger"));
  }
  ?>
</p>
  <fieldset>
    <legend>
      <?php echo libelle('msg_convention_fieldset_description'); ?>
    </legend>

    <?php echo $objForm['numero_convention']->renderRow(array("disabled" => true)); ?>
    <?php echo $objForm['type_convention_organisme_id']->renderRow(array("disabled" => true)); ?>
    <?php echo $objForm['organisme_id']->renderRow(array("disabled" => true)); ?>
    <?php echo $objForm['montant']->renderRow(array("disabled" => true)); ?>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_reperes_temporels'); ?>
    </legend>

    <?php echo $objForm['date_signature']->renderRow(array("disabled" => true)); ?>
    <?php echo $objForm['date_notification']->renderRow(array("disabled" => true)); ?>
    <?php echo $objForm['date_prise_effet']->renderRow(array("disabled" => true)); ?>
    <?php echo $objForm['date_fin_effet']->renderRow(array("disabled" => true)); ?>
    <?php echo $objForm['date_archivage']->renderRow(array("disabled" => true)); ?>
  </fieldset>
<?php endif; ?>