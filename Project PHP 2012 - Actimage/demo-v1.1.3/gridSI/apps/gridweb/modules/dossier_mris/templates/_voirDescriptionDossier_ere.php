<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>
<?php use_helper("Libelle"); ?>

<div><?php echo libelle("msg_dossier_ere_recapitulatif_libelle"); ?></div>

<!--Cadre Proposant / Etudiant -->
<fieldset class="top_douze">
  <legend>
    <?php echo libelle("msg_libelle_proposant_etudiant") ?>
  </legend>

  <div class="floatleft width50">
    <div><?php echo $proposantEre->getNom() . " " . $proposantEre->getPrenom(); ?></div>
    <div><a href='mailto:<?php echo $proposantEre->getEmail(); ?>'><?php echo $proposantEre->getEmail(); ?></a></div>
  </div>
  <div class="floatleft">
    <?php if ($proposantAdresseFrEre) : ?>
       <div><?php echo $proposantEre->getAdresse(); ?></div>
       <div><?php echo $proposantEre->getCodePostal() . " " . $proposantEre->getVille()->getNom(); ?></div>
       <div><?php echo $proposantEre->getComplementAdresse(); ?></div>
    <?php else: ?>
       <div><?php echo nl2br($proposantEre->getAdresseEtrangere()); ?></div>
       <div><?php echo $proposantEre->getPays()->getNom(); ?></div>
    <?php endif; ?>
  </div>
</fieldset>

<!--Cadre Informations complémentaires -->
<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_informations_complementaires") ?>
  </legend>

  <div><?php echo libelle("msg_libelle_domaine_scientifique") . " : " . $objDossierEre->getDomaine_scientifique()->getIntitule(); ?></div>
  <div><?php echo libelle("msg_libelle_org_mindef") . " : " . $objDossierEre->getOrganisme_mindef()->getIntitule(); ?></div>
  <div><?php echo libelle("msg_libelle_organisme_exterieur") . " : " . $objDossierEre->getOrganisme()->getIntitule(); ?></div>
  <br />
  <?php if ($hasPDFEre) : ?>
    <?php echo link_to_grid(libelle("msg_libelle_telecharger_pdf"), "interface/telechargerDocument?type=mris_dossier_ere&fichier=".$objDossierEre->getFichierPdf()."&fichier_orig=".$objDossierEre->getFichierPdfOrig(), array('target'=>"_blank")); ?>
  <?php  endif; ?>
   <?php if ($hasEditableEre) : ?>
    <?php if ($hasPDFEre) echo " - "; ?>
    <?php echo link_to_grid(libelle("msg_libelle_telecharger_editable"), "interface/telechargerDocument?type=mris_dossier_ere&fichier=".$objDossierEre->getFichierEditable()."&fichier_orig=".$objDossierEre->getFichierEditableOrig(), array('target'=>"_blank")); ?>
  <?php  endif; ?>
</fieldset>

<!-- Cadre Encadrants -->
<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_encadrants") ?>
  </legend>
  <?php if ($nbEncadrantsEre==0): ?>
    <div class="center">
      <?php echo libelle("msg_dossier_mris_aucun_encadrant_assoc"); ?>
    </div>
  <?php endif; ?>
  <?php if ($nbEncadrantsEre>0):  ?>
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
            <?php foreach ($encadrantsEre as $encadrantAssoc): ?>
              <tr class="<?php echo $i%2 == 0 ? "pair" : "impair" ?>">
                <td><?php echo $encadrantAssoc->getIntervenant()->getNom() ?></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getPrenom() ?></td>
                <td><a href='mailto:<?php echo $encadrantAssoc->getIntervenant()->getEmail() ?>'><?php echo $encadrantAssoc->getIntervenant()->getEmail() ?></a></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getNomOrganisme() ?></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getTitre() ?></td>
                <td><?php echo $encadrantAssoc->getRole_ere()->getIntitule() ?></td>
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
  <?php if ($nbLaboratoiresEre==0): ?>
    <div class="center">
      <?php echo libelle("msg_dossier_mris_aucun_laboratoire_assoc"); ?>
    </div>
  <?php endif; ?>
  <?php if ($nbLaboratoiresEre>0):  ?>
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
            <?php foreach ($laboratoiresEre as $laboratoireAssoc): ?>
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

<?php if ($objDossierEre->getFichierPdf() || $objDossierEre->getFichierEditable()) { ?>
  <!-- Fichiers de description -->
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_description") ?>
    </legend>

    <ul>
      <?php if ($objDossierEre->getFichierPdf()) { ?>
        <li>
          <a href="<?php echo url_for("referentiel_mris/telechargerFichierDossierMris?id=".$objDossierEre->getId()."&type_dossier=Dossier_ere&type_fichier=pdf", true); ?>" target="_blank"><?php echo $objDossierEre->getFichierPdfOrig() ?></a>
        </li>
      <?php } ?>
      <?php if ($objDossierEre->getFichierEditable()) { ?>
        <li>
          <a href="<?php echo url_for("referentiel_mris/telechargerFichierDossierMris?id=".$objDossierEre->getId()."&type_dossier=Dossier_ere&type_fichier=editable", true); ?>" target="_blank"><?php echo $objDossierEre->getFichierEditableOrig() ?></a>
        </li>
      <?php } ?>
    </ul>
  </fieldset>
<?php } ?>

<p>
  <div class="underline"><?php echo $objDossierEre->getTitre(); ?></div>
  <div><?php echo ($objDossierEre->getNumeroDefinitif() ? $objDossierEre->getNumeroDefinitif() : $objDossierEre->getNumeroProvisoire()); ?> - <?php echo ($objStatutDossierEre ? $objStatutDossierEre->getIntitule() : ""); ?></div>
  <br />
  <br />
  <?php echo $objDossierEre->getRaw("objet"); ?>
</p>
