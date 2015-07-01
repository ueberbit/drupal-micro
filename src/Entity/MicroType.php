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
 *   handlers = {
 *     "list" = "Drupal\micro\Controller\MicroTypeListController",
 *     "form" = {
 *       "add" = "Drupal\micro\Form\MicroTypeFormController",
 *       "edit" = "Drupal\micro\Form\MicroTypeFormController",
 *       "delete" = "Drupal\micro\Form\MicroTypeDeleteConfirm"
 *     },
 *    "list_builder" = "Drupal\micro\MicroTypeListBuilder"
 *   },
 *   admin_permission = "administer micro types",
 *   config_prefix = "type",
 *   bundle_of = "micro",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "edit-form" = "/admin/structure/micro/manage/{micro_type}",
 *     "delete-form" = "/admin/structure/micro/manage/{micro_type}/delete",
 *     "collection" = "/admin/structure/micro"
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
   * The bundle name.
   *
   * @var string
   */
  public $name;

  /**
   * Implements Drupal\Core\Entity\EntityInterface::id().
   */
  public function id() {
    return $this->id;
  }

}
