<?php

/**
 * @file
 * Definition of Drupal\micro\Entity\Term.
 */

namespace Drupal\micro\Entity;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the micro entity.
 *
 * @ContentEntityType(
 *   id = "micro",
 *   label = @Translation("Micro"),
 *   bundle_label = @Translation("Micro type"),
 *   module = "micro",
 *   handlers = {
 *     "storage" = "\Drupal\Core\Entity\ContentEntityDatabaseStorage",
 *     "form" = {
 *       "default" = "Drupal\micro\Form\MicroFormController",
 *       "add" = "Drupal\micro\Form\MicroFormController",
 *       "edit" = "Drupal\micro\Form\MicroFormController",
 *       "delete" = "Drupal\micro\Form\MicroDeleteForm"
 *     },
 *     "access" = "Drupal\micro\MicroEntityAccessControlHandler",
 *     "views_data" = "Drupal\micro\MicroViewsData",
 *     "view_builder" = "Drupal\micro\Entity\MicroViewBuilder"
 *   },
 *   admin_permission = "administer micro entity",
 *   base_table = "micro",
 *   data_table = "micro_field_data",
 *   uri_callback = "micro_uri",
 *   fieldable = TRUE,
 *   translatable = TRUE,
 *   render_cache = FALSE,
 *   entity_keys = {
 *     "id" = "mid",
 *     "label" = "title",
 *     "bundle" = "type",
 *     "uuid" = "uuid"
 *   },
 *   bundle_keys = {
 *     "bundle" = "type"
 *   },
 *   bundle_entity_type = "micro_type",
 *   permission_granularity = "bundle",
 *   field_ui_base_route = "entity.micro.admin_form",
 *   links = {
 *     "canonical" = "entity.micro.canonical",
 *     "edit-form" = "entity.micro.edit_form",
 *     "delete-form" = "entity.micro.delete_form",
 *     "admin-form" = "entity.micro.admin_form"
 *   }
 * )
 */
class Micro extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage_controller) {
    parent::preSave($storage_controller);

    // Before saving the micro entity, set changed time.
    $this->changed->value = REQUEST_TIME;
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(EntityStorageInterface $storage_controller, $update = TRUE) {
    parent::postSave($storage_controller, $update);
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['mid'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Micro ID'))
      ->setDescription(t('The micro entity ID.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The micro UUID.'))
      ->setReadOnly(TRUE);

    $fields['type'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Type'))
      ->setDescription(t('The micro type.'))
      ->setSetting('target_type', 'micro_type')
      ->setReadOnly(TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The micro language code.'));

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The title of this micro, always treated as non-markup plain text.'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setDefaultValue('')
      ->setSetting('max_length', 255)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayConfigurable('form', TRUE);


    $fields['changed'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the micro entity was last edited.'))
      ->setPropertyConstraints('value', array('EntityChanged' => array()));

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public static function bundleFieldDefinitions(EntityTypeInterface $entity_type, $bundle, array $base_field_definitions) {
    $micro_type = MicroType::load($bundle);
    $fields = array();
    if (isset($micro_type->title_label)) {
      $fields['title'] = clone $base_field_definitions['title'];
      $fields['title']->setLabel($micro_type->title_label);
    }
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->get('title')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getChangedTime() {
    return $this->changed->value;
  }

  /**
   * {@inheritdoc}
   */
  protected static function invalidateTagsOnDelete(array $entities) {
    parent::invalidateTagsOnDelete($entities);
    static::doInvalideCache();
  }

  /**
   * {@inheritdoc}
   */
  protected function invalidateTagsOnSave($update) {
    parent::invalidateTagsOnSave($update);
    static::doInvalideCache();
  }

  /**
   * @todo Replace this with proper cache tags.
   */
  protected static function doInvalideCache() {
    // Cache::invalidateTags(array('content' => TRUE));
  }

}
