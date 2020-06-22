<?php

$GLOBALS['TL_DCA']['tl_settings']['fields']['xprojects_getparam'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_settings']['xprojects_getparam'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'w50', 'mandatory' => true)
);

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{xprojects_legend},xprojects_getparam;';
