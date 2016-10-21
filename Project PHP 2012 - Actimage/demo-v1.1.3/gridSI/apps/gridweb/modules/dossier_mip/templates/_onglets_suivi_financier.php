
<ul id="onglets">
  <li <?php if ($ongletActif == 1)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_budgets"), "dossier_mip/suiviFinancierDossier_mips?dossier_mip=".$strId); ?>
  </li>
  <li <?php if ($ongletActif == 2)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_financements"), "dossier_mip/listerFinancementDossier_mips?dossier_mip=".$strId); ?>
  </li>
  <li <?php if ($ongletActif == 3)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_engagements"), "dossier_mip/listerEngagementDossier_mips?dossier_mip=".$strId); ?>
  </li>
  <li <?php if ($ongletActif == 4)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_paiements"), "dossier_mip/listerPaiementDossier_mips?dossier_mip=".$strId); ?>
  </li>
</ul>
