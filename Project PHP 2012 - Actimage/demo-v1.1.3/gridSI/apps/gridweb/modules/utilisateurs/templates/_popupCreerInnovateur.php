<?php use_javascripts_for_form($objForm) ?>
<?php use_helper("Message"); ?>
<?php echo message(); ?>
<?php
if (isset($strContenant)) {
  $strRedirection = "?" . $strContenant . "=" . $idContenant;
} else {
  $strRedirection = "";
}
?>

<div class="popup">
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

    <script type='text/javascript'>
      hideOtherOptionsOnSelectValue('<?php echo $objForm["organisme_mindef_id"]->renderId(); ?>', '<?php echo $objForm["entite_id"]->renderId(); ?>');
    </script>

  </form>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), $strRedirectionComplete . $strRedirection, array("class" => "picto bt_retour")); ?>
  </div>
</div>