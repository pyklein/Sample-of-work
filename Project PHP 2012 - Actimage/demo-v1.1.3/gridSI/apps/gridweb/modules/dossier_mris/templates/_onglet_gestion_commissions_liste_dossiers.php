<ul id="onglets">
  
  <?php if ($objCommission->getEstAnalyse()):  ?>
  <li <?php if ($ongletActif == 1)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_propositions"), "dossier_mris/listerDossiersCommission?id=".$strId."&proposition=true"); ?>
  </li>
  <?php endif; ?>

  <?php if ($objCommission->getEstSuivi()):  ?>
  <li <?php if ($ongletActif == 2)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_dossiers_en_cours"), "dossier_mris/listerDossiersCommission?id=".$strId."&EnCours=true"); ?>
  </li>
  <?php endif; ?>
</ul>