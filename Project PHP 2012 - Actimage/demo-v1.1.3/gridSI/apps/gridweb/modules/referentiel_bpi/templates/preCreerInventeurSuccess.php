<?php use_helper("Message"); ?>
<?php echo message(); ?>

<form action="" method="post">
  <fieldset>
    <legend>
      <?php echo libelle("msg_module_referentiel_bpi_action_precreerinventeur") ?>
    </legend>

    <?php echo $objForm['nom']->renderRow(); ?>
    <?php echo $objForm['est_exterieur']->renderLabel();?>&nbsp;:
    <?php echo $objForm['est_exterieur']->render();?>

    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_creer"); ?>" />
    </div>
  </fieldset>
</form>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "referentiel_bpi/listerInventeurs", array("class" => "picto bt_retour")); ?>
</div>
