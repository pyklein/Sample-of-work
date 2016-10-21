<?php use_helper("Message"); ?>
<?php echo message(); ?>


  <div class="entry" id="zone_login">

    <fieldset>
      <legend><?php echo libelle("msg_libelle_identification"); ?></legend>
      <?php if (!sfContext::getInstance()->getUser()->isAuthenticated()) : ?>

        <form action="" method="post">
          <?php echo $objForm; ?>

          <div class="boutons">
            <input type="submit" value="<?php echo libelle("msg_bouton_login"); ?>" />
          </div>
        </form>

      <?php else : ?>

        <div class="center">
          Vous êtes déjà authentifié. <br />
          Souhaitez-vous vous <?php echo link_to('déconnecter','@deconnecter') ?> ?
        </div>

      <?php endif; ?>

    </fieldset>

    <div class="left">
      <?php echo link_to(libelle("msg_bouton_oubli_motdepasse"), "authentification/oubliMotdepasse"); ?>
    </div>
    
  </div>
