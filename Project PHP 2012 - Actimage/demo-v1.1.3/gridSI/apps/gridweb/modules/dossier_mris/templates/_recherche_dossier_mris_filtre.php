<?php use_helper("Message"); ?>
<?php use_stylesheets_for_form($objFormFiltre) ?>
<?php use_javascripts_for_form($objFormFiltre) ?>

<div class="filtre">
  <form action="" method="post" name="filtre">
    <fieldset>
      <legend>
        <?php echo libelle('msg_libelle_filtres') ?>
      </legend>
      
      <?php echo $objFormFiltre['annee']->renderRow(); ?>
      <?php echo $objFormFiltre['domaine_scientifique_id']->renderRow(); ?>
      <?php echo $objFormFiltre['organisme_mindef_id']->renderRow(); ?>
      <?php echo $objFormFiltre['organisme_id']->renderRow(); ?>
      <?php echo $objFormFiltre['laboratoire']->renderRow(); ?>
      <?php echo $objFormFiltre['region_laboratoire']->renderRow(); ?>

      <hr class="separateur" />
      <?php echo $objFormFiltre['etudiant']->renderRow(); ?>
      <?php echo $objFormFiltre['encadrant']->renderRow(); ?>
      <p>
        <?php echo $objFormFiltre['titre']->renderLabel(); ?> :
        <?php echo $objFormFiltre['titre']->render(); ?>
        <?php echo $objFormFiltre['etou_titre']->render(); ?>
      </p>


        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_filtrer"); ?>" />
          <input type="submit" name="reset" value="<?php echo libelle('msg_bouton_reset_filtres') ?>" />
        </div>
    </fieldset>

  </form>
</div>
