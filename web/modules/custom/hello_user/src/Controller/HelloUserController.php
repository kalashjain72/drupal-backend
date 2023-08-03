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
    // Get the current user object.
    $user = \Drupal::currentUser();
    // Get the display name of the user.
    $name = $user->getDisplayName();
    // Prepare the render array for the content.
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Hello @name', ['@name' => $name]),
    ];
    // Return the render array.
    return $build;
  }

}
