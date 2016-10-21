<?php use_helper("Message"); ?>
<?php echo message(); ?>

<?php 
  if ($checkBonnePage == 'proposition') {
    include_partial('dossier_mris/onglet_gestion_commissions_liste_dossiers', array( 'strId' => $strId,'objCommission' => $objCommission ,'ongletActif' => 1)) ;
  } else if ($checkBonnePage == 'EnCours') {
    include_partial('dossier_mris/onglet_gestion_commissions_liste_dossiers', array( 'strId' => $strId,'objCommission' => $objCommission, 'ongletActif' => 2)) ;
  }
?>

<div id="zone_cadre">
  <?php if($checkListeNonVide) { ?>

    <?php foreach ($arrDomaineScientifique as $domaineSc) { ?>
      <?php if ($arrPager[$domaineSc->getId()]->count() != 0) { ?>
        <br />
        <table class="mep">
          <caption>
            <?php echo libelle("msg_libelle_liste_proposition_dans", array($domaineSc->getIntitule())); ?>
          </caption>
          <thead>
            <tr>
              <th><?php echo libelle("msg_libelle_actions"); ?></th>
              <th><?php echo libelle("msg_libelle_numero"); ?></th>
              <th><?php echo libelle("msg_libelle_intitule"); ?></th>
              <th><?php echo libelle("msg_libelle_proposant_etudiant"); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($arrPager[$domaineSc->getId()] as $intCle => $objDossier) { ?>

              <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
                <td width="10%">
                  <?php if($checkBonnePage == 'proposition') echo link_to_grid("", "dossier_mris/evaluerCommissionPreselection?".strtolower($strModelContenant)."_id=". $objDossier->getId()."&commission_id=".$objCommission->getId(), array("class" => "picto_court bt_evaluations", "title" => libelle("msg_bouton_evaluation"))); ?>
                  <?php if($checkBonnePage == 'EnCours') echo link_to_grid("", "dossier_mris/suiviCommissionDossier?".  strtolower($strModelContenant)."_id=" . $objDossier->getId()."&commission_id=" . $objCommission->getId() , array("class" => "picto_court bt_suivi", "title" => libelle("msg_bouton_suivi"))); ?>
                </td>
                <td width="20%"><?php echo $objDossier->getNumeroAAfficher(); ?></td>
                <td width="30%"><?php echo $objDossier->getTitre(); ?></td>

                <td width="40%"><?php echo $objDossier->getEtudiant()->getNom()." ". $objDossier->getEtudiant()->getPrenom() ; ?></td>

              </tr>

            <?php } //fin foreach $arrDossiers ?>
          </tbody>
        </table>

        <?php
          if ($arrPager[$domaineSc->getId()]->haveToPaginate()) {
            include_partial('interface/paginateur', array('objPager' => $arrPager[$domaineSc->getId()], 'strUrlRedirection' => $strUrlRedirection,'intIdPager' => $domaineSc->getId())) ;
          }

          if ($arrPager[$domaineSc->getId()]->count() > 0) {
            include_partial('interface/maxParPage', array('intSelectionne' => $intSelectionne, 'arrNombres' => $arrNombres, 'intIdPager' => $domaineSc->getId())) ;
          }
        ?>

      <?php } ?>

    <?php } //fin foreach domaine_scientifique ?>

  <?php } else {//fin ChecklisteNonVide ?>
    <?php echo libelle("msg_lister_dossier_commission_aucun_dossier"); ?>
  <?php } ?>
  <br />
</div>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_commission"), "dossier_mris/listerCommissions", array("class" => "picto bt_retour")); ?>
</div>
