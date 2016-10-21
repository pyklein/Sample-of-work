<?php use_stylesheets_for_form($objFiltre) ?>
<?php use_javascripts_for_form($objFiltre) ?>

<form action="<?php echo url_for('utilisateurs/listerUtilisateurs')?>" method="post" >

  <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_filtres')?>
    </legend>

    <?php echo $objFiltre ?>

    <div class="boutons">
      <input type="submit" value="<?php echo libelle('msg_bouton_filtrer') ?>" />
      <?php if (isset($boolReinitialiser)): ?>
            <input type="submit" name="reset" value="<?php echo libelle('msg_bouton_reset_filtres') ?>" />
      <?php endif; ?>
    </div>

  </fieldset>
  <?php echo link_to_grid(libelle("msg_menu_rechercher_innovateurs"), "utilisateurs/rechercherInnovateurs"); ?>

  <script type='text/javascript'>
    hideOtherOptionsOnSelectValue('<?php echo $objFiltre["organisme_mindef_id"]->renderId(); ?>', '<?php echo $objFiltre["entite_id"]->renderId(); ?>');
  </script>

</form>
