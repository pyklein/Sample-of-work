<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>
<?php use_helper("Libelle"); ?>

<div><?php echo libelle("msg_dossier_these_recapitulatif_libelle"); ?></div>

<!--Cadre Proposant / Etudiant -->
<fieldset class="top_douze">
  <legend>
    <?php echo libelle("msg_libelle_proposant_etudiant") ?>
  </legend>

  <div class="floatleft width50">
    <div><?php echo $proposantThese->getNom() . " " . $proposantThese->getPrenom(); ?></div>
    <div><a href='mailto:<?php echo $proposantThese->getEmail(); ?>'><?php echo $proposantThese->getEmail(); ?></a></div>
  </div>
  <div class="floatleft">
    <?php if ($proposantAdresseFrThese) : ?>
       <div><?php echo $proposantThese->getAdresse(); ?></div>
       <div><?php echo $proposantThese->getCodePostal() . " " . $proposantThese->getVille()->getNom(); ?></div>
       <div><?php echo $proposantThese->getComplementAdresse(); ?></div>
    <?php else: ?>
       <div><?php echo nl2br($proposantThese->getAdresseEtrangere()); ?></div>
       <div><?php echo $proposantThese->getPays()->getNom(); ?></div>
    <?php endif; ?>
  </div>
</fieldset>

<!--Cadre Informations complémentaires -->
<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_informations_complementaires") ?>
  </legend>

  <div><?php echo libelle("msg_libelle_domaine_scientifique") . " : " . $objDossierThese->getDomaine_scientifique()->getIntitule(); ?></div>
  <div><?php echo libelle("msg_libelle_org_mindef") . " : " . $objDossierThese->getOrganisme_mindef()->getIntitule(); ?></div>
  <div><?php echo libelle("msg_libelle_organisme_exterieur") . " : " . $objDossierThese->getOrganisme()->getIntitule(); ?></div>
  <div><?php echo libelle("msg_libelle_type_convention_organisme") . " : " . $objTypeConventionOrganismeThese->getIntitule(); ?></div>
  <br />
  <?php if ($hasPDFThese) : ?>
    <?php echo link_to_grid(libelle("msg_libelle_telecharger_pdf"), "interface/telechargerDocument?type=mris_dossier_these&fichier=".$objDossierThese->getFichierPdf()."&fichier_orig=".$objDossierThese->getFichierPdfOrig(), array('target'=>"_blank")); ?>
  <?php  endif; ?>
   <?php if ($hasEditableThese) : ?>
    <?php if ($hasPDFThese) echo " - "; ?>
    <?php echo link_to_grid(libelle("msg_libelle_telecharger_editable"), "interface/telechargerDocument?type=mris_dossier_these&fichier=".$objDossierThese->getFichierEditable()."&fichier_orig=".$objDossierThese->getFichierEditableOrig(), array('target'=>"_blank")); ?>
  <?php  endif; ?>
</fieldset>

<!-- Cadre Encadrants -->
<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_encadrants") ?>
  </legend>
   <?php if ($nbEncadrantsThese==0): ?>
     <div class="center">
       <?php echo libelle("msg_dossier_mris_aucun_encadrant_assoc"); ?>
     </div>
   <?php endif; ?>
   <?php if ($nbEncadrantsThese>0):  ?>
      <table class="mep">
          <thead>
            <tr>
              <th><?php echo libelle("msg_libelle_nom"); ?></th>
              <th><?php echo libelle("msg_libelle_prenom"); ?></th>
              <th><?php echo libelle("msg_libelle_email"); ?></th>
              <th><?php echo libelle("msg_libelle_organisme"); ?></th>
              <th><?php echo libelle("msg_intervenant_libelle_fontion_titre"); ?></th>
              <th><?php echo libelle("msg_dossier_mris_libelle_role"); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $i=0; ?>
            <?php foreach ($encadrantsThese as $encadrantAssoc): ?>
              <tr class="<?php echo $i%2 == 0 ? "pair" : "impair" ?>">
                <td><?php echo $encadrantAssoc->getIntervenant()->getNom() ?></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getPrenom() ?></td>
                <td><a href='mailto:<?php echo $encadrantAssoc->getIntervenant()->getEmail() ?>'><?php echo $encadrantAssoc->getIntervenant()->getEmail() ?></a></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getNomOrganisme() ?></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getTitre() ?></td>
                <td><?php echo $encadrantAssoc->getRole_these()->getIntitule() ?></td>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
          </tbody>
      </table>
   <?php endif; ?>
</fieldset>

<!-- Cadre laboratoires d'accueil -->
<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_laboratoires_accueil") ?>
  </legend>
  <?php if ($nbLaboratoiresThese==0): ?>
    <div class="center">
      <?php echo libelle("msg_dossier_mris_aucun_laboratoire_assoc"); ?>
    </div>
  <?php endif; ?>
  <?php if ($nbLaboratoiresThese>0):  ?>
    <table class="mep">
          <thead>
            <tr>
              <th><?php echo libelle("msg_libelle_intitule"); ?></th>
              <th><?php echo libelle("msg_libelle_organisme"); ?></th>
              <th><?php echo libelle("msg_libelle_service"); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $i=0; ?>
            <?php foreach ($laboratoiresThese as $laboratoireAssoc): ?>
              <tr class="<?php echo $i%2 == 0 ? "pair" : "impair" ?>">
                <td><?php echo $laboratoireAssoc->getLaboratoire()->getIntitule() ?></td>
                <td><?php echo $laboratoireAssoc->getLaboratoire()->getOrganisme()->getIntitule() ?></td>
                <td><?php echo $laboratoireAssoc->getLaboratoire()->getService()->getIntitule() ?></td>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
          </tbody>
      </table>
  <?php endif; ?>
</fieldset>

<?php if ($objDossierThese->getFichierPdf() || $objDossierThese->getFichierEditable()) { ?>
  <!-- Fichiers de description -->
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_description") ?>
    </legend>

    <ul>
      <?php if ($objDossierThese->getFichierPdf()) { ?>
        <li>
          <a href="<?php echo url_for("referentiel_mris/telechargerFichierDossierMris?id=".$objDossierThese->getId()."&type_dossier=Dossier_these&type_fichier=pdf", true); ?>" target="_blank"><?php echo $objDossierThese->getFichierPdfOrig() ?></a>
        </li>
      <?php } ?>
      <?php if ($objDossierThese->getFichierEditable()) { ?>
        <li>
          <a href="<?php echo url_for("referentiel_mris/telechargerFichierDossierMris?id=".$objDossierThese->getId()."&type_dossier=Dossier_these&type_fichier=editable", true); ?>" target="_blank"><?php echo $objDossierThese->getFichierEditableOrig() ?></a>
        </li>
      <?php } ?>
    </ul>
  </fieldset>
<?php } ?>

<p>
  <div class="underline"><?php echo $objDossierThese->getTitre(); ?></div>
  <div><?php echo $objDossierThese->getNumero(); ?> - <?php echo ($objStatutDossierThese ? $objStatutDossierThese->getIntitule() : ""); ?></div>
  <br />
  <br />
  <?php echo $objDossierThese->getRaw("objet"); ?>
</p>
