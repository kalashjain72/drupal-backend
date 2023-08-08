<?php

namespace Drupal\block_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block with the form data.
 *
 * @Block(
 *   id = "Form_block",
 *   admin_label = @Translation("Form Block task 2"),
 * )
 */
class formBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Retrieve the configuration name dynamically based on some condition.
    $config_name = 'blocks_form.settings'; // Replace this with your dynamic configuration name.

    // Load the configuration data.
    $config = \Drupal::config($config_name);
    $content = [];

    // Get the number of groups from the configuration data.
    $num_groups = $config->get('num_groups') ?? 1;
  
    // Loop through each group and add it to the $content array.
    for ($i = 0; $i < $num_groups; $i++) {
      $group = [
        'group_name' => $config->get('group_' . $i . '_name'),
        'label_1' => $config->get('group_' . $i . '_label_1'),
        'label_1_value' => $config->get('group_' . $i . '_label_1_value'),
        'label_2' => $config->get('group_' . $i . '_label_2'),
        'label_2_value' => $config->get('group_' . $i . '_label_2_value'),
      ];
      $content[] = $group;
    }
    
    return [
      '#theme' => 'custom_form_data_block',
      '#content' => $content,
      '#cache' => ['max-age' => 0], // Set cache max-age to 0 to always render fresh content.
    ];
  }

}
