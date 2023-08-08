<?php

namespace Drupal\custom_form_2\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;


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

    $form['element'] = [
			'#type' => 'markup',
			'#markup' => "<div class='success'></div>",
		];
    
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
      '#suffix' => '<div class = "error" id = "phone_number"></div>'
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email ID'),
      '#default_value' => $config->get('email'),
      '#required' => TRUE,
      '#suffix' => '<div class = "error" id = "email"></div>'
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
    
		
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t("submit"),
			'#ajax' => [
						'callback' => '::validateAjax',
			],
		];

		$form['#attatched']['library'][] = 'custom_form_2/custom_form_2_css';
		return $form;
	
	}

	/**
   * {@inheritdoc}
   */

  /**
   * Ajax callback to validate the phone number and email field.
   */
  
  public function validateAjax(array &$form, FormStateInterface $form_state) {
		$ajax_response = new AjaxResponse();

    $email = $form_state->getValue('email');
    $phoneNumber = $form_state->getValue('phone_number');

		$valid = TRUE;
    // Validate phone number.
    if (!is_numeric($phoneNumber) || strlen($phoneNumber) != 10) {
      $ajax_response->addCommand(new HtmlCommand('#phone_number', 
        $this->t('A phone number needs to have exactly 10 digits.')));
      $valid = FALSE;
    }

    // Validate email.
    if (!\Drupal::service('email.validator')->isValid($email)) {
			$ajax_response->addCommand(new HtmlCommand('#email', $this->t('Invalid format')));
    }
    elseif (!preg_match('/@(yahoo|gmail|outlook)\.com$/', $email)) {
      $ajax_response->addCommand(new HtmlCommand('#email', $this->t('Use email from Yahoo, Gmail, or Outlook.')));
    }
		if ($valid) {
		$ajax_response->addCommand(new HtmlCommand('.success', 'Form submitted successfully'));
		}
		return $ajax_response;
  }

	/**
   * {@inheritdoc}
   */
	public function submitForm(array &$form, FormStateInterface $form_state) {
    }
}