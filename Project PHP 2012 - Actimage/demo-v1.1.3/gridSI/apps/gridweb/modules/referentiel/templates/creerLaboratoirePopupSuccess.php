<?php
include_partial('referentiel/popupCreerObjet',
        array('action' => 'creer',
            'model' => 'Laboratoire',
            'objForm' => $objForm ,
            'strModule' => $sf_context->getModuleName(),
            ))
?>