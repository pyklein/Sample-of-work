
<ul id="onglets">
  <li <?php if ($ongletActif == 1)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_description_dossier"), "dossier_mip/voirDescriptionDossier_mip?id=".$strId); ?>
  </li>
  <li <?php if ($ongletActif == 2)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_calendrier"), "dossier_mip/voirCalendrierDossier_mip?id=".$strId); ?>
  </li>
  <li <?php if ($ongletActif == 3)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_valorisation"), "dossier_mip/voirValorisationDossier_mip?id=".$strId); ?>
  </li>
</ul>
