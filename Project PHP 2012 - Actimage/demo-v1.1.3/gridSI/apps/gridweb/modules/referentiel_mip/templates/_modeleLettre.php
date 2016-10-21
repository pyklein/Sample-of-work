<div class="formulaire_ligne">

  <label>
    <?php echo libelle("msg_libelle_".$strCle); ?> :<br />
    <span class="aide"><?php echo libelle("msg_libelle_taille_maximum", array($strLimiteUpload)); ?></span><br />
    <span class="aide"><?php echo libelle("msg_libelle_fichiers_acceptes", array($strExtension)); ?></span>
  </label>
  <?php echo $objForm[$strCle]['fichier']->render(); ?>
  <?php echo $objForm[$strCle]['fichier']->renderError(); ?>

</div>
