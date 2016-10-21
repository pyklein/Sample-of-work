<?php
include_partial('referentiel/popupCreerObjet',
        array('action' => 'creer',
            'model' => 'Organisme',
            'objForm' => $objForm ,
            'strModule' => $sf_context->getModuleName()
            ))
?>