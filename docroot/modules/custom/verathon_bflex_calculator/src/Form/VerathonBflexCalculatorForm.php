<?php

namespace Drupal\verathon_bflex_calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

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
    $form['#strings'] = $config;
    // check if form has been submitted.
    if ($form_state->has('submitted') && $form_state->get('submitted')) {
      $form['#form_values'] = $values;
      $arguments = $form_state->get('calculator_args');
      $form['#calculations'] = \Drupal::service('verathon_bflex_calculator.calculator')->calculate(
        $arguments['facilityName'],
        (int) $arguments['totalProcedures'],
        (int) $arguments['singleUseProcedures'],
        $arguments['bflexBroncoscopePrice'],
        (int) $arguments['currentReusableQuantity'],
        (int) $arguments['currentAnnualServicePer'],
        \Drupal::service('verathon_bflex_calculator.calculator')->getReprocessingMethodByValue($arguments['reprocessingCalcMethod']),
        (int) $arguments['currentAnnualOopRepairAllFactor'],
      );
      $url = Url::fromRoute('verathon_bflex_calculator.pdf');
      $url->setOption('query', [
        'fn' => $arguments['facilityName'],
        'tp' => (int) $arguments['totalProcedures'],
        'sup' => (int) $arguments['singleUseProcedures'],
        'bbp' => $arguments['bflexBroncoscopePrice'],
        'crq' => (int) $arguments['currentReusableQuantity'],
        'casp' => (int) $arguments['currentAnnualServicePer'],
        'rcm' => \Drupal::service('verathon_bflex_calculator.calculator')->getReprocessingMethodByValue($arguments['reprocessingCalcMethod']),
        'caoraf' => (int) $arguments['currentAnnualOopRepairAllFactor'],
      ]);
      $form['#pdf_url'] = $url;
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
        '#min' => 1,
        '#max' => 3000,
        '#step' => 1,
        '#default_value' => 3000,
      ];
      $form['procedures_count_single_usage'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
        '#min' => 1,
        '#max' => 3000,
        '#step' => 1,
        '#default_value' => 2250,
      ];
      $form['total_annual_bronchoscopy_procedures'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
        '#min' => 1,
        '#max' => 3000,
        '#step' => 1,
        '#default_value' => 3000,
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
        '#min' => 1,
        '#max' => 100,
        '#step' => 1,
        '#default_value' => 30,
      ];
      $form['annual_service_cost_per_bronchoscope'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
        '#min' => 1,
        '#max' => 5000,
        '#step' => 1,
        '#default_value' => 5000,
      ];
      $form['annual_out_of_pocket_repair_cost'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
          'list' => 'tickmarks',
        ],
        '#min' => 0,
        '#max' => 100,
        '#step' => 50,
        '#default_value' => 50,
      ];

      // Hidden Reprocessing Costs.
      $form['reprocessing_costs'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
        '#min' => 0,
        '#max' => 100,
        '#step' => 50,
        '#default_value' => 50,
      ];

      $form['reprocessing_costs_method'] = [
        '#type' => 'range',
        '#attributes' => [
          'class' => ['slider'],
        ],
        '#min' => 0,
        '#max' => 100,
        '#step' => 50,
        '#default_value' => 50,
      ];

      $form['actions'] = [
        '#type' => 'actions',
      ];


      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $config['result_button_label'] ? $config['result_button_label'] : 'See Results',
      ];
    }

    $form['#attached']['library'][] = 'verathon_bflex_calculator/verathon_bflex_calculator';
    $form['#attached']['drupalSettings']['config'] = $config;

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
    // Getting the form values and assigning it to an array.
    $submission_values = $form_state->getValues();
    $values = [
      'facilityName' => $submission_values['facility_name'],
      'totalProcedures' => $submission_values['total_annual_bronchoscopy_procedures'],
      'singleUseProcedures' => $submission_values['procedures_count_single_usage'],
      'bflexBroncoscopePrice' => (is_numeric($submission_values['your_bronchoscope_price']) && !empty($submission_values['your_bronchoscope_price'])) ? $submission_values['your_bronchoscope_price'] : 1,
      'currentReusableQuantity' => $submission_values['total_reusable_bronchoscopes'],
      'currentAnnualServicePer' => $submission_values['annual_service_cost_per_bronchoscope'],
      'reprocessingCalcMethod' => $submission_values['reprocessing_costs_method'],
      'currentAnnualOopRepairAllFactor' => $submission_values['annual_out_of_pocket_repair_cost'],
    ];
    $form_state->set('calculator_args', $values);

    $form_state->set('submitted', true)->setRebuild(true);
  }
}
