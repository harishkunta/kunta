<?php

namespace Drupal\verathon_bflex_calculator\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "verathon_bflex_calculator_example",
 *   admin_label = @Translation("Example"),
 *   category = @Translation("Verathon Bflex Calculator")
 * )
 */
class ExampleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}
