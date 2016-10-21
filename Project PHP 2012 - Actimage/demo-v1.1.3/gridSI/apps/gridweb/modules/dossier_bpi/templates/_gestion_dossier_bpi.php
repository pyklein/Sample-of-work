
<ul id="onglets">
  <li <?php if ($ongletActif == 1)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_description"), "dossier_bpi/modifierDossier_bpi?id=".$strId); ?>
  </li>
  <li <?php if ($ongletActif == 2)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_parts_inventives"), "dossier_bpi/modifierSituation_inventeurs?dossier_bpi=".$strId."&start=true"); ?>
  </li>  
  <li <?php if ($ongletActif == 3)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_onglet_classement"), "dossier_bpi/modifierClassement?dossier_bpi=".$strId); ?>
  </li>   
  <li <?php if (!$estBrevetable) echo "class=inactif"; else if ($ongletActif == 4)  echo "class=actif"; ?> >
    <?php
      if ($estBrevetable) {
        echo link_to_grid(libelle("msg_libelle_droits"), "dossier_bpi/modifierDroits?dossier_bpi=".$strId);
      } else {
        echo libelle("msg_libelle_droits");
      }
    ?>
  </li>
  <li <?php if ($ongletActif == 5)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_valorisation"), "dossier_bpi/modifierValorisation?dossier_bpi=".$strId."&start=true"); ?>
  </li>
  <li <?php if ($ongletActif == 6)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_exploitation"), "dossier_bpi/modifierExploitation?dossier_bpi=".$strId); ?>
  </li>
</ul>
