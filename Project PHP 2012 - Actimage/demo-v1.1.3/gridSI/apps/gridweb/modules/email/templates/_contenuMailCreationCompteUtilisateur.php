<html>
  <body>
    <div>
      Bonjour <?php echo $utilisateur->getCivilite()->getIntitule()." ".$utilisateur->getPrenom()." ".$utilisateur->getNom()?>,<br>
      <br/>
      Nous avons le plaisir de vous informer que votre compte utilisateur GRID a été créé. Veuillez trouver, ci-après les informations qui vous permettront
      de vous connecter à l'application :   
      <ul>
        <li>E-mail : <strong><?php echo $utilisateur->getEmail()?></strong></li>
        <li>Mot de passe : <strong><?php echo $motdepasse?></strong></li>
      </ul>
      <?php if ($utilisateur->getEstUtilisateurLdap()) : ?>
        <br/>
        Ces informations sont complémentaires à votre compte sur l'annuaire LDAP de la DGA.
		Le mot de passe intégré à ce mail n'est donc utile que lorsque l'annuaire DGA est indisponible.
		Dans tous les autres cas, vous pouvez utiliser votre mot de passe de l'annuaire LDAP.
      <?php endif; ?>
    </div>
    <div>
	  Merci de ne pas répondre à cet email<br/>
      Application GRID<br />
      <br />
      [ENVOYE PAR INTERNET]
    </div>
  </body>
</html>
