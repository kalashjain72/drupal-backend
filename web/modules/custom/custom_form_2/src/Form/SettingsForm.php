<?php

namespace Drupal\custom_form_2\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Configure custom form 2 settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form_2_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['custom_form_2.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_form_2.settings');

    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#default_value' => $config->get('full_name'),
      '#required' => TRUE,
    ];

		
    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone Number'),
      '#default_value' => $config->get('phone_number'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validatePhoneNumberAjax',
        'event' => 'change',
        'wrapper' => 'phone-number-validation-message',
        'progress' => [
          'type' => 'throbber',
          'message' => NULL,
        ],
      ],
    ];

    $form['phone_number_validation_message'] = [
      '#type' => 'markup',
      '#prefix' => '<div id="phone-number-validation-message">',
      '#suffix' => '</div>',
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email ID'),
      '#default_value' => $config->get('email'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validateEmailAjax',
        'event' => 'change',
        'wrapper' => 'email-validation-message',
        'progress' => [
          'type' => 'throbber',
          'message' => NULL,
        ],
      ],
    ];

    $form['email_validation_message'] = [
      '#type' => 'markup',
      '#prefix' => '<div id="email-validation-message">',
      '#suffix' => '</div>',
    ];


		$form['gender'] = [
			'#type' => 'radios',
			'#title' => $this->t('Gender'),
			'#options' => [
        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'other' => $this->t('Other'),
      ]
		];
		return parent::buildForm($form, $form_state);
	}

	/**
   * {@inheritdoc}
   */

  
  /**
   * Ajax callback to validate the phone number field.
   */
  public function validatePhoneNumberAjax(array &$form, FormStateInterface $form_state) {
    $phone_number = $form_state->getValue('phone_number');

    // Validate phone number.
    if (!is_numeric($phone_number) || strlen($phone_number) != 10) {
      $error_message = $this->t('A phone number needs to have exactly 10 digits.');
      $form_state->setErrorByName('phone_number', $error_message);

      return new JsonResponse(['error' => $error_message]);
    }

    return new JsonResponse(['success' => TRUE]);
  }

  /**
   * Ajax callback to validate the email field.
   */
  public function validateEmailAjax(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');

    // Validate email format.
    if (!\Drupal::service('email.validator')->isValid($email)) {
      $error_message = $this->t('Invalid email format.');
      $form_state->setErrorByName('email', $error_message);

      return new JsonResponse(['error' => $error_message]);
    }

    // Separate domain validation (Yahoo, Gmail, or Outlook) from email format validation.
    if (!preg_match('/@(yahoo|gmail|outlook)\.com$/', $email)) {
      $error_message = $this->t('Use email from Yahoo, Gmail, or Outlook.');
      $form_state->setErrorByName('email', $error_message);

      return new JsonResponse(['error' => $error_message]);
    }

    return new JsonResponse(['success' => TRUE]);
  }



	/**
   * {@inheritdoc}
   */
	public function submitForm(array &$form, FormStateInterface $form_state) {
    $submitted_name = $form_state->getValue('full_name');
    $this->messenger()->addMessage($this->t("@user Your Form has been submitted Successfully", ['@user' => $submitted_name]));
  }
}
