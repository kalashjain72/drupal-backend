<?php

namespace Drupal\routing_system\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for routing system routes.
 */
class RoutingSystemController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

  public function dynamicParameter(string $value) {
  	return [
    	'#type' => 'markup',
    	'#markup' => $this->t('@value Fetched from the url', ['@value' => $value]),
    ];
  }
}
