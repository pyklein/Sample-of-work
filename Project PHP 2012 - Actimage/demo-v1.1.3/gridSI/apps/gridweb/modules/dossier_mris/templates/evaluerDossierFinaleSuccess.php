<?php use_helper("Message"); ?>
<?php echo message(); ?>


<div id="titre_evaluation_dossier">
  <?php echo libelle("msg_libelle_evaluation_dossier_numero", array($objDossier->getNumeroAAfficher())); ?>
</div>
<br />
<div class="sous_titre_evaluation_dossier">
  <?php echo libelle("msg_libelle_titre_dossier", array($objDossier->getTitre())); ?>
</div>
<div class="sous_titre_evaluation_dossier">
  <?php echo libelle("msg_libelle_objet_dossier", array($objDossier->getRaw('objet'))); ?>
</div>
<div class="sous_titre_evaluation_dossier">
  <?php echo libelle("msg_libelle_etudiant", array($objDossier->getEtudiant())); ?>
</div>
<br />

<?php
if($boolListeCommission){
  include_partial('dossier_mris/onglet_evaluation_dossiers', array('strListe'=> 'liste_commission' ,'strModelContenant' => strtolower($strModelContenant),  'strId' => $strId, 'ongletActif' => 3)) ;
}else if($boolListeDossier){
  include_partial('dossier_mris/onglet_evaluation_dossiers', array('strListe'=> 'liste_dossier', 'strModelContenant' => strtolower($strModelContenant),  'strId' => $strId, 'ongletActif' => 3)) ;
}
?>
<div>
  <div id="zone_cadre" class="reduit">
    <?php if(isset($commissionId)):?>
      <table class="mep">
      <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_identite_evaluateur"); ?></th>
        <th><?php echo libelle("msg_libelle_evaluation_finale"); ?></th>
      </tr>
    </thead>
    <tbody>

      <tr class="impair">
        <td>
          <?php echo libelle("msg_libelle_preselection");?>
        </td>

        <td> <?php echo $notePreselection ?></td>
      </tr>

      <?php foreach ($arrInvitations as $intCle => $objInvitation) { ?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">

         <td>
           <?php if($objInvitation->getServiceId() != null) echo $objInvitation->getService()->getIntitule(), " (".$objInvitation->getService()->getOrganisme()->getIntitule().")";?>
           <?php if($objInvitation->getLaboratoireId() != null) echo $objInvitation->getLaboratoire()->getIntitule(), " (".$objInvitation->getLaboratoire()->getOrganisme()->getIntitule().")";?>
         </td>

         <td> <?php echo $arrNotesInvitation[$objInvitation->getId()] ?></td>

        </tr>

      <?php } ?>
      </tbody>
    </table>
    <?php else:
      {
        echo libelle("msg_libelle_aucune_commission_selection");
      }
    ?>
    <?php endif;?>

    <form action="" method="post" >

      <?php echo $objForm ; ?>

      <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer"); ?>" />
      </div>
    </form>
    
    
  </div>


  <?php include_partial('autreActionsMris',array('strNomModel'=> $strModelContenant, 'id' => $strId, 'boolEstDansEvaluation' => true)) ?>
</div>

<hr class="clear"/>
<div class="left">
    <?php if(isset($commissionId)){
      echo link_to(libelle("msg_bouton_retour_dossier"), "dossier_mris/listerDossiersCommission?id=".$commissionId."&proposition=true", array("class" => "picto bt_retour"));
    }else{
      echo link_to(libelle("msg_bouton_retour_dossier"), "dossier_mris/lister".$strModelContenant."s", array("class" => "picto bt_retour"));
    }
    ?>
</div>