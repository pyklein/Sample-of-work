<?php
include_partial('referentiel/popupCreerObjet',
        array('action' => 'creer',
            'model' => 'Grade',
            'objForm' => $objForm ,
            'strModule' => $sf_context->getModuleName()
            ))
?>