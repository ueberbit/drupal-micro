<?php

/**
 * @file
 * Contains \Drupal\micro\Controller\MicroController.
 */

namespace Drupal\micro\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\micro\Entity\Micro;
use Drupal\micro\Entity\MicroType;

/**
 * Provides a couple of controllers for the micro module.
 */
class MicroController extends ControllerBase {

  /**
   * Provides an add form for a micro entity of a specific type.
   *
   * @param \Drupal\micro\Entity\MicroType $micro_type
   *   The micro type to add a micro entity for.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function add(MicroType $micro_type) {
    $user = $this->currentUser();

    $type = $micro_type->id;
    $langcode = $this->moduleHandler()->invoke('language', 'get_default_langcode', array('micro', $type));

    $micro = Micro::create([
      'uid' => $user->id(),
      'name' => $user->getUsername(),
      'bundle' => $type,
      'type' => $type,
      // @todo The form code should already handle that, test whether this is
      //   is still needed.
      'langcode' => $langcode ? $langcode : \Drupal::languageManager()->getDefaultLanguage()->getId(),
    ]);

    $form = $this->entityFormBuilder()->getForm($micro);
    return $form;
  }

  /**
   * Displays add micro links for available micro types.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function addPage() {
    $micro_types = [];
    // Only use micro types the user has access to.
    foreach ($this->entityManager()->getStorage('micro_type')->loadMultiple() as $type) {
      if ($this->entityManager()->getAccessControlHandler('micro')->createAccess($type->type)) {
        $micro_types[$type->type] = $type;
      }
    }

    // Bypass the node/add listing if only one content type is available.
    if (count($micro_types) == 1) {
      $type = array_shift($content);
      return $this->redirect('micro.add', ['micro_type' => $type->type]);
    }

    return [
      '#theme' => 'micro_add_list',
      '#micro' => $micro_types,
    ];
  }

  /**
   * Displays a micro entity.
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
    return $this->t('Create @name', ['@name' => $micro_type->label()]);
  }

}
