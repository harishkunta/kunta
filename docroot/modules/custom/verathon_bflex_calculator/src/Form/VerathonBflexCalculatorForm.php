<?php

namespace Drupal\verathon_bflex_calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Verathon Bflex Calculator form.
 */
class VerathonBflexCalculatorForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'verathon_bflex_calculator_verathon_bflex_calculator';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = \Drupal::service('config.factory')->getEditable('verathon_bflex_calculator.settings')->get();
    $values = $form_state->getValues();

    // check if form has been submitted.
    if ($form_state->has('submitted') && $form_state->get('submitted')) {
      $form['#form_values'] = $values;
      $form['#calculations'] = \Drupal::service('verathon_bflex_calculator.calculator')->getMock();
    }
    // If opening first time.
    else {
      $form_state->set('submitted', false);

      $form['facility_name'] = [
        '#type' => 'textfield',
        '#required' => true,
      ];

      $form['total_annual_bronchoscopy_procedures'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
      ];
      $form['procedures_count_single_usage'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
      ];
      $form['total_annual_bronchoscopy_procedures'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
      ];
      $form['your_bronchoscope_price'] = [
        '#type' => 'number',
      ];

      // Repair & Maintenance Form Fields.
      $form['total_reusable_bronchoscopes'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
      ];
      $form['annual_service_cost_per_bronchoscope'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
      ];
      $form['annual_out_of_pocket_repair_cost'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
      ];

      // Hidden Reprocessing Costs.
      $form['reprocessing_costs'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
      ];

      $form['actions'] = [
        '#type' => 'actions',
      ];


      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
      ];
    }
    $form['#attached']['library'][] = 'verathon_bflex_calculator/verathon_bflex_calculator';
    $form['#theme'] = 'form__verathon_bflex_calculator_verathon_bflex_calculator';
    $form['#config'] = $config;
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    // if (mb_strlen($form_state->getValue('message')) < 10) {
    //   $form_state->setErrorByName('name', $this->t('Message should be at least 10 characters.'));
    // }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $form_state->set('submitted', true)->setRebuild(true);
  }
}
