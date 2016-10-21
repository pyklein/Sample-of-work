<?php use_helper("Message"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossierBpi)); ?>

<?php echo message(); ?>

<?php include_partial('dossier_bpi/gestion_dossier_bpi', array('strId' => $strId, 'ongletActif' => 2, "estBrevetable" => $objDossierBpi->getEstBrevetable())) ?>

<div id="zone_cadre" class="reduit">
  <form action="" method="post">
     <div class="boutons">
       <input type="submit" value="Enregistrer" name="enregistrer_modifications"/>
     </div>
  </form>
  <fieldset>
    <legend><?php echo libelle('msg_inventeurs_libelle_disponibles') ?></legend>
    <?php if ($objPager->count() == 0) : ?>
      <?php echo libelle('msg_inventeurs_0_disponible') ?>
    <?php else : ?>
      <form action="" method="post">
        <label><?php echo libelle("msg_libelle_part_inventive") ?></label>
        <input type="text" name="percent" class="percent" maxlength="3" value="<?php echo $intPourcentageRestant ?>" />
        <strong>%</strong>
        <table class="mep">
          <thead>
            <tr>
              <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_nom") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_prenom") ?></th>
              <th><?php echo libelle("msg_libelle_situation") ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($objPager->getResults() as $clef => $inventeur): ?>
            <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
              <td>
                <button class="picto_court bt_ajouter" type="submit" value="<?php echo libelle("msg_bouton_ajouter") ?>" title="<?php echo libelle("msg_bouton_ajouter") ?>" id="<?php echo $inventeur->getId() ?>" name="Inventeur_<?php echo $inventeur->getId()?>"/>
              </td>
              <td><?php echo $inventeur->getNom() ?></td>
              <td><?php echo $inventeur->getPrenom() ?></td>
              <td><?php echo $inventeur->getSituation() ?></td>
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
      <legend><?php echo libelle('msg_inventeurs_libelle_concernes') ?></legend>
      <?php if ($arrInventeursConcernes->count() == 0): ?>
        <?php echo libelle('msg_inventeurs_0_concernes') ?>
      <?php else : ?>
      <form action="" method="post">
        <table class="mep">
          <thead>
            <tr>
              <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_nom") ?></th>
              <th width="25%"><?php echo libelle("msg_utilisateur_libelle_prenom") ?></th>
              <th><?php echo libelle("msg_libelle_situation") ?></th>
              <th><?php echo libelle("msg_libelle_part") ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($arrInventeursConcernes as $clef => $inventeur): ?>
            <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
              <td>
                    <?php echo link_to("", "dossier_bpi/retirerInventeur?dossier_bpi=" . $strId . "&inventeur=" . $inventeur->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_retirer"))); ?>
              </td>
              <td><?php echo $inventeur->getNom() ?></td>
              <td><?php echo $inventeur->getPrenom() ?></td>
              <td><?php echo $inventeur->getSituation() ?></td>
              <td><input type="text" name="<?php echo "percent_".$inventeur->getId() ?>" class="percent" maxlength="3" value="<?php echo $inventeur->getPartInventiveSession($strId,$transactionToken) ?>" />%</td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_modifier") ?>" title="<?php echo libelle("msg_bouton_modifier") ?>" name="modifier_modifications"/>
        </div>
      </form>
      <?php endif; ?>
    </fieldset>
    <form action="" method="post">
      <div class="boutons">
        <input type="submit" value="Enregistrer" name="enregistrer_modifications"/>
      </div>
    </form>

<!--  Partie ajout d'inventeur à chaud-->
    <form action="" method="post">
      <fieldset>
        <legend>
          <?php echo libelle("msg_module_referentiel_bpi_action_precreerinventeur") ?>
        </legend>

        <?php echo $objForm['nom']->renderRow();?>
        <?php echo $objForm['est_exterieur']->renderLabel();?> :
        <?php echo $objForm['est_exterieur']->render() ?><br><br>

        <label><?php echo libelle("msg_libelle_part_inventive"); ?></label> :
        <input type="text" name="percent_popup" class="percent" maxlength="3" value="<?php echo $intPourcentageRestant ?>" />
        <strong>%</strong>
       
        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_ajouter_et_associer"); ?>" name="enregistrer_inventeur" />
        </div>
      </fieldset>
    </form>
</div>

<?php include_partial('autreActions', array('id' => $strId)) ?>

<hr class="clear" />
<div>
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerDossier_bpis", array("class" => "picto bt_retour")); ?>
</div>
