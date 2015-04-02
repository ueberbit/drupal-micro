<?php

/**
 * @file
 * Contains \Drupal\micro\MicroPermissions.
 */

namespace Drupal\micro;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides dynamic permissions for micro.
 */
class MicroPermissions {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function permissions() {
    $permissions = [];

    $bundles = \Drupal::entityManager()->getBundleInfo('micro');
    foreach ($bundles as $bundle => $bundle_info) {
      $permissions['access micro admin overview - type ' . $bundle] = array(
        'title' => $this->t('Access micro admin overview - Type: @type', array('@type' => $bundle_info['label'])),
      );

      $permissions['administer micro - ' . $bundle . ' entity'] = array(
        'title' => $this->t('Administer Micro entity, Type: @type', array('@type' => $bundle_info['label'])),
      );

      $permissions['view micro - ' . $bundle . ' entity'] = array(
        'title' => $this->t('View Micro entity, Type: @type', array('@type' => $bundle_info['label'])),
      );
    }

    return $permissions;
  }

}
