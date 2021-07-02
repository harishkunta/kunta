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
    $service = \Drupal::service('verathon_bflex_calculator.calculator');
    $results = $service->calculate('My Facility', 1000, 750, 265, 30, 2200, 'low', 53);
    dump($results);die;
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
