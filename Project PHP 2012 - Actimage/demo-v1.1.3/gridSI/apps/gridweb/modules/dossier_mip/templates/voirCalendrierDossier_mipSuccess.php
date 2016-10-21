<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossierMip)); ?>

<?php echo message(); ?>

<!-- Bouton export PDF -->
<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_export_pdf"), "dossier_mip/exporterDossier_mipPDF?id=".$strId, array("class" => "picto bt_export_pdf", "target" => "_blank")); ?>
</div>

<?php include_partial('dossier_mip/vue_dossier_mip', array('strId' => $strId, 'ongletActif' => 2)) ?>

<div id="zone_cadre">
  
  <?php include_component("dossier_mip", "voirCalendrierDossier_mip", array("id" => $strId)); ?>

</div>

<!--Bouton retour -->
<div class="left">
  <?php echo link_to_grid(libelle("msg_bouton_retourner"), "dossier_mip/listerDossier_mips", array("class" => "picto bt_retour")); ?>
</div>
