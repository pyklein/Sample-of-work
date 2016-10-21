<?php use_helper("Message"); ?>
<?php echo message(); ?>


<?php include_partial('etudiantFormInformation', array('action' => 'modifier', 'model' => 'Etudiant', 'objForm' => $objForm, 'strId' => $strId)) ?>