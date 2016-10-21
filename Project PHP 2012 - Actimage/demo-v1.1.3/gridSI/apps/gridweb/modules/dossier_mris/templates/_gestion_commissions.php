
<ul id="onglets">
  <li <?php if ($ongletActif == 1)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_description_commission"), "dossier_mris/modifierCommission?id=".$strId); ?>
  </li>
  <li <?php if ($ongletActif == 2)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_participants_mindef"), "dossier_mris/modifierParticipants_mindef?commission=".$strId."&start=true"); ?>
  </li>
  <li <?php if ($ongletActif == 3)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_participants_exterieur"),"dossier_mris/modifierParticipants_exterieurs?commission=".$strId."&start=true"); ?>
  </li>
  <li <?php if ($ongletActif == 4)  echo "class=actif"; ?> >
    <?php echo link_to_grid(libelle("msg_libelle_invitations_et_inscriptions"),"dossier_mris/modifierInvitations?id=".$strId."&start=true"); ?>
  </li>
</ul>
