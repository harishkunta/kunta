<?php

namespace Drupal\verathon_bflex_calculator\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Verathon Bflex Calculator settings for this site.
 */
class CalculatorResultContentForm extends ConfigFormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'verathon_bflex_calculator_calculator_result_current_labels';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return ['verathon_bflex_calculator.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    // Getting Default configurations.
    $config = $this->config('verathon_bflex_calculator.settings')->get();
    $values = $form_state->getValues();
    // Global Form
    $form['current'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#collapsible' => TRUE,
      '#title' => $this->t('Current Operating Cost')
    ];
    $form['with'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#collapsible' => TRUE,
      '#title' => $this->t('Bflex Cost')
    ];
    // Global Section
    $form['global'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#collapsible' => TRUE,
      '#weight' => -1,
      '#title' => $this->t('Global')
    ];

    $form['global']['result_page_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your Cost-Comparison Results'),
      '#attributes' => [
        'placeholder' => $this->t('Page Heading'),
      ],
      '#default_value' => !empty($values['result_page_heading']) ? $values['result_page_heading'] : $config['result_page_heading'],
    ];
    $form['global']['result_page_description'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Description'),
      '#default_value' => !empty($values['result_page_description']) ? $values['result_page_description'] : $config['result_page_description'],
    ];

    $form['global']['result_page_footer'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Footer Text - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Footer Text'),
      ],
      '#default_value' => !empty($values['result_page_footer']) ? $values['result_page_footer'] : $config['result_page_footer'],
    ];



    // GEnerating fields for the current section.
    $form['current']['current_bronchoscope_usage'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#collapsible' => TRUE,
      '#title' => $this->t('Current bronchoscope usage')
    ];
    $form['current']['repair_maintenance_usage'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#collapsible' => TRUE,
      '#title' => $this->t('Repair & Maintenance')
    ];
    $form['current']['reprocessing_costs'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#collapsible' => TRUE,
      '#title' => $this->t('Reprocessing Costs')
    ];
    $form['current']['preventable_infections'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#collapsible' => TRUE,
      '#title' => $this->t('Preventable Infections')
    ];
    $form['current']['result_current_current_main_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Heading - Label'),
      '#attributes' => [
        'placeholder' => $this->t('CURRENT OPERATING COSTS'),
      ],
      '#default_value' => !empty($values['result_current_current_main_heading']) ? $values['result_current_current_main_heading'] : $config['result_current_current_main_heading'],
    ];
    $form['current']['result_current_current_sub_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Sub-heading - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Using reusable bronchoscopes only'),
      ],
      '#default_value' => !empty($values['result_current_current_sub_heading']) ? $values['result_current_current_sub_heading'] : $config['result_current_current_sub_heading'],
    ];
    $form['current']['result_current_grand_total_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual Estimated Operating Costs - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Annual Estimated Operating Costs'),
      ],
      '#default_value' => !empty($values['result_current_grand_total_label']) ? $values['result_current_grand_total_label'] : $config['result_current_grand_total_label'],
    ];

    // Bronchoscope section fields
    $form['current']['current_bronchoscope_usage']['result_current_bronchoscope_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Section Heading'),
      '#attributes' => [
        'placeholder' => $this->t('Current bronchoscope usage'),
      ],
      '#default_value' => !empty($values['result_current_bronchoscope_heading']) ? $values['result_current_bronchoscope_heading'] : $config['result_current_bronchoscope_heading'],
    ];
    $form['current']['current_bronchoscope_usage']['result_current_single_usage_count_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Single Usage Bronchoscopes - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Current bronchoscope usage'),
      ],
      '#default_value' => !empty($values['result_current_single_usage_count_label']) ? $values['result_current_single_usage_count_label'] : $config['result_current_single_usage_count_label'],
    ];
    $form['current']['current_bronchoscope_usage']['result_current_bronchoscope_cost_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual Cost - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Annual Cost'),
      ],
      '#default_value' => !empty($values['result_current_bronchoscope_cost_label']) ? $values['result_current_bronchoscope_cost_label'] : $config['result_current_bronchoscope_cost_label'],
    ];

    // Repair & Maintenance Costs Section fields
    $form['current']['repair_maintenance_usage']['result_current_repair_maintenance_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Section Heading'),
      '#attributes' => [
        'placeholder' => $this->t('Repair and maintenance costs'),
      ],
      '#default_value' => !empty($values['result_current_repair_maintenance_heading']) ? $values['result_current_repair_maintenance_heading'] : $config['result_current_repair_maintenance_heading'],
    ];
    $form['current']['repair_maintenance_usage']['result_current_reusable_bronchoscope_usage_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Reusable bronchoscopes (QTY) - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Reusable bronchoscopes (QTY)'),
      ],
      '#default_value' => !empty($values['result_current_reusable_bronchoscope_usage_label']) ? $values['result_current_reusable_bronchoscope_usage_label'] : $config['result_current_reusable_bronchoscope_usage_label'],
    ];
    $form['current']['repair_maintenance_usage']['result_current_annual_cost_of_service_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual cost of service agreement per reusable bronchoscope - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Annual cost of service agreement per reusable bronchoscope'),
      ],
      '#default_value' => !empty($values['result_current_annual_cost_of_service_label']) ? $values['result_current_annual_cost_of_service_label'] : $config['result_current_annual_cost_of_service_label'],
    ];
    $form['current']['repair_maintenance_usage']['result_current_annual_oop_cost_of_service_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual out-of-pocket repair costs for all reusable bronchoscopes - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Annual out-of-pocket repair costs for all reusable bronchoscopes'),
      ],
      '#default_value' => !empty($values['result_current_annual_oop_cost_of_service_label']) ? $values['result_current_annual_oop_cost_of_service_label'] : $config['result_current_annual_oop_cost_of_service_label'],
    ];
    $form['current']['repair_maintenance_usage']['result_current_repair_maintenance_costs_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual Cost - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Annual Cost'),
      ],
      '#default_value' => !empty($values['result_current_repair_maintenance_costs_label']) ? $values['result_current_repair_maintenance_costs_label'] : $config['result_current_repair_maintenance_costs_label'],
    ];

    // Repair & Maintenance Costs Section fields
    $form['current']['reprocessing_costs']['result_current_reprocessing_costs_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Section Heading'),
      '#attributes' => [
        'placeholder' => $this->t('Reprocessing costs per use'),
      ],
      '#default_value' => !empty($values['result_current_reprocessing_costs_heading']) ? $values['result_current_reprocessing_costs_heading'] : $config['result_current_reprocessing_costs_heading'],
    ];
    $form['current']['reprocessing_costs']['result_current_reprocessing_cost_left_column_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Reprocessing costs - column header'),
      '#attributes' => [
        'placeholder' => $this->t('Reprocessing costs'),
      ],
      '#default_value' => !empty($values['result_current_reprocessing_cost_left_column_heading']) ? $values['result_current_reprocessing_cost_left_column_heading'] : $config['result_current_reprocessing_cost_left_column_heading'],
    ];
    $form['current']['reprocessing_costs']['result_current_reprocessing_cost_right_column_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average - column header'),
      '#attributes' => [
        'placeholder' => $this->t('Average'),
      ],
      '#default_value' => !empty($values['result_current_reprocessing_cost_right_column_heading']) ? $values['result_current_reprocessing_cost_right_column_heading'] : $config['result_current_reprocessing_cost_right_column_heading'],
    ];
    $form['current']['reprocessing_costs']['result_current_ppe_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PPE for personnel - Label'),
      '#attributes' => [
        'placeholder' => $this->t('PPE for personnel'),
      ],
      '#default_value' => !empty($values['result_current_ppe_label']) ? $values['result_current_ppe_label'] : $config['result_current_ppe_label'],
    ];
    $form['current']['reprocessing_costs']['result_current_bedside_precleaning_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Bedside precleaning - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Bedside precleaning'),
      ],
      '#default_value' => !empty($values['result_current_bedside_precleaning_label']) ? $values['result_current_bedside_precleaning_label'] : $config['result_current_bedside_precleaning_label'],
    ];
    $form['current']['reprocessing_costs']['result_current_leak_testing_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Leak testing - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Leak testing'),
      ],
      '#default_value' => !empty($values['result_current_leak_testing_label']) ? $values['result_current_leak_testing_label'] : $config['result_current_leak_testing_label'],
    ];
    $form['current']['reprocessing_costs']['result_current_manual_cleaning_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Manual Cleaning - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Manual cleaning'),
      ],
      '#default_value' => !empty($values['result_current_manual_cleaning_label']) ? $values['result_current_manual_cleaning_label'] : $config['result_current_manual_cleaning_label'],
    ];
    $form['current']['reprocessing_costs']['result_current_visual_inspection_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Visual Inspection - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Visual Inspection'),
      ],
      '#default_value' => !empty($values['result_current_visual_inspection_label']) ? $values['result_current_visual_inspection_label'] : $config['result_current_visual_inspection_label'],
    ];
    $form['current']['reprocessing_costs']['result_current_hld_in_aer_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('HLD in an AER - Label'),
      '#attributes' => [
        'placeholder' => $this->t('HLD in an AER'),
      ],
      '#default_value' => !empty($values['result_current_hld_in_aer_label']) ? $values['result_current_hld_in_aer_label'] : $config['result_current_hld_in_aer_label'],
    ];
    $form['current']['reprocessing_costs']['result_current_dying_storage_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Dying and Storage - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Dying and Storage'),
      ],
      '#default_value' => !empty($values['result_current_dying_storage_label']) ? $values['result_current_dying_storage_label'] : $config['result_current_dying_storage_label'],
    ];
    $form['current']['reprocessing_costs']['result_current_reprocessing_costs_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual Cost - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Annual Cost'),
      ],
      '#default_value' => !empty($values['result_current_reprocessing_costs_label']) ? $values['result_current_reprocessing_costs_label'] : $config['result_current_reprocessing_costs_label'],
    ];

    // Preventable Infections Section Fields.
    $form['current']['preventable_infections']['result_current_preventable_infections_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Section Heading - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Preventable Infections'),
      ],
      '#default_value' => !empty($values['result_current_preventable_infections_heading']) ? $values['result_current_preventable_infections_heading'] : $config['result_current_preventable_infections_heading'],
    ];
    $form['current']['preventable_infections']['result_current_preventable_infections_patient_infections_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Patient infections due to cross contamination - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Patient infections due to cross contamination'),
      ],
      '#default_value' => !empty($values['result_current_preventable_infections_patient_infections_label']) ? $values['result_current_preventable_infections_patient_infections_label'] : $config['result_current_preventable_infections_patient_infections_label'],
    ];
    $form['current']['preventable_infections']['result_current_cost_per_infection_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cost per infection - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Cost per infection'),
      ],
      '#default_value' => !empty($values['result_current_cost_per_infection_label']) ? $values['result_current_cost_per_infection_label'] : $config['result_current_cost_per_infection_label'],
    ];
    $form['current']['preventable_infections']['result_current_preventable_infections_costs_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual Cost - Label'),
      '#attributes' => [
        'placeholder' => $this->t('Annual Cost'),
      ],
      '#default_value' => !empty($values['result_current_preventable_infections_costs_label']) ? $values['result_current_preventable_infections_costs_label'] : $config['result_current_preventable_infections_costs_label'],
    ];



    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    if ($form_state->getValue('example') != 'example') {
      $form_state->setErrorByName('example', $this->t('The value is not correct.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->config('verathon_bflex_calculator.settings')
      ->set('example', $form_state->getValue('example'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}
