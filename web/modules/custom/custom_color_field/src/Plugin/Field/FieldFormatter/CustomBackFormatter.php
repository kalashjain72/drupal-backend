<?php
namespace Drupal\custom_color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Render\Markup;

/**
 * Plugin implementation of the 'custom_hex_color_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "custom_hex_color_formatter",
 *   label = @Translation("Hex Color background"),
 *   field_types = {
 *     "custom_rgb_color",
 *     "custom_hex_color"
 *   }
 * )
 */
class CustomBackFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $value = $item->value;

      // Convert RGB to HEX if necessary
      if ($item->getFieldDefinition()->getType() == 'custom_rgb_color') {
        $value = $this->convertRgbToHex($value);
      }

      $elements[$delta] = [
        '#markup' => Markup::create('<div style="background-color: ' . $value . '; width: auto; height: 20px;"></div> '),
      ];
    }

    return $elements;
  }

  /**
   * Convert RGB color code to HEX color code.
   */
  protected function convertRgbToHex($rgb) {
    $r = hexdec(substr($rgb, 1, 2));
    $g = hexdec(substr($rgb, 3, 2));
    $b = hexdec(substr($rgb, 5, 2));
    return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT) .
                  str_pad(dechex($g), 2, '0', STR_PAD_LEFT) .
                  str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
  }

}
?>