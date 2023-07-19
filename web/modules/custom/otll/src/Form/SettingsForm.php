<?php

namespace Drupal\otll\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\user\Entity\User;


/**
 * Configure otll settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'otll_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['otll.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['user_id'] = [
      '#type' => 'number',
      '#title' => $this->t('User Id'),
      '#description' => 'Please enter a valid user id to generate link.',
    ];

    $form['actions'] = [
      '#type' => 'submit',
      '#value' => $this->t('Get Link'),
      '#ajax' => [
        'callback' => '::generateOneTimeLoginLink',
      ]
    ];
    $form['status'] = [
      '#type' => 'markup',
      '#markup' => '<p id="link-status"></p>',
    ];
    return $form;
  }

  /**
   * Using ajax show the errors.
   *
   * @param array $form
   * @param FormStateInterface $form_state
   * @return object
   */
  public function generateOneTimeLoginLink(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $user_id = $form_state->getValue('user_id');
    var_dump($user_id);
    exit();
    $account = User::load($user_id);

    $user = $account->get('name')->value;

    $flag = FALSE;
    if (is_null($user)) {
      $message = 'User not exists.';
    }
    else {
      $result = user_pass_reset_url($user) . '/login';
      $flag = TRUE;
    }
    if ($flag) {
      var_dump($result);
      $response->addCommand(new HtmlCommand('#link-status', $result));
      $response->addCommand(new CssCommand('#link-status', ['color' => 'green']));
    }
    else {
      $response->addCommand(new HtmlCommand('#link-status', $message));
      $response->addCommand(new CssCommand('#link-status', ['color' => 'red']));
    }
    return $response;
  }

  /**
   * {@inheritDoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }
}