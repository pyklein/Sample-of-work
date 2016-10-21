<?php use_helper("Format"); ?>
<html>
  <body>
    <div>
      Bonjour,<br/>
      <br/>

      L'application GRID vous envoi un mail d'alerte concernant le dossier
      <?php echo $objDossierBpi->getNumero(); ?> intitulé <?php echo $objDossierBpi->getTitre(); ?>.
      <br/>
      <br/>

      <?php if (isset($arrErreurs['actions']) && count(isset($arrErreurs['actions'])) > 0) : ?>
        <u>Actions à mener</u>
        <ul>
          <?php foreach($arrErreurs['actions'] as $arrErreur) : ?>
            <li class="<?php echo $arrErreur["class"] ?>">
              Action à mener par <?php echo $arrErreur["objet"]->getPilote(); ?> pour le <?php echo formatDate($arrErreur["objet"]->getDateEcheance()); ?>.
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if (isset($arrErreurs['classements']) && count($arrErreurs['classements']) > 0) : ?>
        <u>Délai pour le classement de l'invention</u>
        <ul>
          <?php foreach($arrErreurs['classements'] as $arrErreur) : ?>
            <li class="<?php echo $arrErreur["class"] ?>">
              Classement de l'invention incomplet - Echéance : <?php echo formatDate($arrErreur["echeance"]); ?>.
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if (isset($arrErreurs['droits']) && count($arrErreurs['droits']) > 0) : ?>
        <u>Attribution des droits</u>
        <ul>
          <?php foreach($arrErreurs['droits'] as $arrErreur) : ?>
            <li class="<?php echo $arrErreur["class"] ?>">
              Attribution non renseignée - Echeance : <?php echo formatDate($arrErreur["echeance"]); ?>.
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if (isset($arrErreurs['brevets']) && count($arrErreurs['brevets']) > 0) : ?>
        <u>Brevets</u>
        <ul>
          <?php foreach($arrErreurs['brevets'] as $arrErreur) : ?>
            <li class="<?php echo $arrErreur["class"] ?>">
              Extension de brevet "<?php echo $arrErreur["objet"]->getTitre(); ?> non déposé - Objectif de dépot : <?php echo formatDate($arrErreur["objet"]->getDateObjectifDepot()); ?>.
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if (isset($arrErreurs['primes']) && count($arrErreurs['primes']) > 0) : ?>
        <u>Prime au brevet</u>
        <ul>
          <?php foreach($arrErreurs['primes'] as $arrErreur) : ?>
            <li class="<?php echo $arrErreur["class"] ?>">
              Versement des 20% de prime au brevet non indiquée - Echéance <?php echo formatDate($arrErreur["echeance"]); ?>.
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <br/>
      <a href="<?php echo $strLienAction; ?>">Gérer le dossier d'invention</a>
      <br/>
      <br/>

      Merci de ne pas répondre à cet email<br/>
      Application GRID<br/>
      [ENVOYE PAR INTERNET]
    </div>
  </body>
</html>