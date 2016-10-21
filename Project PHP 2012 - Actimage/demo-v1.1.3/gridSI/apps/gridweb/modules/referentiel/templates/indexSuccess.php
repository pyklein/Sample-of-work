<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php
//on récupère le user
$objUser = sfContext::getInstance()->getUser();
?>

<div class="accueil">

  <?php
  //on filtre les users qui peuvent voir le fieldset
  if ($objUser->hasCredential('ADM') || $objUser->hasCredential('SUP-MIP') ||
          $objUser->hasCredential('SUP-BPI') || $objUser->hasCredential('SUP-MRIS') ||
          $objUser->hasCredential('USR-MIP') || $objUser->hasCredential('COR-MIP'))
  {
  ?>
  <fieldset>
    <legend><?php echo libelle("msg_titre_utilisateurs"); ?></legend>
    <ul class="menu">
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_utilisateurs"), "utilisateurs/listerUtilisateurs"); ?>
    </ul>
  </fieldset>
  <?php
  }

  if ($objUser->hasCredential('ADM') || $objUser->hasCredential('SUP-MIP') ||
          $objUser->hasCredential('SUP-BPI') || $objUser->hasCredential('SUP-MRIS'))
  {
  ?>
  <fieldset>
    <legend><?php echo libelle("msg_titre_notifications"); ?></legend>
    <ul class="menu">
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_notifications"), "notification/listerNotifications"); ?>
    </ul>
  </fieldset>
  <?php
  }
  if ($objUser->hasCredential('ADM') || $objUser->hasCredential('SUP-MIP') ||
          $objUser->hasCredential('SUP-BPI') || $objUser->hasCredential('SUP-MRIS'))
  {
  ?>
  <fieldset>
    <legend><?php echo libelle("msg_titre_referentiels"); ?></legend>
    <ul class="menu">
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_villes"), "referentiel/listerVilles"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_departements"), "referentiel/listerDepartements"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_grades"), "referentiel/listerGrades"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_entites"), "referentiel/listerEntites"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_organismes_mindef"), "referentiel/listerOrganisme_mindefs"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_org_exterieur"), "referentiel/listerOrganismes"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_contact_se"), "referentiel/listerContactSes"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_services_orphelin"), "referentiel/listerServiceOrphelins"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_laboratoires_orphelin"), "referentiel/listerLaboratoireOrphelins"); ?>
    </ul>
  </fieldset>
  <?php
  }
  if ($objUser->hasCredential('SUP-MIP'))
  {
  ?>
  <fieldset>
    <legend><?php echo libelle("msg_titre_referentiels_mip"); ?></legend>
    <ul class="menu">
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_statut_dossier_mip"), "referentiel_mip/listerStatut_Dossier_mips"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_prix"), "referentiel_mip/listerPrixs"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_modele_lettre"), "referentiel_mip/modifierModeleLettre"); ?>
    </ul>
  </fieldset>
  <?php
  }
  if ($objUser->hasCredential('SUP-MRIS'))
  {
  ?>
  <fieldset>
    <legend><?php echo libelle("msg_titre_referentiels_mris"); ?></legend>
    <ul class="menu">
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_etudiant"), "referentiel_mris/listerEtudiants"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_intervenants"), "referentiel_mris/listerIntervenants"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_convention_otganisme"), "referentiel_mris/listerConvention_organismes"); ?>
    </ul>
  </fieldset>
  <?php
  }
  if ($objUser->hasCredential('SUP-BPI'))
  {
  ?>
  <fieldset>
    <legend><?php echo libelle("msg_titre_referentiels_bpi"); ?></legend>
    <ul class="menu">
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_inventeurs"), "referentiel_bpi/listerInventeurs"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_statut_dossier_bpi"), "referentiel_bpi/listerStatut_Dossier_bpis"); ?>
      <?php echo link_to_grid_liste(libelle("msg_menu_gerer_phase_depot_brevet"), "referentiel_bpi/listerPhase_depot_brevets"); ?>
    </ul>
  </fieldset>
  <?php } ?>
</div>
