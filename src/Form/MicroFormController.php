<?php

/**
 * @file
 * Contains \Drupal\micro\Form\MicroFormController.
 */

namespace Drupal\micro\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

class MicroFormController extends ContentEntityForm {

  public function save(array $form, array &$form_state) {
    $micro = $this->entity;
    $micro->save();
  }

  /**
   * Overrides Drupal\Core\Entity\EntityFormController::actions().
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $element = parent::actions($form, $form_state);
    $element['delete']['#access'] = $this->entity->access('delete');
    $element['delete']['#weight'] = 100;
    return $element;
  }

  /**
   * Overrides Drupal\Core\Entity\EntityFormController::delete().
   */
  public function delete(array $form, FormStateInterface $form_state) {
    $destination = array();
    $query = \Drupal::request()->query;
    if ($query->has('destination')) {
      $destination = drupal_get_destination();
      $query->remove('destination');
    }
    $form_state->setRedirect('micro.delete_confirm',
      array('micro' => $this->entity->id()),
      array('query' => $destination)
    );
  }

}
