<?php
include_partial('referentiel/popupCreerObjet',
        array('action' => 'creer',
            'model' => 'Service',
            'objForm' => $objForm ,
            'strModule' => $sf_context->getModuleName()
            ))
?>