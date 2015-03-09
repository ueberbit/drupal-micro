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

class MicroViewsData extends EntityViewsData implements EntityViewsDataInterface {

  public function getViewsData() {
    $data = parent::getViewsData();

    $data['micro']['view_micro'] = array(
      'field' => array(
        'title' => t('Link to content'),
        'help' => t('Provide a simple link to the content.'),
        'id' => 'entity_link',
      ),
    );

    $data['micro']['edit_micro'] = array(
      'field' => array(
        'title' => t('Link to edit content'),
        'help' => t('Provide a simple link to edit the content.'),
        'id' => 'entity_link_edit',
      ),
    );

    $data['micro']['delete_micro'] = array(
      'field' => array(
        'title' => t('Link to delete content'),
        'help' => t('Provide a simple link to delete the content.'),
        'id' => 'entity_link_delete',
      ),
    );

    return $data;
  }

}
