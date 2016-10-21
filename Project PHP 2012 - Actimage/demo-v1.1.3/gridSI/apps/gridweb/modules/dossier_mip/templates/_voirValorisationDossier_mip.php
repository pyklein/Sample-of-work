<?php use_helper("Format"); ?>

<?php if( ($objValorisation && $objValorisation->getDateDemandeGeneralisation() != null) || $boolPrixExiste || count($arrDossierBpi) > 0 ){ ?>

  <!--Cadre Généralisation -->
  <?php if ($objValorisation && $objValorisation->getDateDemandeGeneralisation() != null) { ?>
    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_generalisation") ?>
      </legend>

      <p><?php echo libelle("msg_libelle_generalisation_demande_le"). formatDate($objValorisation->getDateDemandeGeneralisation()) . libelle("msg_libelle_generalisation_a"). $objValorisation->getDestinataireDemandeGeneralisation(); ?></p>

    </fieldset>
  <?php } ?>

  <!--Cadre Prix et récompenses -->
  <?php if (count($arrPrix) > 0 && $boolPrixExiste) { ?>
    <fieldset>

      <legend>
        <?php echo libelle("msg_libelle_prix_recompenses") ?>
      </legend>

      <?php if($boolPrixSelectionneExiste):?>
        <p><?php echo libelle("msg_libelle_selections") ; ?></p>

        <ul>
          <?php
            foreach($arrPrix as $prix) {
              if($prix->getEstSelectionne()) {
                echo '<li>' . $prix->getPrix()->getIntitule(). " " .$prix->getAnnee() . "</li>";
              }
            }
          ?>
        </ul>
      <?php endif; ?>

      <?php if($boolPrixObtenuExiste):?>
        <p><?php echo libelle("msg_libelle_prix_obtenus") ; ?></p>

        <ul>
          <?php
            foreach($arrPrix as $prix) {
              if($prix->getEstObtenu()) {
                echo '<li>' . $prix->getPrix()->getIntitule(). " " .$prix->getAnnee() . "</li>";
              }
            }
          ?>
        </ul>
      <?php endif; ?>

    </fieldset>
  <?php } ?>

  <?php if (count($arrDossierBpi) > 0
          && ($sf_user->hasCredential('SUP-MIP') || $sf_user->hasCredential('USR-MIP'))) : ?>

    <!--Cadre Brevet -->
    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_brevet") ?>
      </legend>

      <?php foreach($arrDossierBpi as $lienDossierBpi) { ?>

        <?php $dossierBpi = $lienDossierBpi->getDossier_bpi(); ?>

        <p><?php echo $dossierBpi->getNumero() . " - " . $dossierBpi->getTitre(); ?></p>

        <?php $arrBrevets = BrevetTable::getInstance()->findbyDossierBpiId($dossierBpi->getId()); ?>
        <?php $arrClassementInvention = Classement_invention_inventeurTable::getInstance()->findByDossierBpiId($dossierBpi->getId()); ?>

        <?php if (count($arrClassementInvention) > 0 || count($arrBrevets) > 0) { ?>
          <ul>
            <?php if (count($arrClassementInvention) > 0) { ?>
              <li>
                <?php
                  echo libelle("msg_libelle_simple_classement").": ";
                  foreach($arrClassementInvention as $intI => $objClassementInvention) {
                    echo ($intI == 0 ? "" : ", ").$objClassementInvention->getConcerne()." - ".$objClassementInvention->getClassement_final();
                  }
                ?>
              </li>
            <?php } ?>

            <?php if (count($arrBrevets) > 0) { ?>
              <li>
                <?php echo libelle("msg_libelle_brevet_s"). ": " ?>
              </li>

              <ul>
                <?php
                  foreach($arrBrevets as $brevet) {
                    echo '<li>'.$brevet->getTitre()." - ".$brevet->getType_depot()." - ".$brevet->getPhase_depot_brevet().'</li>' ;
                  }
                ?>
              </ul>
            <?php } ?>
          </ul>
        <?php } ?>
      <?php } ?>

    </fieldset>

  <?php endif; ?>

  <!--Cadre Retour d'expérience -->
  <?php if($objValorisation && $objValorisation->getRetourExperience() != null) { ?>
    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_retour_experience") ?>
      </legend>

      <p><?php if($objValorisation && $objValorisation->getRetourExperience() != null) echo $objValorisation->getRaw('retour_experience') ; ?></p>

    </fieldset>
  <?php } ?>

  <!--Cadre Avantages inconvénients -->
  <?php if ($objValorisation && $objValorisation->getAvantageInconvenient() != null) { ?>
    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_avantages_inconvenients") ?>
      </legend>

      <p><?php echo $objValorisation->getRaw('avantage_inconvenient') ; ?></p>

    </fieldset>
  <?php } ?>
<?php } else if (!isset($pdf)) {
  echo libelle("msg_libelle_aucune_information_disponible") ;
}?>
