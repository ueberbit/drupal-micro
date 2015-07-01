<?php

/**
 * @file
 * Contains \Drupal\micro\MicroViewsData.
 */

namespace Drupal\micro;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides views data for the micro entity type.
 */
class MicroViewsData extends EntityViewsData {

  public function getViewsData() {
    $data = parent::getViewsData();
    return $data;
  }

}
