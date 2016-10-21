<?php use_helper("Message"); ?>
<?php echo message(); ?>

<form action="" method="post">

  <fieldset>
    <legend>
      <?php echo libelle('msg_utilisateur_fieldset_profils')?>
    </legend>
    <?php echo $objForm; ?>
  </fieldset>
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_modifier"); ?>" />
  </div>
  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"),"utilisateurs/listerUtilisateurs",array("class" => "picto bt_retour")); ?>
  </div>
  
</form>
