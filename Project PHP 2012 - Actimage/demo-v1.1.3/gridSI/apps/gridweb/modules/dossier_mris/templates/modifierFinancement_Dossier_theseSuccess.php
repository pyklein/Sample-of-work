<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php
  use_helper("Message");
  use_helper("Format");
?>

<?php echo message(); ?>

<?php include_partial('onglet_contractualisation',array( 'type_dossier' => $type_dossier, 'dossierId' => $dossierId, 'ongletActif' => "2" )) ?>

<?php $total = 0;
      $reserve = 0;
?>

<div id="zone_cadre">
  <?php if($conventionCollective):?>
    <div>
      <form action="" method="post">
        <fieldset>
          <legend>
            <?php echo libelle("msg_libelle_ajouter_versement") ?>
          </legend>
            <?php echo $objForm; ?>
        

          <div class="boutons">
              <input type="submit" value="<?php echo  libelle("msg_bouton_ajouter"); ?>" />
          </div>
   
        </fieldset>
      </form>
    </div>
  <br>

  <?php if($arrVersements->count() > 0):?>
    <table class="mep">
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_actions"); ?></th>
          <th><?php echo libelle("msg_libelle_date_versement"); ?></th>
          <th><?php echo libelle("msg_libelle_montant_e");?></th>
        </tr>
      </thead>
      <tbody>
        <tr class="pair">
          <td></td>
          <td><?php echo libelle("msg_libelle_montant_a_verser");?></td>
          <td><?php echo formatMontantFr($objConvention->getMontant()) ?></td>
        </tr>

        <?php foreach ($arrVersements as $intCle => $objVersement): ?>
          <tr class="<?php echo $intCle % 2 == 0 ? "impair" : "pair" ?>">
            <td>
              <?php echo link_to_grid("","dossier_mris/modifierVersement_".$type_dossier."?id=".$objVersement->getId(),array("class" => "picto_court bt_modifier","title"=>libelle("msg_bouton_modifier"))) ?>
              <?php echo link_to_grid("","dossier_mris/supprimerVersement_".$type_dossier."?id=".$objVersement->getId(),array("class" => "picto_court bt_supprimer","title"=>libelle("msg_bouton_supprimer"))) ?>
            </td>
            <td><?php if($objVersement['date_versement'] != NULL) echo formatDate($objVersement->getDate_versement()); ?></td>
            <td>
              <?php echo formatMontantFr($objVersement->getMontant_versement());
                    $total += $objVersement->getMontant_versement();
              ?>
            </td>
          </tr>
        <?php endforeach;?>

        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td></td>
          <td><?php echo libelle("msg_libelle_total");?> </td>
          <td><?php echo formatMontantFr($total); ?></td>
        </tr>

        <tr class="<?php echo $intCle % 2 == 0 ? "impair" : "pair" ?>">
          <td></td>
          <td><?php echo libelle("msg_libelle_reserve");?> </td>
          <td>
            <?php $reserve = $objConvention->getMontant() - $total;
                  echo formatMontantFr($reserve);
            ?>
          </td>
        </tr>

      </tbody>
    </table>
  <?php endif;?>

  <?php else :?>
    <p><?php echo libelle("msg_dossier_mris_aucune_convention");?></p>
  <?php endif;?>
</div>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/lister".$type_dossier."s", array("class" => "picto bt_retour")); ?>
</div>