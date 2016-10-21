<?php use_helper("Message"); ?>
<?php echo message(); ?>


<?php include_partial('etudiantFormFormation', array('objForm' => $objForm, 'strId' => $strId)) ?>