<?php

/**
 * @file
 * Contains \Drupal\micro\Form\MicroTypeFormController.
 */

namespace Drupal\micro\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class MicroTypeFormController extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $type = $this->entity;
    if ($this->operation == 'add') {
      $form['#title'] = SafeMarkup::checkPlain($this->t('Add micro type'));
    }
    elseif ($this->operation == 'edit') {
      $form['#title'] = $this->t('Edit %label micro type', array('%label' => $type->label()));
    }

    $form['name'] = array(
      '#title' => t('Name'),
      '#type' => 'textfield',
      '#default_value' => $type->name,
      '#description' => t('The human-readable name of this micro type. This text will be displayed as part of the list on the <em>Add new micro</em> page. It is recommended that this name begin with a capital letter and contain only letters, numbers, and spaces. This name must be unique.'),
      '#required' => TRUE,
      '#size' => 30,
    );

    $form['type'] = array(
      '#type' => 'machine_name',
      '#default_value' => $type->id(),
      '#maxlength' => 32,
      '#machine_name' => array(
        'exists' =>  ['Drupal\micro\Entity\Micro', 'load'],
        'source' => array('name'),
      ),
      '#description' => t('A unique machine-readable name for this micro type. It must only contain lowercase letters, numbers, and underscores. This name will be used for constructing the URL of the %micro-add page, in which underscores will be converted into hyphens.', array(
        '%micro-add' => t('Add new micro type'),
      )),
    );

    /*
    $form['description'] = array(
      '#title' => t('Description'),
      '#type' => 'textarea',
      '#default_value' => $type->description,
      '#description' => t('Describe this micro type. The text will be displayed on the <em>Add new micro</em> page.'),
    );
    */

    $form['additional_settings'] = array(
      '#type' => 'vertical_tabs',
      '#attached' => array(
        'library' => array(array('micro', 'drupal.micro_types')),
      ),
    );

    return $form;
  }

  public function save(array $form, FormStateInterface $form_state) {
    /**
     * @var \Drupal\micro\Entity\MicroType
     */
    $type = $this->entity;
    $type->id = trim($type->type);
    $type->name = trim($type->name);

    $variables = $form_state->getValues();

    // Do not save settings from vertical tabs.
    // @todo Fix vertical_tabs.
    unset($variables['additional_settings__active_tab']);

    $status = $type->save();

    $t_args = array('%name' => $type->name);

    if ($status == SAVED_UPDATED) {
      drupal_set_message(t('The micro type %name has been updated.', $t_args));
    }
    elseif ($status == SAVED_NEW) {
      drupal_set_message(t('The micro type %name has been added.', $t_args));
      $this->logger('micro')->notice('Added micro type %name.', $t_args);
    }

    $form_state->setRedirectUrl(new Url('micro.type_list'));
  }


}
