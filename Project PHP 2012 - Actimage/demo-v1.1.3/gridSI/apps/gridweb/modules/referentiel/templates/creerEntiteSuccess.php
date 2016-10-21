<?php include_partial('interface/conteneurForme', array('action' => 'creer', 'model' => 'Entite', 'objForm' => $objForm, 'strModule' => $sf_context->getModuleName())) ?>

<script type="text/javascript">
  activateOnCheck('<?php echo $objForm["est_executant"]->renderId(); ?>','<?php echo $objForm["code_executant"]->renderId(); ?>');
</script>


<script type='text/javascript'>
  hideOtherOptionsOnSelectValue('<?php echo $objForm["organisme_mindef_id"]->renderId(); ?>', '<?php echo $objForm["entite_id"]->renderId(); ?>');
</script>
