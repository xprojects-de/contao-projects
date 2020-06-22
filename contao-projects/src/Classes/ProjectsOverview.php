<?php

namespace XProjects\Projects\Classes;

use XProjects\Projects\ProjectsUtils;

class ProjectsOverview extends \ContentElement {

  protected $strTemplate = 'projects_overview';
  private $globalTags = array();
  private $SESSEIONKEY = 'xprojects_session';

  public function generate() {
    if (TL_MODE === 'BE') {
      $template = new \BackendTemplate('be_wildcard');
      $template->wildcard = '### PROJECTS OVERVIEW ###';
      return $template->parse();
    }
    return parent::generate();
  }

  protected function compile() {
    \Session::getInstance()->set($this->SESSEIONKEY, null);
    $assetsDir = 'bundles/projects';
    $GLOBALS['TL_JAVASCRIPT'][] = $assetsDir . '/js/jquery.lazy.min.js|static';
    $GLOBALS['TL_JAVASCRIPT'][] = $assetsDir . '/js/projects.js|static';
    $GLOBALS['TL_CSS'][] = $assetsDir . '/css/projects.css|static';
    $this->Template->data = $this->getProjects();
    $this->Template->tags = $this->globalTags;
    $this->Template->text = $this->xprojectsoptionaltext;
  }

  private function getProjects() {
    $this->globalTags = array();
    $data = array();
    $referencearray = array();
    if ($this->xprojects != '') {
      $tmp = deserialize($this->xprojects);
      if (is_array($tmp)) {
        $referencearray = $tmp;
      }
    }
    $sortingInfoarray = array();
    $projectsObj = \Database::getInstance()->prepare("SELECT * FROM tl_xprojects WHERE published=? ORDER BY sorting ASC")->execute(1);
    if ($projectsObj->numRows > 0) {
      while ($projectsObj->next()) {
        if (!in_array($projectsObj->id, $referencearray)) {
          continue;
        }
        $mainimage = '';
        $mainImageData = ProjectsUtils::xGetImage($projectsObj->mainimage);
        if ($mainImageData['imgsrc'] != '') {
          $mainimage = $mainImageData['imgsrc'];
        }

        $tags = array();
        if (intval($this->xprojectsshowtags) == 1) {
          if ($projectsObj->tags != "") {
            $tmp = explode(',', $projectsObj->tags);
            foreach ($tmp as $tag) {
              array_push($tags, trim($tag));
              if (!in_array(trim($tag), $this->globalTags)) {
                array_push($this->globalTags, trim($tag));
              }
            }
          }
        }

        $detailPage = \Controller::replaceInsertTags('{{link_url::' . $this->xprojectsdetail . '}}');
        $baseLink = str_replace('.html', '', $detailPage);
        array_push($data, array(
            'id' => $projectsObj->id,
            'title' => $projectsObj->title,
            'teaser' => $projectsObj->teaser,
            'image' => $mainimage,
            'tags' => implode(',', $tags),
            'link' => \Environment::get('base') . $baseLink . '/' . $GLOBALS['TL_CONFIG']['xprojects_getparam'] . '/' . $projectsObj->alias . '.html'
        ));
        array_push($sortingInfoarray, $projectsObj->id);
      }
    }
    $this->setProjectState($sortingInfoarray);
    return $data;
  }

  private function setProjectState($sortingInfoarray) {
    global $objPage;
    \Session::getInstance()->set($this->SESSEIONKEY, array(
        'overviewlink' => \Controller::replaceInsertTags('{{link_url::' . $objPage->id . '}}'),
        'sortingInfoarray' => $sortingInfoarray
    ));
  }

}
