<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>
<?php use_helper("Libelle"); ?>

<?php if (!$objDossierEre->isProposition()) { ?>
<fieldset class="top_douze">
  <legend><?php echo libelle("msg_dossier_mris_suivi_postcommission"); ?></legend>
  <?php if ($suiviPostCommEre->count()==0): ?>
    <div class="center">
      <?php echo libelle("msg_dossier_mris_aucun_suivi_postcomm"); ?>
    </div>
  <?php endif; ?>
  <?php if ($suiviPostCommEre->count()>0):  ?>
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
          <?php  foreach ($suiviPostCommEre as $unSuiviPostCommEre) : ?>
            <tr class="<?php echo $i%2 == 0 ? "pair" : "impair" ?>">
              <td><?php echo $unSuiviPostCommEre->getDateTimeObject('date_avis')->format('Y') ?></td>
              <td><?php if($unSuiviPostCommEre->getEst_satisfaisant()) {echo libelle("msg_libelle_satisfaisant");} else {echo libelle("msg_libelle_non_satisfaisant");} ?></td>
              <td><?php echo link_to(libelle("msg_libelle_telecharger"),"dossier_mris/voirSuiviDossier_ere?id=".$dossierId); ?></td>
              <td><?php if($unSuiviPostCommEre->getDate_envoi_lettre() != NULL) echo formatDate($unSuiviPostCommEre->getDate_envoi_lettre()); else echo "-"; ?></td>
            </tr>
          <?php $i++; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</fieldset>
<?php } ?>

<table <?php if ($objDossierEre->isProposition()) echo "class='top_douze'"; ?>>
  <tbody>
    <tr>
      <td class="suivi_mris_soixante">
        <fieldset class="suivi_mris_quatrevingtquinze">
          <legend><?php echo libelle("msg_dossier_ere_fieldset_element_suivi"); ?></legend>
          <?php if ($suiviDossierEre->count() == 0) { ?>
              <div class="center">
                <?php echo libelle('msg_dossier_mris_aucun_suivi_libelle'); ?>
              </div>
          <?php } else { ?>
            <?php $lastTypeSuiviEre = 0;
              foreach ($suiviDossierEre as $objSuivi): ?>
                <?php if ($lastTypeSuiviEre != $objSuivi->getTypeSuiviEreId()) :
                  $lastTypeSuiviEre = $objSuivi->getTypeSuiviEreId(); ?>
                  <p class="underline"><?php echo $objSuivi->getType_suivi_ere()->getIntitule(); ?></p>
                <?php endif; ?>

                <p>
                  <div class="left_vingtcinq"><?php echo $objSuivi->getDescriptif() ?></div>
                  <div class="left_vingtcinq"><?php if($objSuivi->getDate_reception() != null)
                         {
                            echo libelle("msg_message_suivi_element_recu_ere",array(formatDate($objSuivi->getDate_demande()),formatDate($objSuivi->getDate_reception())));
                         }
                         else
                         {
                            echo libelle("msg_message_suivi_element_nonrecu_ere",array(formatDate($objSuivi->getDate_demande())));
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
          <legend><?php echo libelle("msg_dossier_ere_fieldset_element_aboutiss"); ?></legend>
          <?php if (!$aboutissementEre) { ?>
            <div class="center">
              <?php echo libelle('msg_dossier_mris_aucun_aboutissement_libelle'); ?>
            </div>
          <?php } else { ?>
            <p><?php echo libelle("msg_dossier_ere_libelle_date_rapp_fin") ?> : <?php echo ($aboutissementEre->getReceptionRapportFinal() ? formatDate($aboutissementEre->getReceptionRapportFinal()) : ""); ?> </p>
            <p><?php echo libelle("msg_dossier_ere_libelle_date_fich_eval") ?> : <?php echo ($aboutissementEre->getReceptionFicheEvaluation() ? formatDate($aboutissementEre->getReceptionFicheEvaluation()) : ""); ?> </p>
            <p><?php echo libelle("msg_dossier_ere_libelle_date_fich_synt") ?> : <?php echo ($aboutissementEre->getReceptionSynthese() ? formatDate($aboutissementEre->getReceptionSynthese()) : ""); ?> </p>
          <?php } ?>
        </fieldset>
      </td>
    </tr>
  </tbody>
</table>

<fieldset>
  <legend><?php echo libelle("msg_libelle_evenements"); ?></legend>
  <?php if ($evenementsEre->count() == 0) { ?>
    <div class="center">
        <?php echo libelle('msg_dossier_mris_aucun_evenement_libelle'); ?>
    </div>
  <?php } else {
    $strMoisCourant ="";
    $strAnneeCourante ="";
    $UtilDate = new UtilDate();
    foreach ($evenementsEre as $objEvenement):
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
    <?php echo $objEvenement->getType_evenement_ere()->getIntitule(); ?>
  </div>
  <div class="left_vingtcinq">
    <?php echo $objEvenement->getRaw('description') ?>
  </div>
  <br />
  <?php endforeach;
  } ?>

</fieldset>
