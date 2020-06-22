<?php

namespace XProjects\Projects;

class ProjectsUtils extends \Backend {

  public function pasteElement(\DataContainer $dc, $row, $table) {
    $imagePasteAfter = \Image::getHtml('pasteafter.gif', sprintf($GLOBALS['TL_LANG'][$table]['pasteafter'][1], $row['id']));
    return '<a href="' . $this->addToUrl('act=' . \Input::get('mode') . '&mode=1&pid=' . $row['id'] . '&rt=' . REQUEST_TOKEN) . '" title="' . specialchars(sprintf($GLOBALS['TL_LANG'][$table]['pasteafter'][1], $row['id'])) . '" onclick="Backend.getScrollOffset()">' . $imagePasteAfter . '</a> ';
  }

  public function toggleIcon($row, $href, $label, $title, $icon, $attributes) {
    if (strlen(\Input::get('tid'))) {
      \Database::getInstance()->prepare("UPDATE tl_" . \Input::get('do') . " SET tstamp=" . time() . ", published='" . (\Input::get('state') ? 1 : '') . "' WHERE id=?")->execute(\Input::get('tid'));
      $this->redirect($this->getReferer());
    }

    $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);
    if (!$row['published']) {
      $icon = 'invisible.gif';
    }

    return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . \Image::getHtml($icon, $label) . '</a> ';
  }

  public function generateAlias($varValue, \DataContainer $dc) {
    $autoAlias = false;
    if ($varValue == '') {
      $autoAlias = true;
      $varValue = standardize(\StringUtil::restoreBasicEntities($dc->activeRecord->title));
    }
    $objAlias = $this->Database->prepare("SELECT id FROM tl_" . \Input::get('do') . " WHERE id=? OR alias=?")->execute($dc->id, $varValue);
    if ($objAlias->numRows > 1) {
      if (!$autoAlias) {
        throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
      }
      $varValue .= '-' . $dc->id;
    }
    return $varValue;
  }

  public function listChilds($arrRow) {
    return $arrRow['title'];
  }

  public static function xGetImage($name, $size = array()) {
    $returnvalue = array(
        'path' => '',
        'imgsrc' => ''
    );
    $objFile = \FilesModel::findByUUID($name);
    if (is_file(TL_ROOT . '/' . $objFile->path)) {
      $file1 = new \File($objFile->path, true);
      if ($file1->exists()) {
        $returnvalue['path'] = $objFile->path;
        if (count($size)) {
          $returnvalue['imgsrc'] = \Image::get($objFile->path, $size[0], $size[1], $size[2]);
        } else {
          $returnvalue['imgsrc'] = \Image::get($objFile->path, $file1->width, $file1->height);
        }
      }
    }
    return $returnvalue;
  }

}
