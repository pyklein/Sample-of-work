<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossier)); ?>

<?php echo message(); ?>

<?php include_partial('dossier_mip/onglets_suivi_financier', array('strId' => $objDossier->getId(), 'ongletActif' => 3)) ?>

<div class="reduit" id="zone_cadre">
  <?php if (count($arrFinancementParAnnee)>0):  ?>
    <table class="mep" >
      <thead>
        <tr>
          <td class="cache right"><?php echo libelle("msg_dossier_mip_engagement_rappel_financements"); ?> : </td>
          <th width="20%"><?php echo libelle("msg_libelle_annee")?></th>
          <th width="20%"><?php echo libelle("msg_libelle_montant_financements")?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($arrFinancementParAnnee as $clef => $floatFinancementParAnnee): ?>
          <tr class="total">
            <td class="cache"></td>
            <td ><?php echo $clef ?></td>
            <td class="montant"><?php echo formatMontantFr($floatFinancementParAnnee) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
  
  <br/>
  <br/>

  <div class="right">
    <?php echo link_to_grid(libelle("msg_dossier_mip_engagement_bouton_nouveau"),'dossier_mip/creerEngagementDossier_mip?dossier_mip='.$objDossier->getId(),array("class" => "picto bt_ajouter", "title"=>libelle("msg_dossier_mip_engagement_bouton_nouveau"))); ?>
  </div>

  <table class="mep">
    <caption>
      <?php echo (count($arrEngagements)==0) ? libelle("msg_dossier_mip_engagement_aucun_resultats") : libelle("msg_dossier_mip_engagement_nombre_resultats",array(count($arrEngagements))); ?>
    </caption>
    <?php if (count($arrEngagements)>0):  ?>
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_action")?></th>
          <th><?php echo libelle("msg_libelle_date")?></th>
          <th><?php echo libelle("msg_libelle_service_executant_code")?></th>
          <th><?php echo libelle("msg_libelle_reference")?></th>
          <th width="20%"><?php echo libelle("msg_libelle_type")?></th>
          <th width="20%"><?php echo libelle("msg_libelle_montant")?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($arrEngagements as $clef => $objEngagement): ?>
          <tr class="<?php echo $clef%2 == 0 ? "pair" : "impair" ?>">
            <td>
              <?php echo link_to_grid(' ','dossier_mip/modifierEngagementDossier_mip?engagement_id='.$objEngagement->getId(),array("class" => "picto_court bt_modifier", "title"=>libelle("msg_bouton_modifier"))); ?>
              <?php echo link_to_grid(' ','dossier_mip/supprimerEngagementDossier_mip?engagement_id='.$objEngagement->getId(),array("class" => "picto_court bt_supprimer", "title"=>libelle("msg_bouton_supprimer"))); ?>
            </td>
            <td><?php echo formatDate($objEngagement->getDateEngagement()); ?></td>
            <td><?php echo $objEngagement->getEntite()->getNomHierarchiqueCompletPlusCode() ?></td>
            <td><?php echo $objEngagement->getReference() ?></td>
            <td><?php echo $objEngagement->getType_engagement()->getNomAlternatif() ?></td>
            <td class="montant"><?php echo formatMontantFr($objEngagement->getMontantAvecSigne()) ?></td>
          </tr>
        <?php endforeach; ?>

        <tr class="total">
          <td colspan="4" class="cache"></td>
          <td><?php echo libelle('msg_libelle_total_global').' ' ?></td>
          <td class="montant"><?php echo formatMontantFr($floatEngagementTotal) ?></td>
        </tr>

        <tr class="total">
          <td colspan="4" class="cache"></td>
          <td><?php echo libelle('msg_libelle_budget_global').' ' ?></td>
          <td class="montant"><?php echo formatMontantFr($floatBudgetGlobal) ?></td>
        </tr>

        <tr class="total">
          <td colspan="4" class="cache"></td>
          <td><?php echo libelle('msg_libelle_reserve_global').' ' ?></td>
          <td class="montant"><?php echo formatMontantFr($floatReserveGlobal) ?></td>
        </tr>

        <?php foreach ($arrEngagementParAnnee as $clef => $floatEngagementParAnnee): ?>
          <tr class="total">
            <td colspan="4" class="cache"></td>
            <td><?php echo libelle('msg_libelle_total').' '.$clef ?></td>
            <td class="montant"><?php echo formatMontantFr($floatEngagementParAnnee) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    <?php endif; ?>
  </table>
</div>

<?php include_partial('autreActions',array('id' => $objDossier->getId(),'objDossier'=>$objDossier)) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_dossier_mip"), "dossier_mip/listerDossier_mips", array("class" => "picto bt_retour")); ?>
</div>