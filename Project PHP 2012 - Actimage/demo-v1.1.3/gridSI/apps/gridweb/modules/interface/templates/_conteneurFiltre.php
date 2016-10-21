<?php use_helper("Message"); ?>
<?php use_stylesheets_for_form($objFormFiltre) ?>
<?php use_javascripts_for_form($objFormFiltre) ?>

<div class="filtre">
  <form action="" method="post" name="filtre">
    <fieldset>
      <legend>
        <?php echo libelle('msg_libelle_filtres') ?>
      </legend>
      <?php echo $objFormFiltre; ?>
        <div class="boutons">
          <input type="submit" value="<?php echo isset($strValueSubmit) ? libelle('msg_'.$strValueSubmit) : libelle("msg_bouton_filtrer"); ?>" />
          <?php if (isset($boolReinitialiser)): ?>
            <input type="submit" name="reset" value="<?php echo libelle('msg_bouton_reset_filtres') ?>" />
          <?php endif; ?>
        </div>
    </fieldset>
  </form>
</div>
