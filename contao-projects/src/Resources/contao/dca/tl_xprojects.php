<?php

$GLOBALS['TL_DCA']['tl_xprojects'] = array
    (
    'config' => array
        (
        'dataContainer' => 'Table',
        'ctable' => array('tl_content'),
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => array
            (
            'keys' => array
                (
                'id' => 'primary',
                'title' => 'index',
                'pid' => 'index'
            )
        )
    ),
    'list' => array
        (
        'sorting' => array
            (
            'mode' => 5,
            'fields' => array('sorting'),
            'flag' => 1,
            'panelLayout' => 'filter,search,limit',
            'paste_button_callback' => array('XProjects\\Projects\\ProjectsUtils', 'pasteElement')
        ),
        'label' => array
            (
            'fields' => array('title'),
            'showColumns' => true,
        ),
        'global_operations' => array
            (
            'all' => array
                (
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
            (
            'edit' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['edit'],
                'href' => 'table=tl_content',
                'icon' => 'edit.gif'
            ),
            'editheader' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['editheader'],
                'href' => 'act=edit',
                'icon' => 'header.gif',
            ),
            'copy' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif',
            ),
            'cut' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['cut'],
                'href' => 'act=paste&amp;mode=cut',
                'icon' => 'cut.gif'
            ),
            'toggle' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['toggle'],
                'icon' => 'visible.gif',
                'attributes' => 'onclick="Backend.getScrollOffset();"',
                'button_callback' => array('XProjects\\Projects\\ProjectsUtils', 'toggleIcon')
            ),
            'delete' => array
                (
                'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ),
        )
    ),
    'palettes' => array
        (
        'default' => 'title,published;alias,seo_titel,seo_desc;teaser;mainimage;tags'
    ),
    'fields' => array
        (
        'id' => array
            (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
            (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array
            (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting' => array
            (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['title'],
            'exclude' => true,
            'search' => true,
            'sorting' => true,
            'inputType' => 'text',
            'eval' => array('mandatory' => true, 'tl_class' => 'clr', 'maxlength' => 250),
            'sql' => "varchar(250) NOT NULL default ''"
        ),
        'published' => array
            (
            'exclude' => true,
            'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['published'],
            'inputType' => 'checkbox',
            'eval' => array('doNotCopy' => true, 'tl_class' => 'w50'),
            'sql' => "char(1) NOT NULL default ''"
        ),
        'teaser' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['teaser'],
            'exclude' => true,
            'inputType' => 'textarea',
            'eval' => array('rte' => 'tinyMCE', 'tl_class' => 'clr'),
            'sql' => "mediumtext NULL"
        ),
        'alias' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['alias'],
            'exclude' => true,
            'inputType' => 'text',
            'search' => true,
            'eval' => array('unique' => true, 'rgxp' => 'alias', 'doNotCopy' => true, 'maxlength' => 128, 'tl_class' => 'clr'),
            'save_callback' => array(
                array('XProjects\\Projects\\ProjectsUtils', 'generateAlias')
            ),
            'sql' => "varbinary(128) NOT NULL default ''"
        ),
        'seo_titel' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['seo_titel'],
            'exclude' => true,
            'search' => true,
            'sorting' => true,
            'inputType' => 'text',
            'eval' => array('tl_class' => 'clr', 'maxlength' => 250),
            'sql' => "varchar(250) NOT NULL default ''"
        ),
        'seo_desc' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['seo_desc'],
            'exclude' => true,
            'inputType' => 'textarea',
            'eval' => array(),
            'sql' => "mediumtext NULL"
        ),
        'mainimage' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['mainimage'],
            'exclude' => true,
            'inputType' => 'fileTree',
            'eval' => array('filesOnly' => true, 'files' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => 'clr'),
            'sql' => "binary(16) NULL",
        ),
        'tags' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_xprojects']['tags'],
            'exclude' => true,
            'inputType' => 'textarea',
            'eval' => array('tl_class' => 'clr'),
            'sql' => "mediumtext NULL"
        )
    )
);
