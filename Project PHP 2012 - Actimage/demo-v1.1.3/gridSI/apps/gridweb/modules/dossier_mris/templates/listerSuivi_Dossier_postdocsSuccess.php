<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php echo message(); ?>

<?php include_partial('dossier_mris/onglet_dossier', array('strNomModel' => $strModelContenant, 'strId' => $strIdContenant, 'ongletActif' => 5)) ?>

<div id="zone_cadre" class="reduit">

  <!--Le formulaire d'ajout d'évènement-->
  <?php if ($objDossier->getEstActif()): ?>
    <form action="" method="post">
      <fieldset class="fieldset_formulaire">
        <legend>
          <?php echo libelle("msg_module_".strtolower($strModelContenant)."_action_creer_suivi") ?>
        </legend>
        <?php echo $objForm; ?>
        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_creer_suivi"); ?>" />
        </div>
      </fieldset>
      <br />
    </form>
  <?php endif; ?>

  <!--Initialisation de variables-->
  <?php $strTypeCourant ="";
  ?>

  <?php if($objPager->count() != 0): ?>
    <fieldset>
      <legend>
        <?php echo libelle("msg_fieldset_suivi_postdoc")?>
      </legend>
      <!--Liste des éléments de suivi-->
      <?php foreach ($objPager->getResults() as $objSuivi): ?>

        <!--Construction d'une chaine permettant de récuperer le type de l'évènement selon le type du dossier-->
        <?php $arrTypes = explode("_",$strModelContenant);
              $strTypeDossier = $arrTypes[1];
              $strGet = 'getType_suivi_'.$strTypeDossier;
              $strType = $objSuivi->$strGet();
                ?>

        <!--Affichage du suivi-->
        <p class="underline"><big><b>
          <?php if($strType != $strTypeCourant)
                {
                  echo $strType;
                  $strTypeCourant = $strType;
                }
          ?></b></big>
        </p>

        <p><?php echo $objSuivi->getDescriptif()." - ".
                link_to_grid(libelle("msg_suivi_postdoc_libelle_edit"),"dossier_mris/modifierSuivi". $strModelContenant."?id=".$objSuivi->getId()."&dossier_id=".$objDossier->getId(),array("class" => "picto bt_modifier"))." ".
                link_to_grid(libelle("msg_suivi_postdoc_libelle_del"),"dossier_mris/supprimerSuivi". $strModelContenant."?id=".$objSuivi->getId()."&dossier_id=".$objDossier->getId(),array("class" => "picto bt_supprimer")) ?>
        </p>
        <p><?php if($objSuivi->getDate_reception() != null)
                 {
                    echo libelle("msg_message_suivi_element_recu_postdoc",array(formatDate($objSuivi->getDate_demande()),formatDate($objSuivi->getDate_reception()),formatDate($objSuivi->getDate_echeance())));
                 }
                 else
                 {
                    echo libelle("msg_message_suivi_element_nonrecu_postdoc",array(formatDate($objSuivi->getDate_demande()),formatDate($objSuivi->getDate_echeance())));
                 }
            ?>
        </p>
       <br>
      <?php endforeach ?>
     </fieldset>

    
    <?php if ($objPager->haveToPaginate()) : ?>
      <?php include_partial('interface/paginateur', array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
    <?php endif; ?>

    <?php if ($objPager->count() > 0) : ?>
      <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
    <?php endif; ?>

  <?php endif;?>
</div>

<?php include_partial('autreActionsMris',array('strNomModel' => $strModelContenant,'id' => $objDossier->getId())) ?>

<hr class="clear" />

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/lister".$strModelContenant."s", array("class" => "picto bt_retour")); ?>
</div>
