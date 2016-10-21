<ul id="onglets">
  <?php if ($arrInventeurs != NULL){?>
  <?php foreach ($arrInventeurs as $objInventeur): ?>
    <li <?php if ($objInventeur->getId() == $checkInventeur && $ongletActif == 1) echo "class=actif"; ?>>
      <?php echo link_to_grid($objInventeur, "dossier_bpi/modifierContentieux?dossier_bpi_id=" . $dossierId . "&inventeur_id=" . $objInventeur->getId()); ?>
    </li>
  <?php
    endforeach;
  }
  ?>
    <li <?php if ($ongletActif == 2) echo "class=actif"?>>
      <?php echo link_to_grid(libelle("msg_libelle_contentieux_tiers"), "dossier_bpi/modifierContentieuxAvecTiers?dossier_bpi_id=" . $dossierId . "&inventeur_id=" . $objInventeur->getId()); ?>
    </li>


</ul>
