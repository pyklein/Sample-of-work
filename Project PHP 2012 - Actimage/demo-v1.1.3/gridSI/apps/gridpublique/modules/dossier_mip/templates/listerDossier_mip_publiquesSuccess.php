<?php use_stylesheets_for_form($objFormFiltre) ?>

<!-- Filtre -->
<div class="filtre">
  <form action="" method="post" name="filtre">
    <fieldset>
      <legend>
        <?php echo libelle('msg_libelle_filtres') ?>
      </legend>
      <?php echo $objFormFiltre['organisme_mindef_id']->renderRow(); ?>
      <?php echo $objFormFiltre['annee']->renderRow(); ?>
      <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_filtrer"); ?>" />
        <input type="submit" name="reset" value="<?php echo libelle('msg_bouton_reset_filtres') ?>" />
      </div>
    </fieldset>
  </form>
</div>
<br>

<!-- Liste -->
<?php if ($objPager->count() != 0 ) : ?>
  <table class="mep">
    <caption>
      <?php echo libelle("msg_dossier_mip_nombre_resultat", array($objPager->getNbResults())); ?>
    </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_actions"); ?></th>
        <th><?php echo libelle("msg_libelle_numero"); ?></th>
        <th><?php echo libelle("msg_libelle_intitule_acronyme"); ?></th>
        <th><?php echo libelle("msg_libelle_innovateurs"); ?></th>
        <th><?php echo libelle("msg_libelle_organisme_armee"); ?></th>
        <th><?php echo libelle("msg_libelle_statut_dossier"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager->getResults() as $intCle => $objDossier) { ?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php echo link_to("", "dossier_mip/voirDescriptionDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_voir", 'title' => libelle("msg_bouton_voir"))); ?>
          </td>
          <td><?php echo $objDossier->getNumero(); ?></td>
          <td><?php echo $objDossier->getTitre();
                    echo $objDossier->getAcronyme()?"-".$objDossier->getAcronyme():""; ?>
          </td>
          <td>
            <?php foreach ($objDossier->getInnovateurs() as $innovateur): ?>
              <?php echo $innovateur ?><br/>
            <?php endforeach; ?>
          </td>
          <td><?php echo $objDossier['Organisme_mindef']; ?></td>
          <td><?php echo $objDossier['Statut_dossier_mip']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <?php if ($objPager->haveToPaginate()) : ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager, 'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>

<?php else: ?>

   <?php echo libelle("msg_dossier_mip_0_resultat"); ?>

<?php endif; ?>
