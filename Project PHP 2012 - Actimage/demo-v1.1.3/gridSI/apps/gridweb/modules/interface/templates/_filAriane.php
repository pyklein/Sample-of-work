
<p id="breadcrumbs">
  
  <?php if($objAriane->getNomModule() != "") { ?>
    <?php echo link_to($objAriane->getLabelAccueil(), '@accueil', array("title" => $objAriane->getLabelAccueil())); ?>
    >
    <?php if($objAriane->getNomAction() != "") { ?>
      <?php echo link_to($objAriane->getLabelModule(), $objAriane->getNomModule().'/index', array("title" => $objAriane->getLabelModule())); ?>
      >
      <span title="<?php echo $objAriane->getLabelAction(); ?>"><?php echo $objAriane->getLabelAction(); ?></span>
    <?php } else { ?>
      <span title="<?php echo $objAriane->getLabelModule(); ?>"><?php echo $objAriane->getLabelModule(); ?></span>
    <?php } ?>
  <?php } else { ?>
    <span title="<?php echo $objAriane->getLabelAccueil(); ?>"><?php echo $objAriane->getLabelAccueil(); ?></span>
  <?php } ?>

  <?php sfContext::getInstance()->getUser()->setFlash("ariane", $objAriane); ?>
</p>
