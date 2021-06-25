<?php

namespace Drupal\verathon_bflex_calculator\Controller;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\verathon_bflex_calculator\Calculator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Verathon Bflex Calculator routes.
 */
class VerathonBflexCalculatorResultController extends ControllerBase
{

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The verathon_bflex_calculator.calculator service.
   *
   */
  protected $verathonBflexCalculatorCalculator;

  /**
   * Builds the response.
   */
  public function build()
  {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }
}
