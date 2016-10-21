<?php use_helper("Message"); ?>
<?php if (!isset($intIdPager)) { $intIdPager = '0';} ?>
<?php if ($intIdPager != 0) { $intSelectionne = $intSelectionne[$intIdPager];} ?>

<div class="pagination_choix">
  <form action="" method="post" name="pagination<?php echo $intIdPager ?>">
    <label><?php echo libelle("msg_libelle_nbr_el_par_page") ?></label>
    <select name="resultats<?php echo $intIdPager ?>">
      <?php foreach ($arrNombres as $choix) : ?>
        <?php if ($choix == $intSelectionne) : ?>
            <option value="<?php echo $choix ?>" selected="true"><?php echo $choix ?></option>
        <?php else : ?>
              <option value="<?php echo $choix ?>"><?php echo $choix ?></option>
        <?php endif ?>
      <?php endforeach; ?>
    </select>
    <input type="submit"  value="<?php echo libelle('msg_bouton_changer_pagination') ?>"/>
  </form>
</div>
