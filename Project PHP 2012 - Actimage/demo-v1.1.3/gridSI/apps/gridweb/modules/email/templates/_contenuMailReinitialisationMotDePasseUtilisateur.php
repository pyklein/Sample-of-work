<html>
  <body>
    <div>
      Bonjour <?php echo $utilisateur->getCivilite()->getIntitule()." ".$utilisateur->getPrenom()." ".$utilisateur->getNom()?>,<br>
      <br/>
      Votre mot de passe GRID a été réinitialisé.
	  Le nouveau mot de passe pour l'adresse e-mail <?php echo $utilisateur->getEmail()?> est :<br />
      <strong><?php echo $motdepasse ?></strong>
      
      <?php if ($utilisateur->getEstUtilisateurLdap()) : ?>
        <br/>
        Ces informations sont complémentaires à votre compte sur l'annuaire LDAP de la DGA.
		Le mot de passe intégré à ce mail n'est donc utile que lorsque l'annuaire DGA est indisponible.
		Dans tous les autres cas, vous pouvez utiliser votre mot de passe de l'annuaire LDAP.
		</br/>
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
