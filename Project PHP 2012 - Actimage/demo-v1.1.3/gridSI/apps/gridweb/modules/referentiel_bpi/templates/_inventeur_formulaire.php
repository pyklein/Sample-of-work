
<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_identite") ?>
  </legend>

  <?php echo $objForm["civilite_id"]->renderRow(); ?>
  <?php echo $objForm["nom"]->renderRow(); ?>
  <?php echo $objForm["prenom"]->renderRow(); ?>

</fieldset>

<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_informations_personnelles") ?>
  </legend>

  <?php echo $objForm["date_naissance"]->renderRow(); ?>
  <?php echo $objForm["date_retraite"]->renderRow(); ?>
  <?php echo $objForm["date_deces"]->renderRow(); ?>

</fieldset>

<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_situation_coordonnes_professionnelles") ?>
  </legend>

  <?php echo $objForm["email"]->renderRow(); ?>
  <?php echo $objForm["email2"]->renderRow(); ?>

  <?php if ($objForm->getObject()->getEstExterieur()) { ?>
    <?php echo $objForm["organisme_id"]->renderRow(); ?>
    <?php echo $objForm["service_id"]->renderRow(); ?>
  <?php } else { ?>
    <?php echo $objForm["organisme_mindef_id"]->renderRow(); ?>
    <?php echo $objForm["entite_id"]->renderRow(); ?>
    <?php echo $objForm["grade_id"]->renderRow(); ?>
  <?php } ?>

  <?php echo $objForm["telephone_fixe"]->renderRow(); ?>
  <?php echo $objForm["telephone_mobile"]->renderRow(); ?>
  <?php echo $objForm["telephone_autre"]->renderRow(); ?>
  <?php echo $objForm["fax"]->renderRow(); ?>

</fieldset>

<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_coordonnes_personnelles") ?>
  </legend>

  <?php echo $objForm["email_perso"]->renderRow(); ?>
  <?php echo $objForm["adresse_perso"]->renderRow(); ?>
  <?php echo $objForm["adresse_perso2"]->renderRow(); ?>
  <?php echo $objForm["adresse_perso3"]->renderRow(); ?>
  <?php echo $objForm["code_postal_perso"]->renderRow(); ?>
  <?php echo $objForm['ville_id']->renderLabel()." : " ?>
  <?php echo $objForm['ville_id']->renderError() ?>
  <?php echo $objForm['ville_id']->render(array('class' => 'ville')) ?>
  <?php echo $objForm['complement_adresse_perso']->renderLabel()." : " ?>
  <?php echo $objForm['complement_adresse_perso']->renderError() ?>
  <?php echo $objForm['complement_adresse_perso']->render(array('class' => 'complement')) ?>
  <?php echo $objForm["telephone_fixe_perso"]->renderRow(); ?>
  <?php echo $objForm["telephone_mobile_perso"]->renderRow(); ?>

</fieldset>

<script type='text/javascript'>
  hideOtherOptionsOnSelectValue('<?php echo $objForm["organisme_mindef_id"]->renderId(); ?>', '<?php echo $objForm["entite_id"]->renderId(); ?>');
  hideOtherOptionGroupsOnSelectValue('<?php echo $objForm["organisme_mindef_id"]->renderId(); ?>', '<?php echo $objForm["grade_id"]->renderId(); ?>');
  hideOtherOptionGroupsOnSelectValue('<?php echo $objForm["organisme_id"]->renderId(); ?>', '<?php echo $objForm["service_id"]->renderId(); ?>');
</script>
