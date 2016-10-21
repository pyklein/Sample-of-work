
<?php use_helper("Message"); ?>
<?php echo message(); ?>
<?php if (isset($strId)): ?>
  <?php include_partial('dossier_bpi/gestion_dossier_bpi',array('strId' => $strId, 'ongletActif' => 1, "estBrevetable" => $objForm->getObject()->getEstBrevetable())) ?>
<?php endif; ?>
<?php
if (isset($strContenant)) {
  $strRedirection = "?" . $strContenant . "=" . $idContenant;
} else {
  $strRedirection = "";
}
?>

<div <?php if (!isset($creer)) {echo('id="zone_cadre" class="reduit"');} ?>>
  <form action="" method="post">
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
    </div>
    <fieldset>
      <legend>
        <?php echo libelle("msg_dossier_bpi_identification") ?>
      </legend>
      <?php if (isset($objForm['numero'])): ?>
        <?php echo $objForm['numero']->renderRow() ?>
      <?php endif; ?>
      <?php echo $objForm['titre']->renderRow() ?>
      <?php echo $objForm['description']->renderRow() ?>
    </fieldset>
    <fieldset>
      <legend><?php echo libelle("msg_dossier_bpi_statut") ?></legend>
      <?php echo $objForm['statut_dossier_bpi_id']->renderRow() ?>
      <?php echo $objForm['statut_declaration_id']->renderRow() ?>
      <?php echo $objForm['date_predeclaration']->renderRow() ?>
      <?php echo $objForm['date_declaration_conforme']->renderRow() ?>
      <?php echo $objForm['etat_partage_id']->renderRow() ?>
      <?php echo $objForm['est_classifie']->renderRow() ?>
    </fieldset>
    <fieldset>
      <legend><?php echo libelle("msg_dossier_bpi_hierarchie") ?></legend>
      <?php echo $objForm['hierarchie_locale_id']->renderRow() ?>
    </fieldset>
    <fieldset>
      <legend><?php echo libelle("msg_dossier_bpi_autorite") ?></legend>
      <?php echo $objForm['autorite_decision_id']->renderRow() ?>
    </fieldset>
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
    </div>
  </form>
</div>
