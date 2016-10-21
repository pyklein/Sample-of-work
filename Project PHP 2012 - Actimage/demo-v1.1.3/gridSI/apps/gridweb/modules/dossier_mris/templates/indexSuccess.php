<?php use_helper("Message"); ?>

<?php echo message(); ?>

<div class="accueil">
<fieldset>
    <legend><?php echo libelle("msg_titre_dossiers_mris"); ?></legend>
    <ul class="menu">
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_dossier_these"), "dossier_mris/listerDossier_theses"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_dossier_postdoc"), "dossier_mris/listerDossier_postdocs"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_dossier_ere"), "dossier_mris/listerDossier_eres"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_commissions"), "dossier_mris/listerCommissions"); ?>
    </ul>
  </fieldset>
</div>