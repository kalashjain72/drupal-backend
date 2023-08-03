<?php

namespace Drupal\blockss\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Redirects users to the custom welcome page after login.
 */
class BlockssRedirectSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => 'checkLoginRedirect',
    ];
  }

  /**
   * Check if the user has just logged in and redirect to the custom welcome page.
   *
   * @param \Symfony\Component\HttpKernel\Event\ResponseEvent $event
   *   The response event.
   */
  public function checkLoginRedirect(ResponseEvent $event) {
    $request = $event->getRequest();
    if ($request->attributes->get('_route') === 'user.login' && \Drupal::currentUser()->isAuthenticated()) {
      // Change '/custom-welcome-page' to your actual custom welcome page path.
      $your_custom_path = '/custom-welcome-page';
      $response = new RedirectResponse($your_custom_path);
      $event->setResponse($response);
    }
  }

}