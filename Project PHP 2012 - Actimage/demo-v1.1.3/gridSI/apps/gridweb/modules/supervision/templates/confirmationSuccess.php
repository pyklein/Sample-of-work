
<?php use_helper("Message"); ?>
<?php use_helper("Libelle"); ?>

<?php echo message(); ?>

<?php echo libelle("msg_supervision_connexions_confirmation"); ?>

<form name="confirmer" class="top_douze" action="" method="post">
  <div class="boutons">
    <input type="submit" value="<?php echo libelle('msg_bouton_confirmer'); ?>" />
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "supervision/index" , array("class" => "picto bt_retour")); ?>
  </div>
</form>
