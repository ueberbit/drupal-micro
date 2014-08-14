<?php

/**
 * Implements hook_views_data().
 *
 * @return array
 */
function micro_views_data() {
  $data = array();

  $data['micro']['table']['group']  = t('Micro');
  $data['micro']['table']['base'] = array(
    'field' => 'mid',
    'title' => t('Micro'),
    'help' => '@todo',
  );
  $data['micro']['table']['entity type'] = 'micro';
  $data['micro']['table']['wizard_id'] = 'micro';

  // mid field
  $data['micro']['mid'] = array(
    'title' => t('Micro ID'),
    'help' => t('The mid of a micro entity.'),
    'field' => array(
      'id' => 'numeric',
    ),
    'argument' => array(
      'id' => 'standard',
    ),
    'sort' => array(
      'id' => 'standard',
    ),
  );

  // type field
  $data['micro']['type'] = array(
    'title' => t('Type'),
    'help' => t('The micro type.'),
    /*
    'field' => array(
      'id' => 'micro_type',
    ),
    */
    'sort' => array(
      'id' => 'standard',
    ),
    'filter' => array(
      'id' => 'bundle',
    ),
    /*
    'argument' => array(
      'id' => 'micro_type',
    ),
    */
  );

  // Term title field
  $data['micro']['title'] = array(
    'title' => t('Title'),
    'help' => t('The micro title.'),
    'field' => array(
      'id' => 'standard',
    ),
    'sort' => array(
      'id' => 'standard',
    ),
    'filter' => array(
      'id' => 'string',
      'help' => t('Micro title.'),
    ),
    'argument' => array(
      'id' => 'string',
      'help' => t('Micro title.'),
      'many to one' => TRUE,
      'empty field title' => t('Uncategorized'),
    ),
  );

  $data['micro']['changed'] = array(
    'title' => t('Updated date'),
    'help' => t('The date the content was last updated.'),
    'field' => array(
      'id' => 'date',
    ),
    'sort' => array(
      'id' => 'date'
    ),
    'filter' => array(
      'id' => 'date',
    ),
  );

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
