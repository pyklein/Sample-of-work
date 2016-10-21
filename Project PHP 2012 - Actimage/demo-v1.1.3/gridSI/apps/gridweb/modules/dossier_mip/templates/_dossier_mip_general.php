
<?php use_helper("Message"); ?>
<?php echo message(); ?>

<?php if (isset($strId)): ?>
  <?php include_partial('dossier_mip/gestion_dossier_mip',array('strId' => $strId, 'ongletActif' => 1,'boolEstPreProjet' => $objForm->getObject()->estPreProjet())) ?>
<?php endif; ?>

<?php
if (isset($strContenant)) {
  $strRedirection = "?" . $strContenant . "=" . $idContenant;
} else {
  $strRedirection = "";
}
?>

<div <?php if (!isset($creer)) {echo('id="zone_cadre" class="reduit"');} ?>>
  <form action="" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?> " />
    </div>

    <fieldset>
      <legend>
        <?php echo libelle("msg_dossier_mip_description") ?>
      </legend>
      <?php if (isset($objForm['numero'])): ?>
        <?php echo $objForm['numero']->renderRow() ?>
        
      <?php endif; ?>
      <?php if (isset($objForm['created_at'])): ?>
      <?php echo $objForm['created_at']->renderRow() ?>
      <?php endif; ?>
      <?php echo $objForm['titre']->renderRow() ?>
      <?php echo $objForm['acronyme']->renderRow() ?>
      <?php echo $objForm['descriptif']->renderRow() ?>
      <?php if (isset($objForm['pilote_id'])) : ?>
        <?php echo $objForm['pilote_id']->renderRow() ?>
      <?php endif; ?>
      <?php echo $objForm['organisme_mindef_id']->renderRow() ?>
      <?php if (!$objForm->getObject()->estPreProjet()) : ?>
        <?php echo $objForm['niveau_protection_id']->renderRow() ?>
      </fieldset>
      <fieldset>
        <legend><?php echo libelle("msg_dossier_mip_statut") ?></legend>
        <?php echo $objForm['statut_dossier_mip_id']->renderRow() ?>
        <?php echo $objForm['etat_partage_id']->renderRow() ?>
        <?php echo $objForm['est_publie']->renderRow() ?>
        <?php echo $objForm['dossier_vivant']->renderRow() ?>
      </fieldset>
      <fieldset>
        <legend><?php echo libelle("msg_libelle_photographie") ?></legend>
        <?php echo $objForm['photographie']->renderRow() ?>
      <?php endif; ?>
    </fieldset>
    <?php if (!isset($creer) && $objForm->getObject()->getStatutProjetMipId() == 1) : ?>
      <p>
        <?php echo link_to_grid(libelle('msg_libelle_basculer_projet_mip'), 'dossier_mip/basculerProjet_mip?dossier_mip='.$objForm->getObject()->getId()) ?>
        <br>
        <?php echo link_to_grid(libelle('msg_libelle_abandon_projet_mip'), 'dossier_mip/abandonnerProjet_mip?dossier_mip='.$objForm->getObject()->getId()) ?>
      </p>
    <?php endif; ?>
    
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?> "/>
    </div>

  </form>
</div>