<?php

namespace Drupal\block_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure block form settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}x
   */
  public function getFormId() {
    return 'block_form_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['blocks_form.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
      $num_groups = $form_state->get('num_groups') ?? 1;
  
      $form['groups'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Groups'),
        '#prefix' => '<div id="groups-wrapper">',
        '#suffix' => '</div>',
      ];
      $form['#tree'] = TRUE;

    for ($i = 0; $i < $num_groups; $i++) {
      $form['groups'][$i]['group_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name of the group'),
      ];

      $form['groups'][$i]['label_1'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name of the 1st label'),
      ];

      $form['groups'][$i]['label_1_value'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name of the 1st value of 1st label'),
      ];

      $form['groups'][$i]['label_2'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name of the 2nd label'),
      ];

      $form['groups'][$i]['label_2_value'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name of the 2nd value of 2nd label'),
      ];
    }

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['remove_group'] = [
      '#type' => 'submit',
      '#value' => $this->t('Remove'),
      '#submit' => ['::removeCallback'],
      '#ajax' => [
        'callback' => '::addMoreCallback',
        'wrapper' => 'groups-wrapper',
      ],
    ];

    $form['actions']['add_group'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add more'),
      '#submit' => ['::addMore'],
      '#ajax' => [
        'callback' => '::addMoreCallback',
        'wrapper' => 'groups-wrapper',
      ],
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * Ajax callback for adding more group fields.
   */
  public function addMore(array &$form, FormStateInterface $form_state) {
    $num_groups = $form_state->get('num_groups') ?? 1;
    $form_state->set('num_groups', $num_groups + 1);
    $form_state->setRebuild();
  }

  /**
   * Ajax callback for removing group fields.
   */
  public function removeCallback(array &$form, FormStateInterface $form_state) {
    $num_groups = $form_state->get('num_groups') ?? 1;
    $form_state->set('num_groups', $num_groups - 1);
    $form_state->setRebuild();
  }

  /**
   * Ajax callback for rebuilding the form.
   */
  public function addMoreCallback(array &$form, FormStateInterface $form_state) {
    return $form['groups'];
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration name dynamically based on some condition.
    $config_name = 'blocks_form.settings'; 
  
    // Retrieve the configuration.
    $config = $this->config($config_name);
  
    $num_groups = $form_state->get('num_groups') ?? 1;
  
    // Loop through each group and set the configuration settings.
    for ($i = 0; $i < $num_groups; $i++) {
      $group_name = $form_state->getValue(['groups', $i, 'group_name']);
      $label_1 = $form_state->getValue(['groups', $i, 'label_1']);
      $label_1_value = $form_state->getValue(['groups', $i, 'label_1_value']);
      $label_2 = $form_state->getValue(['groups', $i, 'label_2']);
      $label_2_value = $form_state->getValue(['groups', $i, 'label_2_value']);
    
      // Set the configuration values for each group.
      $config->set('group_' . $i . '_name', $group_name)
        ->set('group_' . $i . '_label_1', $label_1)
        ->set('group_' . $i . '_label_1_value', $label_1_value)
        ->set('group_' . $i . '_label_2', $label_2)
        ->set('group_' . $i . '_label_2_value', $label_2_value);
    }
    
    // Set the number of groups in the configuration.
    $config->set('num_groups', $num_groups);
    
    // Save the configuration.
    $config->save();
    
    parent::submitForm($form, $form_state);
  }
  
  
}

