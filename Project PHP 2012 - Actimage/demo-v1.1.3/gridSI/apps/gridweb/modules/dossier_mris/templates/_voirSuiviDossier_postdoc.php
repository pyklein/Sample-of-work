<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>
<?php use_helper("Libelle"); ?>

<?php if (!$objDossierPostdoc->isProposition()) { ?>
<fieldset class="top_douze">
  <legend><?php echo libelle("msg_dossier_mris_suivi_postcommission"); ?></legend>
  <?php if ($suiviPostCommPostdoc->count()==0): ?>
    <div class="center">
      <?php echo libelle("msg_dossier_mris_aucun_suivi_postcomm"); ?>
    </div>
  <?php endif; ?>
  <?php if ($suiviPostCommPostdoc->count()>0):  ?>
    <table class="mep">
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_annee"); ?></th>
          <th><?php echo libelle("msg_libelle_avis"); ?></th>
          <th><?php echo libelle("msg_libelle_lettre_suivi"); ?></th>
          <th><?php echo libelle("msg_libelle_date_envoi"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php $i=0; ?>
          <?php  foreach ($suiviPostCommPostdoc as $unSuiviPostCommPostdoc) : ?>
            <tr class="<?php echo $i%2 == 0 ? "pair" : "impair" ?>">
              <td><?php echo $unSuiviPostCommPostdoc->getDateTimeObject('date_avis')->format('Y') ?></td>
              <td><?php if($unSuiviPostCommPostdoc->getEst_satisfaisant()) {echo libelle("msg_libelle_satisfaisant");} else {echo libelle("msg_libelle_non_satisfaisant");} ?></td>
              <td><?php echo link_to(libelle("msg_libelle_telecharger"),"dossier_mris/voirSuiviDossier_postdoc?id=".$dossierId); ?></td>
              <td><?php if($unSuiviPostCommPostdoc->getDate_envoi_lettre() != NULL) echo formatDate($unSuiviPostCommPostdoc->getDate_envoi_lettre()); else echo "-"; ?></td>
            </tr>
          <?php $i++; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</fieldset>
<?php } ?>

<table <?php if ($objDossierPostdoc->isProposition()) echo "class='top_douze'"; ?>>
  <tbody>
    <tr>
      <td class="suivi_mris_soixante">
        <fieldset class="suivi_mris_quatrevingtquinze">
          <legend><?php echo libelle("msg_dossier_postdoc_fieldset_element_suivi"); ?></legend>
          <?php if ($suiviDossierPostdoc->count() == 0) { ?>
            <div class="center">
              <?php echo libelle('msg_dossier_mris_aucun_suivi_libelle'); ?>
            </div>
          <?php } else { ?>
            <?php $lastTypeSuiviPostdoc = 0;
              foreach ($suiviDossierPostdoc as $objSuivi): ?>
                <?php if ($lastTypeSuiviPostdoc != $objSuivi->getTypeSuiviPostdocId()) :
                  $lastTypeSuiviPostdoc = $objSuivi->getTypeSuiviPostdocId(); ?>
                  <p class="underline"><?php echo $objSuivi->getType_suivi_postdoc()->getIntitule(); ?></p>
                <?php endif; ?>

                <p>
                  <div class="left_vingtcinq"><?php echo $objSuivi->getDescriptif() ?></div>
                  <div class="left_vingtcinq"><?php if($objSuivi->getDate_reception() != null)
                         {
                            echo libelle("msg_message_suivi_element_recu_postdoc",array(formatDate($objSuivi->getDate_demande()),formatDate($objSuivi->getDate_reception())));
                         }
                         else
                         {
                            echo libelle("msg_message_suivi_element_nonrecu_postdoc",array(formatDate($objSuivi->getDate_demande()), formatDate($objSuivi->getDateEcheance())));
                         }
                    ?>
                    </div>
                </p>
            <?php endforeach ?>
          <?php } ?>
        </fieldset>
      </td>
      <td class="suivi_mris_quarante">
        <fieldset>
          <legend><?php echo libelle("msg_dossier_postdoc_fieldset_element_aboutiss"); ?></legend>
          <?php if (!$aboutissementPostdoc) { ?>
            <div class="center">
              <?php echo libelle('msg_dossier_mris_aucun_aboutissement_libelle'); ?>
            </div>
          <?php } else { ?>
            <p><?php echo libelle("msg_dossier_postdoc_libelle_date_rapp_fin") ?> : <?php echo ($aboutissementPostdoc->getReceptionRapportFinal() ? formatDate($aboutissementPostdoc->getReceptionRapportFinal()) : ""); ?> </p>
            <p><?php echo libelle("msg_dossier_postdoc_libelle_date_fich_eval") ?> : <?php echo ($aboutissementPostdoc->getReceptionFicheEvaluation() ? formatDate($aboutissementPostdoc->getReceptionFicheEvaluation()) : ""); ?> </p>
            <p><?php echo libelle("msg_dossier_postdoc_libelle_date_fich_synt") ?> : <?php echo ($aboutissementPostdoc->getReceptionSynthese() ? formatDate($aboutissementPostdoc->getReceptionSynthese()) : ""); ?> </p>
          <?php } ?>
        </fieldset>
      </td>
    </tr>
  </tbody>
</table>

<fieldset>
  <legend><?php echo libelle("msg_libelle_evenements"); ?></legend>
  <?php if ($evenementsPostdoc->count() == 0) { ?>
    <div class="center">
        <?php echo libelle('msg_dossier_mris_aucun_evenement_libelle'); ?>
    </div>
  <?php } else {
    $strMoisCourant ="";
    $strAnneeCourante ="";
    $UtilDate = new UtilDate();
    foreach ($evenementsPostdoc as $objEvenement):
      //On récupère le mois et l'année
      $arrDate = explode("/", formatDate($objEvenement->getDateEvenement()));
      $strMois = $arrDate[1];
      $strAnnee = $arrDate[2];
  ?>

  <p><big>
    <?php if ($strMois!=$strMoisCourant || $strAnnee != $strAnneeCourante ) {
        echo $UtilDate->getMoisFrByNumero($strMois)." ".$strAnnee ;
        $strMoisCourant = $strMois;
        $strAnneeCourante = $strAnnee;
      }
    ?>
  </big></p>

  <div class="left_vingtcinq">
    <?php echo libelle("msg_evenement_mris_header",array(formatDate($objEvenement->getDateEvenement())))?>
    <?php echo $objEvenement->getType_evenement_postdoc()->getIntitule(); ?>
  </div>
  <div class="left_vingtcinq">
    <?php echo $objEvenement->getRaw('description') ?>
  </div>
  <br />
  <?php endforeach;
  } ?>

</fieldset>
