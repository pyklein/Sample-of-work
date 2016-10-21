<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<h3>
  <?php echo libelle('msg_libelle_redevance_lie_dossier_bpi', array($objDossier));?>
</h3>

<?php echo message(); ?>

<div class="reduit">
  <!-- Ajout -->
  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_ajouter_redevance"), "dossier_bpi/creerRedevance?dossier_bpi_id=".$objDossier->getId(), array("class" => "picto bt_ajouter", "title" => libelle("msg_bouton_ajouter_redevance"))); ?>
  </div>

  <!-- Liste -->
  <?php if ($objPager->count() != 0 ) : ?>
    <table class="mep">
      <caption>
        <?php echo libelle("msg_redevance_nombre_resultat", array($objPager->count())); ?>
      </caption>
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_actions"); ?></th>
          <th><?php echo libelle("msg_libelle_organisme"); ?></th>
          <th><?php echo libelle("msg_libelle_type"); ?></th>
          <th><?php echo libelle("msg_libelle_montant"); ?></th>
          <th><?php echo libelle("msg_libelle_statut_systeme"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($objPager as $intCle => $objRedevance) { ?>
          <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
            <td>
              <?php echo link_to_grid("", "dossier_bpi/modifierRedevance?id=".$objRedevance->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
              <?php echo $objRedevance->getEstActif() ?
                      link_to_grid("", "dossier_bpi/changerActivationRedevance?id=".$objRedevance->getId()."&dossier_bpi_id=".$objDossier->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                      link_to_grid("", "dossier_bpi/changerActivationRedevance?id=".$objRedevance->getId()."&dossier_bpi_id=".$objDossier->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer"))); ?>
            </td>
            <td><?php echo $objRedevance->getOrganisme()->getIntitule(); ?></td>
            <td><?php echo $objRedevance->getType_redevance()->getIntitule(); ?></td>
            <td><?php echo formatMontantFr($objRedevance->getMontant()); ?></td>
            <td><?php echo $objRedevance->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
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
    <?php echo libelle("msg_redevance_aucun_resultat"); ?>
  <?php endif; ?>

</div>

<?php include_partial('autreActions',array('id' => $objDossier->getId())) ?>

<hr class="clear">

<div class="left">
    <?php echo link_to(libelle("msg_bouton_retour_dossier_bpi"), "dossier_bpi/listerDossier_bpis", array("class" => "picto bt_retour")); ?>
</div>

