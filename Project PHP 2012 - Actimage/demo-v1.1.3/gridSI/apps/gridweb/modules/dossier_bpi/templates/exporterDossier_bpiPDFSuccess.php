<?php use_helper("Pdf"); ?>
<?php echo pdf_debut(); ?>
<?php echo 'Le ' . date("d/m/y") . ' à ' . date("H:i:s"); ?><br>

<?php include_component("dossier_bpi", "voirDescriptionDossier_bpi", array("id" => $strId, "pdf" => 1)); ?>
<?php include_component("dossier_bpi", "voirValorisationEtRecompensesDossier_bpi", array("id" => $strId, "pdf" => 1)); ?>
<?php include_component("dossier_bpi", "voirBrevetsEtContratsDossier_bpi", array("id" => $strId, "pdf" => 1)); ?>

<?php echo pdf_fin("dossier_bpi_".$strId.".pdf", $objDossierBpi); ?>
