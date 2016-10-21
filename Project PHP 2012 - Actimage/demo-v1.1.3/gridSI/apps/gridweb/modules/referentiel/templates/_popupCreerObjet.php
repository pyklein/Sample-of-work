<?php use_helper("Message"); ?>
<?php echo message(); ?>

<div class="popup">
  <form action="" method="post" id="<?php echo $model ?>">
    <fieldset>
      <legend>
        <?php echo libelle("msg_module_".$strModule."_action_".$action.strtolower($model)) ?>
      </legend>
      <?php echo $objForm; ?>
      <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_" . $action); ?>" />
      </div>
    </fieldset>
  </form>

  <div class="left">
    <?php echo link_to_grid_retour(libelle("msg_bouton_retourner"), array('class' => 'picto bt_retour')); ?>
  </div>
</div>
