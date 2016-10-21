<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>
<?php use_helper("Libelle"); ?>

<div><?php echo libelle("msg_dossier_postdoc_recapitulatif_libelle"); ?></div>

<!--Cadre Proposant / Etudiant -->
<fieldset class="top_douze">
  <legend>
    <?php echo libelle("msg_libelle_proposant_etudiant") ?>
  </legend>

  <div class="floatleft width50">
    <div><?php echo $proposantPostdoc->getNom() . " " . $proposantPostdoc->getPrenom(); ?></div>
    <div><a href='mailto:<?php echo $proposantPostdoc->getEmail(); ?>'><?php echo $proposantPostdoc->getEmail(); ?></a></div>
  </div>
  <div class="floatleft">
    <?php if ($proposantAdresseFrPostdoc) : ?>
       <div><?php echo $proposantPostdoc->getAdresse(); ?></div>
       <div><?php echo $proposantPostdoc->getCodePostal() . " " . $proposantPostdoc->getVille()->getNom(); ?></div>
       <div><?php echo $proposantPostdoc->getComplementAdresse(); ?></div>
    <?php else: ?>
       <div><?php echo nl2br($proposantPostdoc->getAdresseEtrangere()); ?></div>
       <div><?php echo $proposantPostdoc->getPays()->getNom(); ?></div>
    <?php endif; ?>
  </div>
</fieldset>

<!--Cadre Informations complémentaires -->
<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_informations_complementaires") ?>
  </legend>

  <div><?php echo libelle("msg_libelle_domaine_scientifique") . " : " . $objDossierPostdoc->getDomaine_scientifique()->getIntitule(); ?></div>
  <div><?php echo libelle("msg_libelle_org_mindef") . " : " . $objDossierPostdoc->getOrganisme_mindef()->getIntitule(); ?></div>
  <div><?php echo libelle("msg_libelle_organisme_exterieur") . " : " . $objDossierPostdoc->getOrganisme()->getIntitule(); ?></div>
  <br />
  <?php if ($hasPDFPostdoc) : ?>
    <?php echo link_to_grid(libelle("msg_libelle_telecharger_pdf"), "interface/telechargerDocument?type=mris_dossier_postdoc&fichier=".$objDossierPostdoc->getFichierPdf()."&fichier_orig=".$objDossierPostdoc->getFichierPdfOrig(), array('target'=>"_blank")); ?>
  <?php  endif; ?>
   <?php if ($hasEditablePostdoc) : ?>
    <?php if ($hasPDFPostdoc) echo " - "; ?>
    <?php echo link_to_grid(libelle("msg_libelle_telecharger_editable"), "interface/telechargerDocument?type=mris_dossier_postdoc&fichier=".$objDossierPostdoc->getFichierEditable()."&fichier_orig=".$objDossierPostdoc->getFichierEditableOrig(), array('target'=>"_blank")); ?>
  <?php  endif; ?>
</fieldset>

<!-- Cadre Encadrants -->
<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_encadrants") ?>
  </legend>
  <?php if ($nbEncadrantsPostdoc==0): ?>
    <div class="center">
      <?php echo libelle("msg_dossier_mris_aucun_encadrant_assoc"); ?>
    </div>
  <?php endif; ?>
  <?php if ($nbEncadrantsPostdoc>0):  ?>
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
            <?php foreach ($encadrantsPostdoc as $encadrantAssoc): ?>
              <tr class="<?php echo $i%2 == 0 ? "pair" : "impair" ?>">
                <td><?php echo $encadrantAssoc->getIntervenant()->getNom() ?></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getPrenom() ?></td>
                <td><a href='mailto:<?php echo $encadrantAssoc->getIntervenant()->getEmail() ?>'><?php echo $encadrantAssoc->getIntervenant()->getEmail() ?></a></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getNomOrganisme() ?></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getTitre() ?></td>
                <td><?php echo $encadrantAssoc->getRole_postdoc()->getIntitule() ?></td>
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
  <?php if ($nbLaboratoiresPostdoc==0): ?>
    <div class="center">
      <?php echo libelle("msg_dossier_mris_aucun_laboratoire_assoc"); ?>
    </div>
  <?php endif; ?>
  <?php if ($nbLaboratoiresPostdoc>0):  ?>
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
            <?php foreach ($laboratoiresPostdoc as $laboratoireAssoc): ?>
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

<?php if ($objDossierPostdoc->getFichierPdf() || $objDossierPostdoc->getFichierEditable()) { ?>
  <!-- Fichiers de description -->
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_description") ?>
    </legend>

    <ul>
      <?php if ($objDossierPostdoc->getFichierPdf()) { ?>
        <li>
          <a href="<?php echo url_for("referentiel_mris/telechargerFichierDossierMris?id=".$objDossierPostdoc->getId()."&type_dossier=Dossier_postdoc&type_fichier=pdf", true); ?>" target="_blank"><?php echo $objDossierPostdoc->getFichierPdfOrig() ?></a>
        </li>
      <?php } ?>
      <?php if ($objDossierPostdoc->getFichierEditable()) { ?>
        <li>
          <a href="<?php echo url_for("referentiel_mris/telechargerFichierDossierMris?id=".$objDossierPostdoc->getId()."&type_dossier=Dossier_postdoc&type_fichier=editable", true); ?>" target="_blank"><?php echo $objDossierPostdoc->getFichierEditableOrig() ?></a>
        </li>
      <?php } ?>
    </ul>
  </fieldset>
<?php } ?>

<p>
  <div class="underline"><?php echo $objDossierPostdoc->getTitre(); ?></div>
  <div><?php echo ($objDossierPostdoc->getNumeroDefinitif() ? $objDossierPostdoc->getNumeroDefinitif() : $objDossierPostdoc->getNumeroProvisoire()); ?> - <?php echo ($objStatutDossierPostdoc ? $objStatutDossierPostdoc->getIntitule() : ""); ?></div>
  <br />
  <br />
  <?php echo $objDossierPostdoc->getRaw("objet"); ?>
</p>
