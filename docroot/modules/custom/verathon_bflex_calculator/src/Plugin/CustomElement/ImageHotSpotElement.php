<?php

namespace Drupal\verathon_bflex_calculator\Plugin\CustomElement;

use Drupal\cohesion_elements\CustomElementPluginBase;

/**
 * An image element that supports the image hot-spot feature.
 *
 * @CustomElement(
 *  id = "Hotspot Image Element",
 *  label = @Translation("An image element that supports the image hot-spot feature.")
 * )
 */
class ImageHotSpotElement extends CustomElementPluginBase
{
  public function getFields()
  {
    return [
      'image' => [
        'type' => 'image',
        'title' => 'Image',
        'nullOption' => false,
        'buttonText' => 'Add Image',
      ],
      'x_coordinate' => [
        'htmlClass' => 'col-xs-12',
        'title' => 'Image X Coordinate',
        'type' => 'textfield',
        'placeholder' => 'X-Coordiate',
      ],
      'y_coordinate' => [
        'htmlClass' => 'col-xs-12',
        'title' => 'Image Y Coordinate',
        'type' => 'textfield',
        'placeholder' => 'Y-Coordiate',
      ],
    ];
  }
}
