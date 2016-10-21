<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php echo message(); ?>

<div class="reduit">
  <!--Le titre selon le type de dossier-->
  <div>
    <?php
      if ($strModelContenant == "Dossier_these"):
        echo libelle("msg_titre_dossier_these",array($objDossier->getTitre()));

      elseif($strModelContenant == "Dossier_postdoc"):
        echo libelle("msg_titre_dossier_postdoc",array($objDossier->getTitre()));

      elseif($strModelContenant == "Dossier_ere"):
        echo libelle("msg_titre_dossier_ere",array($objDossier->getTitre()));

      endif;
    ?>
  </div>

  <!--Le formulaire d'ajout d'évènement-->
  <?php if ($objDossier->getEstActif()): ?>
    <form action="" method="post">
      <fieldset class="fieldset_formulaire">
        <legend>
          <?php echo libelle("msg_module_".strtolower($strModelContenant)."_action_creer_evenementmris") ?>
        </legend>
        <?php echo $objForm; ?>
        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_creer_evenement"); ?>" />
        </div>
      </fieldset>
      <br />
    </form>
  <?php endif; ?>

  <!--Initialisation de variables-->
  <?php $strMoisCourant ="";
        $strAnneeCourante ="";
        $UtilDate = new UtilDate();
  ?>

  <!--Liste des évènements-->
  <?php foreach ($objPager->getResults() as $objEvenement): ?>
    <br>
    <br>
    <!--On récupère le mois et l'année-->
    <?php $arrDate = explode("/", formatDate($objEvenement->getDateEvenement()));
          $strMois = $arrDate[1];
          $strAnnee = $arrDate[2];
    ?>

    <!--Construction d'une chaine permettant de récuperer le type de l'évènement selon le type du dossier-->
    <?php $arrTypes = explode("_",$strModelContenant);
          $strTypeDossier = $arrTypes[1];
          $strGet = 'getType_evenement_'.$strTypeDossier;
            ?>

    <!--On affiche le mois et l'année seulement s'ils sont changés-->
    <p><b>
      <?php if($strMois!=$strMoisCourant || $strAnnee != $strAnneeCourante )
            {

              echo $UtilDate->getMoisFrByNumero($strMois)." ".$strAnnee ;
              $strMoisCourant = $strMois;
              $strAnneeCourante = $strAnnee;
            }
      ?></b><p>

    <!--Affichage de la date complète et le type de l'évènement-->
    <p><?php echo libelle("msg_evenement_mris_header",array(formatDate($objEvenement->getDateEvenement())))?> </p>
    <p><?php echo $objEvenement->$strGet() ?></p>

    <fieldset>
      <?php echo $objEvenement->getRaw('description') ?>
    </fieldset>

    <?php if (($objUser->getUtilisateur()->getId() == $objEvenement->getCreated_by()) || ($objUser->hasCredential("SUP-MRIS"))) :?>
      <div class="right">
        <?php echo link_to_grid(libelle("msg_evenement_mris_libelle_edit"),"dossier_mris/modifierEvenement_mris?id=".$objEvenement->getId()."&dossier_id=".$objDossier->getId(),array("class" => "picto bt_modifier")) ?>
        <?php echo link_to_grid(libelle("msg_evenement_mris_libelle_del"),"dossier_mris/supprimerEvenement_mris?id=".$objEvenement->getId()."&dossier_id=".$objDossier->getId(),array("class" => "picto bt_supprimer")) ?>
      </div>
    <?php endif; ?>
  <?php endforeach ?>

  <br>

  <?php if ($objPager->haveToPaginate()) : ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>
  
</div>

<?php include_partial('autreActionsMris',array('strNomModel' => $strModelContenant,'id' => $objDossier->getId())) ?>

<hr class="clear">

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/lister".$strModelContenant."s", array("class" => "picto bt_retour")); ?>
</div>
<br>
