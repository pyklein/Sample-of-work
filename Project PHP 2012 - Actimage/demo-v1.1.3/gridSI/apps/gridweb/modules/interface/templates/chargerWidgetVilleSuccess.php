
<?php if (count($arrVilles) > 0) { ?>
  <option value=""><?php echo libelle('msg_libelle_aucune') ?> (<?php echo count($arrVilles) ?>)</option>
<?php } else { ?>
  <option value=""><?php echo libelle('msg_libelle_aucune') ?></option>
<?php } ?>
  
<?php foreach($arrVilles as $intI => $objVille) { ?>
  <option value="<?php echo $objVille->getId() ?>"><?php echo $objVille->getNom() ?></option>
<?php } ?>
