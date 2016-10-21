<?php use_stylesheets_for_form($objFormContrat) ?>
<?php use_javascripts_for_form($objFormContrat) ?>
<?php use_stylesheets_for_form($objFormSignataire) ?>
<?php use_javascripts_for_form($objFormSignataire) ?>
<?php use_helper("Message"); ?>

<h3>
  <?php echo libelle("msg_titre_dossier_bpi", array($objDossier)); ?>
</h3>

<?php echo message(); ?>

<form action="<?php echo url_for('dossier_bpi/'.($objFormContrat->getObject()->isNew() ? 'creerContrat' : 'modifierContrat').(!$objFormContrat->getObject()->isNew() ? '?contrat_id='.$objFormContrat->getObject()->getId() : '?dossier_bpi_id='.$objDossier->getId())) ?>" method="post" <?php $objFormContrat->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

  <?php if (!$objFormContrat->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="post" />
  <?php endif; ?>

  <fieldset>
    <legend>
      <?php echo libelle("msg_contrat_fieldset_types") ?>
    </legend>

    <?php echo $objFormContrat['type_contrats_list']->render();?>

  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_contrat_fieldset_signataire") ?>
    </legend>

    <?php
      echo $objFormSignataire['organisme_id']->renderRow();
      echo $objFormSignataire['service_id']->renderRow();
    ?>

    <div class="boutons">
      <input type="submit" name="ajouter_signataire_submit" value="<?php echo libelle('msg_contrat_bouton_ajouter_signataire'); ?>" />
    </div>

    <br>
    <?php if (count($arrSignataires) > 0): ?>
      <table class="mep">
        <thead>
          <tr>
            <th width="5%"><?php echo libelle("msg_libelle_actions"); ?></th>
            <th><?php echo libelle("msg_libelle_organisme"); ?></th>
            <th><?php echo libelle("msg_libelle_service"); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($arrSignataires as $intCle => $objSignataire) {
          ?>
            <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
              <td>
                <button type="submit" name="supprimer_signataire_submit[<?php echo $objSignataire->getId();?>]" value="<?php echo libelle('msg_bouton_supprimer'); ?>" title="<?php echo libelle('msg_bouton_supprimer'); ?>" class="picto_court bt_supprimer" />
              </td>

              <td><?php echo $objSignataire->getOrganisme()->getIntitule(); ?></td>

              <td><?php echo $objSignataire->getService()->getIntitule(); ?></td>

            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php endif; ?>


  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_contrat_fieldset_description") ?>
    </legend>

    <?php
      echo $objFormContrat['statut_contrat_id']->renderRow();
      echo $objFormContrat['juriste_id']->renderRow();
      echo $objFormContrat['numero_mb']->renderRow();
    ?>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_contrat_fieldset_reperes_temp") ?>
    </legend>

    <?php echo $objFormContrat['date_redaction']->renderRow();?>
    <?php echo $objFormContrat['date_proposition']->renderRow();?>
    <?php echo $objFormContrat['date_signature']->renderRow();?>
    <?php echo $objFormContrat['date_inscription_mb']->renderRow();?>

  </fieldset>

  <div class="boutons">
    <input type="submit" value="<?php echo ($objFormContrat->getObject()->isNew()) ? libelle('msg_contrat_bouton_ajouter') :  libelle('msg_contrat_bouton_save'); ?>" />
  </div>

  <script type='text/javascript'>
    hideOtherOptionGroupsOnSelectValue('<?php echo $objFormSignataire['organisme_id']->renderId(); ?>', '<?php echo $objFormSignataire['service_id']->renderId(); ?>');
  </script>
</form>
&nbsp;
<div class="left">
    <?php echo link_to_grid(libelle("msg_contrat_bouton_retournervers_contrat"), "dossier_bpi/listerContrats?dossier_bpi_id=".$objDossier->getId(), array("class" => "picto bt_retour")); ?>
</div>