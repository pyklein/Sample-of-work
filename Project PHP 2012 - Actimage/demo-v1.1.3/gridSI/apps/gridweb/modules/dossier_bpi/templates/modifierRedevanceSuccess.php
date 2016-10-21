<h3>
  <?php echo libelle('msg_libelle_redevance_lie_dossier_bpi', array($objDossier));?>
</h3>

<?php include_partial('interface/conteneurForme', array('action' => 'modifier', 'model' => 'Redevance', 'objForm' => $objForm , 'strModule' => $sf_context->getModuleName(), 'strContenant'=> 'dossier_bpi_id','idContenant'=>$objDossier->getId())) ?>

