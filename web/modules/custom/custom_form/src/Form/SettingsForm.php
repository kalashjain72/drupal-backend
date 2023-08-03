<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure custom form settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['custom_form.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_form.settings');

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
		];

		$form['email'] = [
			'#type' => 'email',
			'#title' => $this->t('Email ID'),
			'#default_value' => $config->get('email'),
      '#required' => TRUE,
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
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    $phoneNumber = $form_state->getValue('phone_number');

    // Validate phone number.
    if (!is_numeric($phoneNumber) || strlen($phoneNumber) != 10) {
      $form_state->setErrorByName('phone_number', $this->t('A phone number needs to have exactly 10 digits.'));
    }

    // Validate email.
    if (!\Drupal::service('email.validator')->isValid($email)) {
      $form_state->setErrorByName('email', $this->t('Invalid format'));
    }
    elseif (!preg_match('/@(yahoo|gmail|outlook)\.com$/', $email)) {
      $form_state->setErrorByName('email', $this->t('Use email from Yahoo, Gmail, or Outlook.'));
    }
  }

	/**
   * {@inheritdoc}
   */
	public function submitForm(array &$form, FormStateInterface $form_state) {
    $submitted_name = $form_state->getValue('full_name');
    $this->messenger()->addMessage($this->t("@user Your Form has been submitted Successfully", ['@user' => $submitted_name]));
  }
}
