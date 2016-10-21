<html>
  <body>
    <div>
      Bonjour <?php echo $utilisateur->getCivilite()->getIntitule()." ".$utilisateur->getPrenom()." ".$utilisateur->getNom()?>,<br>
      <br/>
      Bienvenue sur GRID,<br />
      Vos identifiants
      <ul>
        <li>E-mail : <strong><?php echo $utilisateur->getEmail()?></strong></li>
        <li>Mot de passe : <strong><?php echo $utilisateur->getMotDePasse()?></strong></li>
      </ul>
    </div>
    <div>
	  Merci de ne pas répondre à cet email<br/>
      Application GRID<br />
      <br />
      [ENVOYE PAR INTERNET]
    </div>
  </body>
</html>