<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>
<?php use_helper("Pdf"); ?>
<?php use_stylesheet('pdf.css') ?>

<?php echo pdf_debut(); ?>
<?php echo 'Le ' . date("d/m/y") . ' à ' . date("H:i:s"); ?><br>
  <?php if ($editPDF) : ?>

    <!-- ONGLET DESCRIPTION -->
    <div><big><?php echo libelle("msg_libelle_description_dossier"); ?></big></div>
    <?php include_component("dossier_mris", "voirDescriptionDossier_postdoc", array("id" => $strId)); ?>

    <!-- ONGLET EVALUATIONS -->
    <?php if ($isProposition && $hasCredentialsEvaluation) { ?>
        <div><big><?php echo libelle("msg_libelle_evaluations_dossier"); ?></big></div>
        <?php include_component("dossier_mris", "voirEvaluationDossier_postdoc", array("id" => $strId)); ?>
    <?php } ?>

    <!-- ONGLET SUIVI / ABOUTISSEMENT -->
    <div><big><?php echo libelle("msg_libelle_suivi_aboutissement_dossier"); ?></big></div>
    <?php include_component("dossier_mris", "voirSuiviDossier_postdoc", array("id" => $strId)); ?>

  <?php else : ?>
    <div><big><?php echo libelle("msg_dossier_postdoc_aucun_resultat"); ?></big></div>
  <?php endif; ?>

<?php echo pdf_fin("dossier_postdoc_".$strId.".pdf", $objDossierPostdoc->getTitre()); ?>
