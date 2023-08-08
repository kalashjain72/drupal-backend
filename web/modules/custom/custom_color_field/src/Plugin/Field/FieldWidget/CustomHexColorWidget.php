<?php
namespace Drupal\custom_color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'custom_hex_color_widget' widget.
 *
 * @FieldWidget(
 *   id = "custom_hex_color_widget",
 *   label = @Translation("Hex Color Picker"),
 *   field_types = {
 *     "custom_hex_color"
 *   }
 * )
 */
class CustomHexColorWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';

    $element['value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hex Color Code'),
      '#default_value' => $value,
      '#maxlength' => 7,
      '#size' => 7,
      '#element_validate' => [
        [$this, 'validateHexColorCode'],
      ],
    ];

    return $element;
  }

  /**
   * Validate the hex color code.
   */
  public function validateHexColorCode($element, FormStateInterface $form_state) {
    $value = $form_state->getValue($element['#parents']);
    if (!empty($value) && !preg_match('/^#[0-9a-fA-F]{6}$/', $value)) {
      $form_state->setError($element, $this->t('Please enter a valid 6-digit hex color code.'));
    }
  }
}
?>