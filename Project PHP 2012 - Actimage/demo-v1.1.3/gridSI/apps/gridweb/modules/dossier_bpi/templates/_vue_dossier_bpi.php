
<ul id="onglets">
  <li <?php if ($ongletActif == 1)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_description_dossier"), "dossier_bpi/voirDescriptionDossier_bpi?id=".$strId); ?>
  </li>
  <li <?php if ($ongletActif == 2)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_valorisations_recompenses"), "dossier_bpi/voirValorisationEtRecompensesDossier_bpi?id=".$strId); ?>
  </li>
  <li <?php if ($ongletActif == 3)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_brevets_contrats"), "dossier_bpi/voirBrevetsEtContratsDossier_bpi?id=".$strId); ?>
  </li>
</ul>
