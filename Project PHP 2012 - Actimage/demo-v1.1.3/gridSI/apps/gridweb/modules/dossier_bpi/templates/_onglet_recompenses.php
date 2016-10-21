
<ul id="onglets">

  <?php
  foreach ($arrInventeurs as $objInventeur){?>

  <li <?php if ($objInventeur->getId() == $checkInventeur)  echo "class=actif"; ?>>
     <?php echo link_to_grid($objInventeur, "dossier_bpi/modifierRecompenses?dossier_bpi_id=".$dossierId."&inventeur_id=".$objInventeur->getId()); ?>
  </li>
    
 <?php
 }
  ?>

</ul>
