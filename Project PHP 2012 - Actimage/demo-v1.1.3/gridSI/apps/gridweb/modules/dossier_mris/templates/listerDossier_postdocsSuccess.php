<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial("interface/conteneurFiltre",array("objFormFiltre"=>$objFormFiltre,"boolReinitialiser" => true)) ?>

<br />

<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_dossier_postdoc"), "dossier_mris/creerDossier_postdoc", array("class" => "picto bt_ajouter", "title" => libelle("msg_bouton_ajouter"))); ?>
</div>

<?php if ($objPager->count() != 0): ?>

  <table class="mep">
    <caption>
      <?php echo libelle("msg_dossier_postdoc_nombre_resultat", array($objPager->count())); ?>
    </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_actions"); ?></th>
        <th><?php echo libelle("msg_libelle_numero"); ?></th>
        <th><?php echo libelle("msg_libelle_intitule"); ?></th>
        <th><?php echo libelle("msg_libelle_date_creation"); ?></th>
        <th><?php echo libelle("msg_libelle_proposant_etudiant"); ?></th>
        <th><?php echo libelle("msg_libelle_statut"); ?></th>
        <th><?php echo libelle("msg_libelle_statut_systeme"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager as $intCle => $objDossier) { ?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td class="actions">
            <ul class="jsddm">
              <?php echo link_to_grid_liste("", "dossier_mris/modifierDossier_postdoc?id=" . $objDossier->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
              <?php
              echo $objDossier->getEstActif() ?
                      link_to_grid_liste("", "dossier_mris/changerActivationDossier_postdoc?id=" . $objDossier->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                      link_to_grid_liste("", "dossier_mris/changerActivationDossier_postdoc?id=" . $objDossier->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer")));
              ?>

              <?php echo link_to_grid_liste("", "dossier_mris/validerDossier?dossier_postdoc=" . $objDossier->getId() , array("class" => "picto_court bt_validation", "title" => libelle("msg_bouton_validation"))); ?>
              <?php if($objDossier->getStatutDossierPostdocId() == Statut_dossier_postdocTable::PROPOSITION) echo link_to_grid_liste("", "dossier_mris/evaluerDossierPreselection?dossier_postdoc_id=" . $objDossier->getId(), array("class" => "picto_court bt_evaluations", "title" => libelle("msg_bouton_evaluations"))); ?>
              <?php echo link_to_grid_liste("", "dossier_mris/listerSuivi_Dossier_postdocs?dossier_postdoc_id=" . $objDossier->getId() , array("class" => "picto_court bt_suivi", "title" => libelle("msg_bouton_suivi"))); ?>
              <?php echo link_to_grid_liste("", "dossier_mris/listerDocuments?dossier_postdoc=" . $objDossier->getId(), array("class" => "picto_court bt_documents", "title" => libelle("msg_bouton_documents"))); ?>
              <?php echo link_to_grid_liste("", "dossier_mris/listerRemarque_mris?dossier_postdoc=" . $objDossier->getId(), array("class" => "picto_court bt_remarques", "title" => libelle("msg_bouton_remarques"))); ?>
              <?php echo link_to_grid_liste("", "dossier_mris/listerEvenement_mris?dossier_postdoc=".$objDossier->getId(), array("class" => "picto_court bt_evenements", "title" => libelle("msg_bouton_evenements"))); ?>
              <?php echo link_to_grid_liste("", "dossier_mris/modifierContractualisation_Dossier_postdoc?dossier_id=" . $objDossier->getId(), array("class" => "picto_court bt_contractualisation", "title" => libelle("msg_bouton_contractualisation"))); ?>
              <?php echo link_to_grid_liste("", "dossier_mris/voirDescriptionDossier_postdoc?id=" . $objDossier->getId(), array("class" => "picto_court bt_voir", 'title' => libelle("msg_bouton_voir"))); ?>
              <?php echo sfConfig::get('app_menus_deroulants') ? include_partial('interface/listeActions') : '' ?>
            </ul>
          </td>
          <td>
            <?php if($objDossier->getNumeroDefinitif()!=NULL): ?>
              <?php echo $objDossier->getNumeroDefinitif() ?>
            <?php else: ?>
              <?php echo $objDossier->getNumeroProvisoire() ?>
            <?php endif;?>
          </td>
          <td><?php echo $objDossier->getTitre(); ?></td>
          <td><?php echo $objDossier->getDateTimeObject('created_at')->format('d/m/Y'); ?></td>
          <td><?php echo $objDossier->getEtudiant()->getNom()." ". $objDossier->getEtudiant()->getPrenom() ; ?></td>
          <td><?php echo $objDossier['Statut_dossier_postdoc']['intitule']; ?></td>
          <td class="centre"><?php echo $objDossier->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
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

  <table class="mep">
    <caption>
      <?php echo libelle("msg_dossier_postdoc_aucun_resultat"); ?>
    </caption>
  </table>

<?php endif; ?>
