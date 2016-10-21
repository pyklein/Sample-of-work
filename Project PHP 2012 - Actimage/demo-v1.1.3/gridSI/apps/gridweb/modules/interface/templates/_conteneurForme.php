<?php use_helper("Message"); ?>
<?php echo message(); ?>
<?php
if (isset($strContenant)) {
  $strRedirection = "?" . $strContenant . "=" . $idContenant;
} else {
  $strRedirection = "";
}
?>


<form action="" method="post">
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
  <?php echo link_to(libelle("msg_bouton_retourner"), $strModule . "/lister" . $model . "s" . $strRedirection, array("class" => "picto bt_retour")); ?>
</div>