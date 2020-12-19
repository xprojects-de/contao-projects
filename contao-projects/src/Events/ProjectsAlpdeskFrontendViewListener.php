<?php

declare(strict_types=1);

namespace XProjects\Projects\Events;

use Alpdesk\AlpdeskFrontendediting\Events\AlpdeskFrontendeditingEventElement;
use Contao\Input;
use Contao\Database;

class ProjectsAlpdeskFrontendViewListener {

  public function __invoke(AlpdeskFrontendeditingEventElement $event): void {

    if ($event->getElement()->type === 'xprojects_overview') {
      $event->getItem()->setValid(true);
      $event->getItem()->setPath('do=xprojects');
      $event->getItem()->setLabel($GLOBALS['TL_LANG']['projects_label']);
    } else if ($event->getElement()->type === 'xprojects_detail') {
      $alias = Input::get('projekte');
      if ($alias !== null && $alias !== '') {
        // Better use Model but Extention does not have a model
        $projectObj = Database::getInstance()->prepare("SELECT id FROM tl_xprojects WHERE alias=?")->execute($alias);
        if ($projectObj->numRows > 0) {
          $event->getItem()->setValid(true);
          $event->getItem()->setPath('do=xprojects&table=tl_content&id=' . $projectObj->id);
          $event->getItem()->setLabel($GLOBALS['TL_LANG']['projects_label']);
        }
      }
    }
  }

}
