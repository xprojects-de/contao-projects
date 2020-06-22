<?php

namespace XProjects\Projects\Classes;

class ProjectsDetail extends \ContentElement {

  protected $strTemplate = 'projects_detail';
  private $SESSEIONKEY = 'xprojects_session';

  public function generate() {
    if (TL_MODE === 'BE') {
      $template = new \BackendTemplate('be_wildcard');
      $template->wildcard = '### PROJECTS DETAIL ###';
      return $template->parse();
    }
    return parent::generate();
  }

  protected function compile() {
    global $objPage;
    $assetsDir = 'bundles/projects';
    $GLOBALS['TL_CSS'][] = $assetsDir . '/css/projectsdetail.css|static';
    $alias = \Input::get($GLOBALS['TL_CONFIG']['xprojects_getparam']);
    $projectObj = \Database::getInstance()->prepare("SELECT * FROM tl_xprojects WHERE published=? AND alias=?")->execute(1, $alias);
    $data = array();
    $projectId = 0;
    if ($projectObj->numRows > 0) {
      while ($projectObj->next()) {
        if ($projectObj->seo_titel != "") {
          $objPage->title = $projectObj->seo_titel;
        }
        if ($projectObj->seo_desc != "") {
          $objPage->description = $projectObj->seo_desc;
        }
        $data = $this->getElements($projectObj->id);
        $projectId = $projectObj->id;
        break;
      }
    }

    $this->Template->data = $data;
    $this->Template->back = null;
    $this->Template->prev = null;
    $this->Template->next = null;

    $projectState = $this->getProjectState();
    if ($projectState != null) {
      if (is_array($projectState)) {
        if (array_key_exists('overviewlink', $projectState)) {
          $this->Template->back = $projectState['overviewlink'];
        }
        if (array_key_exists('sortingInfoarray', $projectState) && $projectId != 0) {
          $this->generateNav($projectState['sortingInfoarray'], $projectId);
        }
      }
    }
  }

  private function getElements($pid) {
    $contentids = array();
    $c = \Database::getInstance()->prepare("SELECT id FROM tl_content WHERE pid=? AND ptable=? AND invisible!=? ORDER BY sorting")->execute($pid, 'tl_xprojects', 1);
    if ($c->numRows > 0) {
      while ($c->next()) {
        array_push($contentids, $c->id);
      }
    }
    return $contentids;
  }

  private function generateNav($sortingInfoarray, $projectId) {
    global $objPage;
    $prev = null;
    $next = null;
    $counter = 0;
    foreach ($sortingInfoarray as $navObejct) {
      $counter++;
      if (intval($navObejct) == intval($projectId)) {
        if ($counter < count($sortingInfoarray)) {
          $next = intval($sortingInfoarray[$counter]);
        }
        break;
      } else {
        $prev = intval($navObejct);
      }
    }
    $detailPage = \Controller::replaceInsertTags('{{link_url::' . $objPage->id . '}}');
    $baseLink = str_replace('.html', '', $detailPage);
    if ($prev != null) {
      $alias_prev = $this->getAlias($prev);
      if ($alias_prev != null) {
        $this->Template->prev = \Environment::get('base') . $baseLink . '/' . $GLOBALS['TL_CONFIG']['xprojects_getparam'] . '/' . $alias_prev . '.html';
      }
    }
    if ($next != null) {
      $alias_next = $this->getAlias($next);
      if ($alias_next != null) {
        $this->Template->next = \Environment::get('base') . $baseLink . '/' . $GLOBALS['TL_CONFIG']['xprojects_getparam'] . '/' . $alias_next . '.html';
      }
    }
  }

  private function getAlias($id) {
    $alias = null;
    $projectObj = \Database::getInstance()->prepare("SELECT alias FROM tl_xprojects WHERE published=? AND id=?")->execute(1, $id);
    if ($projectObj->numRows > 0) {
      while ($projectObj->next()) {
        $alias = $projectObj->alias;
        break;
      }
    }
    return $alias;
  }

  private function getProjectState() {
    return \Session::getInstance()->get($this->SESSEIONKEY);
  }

}
