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

      Etat d'avancement : à renseigner<br/>
      Echéance prévue le <?php echo formatDate($objDossier->getEcheance()->getDateEcheanceEa())?><br/>
      <br/>

      <a href="<?php echo $strLienModifierDossier?>">Modifier le dossier d'innovation</a><br/>
      <br/>

      Merci de ne pas répondre à cet email<br/>
      Application GRID<br/>
      [ENVOYE PAR INTERNET]
    </div>
  </body>
</html>