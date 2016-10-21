
<fieldset class="outils">
  <legend><?php echo libelle('msg_libelle_autres_actions') ?></legend>

  <?php echo link_to_grid(libelle("msg_bouton_editer_dossier"), "dossier_bpi/modifierDossier_bpi?id=" . $id, array("class" => "picto bt_modifier")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_documents"), "dossier_bpi/listerDocuments_bpis?dossier_bpi=" . $id, array("class" => "picto bt_documents")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_remarques"),"dossier_bpi/listerRemarque_bpis?dossier_bpi_id=" . $id , array("class" => "picto bt_remarques")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_brevets"),"dossier_bpi/listerBrevets?dossier_bpi_id=" . $id, array("class" => "picto bt_brevets")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_redevances"),"dossier_bpi/listerRedevances?dossier_bpi_id=" . $id, array("class" => "picto bt_redevances")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_alertes"),"dossier_bpi/alertesDossier_bpi?id=".$id, array("class" => "picto bt_alertes")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_contentieux"),"dossier_bpi/modifierContentieux?dossier_bpi_id=" . $id , array("class" => "picto bt_contentieux")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_actions_a_mener"),"dossier_bpi/actionsDossiers?dossier_bpi=".$id, array("class" => "picto bt_actions_a_mener")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_contractualisation"),"dossier_bpi/listerContrats?dossier_bpi_id=".$id, array("class" => "picto bt_contractualisation")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_recompenses"),"dossier_bpi/modifierRecompenses?dossier_bpi_id=".$id, array("class" => "picto bt_recompenses")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_liaison"),"dossier_bpi/lierDossiers_mip?dossier_bpi=".$id ."&start=true", array("class" => "picto bt_liaison")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_voir_dossier"),"dossier_bpi/voirDescriptionDossier_bpi?id=".$id , array("class" => "picto bt_voir")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_clore_dossier"),"dossier_bpi/cloreDossier_bpi?id=".$id, array("class" => "picto bt_clore")); ?>

</fieldset>
