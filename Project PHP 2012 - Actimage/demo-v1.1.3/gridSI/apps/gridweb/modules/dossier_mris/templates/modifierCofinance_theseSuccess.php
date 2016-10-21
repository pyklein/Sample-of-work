<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossierBpi)) ?>

<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial('dossier_mris/onglet_dossier', array('strId' => $strId, 'ongletActif' => 7, 'strNomModel' => 'Dossier_these')) ?>

<div id="zone_cadre" class="reduit">
  <form action="" method="post">
     <div class="boutons">
       <input type="submit" value="Enregistrer" name="enregistrer_modifications"/>
     </div>
  </form>
  <fieldset>
    <legend><?php echo libelle('msg_organismes_libelle_disponibles') ?></legend>
    <?php if ($objPager->count() == 0) : ?>
      <?php echo libelle('msg_organismes_0_disponible') ?>
    <?php else : ?>
      <form action="" method="post">
        <label><?php echo libelle("msg_libelle_part_cofinance") ?></label>
        <input type="text" name="percent" class="percent" maxlength="3" value="<?php echo $intPourcentageRestant ?>" />
        <strong>%</strong>
        <table class="mep">
          <thead>
            <tr>
              <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_intitule") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_abreviation") ?></th>
              <th><?php echo libelle("msg_libelle_type") ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($objPager->getResults() as $clef => $organisme): ?>
            <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
              <td>
                <button class="picto_court bt_ajouter" type="submit" value="<?php echo libelle("msg_bouton_ajouter") ?>" title="<?php echo libelle("msg_bouton_ajouter") ?>" id="<?php echo $organisme->getId() ?>" name="Inventeur_<?php echo $organisme->getId()?>"/>
              </td>
              <td><?php echo $organisme->getIntitule() ?></td>
              <td><?php echo $organisme->getAbreviation() ?></td>
              <td><?php echo $organisme->getType_organisme() ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </form>

      <?php if ($objPager->haveToPaginate()): ?>
        <?php include_partial('interface/paginateur', array('objPager' => $objPager, 'strUrlRedirection' => $strUrlRedirection)) ?>
      <?php endif; ?>

      <?php if ($objPager->count() > 0) : ?>
        <?php include_partial('interface/maxParPage', array('intSelectionne' => $intSelectionne, 'arrNombres' => $arrNombres)) ?>
      <?php endif; ?>

    <?php endif; ?>
  </fieldset>
    <fieldset>
      <legend><?php echo libelle('msg_organismes_libelle_concernes') ?></legend>
      <?php if ($arrOrganismeConcernes->count() == 0): ?>
        <?php echo libelle('msg_organismes_0_concernes') ?>
      <?php else : ?>
        <table class="mep">
          <thead>
            <tr>
              <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_intitule") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_abreviation") ?></th>
              <th><?php echo libelle("msg_libelle_type") ?></th>
              <th><?php echo libelle("msg_libelle_part") ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($arrOrganismeConcernes as $clef => $organisme): ?>
            <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
              <td>
                <?php echo link_to("", "dossier_mris/retirerOrganisme?dossier_these=" . $strId . "&organisme=" . $organisme->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_retirer"))); ?>
              </td>
              <td><?php echo $organisme->getIntitule() ?></td>
              <td><?php echo $organisme->getAbreviation() ?></td>
              <td><?php echo $organisme->getType_organisme() ?></td>
              <td><?php echo $organisme->getPartCofinanceSession($strId,$transactionToken) ?>%</td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </fieldset>
    <form action="" method="post">
      <div class="boutons">
        <input type="submit" value="Enregistrer" name="enregistrer_modifications"/>
      </div>
    </form>
</div>

<?php include_partial('autreActionsMris', array('id' => $strId,'strNomModel' => 'Dossier_these')) ?>

<hr class="clear" />
<div>
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerDossier_theses", array("class" => "picto bt_retour")); ?>
</div>
