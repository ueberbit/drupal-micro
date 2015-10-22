<?php

/**
 * @file
 * Definition of Drupal\micro\Entity\Term.
 */

namespace Drupal\micro\Entity;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Language\LanguageInterface;

/**
 * Defines the micro entity.
 *
 * @ContentEntityType(
 *   id = "micro",
 *   label = @Translation("Micro"),
 *   bundle_label = @Translation("Micro type"),
 *   handlers = {
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
 *   translatable = TRUE,
 *   render_cache = FALSE,
 *   entity_keys = {
 *     "id" = "mid",
 *     "label" = "title",
 *     "bundle" = "type",
 *     "langcode" = "langcode",
 *     "uuid" = "uuid"
 *   },
 *   bundle_entity_type = "micro_type",
 *   permission_granularity = "bundle",
 *   field_ui_base_route = "entity.micro_type.edit_form",
 *   links = {
 *     "canonical" = "/micro/{micro}",
 *     "edit-form" = "/micro/{micro}/edit",
 *     "delete-form" = "/micro/{micro}/delete"
 *   }
 * )
 */
class Micro extends ContentEntityBase {

  use EntityChangedTrait;

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
      ->setLabel(t('Language'))
      ->setDescription(t('The micro language code.'))
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setDisplayOptions('view', array(
        'type' => 'hidden',
      ))
      ->setDisplayOptions('form', array(
        'type' => 'language_select',
        'weight' => 2,
      ));

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
        'type' => 'string_textfield',
        'weight' => -5,
      ))
      ->setDisplayConfigurable('form', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the micro was last edited.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

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
    return $this->get('changed')->value;
  }

}
