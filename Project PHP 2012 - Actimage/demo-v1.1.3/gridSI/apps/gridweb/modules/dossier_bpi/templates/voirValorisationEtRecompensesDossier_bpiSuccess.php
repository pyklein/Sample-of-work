<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>
<?php echo message(); ?>

<!-- Bouton export PDF -->
<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_export_pdf"), "dossier_bpi/exporterDossier_bpiPDF?id=".$strId, array("class" => "picto bt_export_pdf", "target" => "_blank")); ?>
</div>

<?php include_partial('dossier_bpi/vue_dossier_bpi', array('strId' => $strId, 'ongletActif' => 2)) ?>

<div id="zone_cadre">

  <?php include_component("dossier_bpi", "voirValorisationEtRecompensesDossier_bpi", array("id" => $strId)); ?>

</div>

 <!--Bouton retour -->
<div class="left">
  <?php echo link_to_grid(libelle("msg_bouton_retourner"), "dossier_bpi/listerDossier_bpis", array("class" => "picto bt_retour")); ?>
</div>
