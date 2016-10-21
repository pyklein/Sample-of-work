<?php use_helper("Format"); ?>
<html>
  <body>
    <div>
      Bonjour,<br/>
      <br/>

      L'application GRID vous envoie un mail d'alerte concernant le dossier
      <?php echo $objDossierBpi->getNumero(); ?> intitulé <?php echo $objDossierBpi->getTitre(); ?>.
      <br/>
      <br/>

      <u>Raison de l'alerte :</u><br/>
      <br/>

      Une action pour laquelle vous êtes pilote arrive à échéance le
      <?php echo formatDate($strDateEcheance); ?>.
      <br/>
      <?php echo $objAction->getRaw('description'); ?>
      <br/>
      <br/>

      <a href="<?php echo $strLienAction; ?>">Gérer les actions à mener</a>
      <br/>
      <br/>

      Merci de ne pas répondre à cet email<br/>
      Application GRID<br/>
      [ENVOYE PAR INTERNET]
    </div>
  </body>
</html>