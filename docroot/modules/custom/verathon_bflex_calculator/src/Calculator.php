<?php

namespace Drupal\verathon_bflex_calculator;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Calculator service.
 */
class Calculator {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a Calculator object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Method description.
   */
  public function doSomething() {
    // @DCG place your code here.
  }

}
