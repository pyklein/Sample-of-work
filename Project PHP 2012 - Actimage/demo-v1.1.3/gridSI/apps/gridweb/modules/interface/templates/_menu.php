<?php if (sfContext::getInstance()->getUser()->isAuthenticated()) { ?>

<?php $strHtml = link_to_grid(libelle("msg_menu_supervision"), "supervision/index", array("title" => libelle("msg_menu_supervision"))); ?>

  <div id="menu">

    <ul class="">
      <li class="first"><?php echo link_to(libelle("msg_menu_accueil"), "interface/index", array("title" => libelle("msg_menu_accueil"))); ?></li>
      <li><?php echo link_to(libelle("msg_menu_recherche_transversale"), "recherche/index", array("title" => libelle("msg_menu_recherche_transversale"))); ?></li>
      <li <?php echo ($strHtml == "") ? 'class="last"' : ""?>><?php echo link_to(libelle("msg_menu_administration"), "referentiel/index", array("title" => libelle("msg_menu_administration"))); ?></li>
      <?php if ($strHtml != ""): ?>
        <li class="last"><?php echo $strHtml ?></li>
		<li class="foradmin"><span></span></li>
        <?php else : ?>
        <li class="last"><span></span></li>
      <?php endif; ?>
    </ul>
  
    <hr class="clear" />
  </div>

<?php } ?>
