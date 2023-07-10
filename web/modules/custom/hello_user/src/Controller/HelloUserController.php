<?php declare(strict_types = 1);

namespace Drupal\hello_user\Controller;

use Drupal\Core\Controller\ControllerBase;


/**
 * Returns responses for hello user routes.
 */
final class HelloUserController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(): array {
    $user = \Drupal::currentUser();
    $name = $user->getDisplayName();
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Hello @name', ['@name' => $name]),
    ];

    return $build;
  }

}
?>