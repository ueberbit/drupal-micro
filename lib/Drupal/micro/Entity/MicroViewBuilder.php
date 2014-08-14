<?php

/**
 * @file
 * Contains \Drupal\micro\Entity\MicroViewBuilder.
 */

namespace Drupal\micro\Entity;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityViewBuilder;

class MicroViewBuilder extends EntityViewBuilder {

  /**
   * {@inheritdoc}
   */
  protected function alterBuild(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode, $langcode = NULL) {
    parent::alterBuild($build, $entity, $display, $view_mode, $langcode);
    if ($entity->id()) {
      $build['#contextual_links']['micro'] = array(
        'route_parameters' => array('micro' => $entity->id()),
      );
    }
  }

}
