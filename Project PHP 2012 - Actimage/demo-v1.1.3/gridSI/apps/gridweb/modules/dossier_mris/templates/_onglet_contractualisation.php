<ul id="onglets">
  <li <?php if ($ongletActif == 1)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_description"), "dossier_mris/modifierContractualisation_".$type_dossier."?dossier_id=".$dossierId); ?>
  </li>
  <li <?php if ($ongletActif == 2)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_versement"), "dossier_mris/modifierFinancement_".$type_dossier."?dossier_id=".$dossierId); ?>
  </li>
</ul>

