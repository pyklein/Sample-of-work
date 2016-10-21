
<ul id="onglets">
  <li <?php if ($ongletActif == 1)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_informations_generales"), "referentiel_mris/modifierEtudiant?id=".$strId); ?>
  </li>
  <li <?php if ($ongletActif == 2)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_photographie"), "referentiel_mris/modifierPhotoEtudiant?etudiant=".$strId); ?>
  </li>  
  <li <?php if ($ongletActif == 3)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_formations"), "referentiel_mris/modifierFormationEtudiant?etudiant=".$strId); ?>
  </li>   
</ul>
