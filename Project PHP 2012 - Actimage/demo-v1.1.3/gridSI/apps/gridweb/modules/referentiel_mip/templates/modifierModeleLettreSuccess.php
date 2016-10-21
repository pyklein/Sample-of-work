<?php use_helper("Message"); ?>
<?php echo message(); ?>

<form action="" method="post" enctype="multipart/form-data">
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_lettres_projet") ?>
    </legend>

    <?php include_partial("referentiel_mip/modeleLettre", array("strCle" => Modele_lettreTable::MIP_LETTRE_PROJET_UN_INNOVATEUR, "objForm" => $objForm, "strLimiteUpload" => $strLimiteUpload, "strExtension" => sfConfig::get("app_extensions_rtf"))); ?>
    <br />
    <?php include_partial("referentiel_mip/modeleLettre", array("strCle" => Modele_lettreTable::MIP_LETTRE_PROJET_PLUSIEURS_INNOVATEURS, "objForm" => $objForm, "strLimiteUpload" => $strLimiteUpload, "strExtension" => sfConfig::get("app_extensions_rtf"))); ?>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_lettres_soutien") ?>
    </legend>

    <?php include_partial("referentiel_mip/modeleLettre", array("strCle" => Modele_lettreTable::MIP_LETTRE_SOUTIEN_UN_INNOVATEUR, "objForm" => $objForm, "strLimiteUpload" => $strLimiteUpload, "strExtension" => sfConfig::get("app_extensions_rtf"))); ?>
    <br />
    <?php include_partial("referentiel_mip/modeleLettre", array("strCle" => Modele_lettreTable::MIP_LETTRE_SOUTIEN_PLUSIEURS_INNOVATEURS, "objForm" => $objForm, "strLimiteUpload" => $strLimiteUpload, "strExtension" => sfConfig::get("app_extensions_rtf"))); ?>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_lettres_cloture_em") ?>
    </legend>

    <?php include_partial("referentiel_mip/modeleLettre", array("strCle" => Modele_lettreTable::MIP_LETTRE_CLOTURE_UN_INNOVATEUR_EM, "objForm" => $objForm, "strLimiteUpload" => $strLimiteUpload, "strExtension" => sfConfig::get("app_extensions_rtf"))); ?>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_lettres_cloture_mindef") ?>
    </legend>

    <?php include_partial("referentiel_mip/modeleLettre", array("strCle" => Modele_lettreTable::MIP_LETTRE_CLOTURE_UN_INNOVATEUR_MINDEF, "objForm" => $objForm, "strLimiteUpload" => $strLimiteUpload, "strExtension" => sfConfig::get("app_extensions_rtf"))); ?>
    <br>
    <?php include_partial("referentiel_mip/modeleLettre", array("strCle" => Modele_lettreTable::MIP_LETTRE_CLOTURE_PLUSIEURS_INNOVATEURS_MINDEF, "objForm" => $objForm, "strLimiteUpload" => $strLimiteUpload, "strExtension" => sfConfig::get("app_extensions_rtf"))); ?>

  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_lettres_accuse_reception") ?>
    </legend>

    <?php include_partial("referentiel_mip/modeleLettre", array("strCle" => Modele_lettreTable::MIP_LETTRE_ACCUSE_RECEPTION_VISITE, "objForm" => $objForm, "strLimiteUpload" => $strLimiteUpload, "strExtension" => sfConfig::get("app_extensions_rtf"))); ?>
  </fieldset>
  
  <div class="boutons">
    <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer"); ?>" />
  </div>
</form>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>