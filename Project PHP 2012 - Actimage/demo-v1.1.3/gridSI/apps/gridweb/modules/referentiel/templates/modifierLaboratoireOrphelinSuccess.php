<?php include_partial('interface/conteneurForme', array('action' => 'modifier', 'model' => 'LaboratoireOrphelin', 'objForm' => $objForm , 'strModule' => $sf_context->getModuleName())) ?>

<script type='text/javascript'>
  hideOtherOptionGroupsOnSelectValue('<?php echo $objForm["organisme_id"]->renderId(); ?>', '<?php echo $objForm["service_id"]->renderId(); ?>');
</script>