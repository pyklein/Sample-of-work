<ul id="onglets">
  <li <?php if ($ongletActif == 1)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_description"), "dossier_mris/voirDescriptionDossier_postdoc?id=".$strId); ?>
  </li>
  <?php if ($isProposition) { ?>
    <?php if ($hasCredentialsEvaluation) { ?>
    <li <?php if ($ongletActif == 2)  echo "class=actif"; ?> >
      <?php echo link_to_grid(libelle("msg_libelle_evaluations_dossier"), "dossier_mris/voirEvaluationDossier_postdoc?id=".$strId); ?>
    </li>
    <?php } else { ?>
    <li class="inactif" >
      <?php echo libelle("msg_libelle_evaluations_dossier"); ?>
    </li>
    <?php } ?>
  <?php } ?>
  <li <?php if ($ongletActif == 3)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_suivi_aboutissement_dossier"), "dossier_mris/voirSuiviDossier_postdoc?id=".$strId); ?>
  </li>
</ul>
