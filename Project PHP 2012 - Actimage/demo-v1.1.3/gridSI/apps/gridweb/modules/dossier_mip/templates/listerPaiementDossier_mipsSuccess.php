<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossier)); ?>

<?php echo message(); ?>

<?php include_partial('dossier_mip/onglets_suivi_financier', array('strId' => $objDossier->getId(), 'ongletActif' => 4)) ?>

<div class="reduit" id="zone_cadre">
  <?php if (count($arrEngagementParAnnee)>0):  ?>
    <table class="mep" >
      <thead>
        <tr>
          <td class="cache right"><?php echo libelle("msg_dossier_mip_engagement_rappel_financements"); ?> : </td>
          <th width="20%"><?php echo libelle("msg_libelle_periode")?></th>
          <th width="20%"><?php echo libelle("msg_libelle_montant_engagement")?></th>
        </tr>
      </thead>
      <tbody>
        <tr class="total">
          <td class="cache"></td>
          <td> <?php echo libelle("msg_libelle_global"); ?> </td>
          <td class="montant"> <?php echo formatMontantFr($floatEngagementTotal)  ?></td>
        </tr>
        <?php foreach ($arrEngagementParAnnee as $clef => $floatEngagementParAnnee): ?>
          <tr class="total">
            <td class="cache"></td>
            <td ><?php echo $clef ?></td>
            <td class="montant"><?php echo formatMontantFr($floatEngagementParAnnee) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
  
  <br/>
  <br/>

  <div class="right">
    <?php echo link_to_grid(libelle("msg_dossier_mip_paiement_bouton_nouveau"),'dossier_mip/creerPaiementDossier_mip?dossier_mip='.$objDossier->getId(),array("class" => "picto bt_ajouter", "title"=>libelle("msg_dossier_mip_paiement_bouton_nouveau"))); ?>
  </div>

  <table class="mep">
    <caption>
      <?php echo (count($arrPaiements)==0) ? libelle("msg_dossier_mip_paiement_aucun_resultats") : libelle("msg_dossier_mip_paiement_nombre_resultats",array(count($arrPaiements))); ?>
    </caption>
    <?php if (count($arrPaiements)>0):  ?>
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_action")?></th>
          <th><?php echo libelle("msg_libelle_date")?></th>
          <th><?php echo libelle("msg_libelle_service_executant_code")?></th>
          <th width="20%"><?php echo libelle("msg_libelle_reference")?></th>
          <th width="20%"><?php echo libelle("msg_libelle_montant")?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($arrPaiements as $clef => $objPaiement): ?>
          <tr class="<?php echo $clef%2 == 0 ? "pair" : "impair" ?>">
            <td>
              <?php echo link_to_grid(' ','dossier_mip/modifierPaiementDossier_mip?paiement_id='.$objPaiement->getId(),array("class" => "picto_court bt_modifier", "title"=>libelle("msg_bouton_modifier"))); ?>
              <?php echo link_to_grid(' ','dossier_mip/supprimerPaiementDossier_mip?paiement_id='.$objPaiement->getId(),array("class" => "picto_court bt_supprimer", "title"=>libelle("msg_bouton_supprimer"))); ?>
            </td>
            <td><?php echo formatDate($objPaiement->getDatePaiement()); ?></td>
            <td><?php echo $objPaiement->getEntite()->getNomHierarchiqueCompletPlusCode() ?></td>
            <td><?php echo $objPaiement->getReference() ?></td>
            <td class="montant"><?php echo formatMontantFr($objPaiement->getMontant()) ?></td>
          </tr>
        <?php endforeach; ?>

        <tr class="total">
          <td colspan="3" class="cache"></td>
          <td><?php echo libelle('msg_libelle_total_global').' ' ?></td>
          <td class="montant"><?php echo formatMontantFr($floatPaiementTotal) ?></td>
        </tr>

        <tr class="total">
          <td colspan="3" class="cache"></td>
          <td><?php echo libelle('msg_libelle_budget_global').' ' ?></td>
          <td class="montant"><?php echo formatMontantFr($floatBudgetGlobal) ?></td>
        </tr>

        <tr class="total">
          <td colspan="3" class="cache"></td>
          <td><?php echo libelle('msg_libelle_reserve_global').' ' ?></td>
          <td class="montant"><?php echo formatMontantFr($floatReserveGlobal) ?></td>
        </tr>

        <?php foreach ($arrPaiementParAnnee as $clef => $floatPaiementParAnnee): ?>
          <tr class="total">
            <td colspan="3" class="cache"></td>
            <td><?php echo libelle('msg_libelle_total').' '.$clef ?></td>
            <td class="montant"><?php echo formatMontantFr($floatPaiementParAnnee) ?></td>
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