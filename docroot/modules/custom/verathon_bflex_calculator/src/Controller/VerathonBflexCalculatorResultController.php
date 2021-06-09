<?php

namespace Drupal\verathon_bflex_calculator\Controller;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\example\ExampleInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Verathon Bflex Calculator routes.
 */
class VerathonBflexCalculatorResultController extends ControllerBase {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The verathon_bflex_calculator.calculator service.
   *
   * @var \Drupal\example\ExampleInterface
   */
  protected $verathonBflexCalculatorCalculator;

  /**
   * The controller constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\example\ExampleInterface $verathon_bflex_calculator_calculator
   *   The verathon_bflex_calculator.calculator service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, ExampleInterface $verathon_bflex_calculator_calculator) {
    $this->configFactory = $config_factory;
    $this->verathonBflexCalculatorCalculator = $verathon_bflex_calculator_calculator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('verathon_bflex_calculator.calculator')
    );
  }

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
