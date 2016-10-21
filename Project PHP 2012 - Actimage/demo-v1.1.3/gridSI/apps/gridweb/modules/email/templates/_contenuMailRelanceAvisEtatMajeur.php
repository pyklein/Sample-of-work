<?php use_helper("Format"); ?>

<html>
  <body>
    <div>
      Bonjour,<br/>
      <br/>

      L'application GRID vous envoi un mail concernant le dossier<br/>
      <?php echo $objDossier->getNumero()?> intitulé <?php echo $objDossier->getTitre()?><br/>
      pour lequel vous êtes enregistré comme pilote.<br/>
      <br/>

      <u>Raison de la relance :</u><br/>
      <br/>

      Avis d'Etat-Major : à renseigner<br/>
      Demande envoyée le <?php echo $strDateReferance?><br/>
      <br/>

      <a href="<?php echo formatDate($strLienModifierDossier)?>">Modifier le dossier d'innovation</a><br/>
      <br/>

      Merci de ne pas répondre à cet email<br/>
      Application GRID<br/>
      [ENVOYE PAR INTERNET]
    </div>
  </body>
</html>