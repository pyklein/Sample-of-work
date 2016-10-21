<?php use_helper("Pdf"); ?>
<?php echo pdf_debut(); ?>
<?php echo 'Le ' . date("d/m/y") . ' à ' . date("H:i:s"); ?><br>
<?php include_component("dossier_mip", "voirDescriptionDossier_mip", array("id" => $strId, "pdf" => 1)); ?>
<?php include_component("dossier_mip", "voirCalendrierDossier_mip", array("id" => $strId, "pdf" => 1)); ?>
<?php include_component("dossier_mip", "voirValorisationDossier_mip", array("id" => $strId, "pdf" => 1)); ?>

<?php echo pdf_fin("dossier_mip_".$strId.".pdf", $objDossierMip); ?>
