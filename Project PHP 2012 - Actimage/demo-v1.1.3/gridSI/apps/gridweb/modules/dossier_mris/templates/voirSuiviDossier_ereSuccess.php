<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossierEre)) ?>

<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>
<?php echo message(); ?>

<!-- Bouton export PDF -->
<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_export_pdf"), "dossier_mris/exporterDossier_erePDF?id=".$strId, array("class" => "picto bt_export_pdf", "target" => "_blank")); ?>
</div>

<?php include_partial('dossier_mris/onglets_recapitulatif_dossier_ere', array('strId' => $strId, 'ongletActif' => 3, 'isProposition'=>$isProposition, 'hasCredentialsEvaluation'=>$hasCredentialsEvaluation)) ?>

<div id="zone_cadre">

  <?php include_component("dossier_mris", "voirSuiviDossier_ere", array("id" => $strId)); ?>

</div>

 <!--Bouton retour -->
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerDossier_eres", array("class" => "picto bt_retour")); ?>
</div>
