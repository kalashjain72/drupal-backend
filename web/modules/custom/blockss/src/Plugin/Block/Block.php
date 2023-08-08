<?php

namespace Drupal\blockss\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "blockss",
 *   admin_label = @Translation("blockss"),
 *   category = @Translation("blockss is use to welcome a user ")
 * )
 */
class Block extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = \Drupal::currentUser();
    // Get the display name of the user.
    $name = $user->getDisplayName();
    // Prepare the render array for the content.
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Hello @name', ['@name' => $name]),
    ];
    return $build;
  }

}
