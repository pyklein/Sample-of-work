<div id="menu_2">

  <?php if (sfContext::getInstance()->getUser()->isAuthenticated()) { ?>

    <?php if (sfContext::getInstance()->getUser()->hasMetier(MetierTable::MIP)) { ?>

      <ul>
        <li>
          <span><?php echo libelle("msg_titre_dossiers_innovation"); ?></span>
          <ul>
            <?php echo link_to_grid_liste(libelle("msg_menu_gerer_dossier_mip"), "dossier_mip/listerDossier_mips"); ?>
            <?php echo link_to_grid_liste(libelle("msg_menu_utilisateurs_innovateurs"), "utilisateurs/rechercherInnovateurs"); ?>
            <?php echo link_to_grid_liste(libelle("msg_menu_suivis_financier_dossier_mip"), "dossier_mip/listerSuiviFinancierDossier_mips"); ?>
            <?php echo link_to_grid_liste(libelle("msg_menu_statistiques_dossier_mip"), "dossier_mip/voirRapportStatistique"); ?>
            <?php echo link_to_grid_liste(libelle("msg_menu_tableau_de_bord_dossier_mip"), "dossier_mip/voirTableauBordMip"); ?>
          </ul>
        </li>
      </ul>
  
    <?php } ?>
    <?php if (sfContext::getInstance()->getUser()->hasMetier(MetierTable::MRIS)) { ?>

      <ul>
        <li>
          <span><?php echo libelle("msg_titre_dossiers_these"); ?></span>
          <ul>
            <?php echo link_to_grid_liste(libelle("msg_menu_gerer_dossier_these"), "dossier_mris/listerDossier_theses"); ?>
            <?php echo link_to_grid_liste(libelle("msg_menu_rechercher_dossier_these"), "dossier_mris/rechercherDossier_theses"); ?>
            <?php echo link_to_grid_liste(libelle("msg_menu_statistiques_tableau_de_bord_dossier_these"), "dossier_mris/voirRapportStatistiquesEtTableauDeBord_Dossier_these"); ?>
          </ul>
        </li>
      </ul>
      <ul>
        <li>
          <span><?php echo libelle("msg_titre_dossiers_postdoc"); ?></span>
          <ul>
            <?php echo link_to_grid_liste(libelle("msg_menu_gerer_dossier_postdoc"), "dossier_mris/listerDossier_postdocs"); ?>
            <?php echo link_to_grid_liste(libelle("msg_menu_rechercher_dossier_postdoc"), "dossier_mris/rechercherDossier_postdocs"); ?>
            <?php echo link_to_grid_liste(libelle("msg_menu_statistiques_tableau_de_bord_dossier_postdoc"), "dossier_mris/voirRapportStatistiquesEtTableauDeBord_Dossier_postdoc"); ?>
          </ul>
        </li>
      </ul>
	  
      <ul>
        <li>
          <span><?php echo libelle("msg_titre_dossiers_ere"); ?></span>
          <ul>
            <?php echo link_to_grid_liste(libelle("msg_menu_gerer_dossier_ere"), "dossier_mris/listerDossier_eres"); ?>
            <?php echo link_to_grid_liste(libelle("msg_menu_rechercher_dossier_ere"), "dossier_mris/rechercherDossier_eres"); ?>
            <?php echo link_to_grid_liste(libelle("msg_menu_statistiques_tableau_de_bord_dossier_ere"), "dossier_mris/voirRapportStatistiquesEtTableauDeBord_Dossier_ere"); ?>
          </ul>
        </li>
      </ul>
	  
      <ul>
        <li>
          <span><?php echo libelle("msg_titre_commissions"); ?></span>
          <ul>
            <?php echo link_to_grid_liste(libelle("msg_menu_gerer_commissions"), "dossier_mris/listerCommissions"); ?>
          </ul>
        </li>
      </ul>

    <?php } ?>
    <?php if (sfContext::getInstance()->getUser()->hasMetier(MetierTable::BPI)) { ?>

      <ul>
        <li>
          <span><?php echo libelle("msg_titre_dossiers_bpi"); ?></span>
          <ul>
            <li><?php echo link_to_grid_liste(libelle("msg_menu_gerer_dossier_bpi"), "dossier_bpi/listerDossier_bpis"); ?></li>
            <li><?php echo link_to_grid_liste(libelle("msg_menu_statistiques_dossier_bpi"), "dossier_bpi/voirRapportStatistique"); ?></li>
          </ul>
        </li>
      </ul>

    <?php } ?>
  
  <?php } ?>
  
</div>
