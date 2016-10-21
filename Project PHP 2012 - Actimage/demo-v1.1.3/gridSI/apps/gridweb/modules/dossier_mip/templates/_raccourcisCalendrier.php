
<fieldset class="outils">
  <legend><?php echo libelle('msg_gestion_calendier_raccourcis') ?></legend>
  
  <?php echo link_to_grid(libelle("msg_calendrier_raccourcis_rdv"), "dossier_mip/modifierCalendrier_dossier_mip?id=" . $id ."#rdv"); ?>
  <br />
  <?php echo link_to_grid(libelle("msg_calendrier_raccourcis_echeance"), "dossier_mip/modifierCalendrier_dossier_mip?id=" . $id."#echeance"); ?>
  <br />
  <?php echo link_to_grid(libelle("msg_calendrier_raccourcis_avis_etat_major"), "dossier_mip/modifierCalendrier_dossier_mip?id=" . $id ."#avisEtatMajor"); ?>
  <br />
  <?php echo link_to_grid(libelle("msg_calendrier_raccourcis_remise_docs"), "dossier_mip/modifierCalendrier_dossier_mip?id=" . $id ."#remiseDocs"); ?>
  <br />
  <?php echo link_to_grid(libelle("msg_calendrier_raccourcis_soutien"), "dossier_mip/modifierCalendrier_dossier_mip?id=" . $id ."#soutien"); ?>
  <br />
  <?php echo link_to_grid(libelle("msg_calendrier_raccourcis_transfert_cloture"), "dossier_mip/modifierCalendrier_dossier_mip?id=" . $id ."#transfert"); ?>
</fieldset>
