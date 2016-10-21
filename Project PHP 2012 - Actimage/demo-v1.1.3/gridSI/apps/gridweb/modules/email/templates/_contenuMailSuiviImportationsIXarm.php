<!-- Template du mail de suivi des importations MRIS -->
<html>
  <body>
    <div>
      Bonjour,<br/>
      <br/>

      L'application GRID a effectuée une importation des dossier MRIS disponibles sur iXarm.<br/>
      - <?php echo count($arrDossiers)?> dossiers ont été importés sur <?php echo $intCompteDossiers?> trouvés.<br/>
      Ci-après un descriptif des dossiers importés :<br/>
      <br/>

      <?php foreach($arrDossiers as $arrDossier) :?>
        <?php $objDossier = $arrDossier[0];
              $arrErreursDossier = $arrDossier[1];
              $arrType = explode('_',$objDossier->getClass());
              $strType = $arrType[1];
        ?>
        <u><b>Dossier <?php echo $objDossier->getNumeroAAfficher() . " - " . $objDossier ?></b></u><br/>
        Proposant : <?php echo (isset($objDossier["Etudiant"])) ?
                 $objDossier->getEtudiant() . ' ' . $objDossier->getEtudiant()->getEmail() : 'Information non disponible' ?><br/>
        Encadrants : <?php if (count($objDossier["Encadrant_".$strType]) > 0) : ?>
                        <?php foreach($objDossier["Encadrant_".$strType] as $index => $encadrant) : ?>
                          <?php echo ($index > 0 ? ', ' : '') . $encadrant->getIntervenant() . ' ' . $encadrant->getIntervenant()->getEmail(); ?>
                        <?php endforeach; ?>
                        <br/>
                     <?php else : ?>
                     Information non disponible.<br/>
                     <?php endif; ?>
        Laboratoires d'accueil : <?php if (count($objDossier["Dossier_". $strType."_laboratoire"]) > 0) : ?>
                                    <?php foreach($objDossier["Dossier_". $strType."_laboratoire"] as $index => $laboratoire) : ?>
                                      <?php echo ($index > 0 ? ', ' : '') . $laboratoire->getLaboratoire() . ' ' . ($laboratoire->getLaboratoire()->getOrganisme() != null ? $laboratoire->getLaboratoire()->getOrganisme() : ''); ?>
                                    <?php endforeach; ?>
                                    <br/>
                                 <?php else : ?>
                                  Information non disponible.<br/>
                                 <?php endif; ?>
       <?php if ($objDossier["fichier_editable_orig"] != null && $objDossier["fichier_pdf_orig"] != null && count($objDossier["Document_mris"]) > 0) : ?>
       Documents joints :<ul>
                          <?php echo ($objDossier["fichier_editable_orig"] != null) ?
                "<li> Fichier editable - " . $objDossier->getFichierEditableOrig() . '</li>' : '' ?>
                           <?php echo ($objDossier["fichier_pdf_orig"] != null) ?
                "<li> Fichier Pdf - " . $objDossier->getFichierPdfOrig() . '</li>' : '' ?>
                           <?php if (count($objDossier["Document_mris"]) > 0) : ?>
                             <?php echo "<li> Autres documents - " ?>
                             <?php foreach($objDossier["Document_mris"] as $index => $document) : ?>
                               <?php echo ($index > 0 ? ', ' : '') . $document->getFichierOrig(); ?>
                             <?php endforeach; ?>
                             <?php echo '</li>' ?>
                          <?php endif; ?>
                         </ul>
        <?php else: ?>
        Aucun document joint trouvé.
        <?php endif; ?>
        <br/>
        <br/>
        <?php if (count($arrErreursDossier) > 0) : ?>
        Erreurs survenues lors de l'importation du dossier:<br/>
        <ul>
          <?php foreach($arrErreursDossier as $erreur) { echo "<li>" . $erreur . "</li>";} ?>
        </ul>
        <?php endif; ?>
      <?php endforeach; ?>
      <br/>
      <?php if  (count($arrDossiers)  < $intCompteDossiers) : ?>
      <b>Erreurs ayant fait échouer l'importation des autres dossiers:</b><br/>
      <ul>
        <?php foreach($arrErreurs as $erreur) { echo "<li>" . $erreur[0] . "</li>";} ?>
      </ul>
      <?php endif; ?>
      <br/>
      <?php echo link_to('Gerer les dossiers MRIS',sfConfig::get("app_url_application").'dossier_mris',array('absolute' => true)) ?>
      <br/>
      <br/>
      Merci de ne pas répondre à cet email<br/>
      Application GRID<br/>
      [ENVOYE PAR INTERNET]
    </div>
  </body>
</html>