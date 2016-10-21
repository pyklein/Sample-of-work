<?php use_helper("Message"); ?>

<?php echo message(); ?>

<!-- Page de confirmation lors de la demande de partage d'un dossier -->
<?php echo libelle("msg_recherche_confirmation_demande",array($objDossier)); ?>
<br/>
<br/>
<form method="post" action="">
  <fieldset>
    <legend>
      <?php echo libelle('msg_recherche_fieldset_demande_partage') ?>
    </legend>
    <?php echo $objForm ?>
  </fieldset>
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_confirmer"); ?>">
  </div>

  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "recherche/listerView_recherches", array("class" => "picto bt_retour")); ?>
  </div>
</form>
