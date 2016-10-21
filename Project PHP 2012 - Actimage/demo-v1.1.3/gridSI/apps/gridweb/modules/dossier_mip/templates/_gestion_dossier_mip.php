
<ul id="onglets">
  <li<?php if ($ongletActif == 1)  echo " class=actif"; ?>><?php echo link_to_grid(libelle("msg_libelle_informations_generales"), "dossier_mip/modifierDossier_mip?id=".$strId); ?></li>
  <?php if (!isset($boolEstPreProjet) || !$boolEstPreProjet) : ?>
  <li<?php if ($ongletActif == 2)  echo " class=actif"; ?>><?php echo link_to_grid(libelle("msg_libelle_innovateurs"), "dossier_mip/modifierInnovateurs?dossier_mip=".$strId."&start=true"); ?></li>
  <li<?php if ($ongletActif == 3)  echo " class=actif"; ?>><?php echo link_to_grid(libelle("msg_libelle_calendrier"), "dossier_mip/modifierCalendrier_dossier_mip?id=".$strId); ?></li>
  <li<?php if ($ongletActif == 4)  echo " class=actif"; ?>><?php echo link_to_grid(libelle("msg_libelle_valorisation"), "dossier_mip/modifierValorisation?dossier_mip=".$strId); ?></li>
  <?php endif; ?>
</ul>
