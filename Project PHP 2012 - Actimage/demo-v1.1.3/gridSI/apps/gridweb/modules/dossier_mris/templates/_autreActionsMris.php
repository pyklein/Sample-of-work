
<fieldset class="outils">
  <legend><?php echo libelle('msg_libelle_autres_actions') ?></legend>
  <?php echo link_to_grid(libelle("msg_bouton_editer_dossier"), "dossier_mris/modifier".$strNomModel."?id=".$id, array("class" => "picto bt_modifier")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_validation"), "dossier_mris/validerDossier?".strtolower($strNomModel)."=".$id, array("class" => "picto bt_validation")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_evaluations"), "dossier_mris/evaluerPreselectionDossier?". strtolower($strNomModel)."_id=".$id."&dossier=true", array("class" => "picto bt_evaluations")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_suivi"),"dossier_mris/listerSuivi_".$strNomModel."s?".strtolower($strNomModel)."_id=".$id, array("class" => "picto bt_suivi")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_documents"),"dossier_mris/listerDocuments?".strtolower($strNomModel)."=".$id, array("class" => "picto bt_documents")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_remarques"),"dossier_mris/listerRemarque_mris?".strtolower($strNomModel)."=" . $id , array("class" => "picto bt_remarques")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_evenements"),"dossier_mris/listerEvenement_mris?".strtolower($strNomModel)."=" . $id, array("class" => "picto bt_evenements")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_contractualisation"),"dossier_mris/modifierContractualisation_".$strNomModel."?dossier_id=" . $id, array("class" => "picto bt_contractualisation")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_voir_dossier"),"dossier_mris/voirDescription".$strNomModel."?id=" . $id, array("class" => "picto bt_voir")); ?>
</fieldset>
