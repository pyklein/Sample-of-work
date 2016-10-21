
<?php if (sfContext::getInstance()->getUser()->isAuthenticated()) { ?>

  <?php $objUtilisateur = sfContext::getInstance()->getUser()->getUtilisateur(); ?>
  <?php $objProfil = $objUtilisateur->getProfil(true); ?>

  <?php if ($objProfil != null && $objProfil->getMetier()->getIntitule() == MetierTable::ADMINISTRATEUR) { ?>

    <!-- Administrateur -->
    <h1><?php echo libelle("msg_titre_grid"); ?></h1>
    

  <?php } else if ($objProfil != null && $objProfil->getMetier()->getIntitule() == MetierTable::BPI) { ?>

    <!-- Service BPI -->
    <h1><?php echo libelle("msg_titre_bpi"); ?></h1>
    <div id="logo_service_bpi"></div>
  
  <?php } else if ($objProfil != null && $objUtilisateur->getProfil()->getMetier()->getIntitule() == MetierTable::MIP) { ?>

    <!-- Service MIP -->
    <h1><?php echo libelle("msg_titre_mip"); ?></h1>
    <div id="logo_service_mip"></div>

  <?php } else if ($objProfil != null && $objUtilisateur->getProfil()->getMetier()->getIntitule() == MetierTable::MRIS) { ?>

    <!-- Service MRIS -->
    <h1><?php echo libelle("msg_titre_mris"); ?></h1>
     <!-- <div id="logo_service_mris"></div> -->

  <?php } else { ?>

      <!-- Sans service -->
      <h1><?php echo libelle("msg_titre_grid"); ?></h1>

  <?php } ?>

<?php } else { ?>

  <!-- Sans service -->
  <h1><?php echo libelle("msg_titre_grid"); ?></h1>

<?php } ?>
