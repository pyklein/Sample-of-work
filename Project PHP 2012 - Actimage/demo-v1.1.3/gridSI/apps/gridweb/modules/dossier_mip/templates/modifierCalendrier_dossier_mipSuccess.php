
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossierMip)); ?>

<?php use_helper("Message"); ?>
<?php echo message(); ?>

<?php include_partial('dossier_mip/gestion_dossier_mip', array('strId' => $strId, 'ongletActif' => 3)) ?>

<div id="zone_cadre" class="reduit">
  <form action="" method="post">
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
    </div>
    <fieldset>
      <legend>
        <a name="rdv">
          <?php echo libelle("msg_gestion_calendrier_creerrendez_vous") ?>
        </a>
      </legend>
          <?php echo $objForm['Rendez_vous']['date_prise_rdv']->renderLabel()." : "; ?>
          <?php echo $objForm['Rendez_vous']['date_prise_rdv']->renderError(); ?>
          <?php echo $objForm['Rendez_vous']['date_prise_rdv']->render(); ?>
          <?php echo $objForm['Rendez_vous']['date_rdv_date']->renderLabel()." : "; ?>
          <?php echo $objForm['Rendez_vous']['date_rdv_date']->renderError(); ?>
          <?php echo $objForm['Rendez_vous']['date_rdv_date']->render(); ?>
          <?php echo $objForm['Rendez_vous']['date_rdv_heure']->renderLabel()." : "; ?>
          <?php echo $objForm['Rendez_vous']['date_rdv_heure']->renderError(); ?>
          <?php echo $objForm['Rendez_vous']['date_rdv_heure']->render(); ?>
    </fieldset>

    <fieldset>
      <legend>
        <a name="echeance">
          <?php echo libelle("msg_gestion_calendrier_creerecheance") ?>
        </a>
      </legend>
          <?php echo $objForm['Echeance']['date_echeance_ea']->renderRow(); ?>
          <?php echo $objForm['Echeance']['date_echeance_cr']->renderRow(); ?>
    </fieldset>

    <fieldset>
      <legend>
        <a name="avisEtatMajor">
          <?php echo libelle("msg_gestion_calendrier_creeravisetatmajor") ?>
        </a>
      </legend>
      <p class="sous_titre_remise_dossier"><strong><?php echo libelle("msg_dossier_mip_demande") ?></strong></p>
          <?php echo $objForm['Avis_etatmajor']['date_demande']->renderRow(); ?>
          <?php echo $objForm['Avis_etatmajor']['reference_demande']->renderRow(array('class' => 'refmip')); ?>
      <p class="sous_titre_remise_dossier"><strong><?php echo libelle("msg_dossier_mip_avis_em") ?></strong></p>
          <?php echo $objForm['Avis_etatmajor']['reference']->renderRow(); ?>
          <?php echo $objForm['Avis_etatmajor']['date_reception']->renderLabel()." : "; ?>
          <?php echo $objForm['Avis_etatmajor']['date_reception']->renderError(); ?>
          <?php echo $objForm['Avis_etatmajor']['date_reception']->render(); ?>
          <?php echo $objForm['Avis_etatmajor']['date_envoi']->renderLabel()." : "; ?>
          <?php echo $objForm['Avis_etatmajor']['date_envoi']->renderError(); ?>
          <?php echo $objForm['Avis_etatmajor']['date_envoi']->render(); ?>
          <?php echo $objForm['Avis_etatmajor']['est_favorable']->renderLabel()." : "; ?>
          <?php echo $objForm['Avis_etatmajor']['est_favorable']->render(); ?>
          <?php echo $objForm['Avis_etatmajor']['recommandation']->renderRow(); ?>
    </fieldset>

	<fieldset>
      <legend>
        <a name="soutien">
          <?php echo libelle("msg_gestion_calendrier_creersoutien") ?>
        </a>
      </legend>

          <?php echo $objForm['Soutien']['date_emission']->renderLabel()." : "; ?>
          <?php echo $objForm['Soutien']['date_emission']->renderError(); ?>
          <?php echo $objForm['Soutien']['date_emission']->render(); ?>
          <?php echo $objForm['Soutien']['reference']->renderLabel()." : "; ?>
          <?php echo $objForm['Soutien']['reference']->renderError(); ?>
          <?php echo $objForm['Soutien']['reference']->render(array('class' => 'refmip')); ?>

    </fieldset>

    <fieldset>
      <legend>
        <a name="remiseDocs">
          <?php echo libelle("msg_gestion_calendrier_creerremisedocuments") ?>
        </a>
      </legend>
      <p class="sous_titre_remise_documents"><strong><?php echo libelle("msg_gestion_calendrier_creerremisedocuments_ea") ?></strong></p>
          <?php echo $objForm['Remise_documents']['date_reception_ea']->renderLabel()." : "; ?>
          <?php echo $objForm['Remise_documents']['date_reception_ea']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['date_reception_ea']->render(); ?>
          <?php echo $objForm['Remise_documents']['mode_transmission_ea']->renderLabel()." : "; ?>
          <?php echo $objForm['Remise_documents']['mode_transmission_ea']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['mode_transmission_ea']->render(array('class' => 'refmip')); ?>
          <?php echo $objForm['Remise_documents']['reference_ea']->renderRow(); ?>
          <?php echo $objForm['Remise_documents']['date_envoi_ar_ea']->renderLabel()." : "; ?>
          <?php echo $objForm['Remise_documents']['date_envoi_ar_ea']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['date_envoi_ar_ea']->render(); ?>
          <?php echo $objForm['Remise_documents']['reference_ar_ea']->renderLabel()." : "; ?>
          <?php echo $objForm['Remise_documents']['reference_ar_ea']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['reference_ar_ea']->render(array('class' => 'refmip')); ?>
      <p class="sous_titre_remise_documents"><strong><?php echo libelle("msg_gestion_calendrier_creerremisedocuments_cr") ?></strong></p>
          <?php echo $objForm['Remise_documents']['date_reception_cr']->renderLabel()." :"; ?>
          <?php echo $objForm['Remise_documents']['date_reception_cr']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['date_reception_cr']->render(); ?>
          <?php echo $objForm['Remise_documents']['mode_transmission_cr']->renderLabel()." : "; ?>
          <?php echo $objForm['Remise_documents']['mode_transmission_cr']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['mode_transmission_cr']->render(array('class' => 'refmip')); ?>
          <?php echo $objForm['Remise_documents']['reference_cr']->renderRow(); ?>
          <?php echo $objForm['Remise_documents']['date_envoi_ar_cr']->renderLabel()." : "; ?>
          <?php echo $objForm['Remise_documents']['date_envoi_ar_cr']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['date_envoi_ar_cr']->render(); ?>
          <?php echo $objForm['Remise_documents']['reference_ar_cr']->renderLabel()." : "; ?>
          <?php echo $objForm['Remise_documents']['reference_ar_cr']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['reference_ar_cr']->render(array('class' => 'refmip')); ?>
      <p class="sous_titre_remise_documents"><strong><?php echo libelle("msg_gestion_calendrier_creerremisedocuments_video") ?></strong></p>
          <?php echo $objForm['Remise_documents']['date_reception_video']->renderLabel()." : "; ?>
          <?php echo $objForm['Remise_documents']['date_reception_video']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['date_reception_video']->render(); ?>
          <?php echo $objForm['Remise_documents']['mode_transmission_video']->renderLabel()." : "; ?>
          <?php echo $objForm['Remise_documents']['mode_transmission_video']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['mode_transmission_video']->render(array('class' => 'refmip')); ?>
          <?php echo $objForm['Remise_documents']['reference_video']->renderRow(); ?>
          <?php echo $objForm['Remise_documents']['date_envoi_ar_video']->renderLabel()." : "; ?>
          <?php echo $objForm['Remise_documents']['date_envoi_ar_video']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['date_envoi_ar_video']->render(); ?>
          <?php echo $objForm['Remise_documents']['reference_ar_video']->renderLabel()." : "; ?>
          <?php echo $objForm['Remise_documents']['reference_ar_video']->renderError(); ?>
          <?php echo $objForm['Remise_documents']['reference_ar_video']->render(array('class' => 'refmip')); ?>

    </fieldset>

    <fieldset>
      <legend>
        <a name="transfert">
          <?php echo libelle("msg_gestion_calendrier_creertransfertcloture") ?>
        </a>
      </legend>
      <p class="sous_titre_remise_documents"><strong><?php echo libelle("msg_gestion_calendrier_transfert_transfert") ?></strong></p>
          <?php echo $objForm['Transfert_cloture']['date_transfert']->renderLabel()." : "; ?>
          <?php echo $objForm['Transfert_cloture']['date_transfert']->renderError(); ?>
          <?php echo $objForm['Transfert_cloture']['date_transfert']->render(); ?>
          <?php echo $objForm['Transfert_cloture']['reference_transfert']->renderLabel()." : "; ?>
          <?php echo $objForm['Transfert_cloture']['reference_transfert']->renderError(); ?>
          <?php echo $objForm['Transfert_cloture']['reference_transfert']->render(array('class' => 'refmip')); ?>
          <?php echo $objForm['Transfert_cloture']['destination_autre']->renderLabel()." : "; ?>           
          <?php echo $objForm['Transfert_cloture']['destination_autre_autre']->render(); ?>
      <p class="sous_titre_remise_documents"><strong><?php echo libelle("msg_gestion_calendrier_transfert_cloture") ?></strong></p>
          <?php echo $objForm['Transfert_cloture']['date_cloture']->renderLabel()." : "; ?>
          <?php echo $objForm['Transfert_cloture']['date_cloture']->renderError(); ?>
          <?php echo $objForm['Transfert_cloture']['date_cloture']->render(); ?>
          <?php echo $objForm['Transfert_cloture']['reference_cloture']->renderLabel()." : "; ?>
          <?php echo $objForm['Transfert_cloture']['reference_cloture']->renderError(); ?>
          <?php echo $objForm['Transfert_cloture']['reference_cloture']->render(array('class' => 'refmip')); ?>

    </fieldset>

    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
    </div>

  </form>
</div>

<?php include_partial('autreActions', array('id' => $strId,'objDossier'=>$objDossierMip)) ?>
<?php include_partial('raccourcisCalendrier', array('id' => $strId)) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/listerDossier_mips", array("class" => "picto bt_retour")); ?>
</div>

<script type='text/javascript'>
  enableElementOnSelectValue('<?php echo $objForm['Transfert_cloture']["destination_autre"]->renderId(); ?>', 'Autre', '<?php echo $objForm['Transfert_cloture']["destination_autre_autre"]->renderId(); ?>');
</script>
