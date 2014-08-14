<?php

/**
 * @file
 * Contains \Drupal\micro\Controller\MicroController.
 */

namespace Drupal\micro\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\micro\Entity\Micro;
use Drupal\micro\Entity\MicroType;

class MicroController extends ControllerBase {

  public function add(EntityInterface $micro_type) {
    $user = \Drupal::currentUser();

    $type = $micro_type->id;
    $langcode = $this->moduleHandler()->invoke('language', 'get_default_langcode', array('micro', $type));

    $micro = entity_create('micro', array(
      'uid' => $user->id(),
      'name' => $user->getUsername(),
      'bundle' => $type,
      'type' => $type,
      'langcode' => $langcode ? $langcode : language_default()->id,
    ));

    $form = $this->entityFormBuilder()->getForm($micro);
    return $form;
  }


  /**
   * Displays a micro enitty.
   *
   * @param \Drupal\micro\Entity\Micro $micro
   *   The micro we are displaying.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function page(Micro $micro) {
    $build = $this->buildPage($micro);
    return $build;
  }

  /**
   * Builds a micro page render array.
   *
   * @param \Drupal\micro\Entity\Micro $micro
   *   The micro we are displaying.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  protected function buildPage(Micro $micro) {
    return array('micro' => $this->entityManager()->getViewBuilder('micro')->view($micro));
  }

  /**
   * The _title_callback for the micro.add route.
   *
   * @param \Drupal\micro\Entity\MicroType $micro_type
   *   The current micro entity.
   *
   * @return string
   *   The page title.
   */
  public function addPageTitle(MicroType $micro_type) {
    return $this->t('Create @name', array('@name' => $micro_type->label()));
  }

}
