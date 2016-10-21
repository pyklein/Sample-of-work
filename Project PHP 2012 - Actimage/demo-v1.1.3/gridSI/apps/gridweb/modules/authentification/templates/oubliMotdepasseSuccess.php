<?php use_helper("Message"); ?>
<?php echo message(); ?>

<div class="entry" id="zone_login">

  <fieldset>
    <legend><?php echo libelle("msg_libelle_reinit_mot_de_passe") ?></legend>

      <form action="" method="post">
        <?php echo $objForm ?>
       
        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_reinitialiser"); ?>" />
        </div>
      </form>

  </fieldset>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "@accueil", array("class" => "picto bt_retour")); ?>
  </div>

</div>
