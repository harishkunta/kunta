<?php

namespace Drupal\verathon_bflex_calculator\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\example\ExampleInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a current bronchoscope usage form block.
 *
 * @Block(
 *   id = "verathon_bflex_calculator_current_bronchoscope_usage_form",
 *   admin_label = @Translation("Current Bronchoscope Usage Form"),
 *   category = @Translation("Verathon")
 * )
 */
class CurrentBronchoscopeUsageFormBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The verathon_bflex_calculator.calculator service.
   *
   * @var \Drupal\example\ExampleInterface
   */
  protected $verathonBflexCalculatorCalculator;

  /**
   * Constructs a new CurrentBronchoscopeUsageFormBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\example\ExampleInterface $verathon_bflex_calculator_calculator
   *   The verathon_bflex_calculator.calculator service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ExampleInterface $verathon_bflex_calculator_calculator) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->verathonBflexCalculatorCalculator = $verathon_bflex_calculator_calculator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('verathon_bflex_calculator.calculator')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'foo' => $this->t('Hello world!'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['foo'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Foo'),
      '#default_value' => $this->configuration['foo'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['foo'] = $form_state->getValue('foo');
  }

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
