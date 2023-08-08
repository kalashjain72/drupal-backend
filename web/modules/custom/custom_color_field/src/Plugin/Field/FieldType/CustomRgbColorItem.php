<?php

namespace Drupal\custom_color_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'custom_rgb_color' field type.
 *
 * @FieldType(
 *   id = "custom_rgb_color",
 *   label = @Translation("RGB Color"),
 *   description = @Translation("Stores an RGB color value."),
 *   category = @Translation("Color"),
 *   default_widget = "custom_hex_color_widget",
 *   default_formatter = "custom_rgb_color_formatter"
 * )
 */
class CustomRgbColorItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(('RGB Color'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'value' => array(
          'type' => 'varchar',
          'length' => 7,
          'not null' => FALSE,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    return empty($this->get('value')->getValue());
  }
}

?>
