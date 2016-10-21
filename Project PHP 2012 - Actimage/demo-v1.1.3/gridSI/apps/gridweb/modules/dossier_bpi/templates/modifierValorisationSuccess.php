<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossierBpi)); ?>

<?php echo message(); ?>

<?php include_partial('dossier_bpi/gestion_dossier_bpi', array('strId' => $strId, 'ongletActif' => 5, "estBrevetable" => $objDossierBpi->getEstBrevetable())) ?>

<div id="zone_cadre" class="reduit">

  <form action="" method="post">
   <div class="boutons">
     <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>"/>
   </div>
    <?php if ($boolABrevetDepose) { ?>
      <fieldset>
        <legend><?php echo libelle('msg_evaluation_brevet') ?></legend>

        <?php echo $objFormulaireValorisationBpi["est_evalue"]->renderLabel(); ?> :
        <?php echo $objFormulaireValorisationBpi["est_evalue"]->render(); ?>

      </fieldset>
    <?php } ?>

    <fieldset>
      <legend><?php echo libelle('msg_valorisation_externe') ?></legend>

      <?php if ($arrValorisationExternes->count() == 0) { ?>
        <?php echo libelle('msg_valorisations_externes_0') ?>
      <?php } else { ?>
        <table class="mep">
          <thead>
            <tr>
              <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
              <th><?php echo libelle("msg_libelle_organisme") ?></th>
              <th><?php echo libelle("msg_libelle_statut") ?></th>
              <th><?php echo libelle("msg_libelle_contrat") ?></th>
              <th><?php echo libelle("msg_libelle_statut_contrat") ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($arrValorisationExternes as $clef => $objValorisationExterneSession): ?>
            <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
              <td>
                <?php echo link_to("", "dossier_bpi/retirerValorisation?dossier_bpi=".$strId."&externe=" . $objValorisationExterneSession->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_retirer"))); ?>
              </td>
              <td><?php echo $objValorisationExterneSession->getOrganisme(); ?></td>
              <td><?php echo $objValorisationExterneSession->getStatutValorisationExterne(); ?></td>
              <?php $objContrat = $objValorisationExterneSession->getContrat(); ?>
              <td><?php echo $objContrat->getId() != null ? $objContrat->getNumeroMb() : ""; ?></td>
              <td><?php echo $objContrat->getId() != null ? $objContrat->getStatut_contrat() : ""; ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php } ?>

      <?php echo $objFormulaireValorisationExterne["organisme_id"]->renderRow(); ?>
      <?php echo $objFormulaireValorisationExterne["statut_valorisation_externe_id"]->renderRow(); ?>
      <?php echo $objFormulaireValorisationExterne["contrat_id"]->renderRow(); ?>

      <div class="boutons">
        <input type="submit" name="externe" value="<?php echo libelle("msg_bouton_ajouter_organisme"); ?>"/>
      </div>

    </fieldset>

    <fieldset>
      <legend><?php echo libelle('msg_valorisation_interne') ?></legend>

      <?php if ($arrValorisationInternes->count() == 0) { ?>
        <?php echo libelle('msg_valorisations_internes_0') ?>
      <?php } else { ?>
        <table class="mep">
          <thead>
            <tr>
              <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
              <th><?php echo libelle("msg_libelle_organisme") ?></th>
              <th><?php echo libelle("msg_libelle_date_debut_exploitation") ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($arrValorisationInternes as $clef => $objValorisationInterneSession): ?>
            <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
              <td>
                <?php echo link_to("", "dossier_bpi/retirerValorisation?dossier_bpi=".$strId."&interne=".$objValorisationInterneSession->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_retirer"))); ?>
              </td>
              <td><?php echo $objValorisationInterneSession->getOrganismeMindef(); ?></td>
              <td>
                <?php 
                if (strtotime($objValorisationInterneSession->getDateDebutExploitation()) != 0)
                  echo formatDate($objValorisationInterneSession->getDateDebutExploitation());
                ?>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php } ?>

      <?php echo $objFormulaireValorisationInterne["organisme_mindef_id"]->renderRow(); ?>
      <?php echo $objFormulaireValorisationInterne["date_debut_exploitation"]->renderRow(); ?>

      <div class="boutons">
        <input type="submit" name="interne" value="<?php echo libelle("msg_bouton_ajouter_organisme"); ?>"/>
      </div>

    </fieldset>

    <fieldset>
      <legend><?php echo libelle('msg_commentaire_valorisation') ?></legend>

      <?php echo $objFormulaireValorisationBpi["commentaire"]->renderRow(); ?>
    </fieldset>

    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>"/>
    </div>

  </form>

</div>

<?php include_partial('autreActions', array('id' => $strId)) ?>

<hr class="clear" />
<div>
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerDossier_bpis", array("class" => "picto bt_retour")); ?>
</div>

