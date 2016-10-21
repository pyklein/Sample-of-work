<?php use_helper("Message"); ?>
<?php echo message(); ?>

<form action="" method="post">

  <?php include_partial("inventeur_formulaire", array("objForm" => $objForm)); ?>

  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_modifier"); ?>" />
  </div>

</form>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "referentiel_bpi/listerInventeurs", array("class" => "picto bt_retour")); ?>
</div>
