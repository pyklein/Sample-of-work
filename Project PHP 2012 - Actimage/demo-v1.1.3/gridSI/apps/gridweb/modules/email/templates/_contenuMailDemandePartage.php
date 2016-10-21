<html>
   <body>
     <div>
       Bonjour,
       <br/>
       L'utilisateur <?php echo $utilisateur->getPrenom() . ' ' . $utilisateur->getNom() ?>
       (<?php foreach ($utilisateur->getProfils() as $key => $profil) { echo (($key>0 ? ', ' : '') . $profil); }?>)
        demande le partage du dossier <b><?php echo $dossier ?></b><br/>
        Commentaire : <?php echo html_entity_decode($commentaire) ?><br/>
       <?php if (isset($dossier_lie)) : ?>
       Dossier potentiellement lié : <b><?php echo $dossier_lie ?></b><br/>
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