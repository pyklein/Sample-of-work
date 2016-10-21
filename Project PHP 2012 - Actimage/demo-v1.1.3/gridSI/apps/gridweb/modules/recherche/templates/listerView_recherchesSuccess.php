<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php echo message(); ?>

<!-- Filtre -->
<div class="filtre">
  <form action="" method="post" name="filtre">
    <fieldset>
      <legend>
        <?php echo libelle('msg_libelle_critere_recherche') ?>
      </legend>
      
      <?php echo $objFormFiltre["numero_dossier"]->renderRow(); ?>
      <?php echo $objFormFiltre["titre"]->renderRow(); ?>
      <?php echo $objFormFiltre["metier_id"]->renderRow(); ?>
      <?php echo $objFormFiltre["created_at"]->renderRow(); ?>
      <?php echo $objFormFiltre["nom_prenom_email"]->renderRow(); ?>
      <?php echo $objFormFiltre["organisme_mindef_id"]->renderRow(); ?>
      <?php echo $objFormFiltre["organisme_id"]->renderRow(); ?>

      <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_lancer_recherche"); ?>" />
        <input type="submit" name="reset" value="<?php echo libelle('msg_bouton_reset_filtres') ?>" />
        
      </div>
    </fieldset>
  </form>
</div>

<br />

<!-- Liste -->
<?php if ($objPager->count() != 0) { ?>

  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_export_csv"), 'recherche/exporterView_recherchesCSV',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
  </div>

  <table class="mep">
    <caption>
      <?php echo libelle("msg_dossier_bpi_nombre_resultat", array($objPager->count())); ?>
    </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_actions"); ?></th>
        <th><?php echo libelle("msg_libelle_metier"); ?></th>
        <th><?php echo libelle("msg_libelle_intitule"); ?></th>
        <th><?php echo libelle("msg_libelle_personnes_concernees"); ?></th>
        <th><?php echo libelle("msg_libelle_date_creation"); ?></th>
        <th><?php echo libelle("msg_libelle_statut_partage"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager as $intCle => $objDossier) { ?>

        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php if ($objDossier->getEtatPartageId() == Etat_partageTable::PARTAGABLE && ($objDossier->getMetierId() != MetierTable::MRIS_ID) ){ ?>
              <?php echo link_to_grid("", "recherche/demanderPartage?id=".$objDossier->getId(), array("class" => "picto_court bt_demander_partage", "title" => libelle("msg_bouton_demander_partage"))); ?>
            <?php } else if ($objDossier->getEtatPartageId() == Etat_partageTable::PARTAGE) { ?>

              <?php
                if ($objDossier->getMetierId() == MetierTable::BPI_ID) {
                  echo link_to_grid("", "dossier_bpi/voirDescriptionDossier_bpi?id=".$objDossier->getDossierBpiId(), array("class" => "picto_court bt_voir", "title" => libelle("msg_bouton_voir")));
                } else if ($objDossier->getMetierId() == MetierTable::MIP_ID) {
                  echo link_to_grid("", "dossier_mip/voirDescriptionDossier_mip?id=".$objDossier->getDossierMipId(), array("class" => "picto_court bt_voir", "title" => libelle("msg_bouton_voir")));
                }
              ?>
            <?php } ?>
          </td>
          <td><?php echo $objDossier->getMetier()->getIntitule(); ?></td>
          <td><?php echo $objDossier->getTitre(); ?></td>
          <td>
            <?php foreach($objDossier->getPersonnesConcernes() as $intCle => $strPersonneConcerne) { ?>
              <?php echo ($intCle == 0 ? "" : ", ").$strPersonneConcerne; ?>
            <?php } ?>
          </td>
          <td><?php echo formatDate($objDossier->getCreatedAt()); ?></td>
          <td>
            <?php if ($objDossier->getEtatPartageId() == Etat_partageTable::PARTAGABLE) { ?>
              <?php echo libelle("msg_libelle_partageable"); ?>
            <?php } else if ($objDossier->getEtatPartageId() == Etat_partageTable::PARTAGE) { ?>
              <?php echo libelle("msg_libelle_partage"); ?>
            <?php } else { ?>
              <?php echo libelle("msg_libelle_non_partageable"); ?>
            <?php } ?>
          </td>
        </tr>

      <?php } ?>
        
    </tbody>
  </table>

  <?php if ($objPager->haveToPaginate()) { ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager, 'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php } ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne, 'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>

  
<?php } else { ?>

  <table class="mep">
    <caption>
      <?php echo libelle("msg_dossier_bpi_aucun_resultat"); ?>
    </caption>
  </table>

<?php } ?>
