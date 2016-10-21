<?php use_helper("Message"); ?>
<?php echo message(); ?>

<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_invitations_et_inscriptions"); ?>
  </legend>
  <p>
    <?php echo link_to_grid(libelle("msg_libelle_fiche_inscription"), "dossier_mris/genererDocumentsCommission?id=".$sf_params->get('id')."&inscription=1", array("class" => "picto_small bt_telecharger_small")); ?>
  </p>

  <?php if (count($arrUtilisateurs) > 0) { ?>
    <p class="underline">
      <?php echo libelle("msg_libelle_participants_mindef"); ?> :
    </p>
    <ul>
      <?php foreach($arrUtilisateurs as $objUtilisateur) { ?>
        <li>
          <?php echo $objUtilisateur; ?> :
          <?php echo link_to_grid(libelle("msg_libelle_lettre_invitation_rtf"), "dossier_mris/genererDocumentsCommission?id=".$sf_params->get('id')."&interne=".$objUtilisateur->getId(), array("class" => "picto_small bt_export_rtf_small")); ?>
        </li>
      <?php } ?>
    </ul>
  <?php } ?>

  <?php if (count($arrIntervenants) > 0) { ?>
    <p class="underline">
      <?php echo libelle("msg_libelle_participants_exterieur"); ?> :
    </p>
    <ul>
      <?php foreach($arrIntervenants as $objIntervenant) { ?>
        <li>
          <?php echo $objIntervenant; ?> :
          <?php echo link_to_grid(libelle("msg_libelle_lettre_invitation_rtf"), "dossier_mris/genererDocumentsCommission?id=".$sf_params->get('id')."&externe=".$objIntervenant->getId(), array("class" => "picto_small bt_export_rtf_small")); ?>
        </li>
      <?php } ?>
    </ul>
  <?php } ?>

  <?php if (count($arrInvitations) > 0) { ?>
    <p class="underline">
      <?php echo libelle("msg_libelle_services_laboratoires"); ?> :
    </p>
    <ul>
      <?php foreach($arrInvitations as $objInvitation) { ?>
        <li>
          <?php echo $objInvitation->estService() ? $objInvitation->getService() : $objInvitation->getLaboratoire(); ?> :
          <?php echo link_to_grid(libelle("msg_libelle_lettre_invitation_rtf"), "dossier_mris/genererDocumentsCommission?id=".$sf_params->get('id').($objInvitation->estService() ? "&service=".$objInvitation->getServiceId() : "&laboratoire=".$objInvitation->getLaboratoireId()), array("class" => "picto_small bt_export_rtf_small")); ?>
        </li>
      <?php } ?>
    </ul>
  <?php } ?>
</fieldset>

<fieldset>
  <legend><?php echo libelle("msg_libelle_documents_de_travail") ?></legend>
  <p>
    <?php echo libelle("msg_libelle_evaluation_propositions"); ?> :
    <?php echo link_to_grid(libelle("msg_libelle_grilles_evaluation"), "dossier_mris/genererDocumentsCommission?id=".$sf_params->get('id')."&evaluation=1", array("class" => "picto_small bt_telecharger_small")); ?>
  </p>
  <p>
    <?php echo libelle("msg_libelle_suivi_dossiers"); ?> :
    <?php echo link_to_grid(libelle("msg_libelle_fiches_suivi"), "dossier_mris/genererDocumentsCommission?id=".$sf_params->get('id')."&suivi=1", array("class" => "picto_small bt_telecharger_small")); ?>
  </p>
</fieldset>

<div class="left">
  <?php echo link_to_grid(libelle("msg_bouton_retourner"), "dossier_mris/listerCommissions", array("class" => "picto bt_retour")); ?>
</div>