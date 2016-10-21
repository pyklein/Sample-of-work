<?php
  use_helper("Message");
  use_helper("Format");
?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objContenant)); ?>

<?php echo message(); ?>

<?php include_partial('dossier_mip/onglets_suivi_financier', array('strId' => $strId, 'ongletActif' => 1)) ?>

<div class="reduit" id="zone_cadre">
  
  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_nouveau_budget"), "dossier_mip/creerBudget?".$strModelContenant."=".$objContenant->getId(), array("class" => "picto bt_ajouter")); ?>
  </div>

  <?php if ($arrBudgets->count()!= 0): ?>

    <table class="mep">
      <caption>
        <?php echo libelle("msg_nb_budgets_trouves",array($arrBudgets->count()))?>
      </caption>
      
      <th><?php echo libelle("msg_libelle_action"); ?></th>
      <th><?php echo libelle("msg_libelle_date"); ?></th>
      <th><?php echo libelle("msg_libelle_reference"); ?></th>
      <th><?php echo libelle("msg_libelle_type"); ?></th>
      <th><?php echo libelle("msg_libelle_montant_e"); ?></th>

      <?php foreach ($arrBudgets as $intCle => $objBudget): ?>
        <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php echo link_to_grid("","dossier_mip/modifierBudget?id=".$objBudget->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier"))); ?>
            <?php echo link_to_grid("", "dossier_mip/supprimerBudget?id=".$objBudget->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_supprimer","title" =>libelle("msg_bouton_supprimer"))); ?>
          </td>
          <td>
            <?php echo formatDate($objBudget->getDate_budget());?>
          </td>
          <td>
            <?php  echo ($objBudget->getReference()?$objBudget->getReference():"");?>
          </td>
          <td>
            <?php echo $objBudget->getBudget_type();?>
          </td>
          <td class="montant">
            <?php echo ($objBudget->getBudget_type()->getId()==Budget_typeTable::RESTITUE ? "-":"");
                echo formatMontantFr($objBudget->getMontant());
            ?>
          </td>
       <?php endforeach ?>

        <tr class="total">
          <td colspan="3" class="cache"></td>
          <td>
            <?php echo libelle("msg_libelle_total_global");?>
          </td>
          <td class="montant">
            <?php echo formatMontantFr($intTotalGlobal) ?>
          </td>
        </tr>

       <?php foreach($arrTotalAnnee as $date => $total):?>
        <tr class="total">
          <td colspan="3" class="cache"></td>
          <td>
            <?php echo libelle("msg_libelle_total")." ".$date ?>
          </td>
          <td class="montant">
            <?php echo formatMontantFr($total) ?>
          </td>
        </tr>
      <?php endforeach;?>
       

    </table>

  <?php else: ?>
      <table class="mep">
        <caption>
          <?php echo libelle("msg_budget_aucun_resultat"); ?>
        </caption>
      </table>

  <?php endif; ?>
 
</div>

<?php include_partial('autreActions',array('id' => $strId,'objDossier'=>$objContenant)) ?>

<hr class="clear">
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_dossier_mip"), "dossier_mip/listerDossier_mips",array("class" => "picto bt_retour")) ?>
</div>