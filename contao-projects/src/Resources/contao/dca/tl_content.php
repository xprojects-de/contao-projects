<?php

if (\Input::get('do') == 'xprojects') {
  $GLOBALS['TL_DCA']['tl_content']['config']['ptable'] = 'tl_xprojects';
}

$GLOBALS['TL_DCA']['tl_content']['palettes']['xprojects_overview'] = '{type_legend},type;xprojects,xprojectsdetail,xprojectsshowtags;xprojectsoptionaltext;{expert_legend:hide},cssID;';
$GLOBALS['TL_DCA']['tl_content']['palettes']['xprojects_detail'] = '{type_legend},type;xprojectsoverview,{expert_legend:hide},cssID;';

$GLOBALS['TL_DCA']['tl_content']['fields']['xprojects'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_content']['xprojects'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'foreignKey' => 'tl_xprojects.title',
    'eval' => array('multiple' => true, 'mandatory' => true),
    'sql' => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['xprojectsdetail'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_content']['xprojectsdetail'],
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => array('fieldType' => 'radio', 'tl_class' => 'clr', 'mandatory' => true),
    'sql' => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['xprojectsoverview'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_content']['xprojectsoverview'],
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => array('fieldType' => 'radio', 'tl_class' => 'clr', 'mandatory' => true),
    'sql' => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['xprojectsshowtags'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_content']['xprojectsshowtags'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('doNotCopy' => true, 'tl_class' => 'clr'),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['xprojectsoptionaltext'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_content']['xprojectsoptionaltext'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => array('rte' => 'tinyMCE', 'tl_class' => 'clr'),
    'sql' => "mediumtext NULL"
);
