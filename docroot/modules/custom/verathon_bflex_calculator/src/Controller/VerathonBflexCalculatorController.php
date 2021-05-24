<?php

namespace Drupal\verathon_bflex_calculator\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Verathon Bflex Calculator routes.
 */
class VerathonBflexCalculatorController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
