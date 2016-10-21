<?php use_helper("Message"); ?>
<h3>
  <?php echo libelle("msg_titre_dossier_bpi", array($objDossier)); ?>
</h3>

<?php echo message(); ?>

<div class="reduit">
  <!-- Ajout -->
  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_nouveau_brevet"), "dossier_bpi/creerBrevet?dossier_bpi_id=".$objDossier->getId(), array("class" => "picto bt_ajouter", "title" => libelle("msg_bouton_nouveau_brevet"))); ?>
  </div>

  <!-- Liste -->
  <?php if ($objPager->count() != 0 ) : ?>
    <table class="mep">
      <caption>
        <?php echo libelle("msg_brevet_nombre_resultat", array($objPager->count())); ?>
      </caption>
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_actions"); ?></th>
          <th><?php echo libelle("msg_libelle_numero_demande"); ?></th>
          <th><?php echo libelle("msg_libelle_numero_publication"); ?></th>
          <th><?php echo libelle("msg_libelle_titre"); ?></th>
          <th><?php echo libelle("msg_libelle_type"); ?></th>
          <th><?php echo libelle("msg_libelle_phase_depot"); ?></th>
          <th><?php echo libelle("msg_libelle_statut_systeme"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($objPager as $intCle => $objBrevet) { ?>
          <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
            <td>
              <?php echo link_to_grid("", "dossier_bpi/modifierBrevet?id=".$objBrevet->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
              <?php echo $objBrevet->getEstActif() ?
                      link_to_grid("", "dossier_bpi/changerActivationBrevet?id=".$objBrevet->getId()."&dossier_bpi_id=".$objDossier->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                      link_to_grid("", "dossier_bpi/changerActivationBrevet?id=".$objBrevet->getId()."&dossier_bpi_id=".$objDossier->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer"))); ?>
              <?php echo link_to_grid("", "dossier_bpi/genererDocumentsBrevet?id=".$objBrevet->getId(), array("class" => "picto_court bt_documents", "title" => libelle("msg_bouton_documents"))); ?>
            </td>
            <td><?php echo $objBrevet->getNumeroDemande(); ?></td>
            <td><?php echo $objBrevet->getNumeroPublication(); ?></td>
            <td><?php echo $objBrevet->getTitre(); ?></td>
            <td><?php echo $objBrevet->getType_depot()->getIntituleComplet(); ?></td>
            <td><?php echo $objBrevet->getPhase_depot_brevet()->getIntitule(); ?></td>
            <td class="centre"><?php echo $objBrevet->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  
    <?php if ($objPager->haveToPaginate()) : ?>
      <?php include_partial('interface/paginateur', array('objPager' => $objPager, 'strUrlRedirection' => $strUrlRedirection)) ?>
    <?php endif; ?>

    <?php if ($objPager->count() > 0) : ?>
      <?php include_partial('interface/maxParPage', array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
    <?php endif; ?>
  
  <?php else: ?>
     <?php echo libelle("msg_brevet_aucun_resultat"); ?>
  <?php endif; ?>

</div>

<?php include_partial('autreActions',array('id' => $objDossier->getId())) ?>

<hr class="clear">

<div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerDossier_bpis", array("class" => "picto bt_retour")); ?>
</div>



