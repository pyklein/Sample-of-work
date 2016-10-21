
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objContenant)); ?>

<?php include_partial('interface/conteneurForme', array('action' => 'modifier', 'model' => 'Documents_mip', 'objForm' => $objForm,'strModule' => $sf_context->getModuleName(),'strContenant' => $strContenant, 'idContenant' => $idContenant)) ?>

<script type='text/javascript'>
  enableElementOnSelectValue('<?php echo $objForm["documents_mip_type_id"]->renderId(); ?>', '', '<?php echo $objForm["autre_type"]->renderId(); ?>');
</script>
