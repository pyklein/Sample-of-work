<?php use_helper("Message"); ?>

<h3>
  <?php echo libelle("msg_titre_dossier_bpi", array($dossierBpi)); ?>
</h3>

<?php echo message(); ?>

<?php include_partial('onglet_contentieux', array('arrInventeurs' => $arrInventeurs, 'ongletActif' => 1, 'checkInventeur' => $checkInventeur, 'dossierId' => $dossierId)) ?>

<div id="zone_cadre" class="reduit">

  <form action="" method="post" >

  <!--Classement de l'invention-->
  <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_contentieux_classement_invention') ?>
    </legend>
    <?php echo $objForm['contentieux_invention']['est_desaccord']->renderRow(); ?>
    <?php echo $objForm['contentieux_invention']['commentaire_desaccord']->renderRow(); ?>
    <?php echo $objForm['contentieux_invention']['date_demande_cnis']->renderRow(); ?>
    <?php echo $objForm['contentieux_invention']['date_cnis']->renderRow(); ?>
    <?php echo $objForm['contentieux_invention']['decision_cnis']->renderRow(); ?>
    <?php echo $objForm['contentieux_invention']['date_accord']->renderRow(); ?>
    </fieldset>

   <!--Attribution des droits-->
  <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_contentieux_attribution_droits') ?>
    </legend>
    <?php echo $objForm['contentieux_droits']['est_desaccord']->renderRow(); ?>
    <?php echo $objForm['contentieux_droits']['commentaire_desaccord']->renderRow(); ?>
    <?php echo $objForm['contentieux_droits']['date_demande_cnis']->renderRow(); ?>
    <?php echo $objForm['contentieux_droits']['date_cnis']->renderRow(); ?>
    <?php echo $objForm['contentieux_droits']['decision_cnis']->renderRow(); ?>
    <?php echo $objForm['contentieux_droits']['date_accord']->renderRow(); ?>
  </fieldset>

  <!--Exploitatoin Interne-->
  <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_contentieux_exploitation interne') ?>
    </legend>
    <?php echo $objForm['contentieux_exploitation']['est_desaccord']->renderRow(); ?>
    <?php echo $objForm['contentieux_exploitation']['commentaire_desaccord']->renderRow(); ?>
    <?php echo $objForm['contentieux_exploitation']['date_demande_cnis']->renderRow(); ?>
    <?php echo $objForm['contentieux_exploitation']['date_cnis']->renderRow(); ?>
    <?php echo $objForm['contentieux_exploitation']['decision_cnis']->renderRow(); ?>
    <?php echo $objForm['contentieux_exploitation']['date_accord']->renderRow(); ?>
  </fieldset>

   <div class="boutons">
      <input type="submit" value="<?php echo  libelle("msg_bouton_enregistrer"); ?>" name="bouton_recompenses" />
    </div>

  </form>
  
</div>

<?php include_partial('autreActions', array('id' => $dossierId)) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerDossier_bpis", array("class" => "picto bt_retour")); ?>
</div>
