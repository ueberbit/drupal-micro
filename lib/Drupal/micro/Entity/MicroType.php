<?php

/**
 * @file
 * Contains \Drupal\micro\Entity\MicroType.
 */

namespace Drupal\micro\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Annotation\Translation;

/**
 * Defines the micro vocabulary entity.
 *
 * @ConfigEntityType(
 *   id = "micro_type",
 *   label = @Translation("Micro type"),
 *   controllers = {
 *     "list" = "Drupal\micro\Controller\MicroTypeListController",
 *     "form" = {
 *       "add" = "Drupal\micro\Form\MicroTypeFormController",
 *       "edit" = "Drupal\micro\Form\MicroTypeFormController",
 *       "delete" = "Drupal\Core\Entity\EntityConfirmFormBase"
 *     },
 *    "list_builder" = "Drupal\micro\MicroTypeListBuilder"
 *   },
 *   config_prefix = "type",
 *   bundle_of = "micro",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "edit-form" = "micro.type_edit"
 *   }
 * )
 */
class MicroType extends ConfigEntityBase {

  /**
   * The bundle ID.
   *
   * @var string
   */
  public $id;

  /**
   * The bundle UUID.
   *
   * @var string
   */
  public $uuid;

  /**
   * The bundle label.
   *
   * @var string
   */
  public $label;

  /**
   * Implements Drupal\Core\Entity\EntityInterface::id().
   */
  public function id() {
    return $this->id;
  }

}
