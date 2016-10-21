<ul id="onglets">

  <?php if (sfContext::getInstance()->getUser()->peutAcceder("dossier_mris", "modifier".$strNomModel."")) { ?>
    <li <?php if ($ongletActif == 1)  echo "class=actif"; ?> >
      <?php echo link_to_grid(libelle("msg_libelle_description_dossier"), "dossier_mris/modifier".$strNomModel."?id=".$strId); ?>
    </li>
  <?php } ?>

  <?php if (sfContext::getInstance()->getUser()->peutAcceder("dossier_mris", "modifierProposant_".$strNomModel."")) { ?>
    <li <?php if ($ongletActif == 2)  echo "class=actif"; ?> >
      <?php echo link_to_grid(libelle("msg_libelle_proposant"), "dossier_mris/modifierProposant_".$strNomModel."?".strtolower($strNomModel)."_id=".$strId); ?>
    </li>
  <?php } ?>

  <?php if (sfContext::getInstance()->getUser()->peutAcceder("dossier_mris", "modifierEncadrants_".$strNomModel."")) { ?>
    <li <?php if ($ongletActif == 3)  echo "class=actif"; ?> >
      <?php echo link_to_grid(libelle("msg_libelle_encadrants"), "dossier_mris/modifierEncadrants_".$strNomModel."?".strtolower($strNomModel)."_id=".$strId."&start=true"); ?>
    </li>
  <?php } ?>

  <?php if (sfContext::getInstance()->getUser()->peutAcceder("dossier_mris", "modifierLaboratoires_".$strNomModel."")) { ?>
    <li <?php if ($ongletActif == 4)  echo "class=actif"; ?> >
      <?php echo link_to_grid(libelle("msg_libelle_laboratoires"), "dossier_mris/modifierLaboratoires_".$strNomModel."?".strtolower($strNomModel)."_id=".$strId."&start=true"); ?>
    </li>
  <?php } ?>

  <?php if (sfContext::getInstance()->getUser()->peutAcceder("dossier_mris", "listerSuivi_".$strNomModel."s")) { ?>
    <li <?php if ($ongletActif == 5)  echo "class=actif"; ?> >
      <?php echo link_to_grid(libelle("msg_libelle_suivi"), "dossier_mris/listerSuivi_".$strNomModel."s?".strtolower($strNomModel)."_id=".$strId); ?>
    </li>
  <?php } ?>

  <?php if (sfContext::getInstance()->getUser()->peutAcceder("dossier_mris", "modifierAboutissement_".$strNomModel."")) { ?>
    <li <?php if ($ongletActif == 6)  echo "class=actif"; ?> >
      <?php echo link_to_grid(libelle("msg_libelle_aboutissement"), "dossier_mris/modifierAboutissement_".$strNomModel."?".strtolower($strNomModel)."_id=".$strId); ?>
    </li>
  <?php } ?>

  <?php if ($strNomModel == 'Dossier_these') :?>
    <?php if (sfContext::getInstance()->getUser()->peutAcceder("dossier_mris", "modifierCofinance_these")) { ?>
      <li <?php if ($ongletActif == 7)  echo "class=actif"; ?> >
        <?php echo link_to_grid(libelle("msg_libelle_cofinance"), "dossier_mris/modifierCofinance_these?dossier_these=".$strId."&start=true"); ?>
      </li>
    <?php } ?>
  <?php endif; ?>

</ul>
