<?php

$GLOBALS['BE_MOD']['content']['xprojects'] = array(
    'tables' => array('tl_xprojects', 'tl_content')
);

$GLOBALS['TL_CTE']['includes']['xprojects_overview'] = 'XProjects\\Projects\\Classes\\ProjectsOverview';
$GLOBALS['TL_CTE']['includes']['xprojects_detail'] = 'XProjects\\Projects\\Classes\\ProjectsDetail';
