<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php echo message(); ?>

<?php include_partial('interface/conteneurFiltre',array('objFormFiltre'=>$objFinancementFiltre)) ?>

<div class="boutons">
  <?php if (count($arrFinancements)>0): ?>
    <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mip/exporterSuiviFinancierDossier_mipCSV',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
  <?php endif; ?>
</div>

<table class="mep">
  <caption>
    <?php echo (count($arrFinancements)==0) ? libelle("msg_dossier_mip_financement_aucun_resultats") : libelle("msg_dossier_mip_financement_nombre_resultats",array(count($arrFinancements))); ?>
  </caption>
  <?php if (count($arrFinancements)>0):  ?>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_numero")?></th>
        <th><?php echo libelle("msg_libelle_titre")?></th>
        <th><?php echo libelle("msg_libelle_pilote")?></th>
        <th><?php echo libelle("msg_libelle_date")?></th>
        <th><?php echo libelle("msg_libelle_service_executant")?></th>
        <th><?php echo libelle("msg_libelle_code_se")?></th>
        <th><?php echo libelle("msg_libelle_reference_financement")?></th>
        <th><?php echo libelle("msg_dossier_mip_suivi_financement_libelle_budget_moment_financement")?></th>
        <th><?php echo libelle("msg_libelle_montant_financement")?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($arrFinancements as $clef => $objFinancement): ?>
        <tr class="<?php echo $clef%2 == 0 ? "pair" : "impair" ?>">
          <td><?php echo $objFinancement->getDossier_mip()->getNumero(); ?></td>
          <td><?php echo $objFinancement->getDossier_mip()->getTitre(); ?></td>
          <td><?php echo $objFinancement->getDossier_mip()->getPilote(); ?></td>
          <td><?php echo formatDate($objFinancement->getDateFinancement()); ?></td>
          <td><?php echo $objFinancement->getEntite()->getNomHierarchique(); ?></td>
          <td><?php echo "(".$objFinancement->getEntite()->getCodeExecutant().")"; ?></td>
          <td><?php echo $objFinancement->getReference(); ?></td>
          
          <td class="montant">
            <?php echo  formatMontantFr($arrBudgets[$objFinancement->getDossierMipId()]); ?>
          </td>
          
          <td class="montant"><?php echo formatMontantFr($objFinancement->getMontantAvecSigne()) ?></td>
        </tr>
      <?php endforeach; ?>

      <tr class="total">
        <td colspan="7" class="cache"></td>
        <td><?php echo libelle('msg_libelle_total_global').' ' ?></td>
        <td class="montant"><?php echo formatMontantFr($floatTotalGlobalFinancements) ?></td>
      </tr>

      <?php  foreach($arrTotauxParOrgMindef as $OrgMindef => $montant): ?>
        <tr class="total">
          <td colspan="7" class="cache"></td>
          <td><?php echo libelle('msg_libelle_total').' '.$OrgMindef ?></td>
          <td class="montant"><?php echo formatMontantFr($montant) ?></td>
        </tr>
      <?php endforeach; ?>

      <?php  foreach($arrTotauxParEntite as $entiteCodeExec => $montant): ?>
        <tr class="total">
          <td colspan="7" class="cache"></td>
          <td><?php echo libelle('msg_libelle_total').' '.$entiteCodeExec ?></td>
          <td class="montant"><?php echo formatMontantFr($montant) ?></td>
        </tr>
      <?php endforeach; ?>


    </tbody>
  <?php endif; ?>
</table>
