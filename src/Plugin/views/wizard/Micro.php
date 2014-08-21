<?php

/**
 * @file
 * Definition of Drupal\micro\Plugin\views\wizard\Users.
 */

namespace Drupal\micro\Plugin\views\wizard;

use Drupal\views\Plugin\views\wizard\WizardPluginBase;
use Drupal\views\Annotation\ViewsWizard;
use Drupal\Core\Annotation\Translation;

/**
 * @todo: replace numbers with constants.
 */

/**
 * Tests creating micro views with the wizard.
 *
 * @ViewsWizard(
 *   id = "micro",
 *   base_table = "micro",
 *   title = @Translation("Micro")
 * )
 */
class Micro extends WizardPluginBase {

  /**
   * Set the created column.
   */
  protected $createdColumn = 'created';

  /**
   * Set default values for the path field options.
   */
  protected $pathField = array(
    'id' => 'mid',
    'table' => 'micro',
    'field' => 'mid',
    'exclude' => TRUE,
    'link_to_micro' => FALSE,
    'alter' => array(
      'alter_text' => TRUE,
      'text' => 'micro/views/[mid]'
    )
  );

  /**
   * Overrides Drupal\views\Plugin\views\wizard\WizardPluginBase::defaultDisplayOptions().
   */
  protected function defaultDisplayOptions() {
    $display_options = parent::defaultDisplayOptions();

    // Remove the default fields, since we are customizing them here.
    unset($display_options['fields']);

    $display_options['fields']['name']['id'] = 'title';
    $display_options['fields']['name']['table'] = 'micro';
    $display_options['fields']['name']['field'] = 'title';
    $display_options['fields']['name']['provider'] = 'micro';
    $display_options['fields']['name']['label'] = '';
    $display_options['fields']['name']['alter']['alter_text'] = 0;
    $display_options['fields']['name']['alter']['make_link'] = 0;
    $display_options['fields']['name']['alter']['absolute'] = 0;
    $display_options['fields']['name']['alter']['trim'] = 0;
    $display_options['fields']['name']['alter']['word_boundary'] = 0;
    $display_options['fields']['name']['alter']['ellipsis'] = 0;
    $display_options['fields']['name']['alter']['strip_tags'] = 0;
    $display_options['fields']['name']['alter']['html'] = 0;
    $display_options['fields']['name']['hide_empty'] = 0;
    $display_options['fields']['name']['empty_zero'] = 0;
    $display_options['fields']['name']['link_to_micro'] = 1;
    $display_options['fields']['name']['overwrite_anonymous'] = 0;

    return $display_options;
  }

}
