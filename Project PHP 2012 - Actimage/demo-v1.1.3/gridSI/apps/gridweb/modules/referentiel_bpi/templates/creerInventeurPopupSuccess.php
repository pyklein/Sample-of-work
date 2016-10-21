<?php use_helper("Message"); ?>
<?php echo message(); ?>

<form action="" method="post">

  <?php include_partial("inventeur_formulaire", array("objForm" => $objForm)); ?>

  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_creer"); ?>" />
  </div>

</form>

<div class="left">
    <?php echo link_to_grid_retour(libelle("msg_bouton_retourner"), array('class' => 'picto bt_retour')); ?>
</div>
