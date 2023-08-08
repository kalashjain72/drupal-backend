<?php
namespace Drupal\custom_color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'custom_rgb_color_widget' widget.
 *
 * @FieldWidget(
 *   id = "custom_rgb_color_widget",
 *   label = @Translation("RGB Color widget"),
 *   field_types = {
 *     "custom_rgb_color"
 *   }
 * )
 */
class CustomRgbColorWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';

    $element['r'] = [
      '#type' => 'number',
      '#size' => 3,
      '#min' => 0,
      '#max' => 255,
      '#title' => $this->t('Red'),
      '#default_value' => $value ? substr($value, 1, 2) : '',
    ];

    $element['g'] = [
      '#type' => 'number',
      '#size' => 3,
      '#min' => 0,
      '#max' => 255,
      '#title' => $this->t('Green'),
      '#default_value' => $value ? substr($value, 3, 2) : '',
    ];

    $element['b'] = [
      '#type' => 'number',
      '#size' => 3,
      '#min' => 0,
      '#max' => 255,
      '#title' => $this->t('Blue'),
      '#default_value' => $value ? substr($value, 5, 2) : '',
    ];
    return $element;
  }
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    $massaged_values = [];
    foreach ($values as $delta => $value) {
      // Construct the HEX color value based on the RGB components.
      $hexValue = $this->calculateHexColor(
        $value['r'],
        $value['g'],
        $value['b']
      );

      $massaged_values[$delta]['value'] = $hexValue;
    }

    return $massaged_values;
  }

  protected function calculateHexColor($r, $g, $b) {
    return sprintf('#%02X%02X%02X', $r, $g, $b);
  }

}