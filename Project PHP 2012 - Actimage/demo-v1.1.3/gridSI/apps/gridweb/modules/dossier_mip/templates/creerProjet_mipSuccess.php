
<?php use_helper("Message"); ?>
<?php echo message(); ?>

<div id="zone_cadre">
  <form action="" method="post">
    <?php echo $objForm ?>
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_continuer"); ?>" />
    </div>
  </form>
</div>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/listerDossier_mips", array("class" => "picto bt_retour")); ?>
</div>