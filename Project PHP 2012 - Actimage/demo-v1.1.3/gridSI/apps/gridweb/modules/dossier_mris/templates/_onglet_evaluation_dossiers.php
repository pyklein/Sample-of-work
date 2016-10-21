<ul id="onglets">
  <li <?php if ($ongletActif == 1)  echo "class=actif"; ?> >
    <?php 
    if($strListe == 'liste_commission'){
      echo link_to_grid(libelle("msg_libelle_evaluation_preselection"), "dossier_mris/evaluerCommissionPreselection?".$strModelContenant."_id=".$strId."&commission=true");
    }else if($strListe == 'liste_dossier'){
      echo link_to_grid(libelle("msg_libelle_evaluation_preselection"), "dossier_mris/evaluerPreselectionDossier?".$strModelContenant."_id=".$strId."&dossier=true");
    }
    ?>
  </li>

  <li <?php if ($ongletActif == 2)  echo "class=actif"; ?> >
     <?php
       if($strListe == 'liste_commission')
       {
        echo link_to_grid(libelle("msg_libelle_evaluation_selection"), "dossier_mris/evaluerSelectionDossier?".$strModelContenant."_id=".$strId."&commission=true");
       }
       else if($strListe == 'liste_dossier')
       {
        echo link_to_grid(libelle("msg_libelle_evaluation_selection"), "dossier_mris/evaluerSelectionDossier?".$strModelContenant."_id=".$strId."&dossier=true");      
       }
     ?>
  </li>

   <li <?php if ($ongletActif == 3)  echo "class=actif"; ?> >
    <?php 
    if($strListe == 'liste_commission'){
      echo link_to_grid(libelle("msg_libelle_evaluation_finale"), "dossier_mris/evaluerDossierFinale?".$strModelContenant."_id=".$strId."&commission=true");
    }else if($strListe == 'liste_dossier'){
      echo link_to_grid(libelle("msg_libelle_evaluation_finale"), "dossier_mris/evaluerDossierFinale?".$strModelContenant."_id=".$strId."&dossier=true");
    }
    ?>
  </li>
  
</ul>