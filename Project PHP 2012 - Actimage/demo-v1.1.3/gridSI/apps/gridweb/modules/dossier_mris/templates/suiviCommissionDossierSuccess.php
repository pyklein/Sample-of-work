<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php echo message(); ?>


  <h3>
    <?php
      if ($strModelContenant == "Dossier_these"):
        echo libelle("msg_titre_dossier_these",array($objDossier->getTitre()));

      elseif($strModelContenant == "Dossier_postdoc"):
        echo libelle("msg_titre_dossier_postdoc",array($objDossier->getTitre()));

      elseif($strModelContenant == "Dossier_ere"):
        echo libelle("msg_titre_dossier_ere",array($objDossier->getTitre()));

      endif;
    ?>
  </h3>

<div id="zone_cadre" class="reduit">
  <!--Titre de dossier-->
  <p><?php echo libelle("msg_avis_libelle_titre_dossier",array($objDossier->getTitre()))?></p>
  <p><?php echo libelle("msg_avis_libelle_objet_dossier",array($objDossier->getRaw('objet')))?></p>
  <p><?php echo libelle("msg_avis_libelle_etudiant_dossier",array($objDossier->getEtudiant()))?></p>


  <!--Liste des avis pour le dossier-->
  <?php if ($arrAvis->count() != 0): ?>
    <table class="mep">
        <th><?php echo libelle("msg_libelle_annee"); ?></th>
        <th><?php echo libelle("msg_libelle_avis"); ?></th>
        <th><?php echo libelle("msg_libelle_lettre_suivi"); ?></th>
        <th><?php echo libelle("msg_libelle_date_envoi"); ?></th>

      <?php foreach ($arrAvis as $intCle => $objAvis): ?>
        <!--Formattage de la date pour récuperer uniquement l'année-->
          <?php $arrDate = explode("-",$objAvis->getDate_avis());
                $annee = $arrDate[0];
          ?>

        <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
          <td><?php echo $annee ?></td>

          <td><?php if($objAvis->getEst_satisfaisant() == 1) {echo libelle("msg_libelle_satisfaisant");} else {echo libelle("msg_libelle_non_satisfaisant");} ?></td>

          <td><?php echo link_to(libelle("msg_libelle_telecharger"),"dossier_mris/suiviCommissionDossier?".  strtolower($strModelContenant)."_id=".$strIdContenant."&commission_id=".$strIdCommission) ?></td>

          <td><?php if($objAvis->getDate_envoi_lettre() != NULL) echo formatDate($objAvis->getDate_envoi_lettre()); else echo link_to(libelle("msg_libelle_avis_renseigner_date"),"dossier_mris/creerDateAvisCommission?id=".$objAvis->getId()); ?></td>
        </tr>
       <?php endforeach ?>
    </table>
  <?php endif;?>
  <br />

  <?php if ($objDossier->getEstActif()): ?>

    <!--Formulaire pour ajouter un avis-->
    <form action="" method="post">
      <fieldset class="fieldset_formulaire">
        <legend>
          <?php echo libelle("msg_module_dossier_these_action_creer_avismris") ?>
        </legend>
          <?php echo $objFormAvis['est_satisfaisant']->renderLabel() ?> <b> : </b>
          <?php echo $objFormAvis['est_satisfaisant']->render()?>
          <br />
          <br />

        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_revenir_dosssier"); ?>" name="enregistrer_retour"/>
          <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_passer_dossier_suivant"); ?>" name="enregistrer_suivant"/>
        </div>

      </fieldset>
      <br />
    </form>

    <!--Formulaire pour ajouter une remarque-->
    <form action="" method="post">
      <fieldset class="fieldset_formulaire">
        <legend>
          <?php echo libelle("msg_module_".strtolower($strModelContenant)."_action_creer_remarquemris") ?>
        </legend>
        <?php echo $objForm; ?>
        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_creer_remarque"); ?>" />
        </div>
      </fieldset>
      <br />
    </form>
  <?php endif; ?>

</div>

<?php include_partial('autreActionsMris',array('strNomModel' => $strModelContenant,'id' => $objDossier->getId())) ?>

<hr class="clear">

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/lister".$strModelContenant."s", array("class" => "picto bt_retour")); ?>
</div>

