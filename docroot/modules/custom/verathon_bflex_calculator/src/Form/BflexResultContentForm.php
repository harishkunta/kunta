<?php

namespace Drupal\verathon_bflex_calculator\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Verathon Bflex Calculator settings for this site.
 */
class BflexResultContentForm extends ConfigFormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'verathon_bflex_calculator_bflex_result_content';
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
    try {
      $config = \Drupal::config('verathon_bflex_calculator.settings')->get();
      $values = $form_state->getValues();
      // Global Form
      $form['current'] = [
        '#type' => 'details',
        '#open' => false,
        '#collapsible' => true,
        '#title' => $this->t('Current Operating Cost')
      ];
      $form['with'] = [
        '#type' => 'details',
        '#open' => false,
        '#collapsible' => true,
        '#title' => $this->t('Bflex Cost')
      ];

      // Global Sectio
      $form['global'] = [
        '#type' => 'details',
        '#open' => false,
        '#collapsible' => true,
        '#weight' => -1,
        '#title' => $this->t('Global')
      ];

      $form['global']['result_page_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Your Cost-Comparison Results'),
        '#attributes' => [
          'placeholder' => $this->t('Page Heading'),
        ],
        '#default_value' => $config['result_page_heading'],
      ];
      $form['global']['result_page_description'] = [
        '#type' => 'text_format',
        '#format' => 'cohesion',
        '#allowed_formats' => ['cohesion'],
        '#title' => $this->t('Description'),
        '#default_value' => $config['result_page_description']['value'],
      ];

      $form['global']['result_page_footer'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Footer Text - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Footer Text'),
        ],
        '#default_value' => $config['result_page_footer'],
      ];

      $form['global']['download_button_text'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Download button  - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Download button  - Label'),
        ],
        '#default_value' => $config['download_button_text'],
      ];

      // GEnerating fields for the current section.
      $form['current']['current_bronchoscope_usage'] = [
        '#type' => 'details',
        '#open' => false,
        '#collapsible' => true,
        '#title' => $this->t('Current bronchoscope usage')
      ];
      $form['current']['repair_maintenance_usage'] = [
        '#type' => 'details',
        '#open' => false,
        '#collapsible' => true,
        '#title' => $this->t('Repair & Maintenance')
      ];
      $form['current']['reprocessing_costs'] = [
        '#type' => 'details',
        '#open' => false,
        '#collapsible' => true,
        '#title' => $this->t('Reprocessing Costs')
      ];
      $form['current']['preventable_infections'] = [
        '#type' => 'details',
        '#open' => false,
        '#collapsible' => true,
        '#title' => $this->t('Preventable Infections')
      ];
      // Gloabl Current Fields
      $form['current']['result_current_main_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Heading - Label'),
        '#attributes' => [
          'placeholder' => $this->t('CURRENT OPERATING COSTS'),
        ],
        '#default_value' => $config['result_current_main_heading'],
      ];
      $form['current']['result_current_sub_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Sub-heading - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Using reusable bronchoscopes only'),
        ],
        '#default_value' => $config['result_current_sub_heading'],
      ];
      $form['current']['result_current_grand_total_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual Estimated Operating Costs - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual Estimated Operating Costs'),
        ],
        '#default_value' => $config['result_current_grand_total_label'],
      ];

      // Bronchoscope section fields
      $form['current']['current_bronchoscope_usage']['result_current_bronchoscope_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Section Heading'),
        '#attributes' => [
          'placeholder' => $this->t('Current bronchoscope usage'),
        ],
        '#default_value' => $config['result_current_bronchoscope_heading'],
      ];
      $form['current']['current_bronchoscope_usage']['result_current_single_usage_count_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Single Usage Bronchoscopes - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Current bronchoscope usage'),
        ],
        '#default_value' => $config['result_current_single_usage_count_label'],
      ];
      $form['current']['current_bronchoscope_usage']['result_current_bronchoscope_cost_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual Cost - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual Cost'),
        ],
        '#default_value' => $config['result_current_bronchoscope_cost_label'],
      ];

      // Repair & Maintenance Costs Section fields
      $form['current']['repair_maintenance_usage']['result_current_repair_maintenance_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Section Heading'),
        '#attributes' => [
          'placeholder' => $this->t('Repair and maintenance costs'),
        ],
        '#default_value' => $config['result_current_repair_maintenance_heading'],
      ];
      $form['current']['repair_maintenance_usage']['result_current_reusable_bronchoscope_usage_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Reusable bronchoscopes (QTY) - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Reusable bronchoscopes (QTY)'),
        ],
        '#default_value' => $config['result_current_reusable_bronchoscope_usage_label'],
      ];
      $form['current']['repair_maintenance_usage']['result_current_annual_cost_of_service_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual cost of service agreement per reusable bronchoscope - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual cost of service agreement per reusable bronchoscope'),
        ],
        '#default_value' => $config['result_current_annual_cost_of_service_label'],
      ];
      $form['current']['repair_maintenance_usage']['result_current_annual_oop_cost_of_service_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual out-of-pocket repair costs for all reusable bronchoscopes - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual out-of-pocket repair costs for all reusable bronchoscopes'),
        ],
        '#default_value' => $config['result_current_annual_oop_cost_of_service_label'],
      ];
      $form['current']['repair_maintenance_usage']['result_current_repair_maintenance_costs_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual Cost - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual Cost'),
        ],
        '#default_value' => $config['result_current_repair_maintenance_costs_label'],
      ];

      // Repair & Maintenance Costs Section fields
      $form['current']['reprocessing_costs']['result_current_reprocessing_costs_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Section Heading'),
        '#attributes' => [
          'placeholder' => $this->t('Reprocessing costs per use'),
        ],
        '#default_value' => $config['result_current_reprocessing_costs_heading'],
      ];
      $form['current']['reprocessing_costs']['result_current_reprocessing_cost_left_column_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Reprocessing costs - column header'),
        '#attributes' => [
          'placeholder' => $this->t('Reprocessing costs'),
        ],
        '#default_value' => $config['result_current_reprocessing_cost_left_column_heading'],
      ];
      $form['current']['reprocessing_costs']['result_current_reprocessing_cost_right_column_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Average - column header'),
        '#attributes' => [
          'placeholder' => $this->t('Average'),
        ],
        '#default_value' => $config['result_current_reprocessing_cost_right_column_heading'],
      ];
      $form['current']['reprocessing_costs']['result_current_ppe_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('PPE for personnel - Label'),
        '#attributes' => [
          'placeholder' => $this->t('PPE for personnel'),
        ],
        '#default_value' => $config['result_current_ppe_label'],
      ];
      $form['current']['reprocessing_costs']['result_current_bedside_precleaning_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Bedside precleaning - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Bedside precleaning'),
        ],
        '#default_value' => $config['result_current_bedside_precleaning_label'],
      ];
      $form['current']['reprocessing_costs']['result_current_leak_testing_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Leak testing - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Leak testing'),
        ],
        '#default_value' => $config['result_current_leak_testing_label'],
      ];
      $form['current']['reprocessing_costs']['result_current_manual_cleaning_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Manual Cleaning - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Manual cleaning'),
        ],
        '#default_value' => $config['result_current_manual_cleaning_label'],
      ];
      $form['current']['reprocessing_costs']['result_current_visual_inspection_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Visual Inspection - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Visual Inspection'),
        ],
        '#default_value' => $config['result_current_visual_inspection_label'],
      ];
      $form['current']['reprocessing_costs']['result_current_hld_in_aer_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('HLD in an AER - Label'),
        '#attributes' => [
          'placeholder' => $this->t('HLD in an AER'),
        ],
        '#default_value' => $config['result_current_hld_in_aer_label'],
      ];
      $form['current']['reprocessing_costs']['result_current_dying_storage_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Dying and Storage - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Dying and Storage'),
        ],
        '#default_value' => $config['result_current_dying_storage_label'],
      ];
      $form['current']['reprocessing_costs']['result_current_reprocessing_costs_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual Cost - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual Cost'),
        ],
        '#default_value' => $config['result_current_reprocessing_costs_label'],
      ];

      // Preventable Infections Section Fields.
      $form['current']['preventable_infections']['result_current_preventable_infections_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Section Heading - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Preventable Infections'),
        ],
        '#default_value' => $config['result_current_preventable_infections_heading'],
      ];
      $form['current']['preventable_infections']['result_current_preventable_infections_patient_infections_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Patient infections due to cross contamination - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Patient infections due to cross contamination'),
        ],
        '#default_value' => $config['result_current_preventable_infections_patient_infections_label'],
      ];
      $form['current']['preventable_infections']['result_current_cost_per_infection_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Cost per infection - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Cost per infection'),
        ],
        '#default_value' => $config['result_current_cost_per_infection_label'],
      ];
      $form['current']['preventable_infections']['result_current_preventable_infections_costs_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual Cost - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual Cost'),
        ],
        '#default_value' => $config['result_current_preventable_infections_costs_label'],
      ];

      // GEnerating fields for the current section.
      $form['with']['bflex_bronchoscope_usage'] = [
        '#type' => 'details',
        '#open' => false,
        '#collapsible' => true,
        '#title' => $this->t('Current bronchoscope usage')
      ];
      $form['with']['bflex_repair_maintenance_usage'] = [
        '#type' => 'details',
        '#open' => false,
        '#collapsible' => true,
        '#title' => $this->t('Repair & Maintenance')
      ];
      $form['with']['bflex_reprocessing_costs'] = [
        '#type' => 'details',
        '#open' => false,
        '#collapsible' => true,
        '#title' => $this->t('Reprocessing Costs')
      ];
      $form['with']['bflex_preventable_infections'] = [
        '#type' => 'details',
        '#open' => false,
        '#collapsible' => true,
        '#title' => $this->t('Preventable Infections')
      ];

      // Global With Fields
      $form['with']['result_with_main_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Heading - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Current operating costs'),
        ],
        '#default_value' => $config['result_with_main_heading'],
      ];
      $form['with']['result_with_sub_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Sub-heading - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Using reusable bronchoscopes only'),
        ],
        '#default_value' => $config['result_with_sub_heading'],
      ];
      $form['with']['result_with_grand_total_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual Estimated Operating Costs - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual Estimated Operating Costs'),
        ],
        '#default_value' => $config['result_with_grand_total_label'],
      ];
      // Bronchoscope section fields
      $form['with']['bflex_bronchoscope_usage']['result_with_bronchoscope_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Section Heading'),
        '#attributes' => [
          'placeholder' => $this->t('Current bronchoscope usage'),
        ],
        '#default_value' => $config['result_with_bronchoscope_heading'],
      ];
      $form['with']['bflex_bronchoscope_usage']['result_with_single_usage_count_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Single Usage Bronchoscopes - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Current bronchoscope usage'),
        ],
        '#default_value' => $config['result_with_single_usage_count_label'],
      ];
      $form['with']['bflex_bronchoscope_usage']['result_with_bronchoscope_cost_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual Cost - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual Cost'),
        ],
        '#default_value' => $config['result_with_bronchoscope_cost_label'],
      ];

      // Repair & Maintenance Costs Section fields
      $form['with']['bflex_repair_maintenance_usage']['result_with_repair_maintenance_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Section Heading'),
        '#attributes' => [
          'placeholder' => $this->t('Repair and maintenance costs'),
        ],
        '#default_value' => $config['result_with_repair_maintenance_heading'],
      ];
      $form['with']['bflex_repair_maintenance_usage']['result_with_reusable_bronchoscope_usage_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Reusable bronchoscopes (QTY) - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Reusable bronchoscopes (QTY)'),
        ],
        '#default_value' => $config['result_with_reusable_bronchoscope_usage_label'],
      ];
      $form['with']['bflex_repair_maintenance_usage']['result_with_annual_cost_of_service_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual cost of service agreement per reusable bronchoscope - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual cost of service agreement per reusable bronchoscope'),
        ],
        '#default_value' => $config['result_with_annual_cost_of_service_label'],
      ];
      $form['with']['bflex_repair_maintenance_usage']['result_with_annual_oop_cost_of_service_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual out-of-pocket repair costs for all reusable bronchoscopes - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual out-of-pocket repair costs for all reusable bronchoscopes'),
        ],
        '#default_value' => $config['result_with_annual_oop_cost_of_service_label'],
      ];
      $form['with']['bflex_repair_maintenance_usage']['result_with_repair_maintenance_costs_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual Cost - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual Cost'),
        ],
        '#default_value' => $config['result_with_repair_maintenance_costs_label'],
      ];

      // Repair & Maintenance Costs Section fields
      $form['with']['bflex_reprocessing_costs']['result_with_reprocessing_costs_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Section Heading'),
        '#attributes' => [
          'placeholder' => $this->t('Reprocessing costs per use'),
        ],
        '#default_value' => $config['result_with_reprocessing_costs_heading'],
      ];
      $form['with']['bflex_reprocessing_costs']['result_with_reprocessing_cost_left_column_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Reprocessing costs - column header'),
        '#attributes' => [
          'placeholder' => $this->t('Reprocessing costs'),
        ],
        '#default_value' => $config['result_with_reprocessing_cost_left_column_heading'],
      ];
      $form['with']['bflex_reprocessing_costs']['result_with_reprocessing_cost_right_column_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Average - column header'),
        '#attributes' => [
          'placeholder' => $this->t('Average'),
        ],
        '#default_value' => $config['result_with_reprocessing_cost_right_column_heading'],
      ];
      $form['with']['bflex_reprocessing_costs']['result_with_ppe_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('PPE for personnel - Label'),
        '#attributes' => [
          'placeholder' => $this->t('PPE for personnel'),
        ],
        '#default_value' => $config['result_with_ppe_label'],
      ];
      $form['with']['bflex_reprocessing_costs']['result_with_bedside_precleaning_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Bedside precleaning - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Bedside precleaning'),
        ],
        '#default_value' => $config['result_with_bedside_precleaning_label'],
      ];
      $form['with']['bflex_reprocessing_costs']['result_with_leak_testing_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Leak testing - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Leak testing'),
        ],
        '#default_value' => $config['result_with_leak_testing_label'],
      ];
      $form['with']['bflex_reprocessing_costs']['result_with_manual_cleaning_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Manual Cleaning - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Manual cleaning'),
        ],
        '#default_value' => $config['result_with_manual_cleaning_label'],
      ];
      $form['with']['bflex_reprocessing_costs']['result_with_visual_inspection_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Visual Inspection - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Visual Inspection'),
        ],
        '#default_value' => $config['result_with_visual_inspection_label'],
      ];
      $form['with']['bflex_reprocessing_costs']['result_with_hld_in_aer_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('HLD in an AER - Label'),
        '#attributes' => [
          'placeholder' => $this->t('HLD in an AER'),
        ],
        '#default_value' => $config['result_with_hld_in_aer_label'],
      ];
      $form['with']['bflex_reprocessing_costs']['result_with_dying_storage_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Dying and Storage - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Dying and Storage'),
        ],
        '#default_value' => $config['result_with_dying_storage_label'],
      ];
      $form['with']['bflex_reprocessing_costs']['result_with_reprocessing_costs_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual Cost - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual Cost'),
        ],
        '#default_value' => $config['result_with_reprocessing_costs_label'],
      ];

      // Preventable Infections Section Fields.
      $form['with']['bflex_preventable_infections']['result_with_preventable_infections_heading'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Section Heading - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Preventable Infections'),
        ],
        '#default_value' => $config['result_with_preventable_infections_heading'],
      ];
      $form['with']['bflex_preventable_infections']['result_with_preventable_infections_patient_infections_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Patient infections due to cross contamination - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Patient infections due to cross contamination'),
        ],
        '#default_value' => $config['result_with_preventable_infections_patient_infections_label'],
      ];
      $form['with']['bflex_preventable_infections']['result_with_cost_per_infection_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Cost per infection - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Cost per infection'),
        ],
        '#default_value' => $config['result_with_cost_per_infection_label'],
      ];
      $form['with']['bflex_preventable_infections']['result_with_preventable_infections_costs_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Annual Cost - Label'),
        '#attributes' => [
          'placeholder' => $this->t('Annual Cost'),
        ],
        '#default_value' => $config['result_with_preventable_infections_costs_label'],
      ];

      return parent::buildForm($form, $form_state);
    } catch (\Exception $e) {
      die($e->getMessage());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    try {

      \Drupal::service('config.factory')->getEditable('verathon_bflex_calculator.settings')

        // Saving Fields.
        ->set('result_page_heading', $form_state->getValue('result_page_heading'))
        ->set('result_page_description', $form_state->getValue('result_page_description'))
        ->set('result_page_footer', $form_state->getValue('result_page_footer'))
        ->set('result_current_main_heading', $form_state->getValue('result_current_main_heading'))
        ->set('result_current_sub_heading', $form_state->getValue('result_current_sub_heading'))
        ->set('result_current_grand_total_label', $form_state->getValue('result_current_grand_total_label'))
        ->set('result_current_bronchoscope_heading', $form_state->getValue('result_current_bronchoscope_heading'))
        ->set('result_current_single_usage_count_label', $form_state->getValue('result_current_single_usage_count_label'))
        ->set('result_current_bronchoscope_cost_label', $form_state->getValue('result_current_bronchoscope_cost_label'))
        ->set('result_current_repair_maintenance_heading', $form_state->getValue('result_current_repair_maintenance_heading'))
        ->set('result_current_reusable_bronchoscope_usage_label', $form_state->getValue('result_current_reusable_bronchoscope_usage_label'))
        ->set('result_current_annual_cost_of_service_label', $form_state->getValue('result_current_annual_cost_of_service_label'))
        ->set('result_current_annual_oop_cost_of_service_label', $form_state->getValue('result_current_annual_oop_cost_of_service_label'))
        ->set('result_current_reprocessing_costs_heading', $form_state->getValue('result_current_reprocessing_costs_heading'))
        ->set('result_current_reprocessing_cost_left_column_heading', $form_state->getValue('result_current_reprocessing_cost_left_column_heading'))
        ->set('result_current_reprocessing_cost_right_column_heading', $form_state->getValue('result_current_reprocessing_cost_right_column_heading'))
        ->set('result_current_ppe_label', $form_state->getValue('result_current_ppe_label'))
        ->set('result_current_bedside_precleaning_label', $form_state->getValue('result_current_bedside_precleaning_label'))
        ->set('result_current_leak_testing_label', $form_state->getValue('result_current_leak_testing_label'))
        ->set('result_current_manual_cleaning_label', $form_state->getValue('result_current_manual_cleaning_label'))
        ->set('result_current_visual_inspection_label', $form_state->getValue('result_current_visual_inspection_label'))
        ->set('result_current_hld_in_aer_label', $form_state->getValue('result_current_hld_in_aer_label'))
        ->set('result_current_dying_storage_label', $form_state->getValue('result_current_dying_storage_label'))
        ->set('result_current_reprocessing_costs_label', $form_state->getValue('result_current_reprocessing_costs_label'))
        ->set('result_current_preventable_infections_heading', $form_state->getValue('result_current_preventable_infections_heading'))
        ->set('result_current_preventable_infections_patient_infections_label', $form_state->getValue('result_current_preventable_infections_patient_infections_label'))
        ->set('result_current_cost_per_infection_label', $form_state->getValue('result_current_cost_per_infection_label'))
        ->set('result_current_preventable_infections_costs_label', $form_state->getValue('result_current_preventable_infections_costs_label'))
        ->set('result_current_repair_maintenance_costs_label', $form_state->getValue('result_current_repair_maintenance_costs_label'))

        // With fields
        ->set('result_with_main_heading', $form_state->getValue('result_with_main_heading'))
        ->set('result_with_sub_heading', $form_state->getValue('result_with_sub_heading'))
        ->set('result_with_grand_total_label', $form_state->getValue('result_with_grand_total_label'))
        ->set('result_with_bronchoscope_heading', $form_state->getValue('result_with_bronchoscope_heading'))
        ->set('result_with_single_usage_count_label', $form_state->getValue('result_with_single_usage_count_label'))
        ->set('result_with_bronchoscope_cost_label', $form_state->getValue('result_with_bronchoscope_cost_label'))
        ->set('result_with_repair_maintenance_heading', $form_state->getValue('result_with_repair_maintenance_heading'))
        ->set('result_with_reusable_bronchoscope_usage_label', $form_state->getValue('result_with_reusable_bronchoscope_usage_label'))
        ->set('result_with_annual_cost_of_service_label', $form_state->getValue('result_with_annual_cost_of_service_label'))
        ->set('result_with_annual_oop_cost_of_service_label', $form_state->getValue('result_with_annual_oop_cost_of_service_label'))
        ->set('result_with_reprocessing_costs_heading', $form_state->getValue('result_with_reprocessing_costs_heading'))
        ->set('result_with_reprocessing_cost_left_column_heading', $form_state->getValue('result_with_reprocessing_cost_left_column_heading'))
        ->set('result_with_reprocessing_cost_right_column_heading', $form_state->getValue('result_with_reprocessing_cost_right_column_heading'))
        ->set('result_with_ppe_label', $form_state->getValue('result_with_ppe_label'))
        ->set('result_with_bedside_precleaning_label', $form_state->getValue('result_with_bedside_precleaning_label'))
        ->set('result_with_leak_testing_label', $form_state->getValue('result_with_leak_testing_label'))
        ->set('result_with_manual_cleaning_label', $form_state->getValue('result_with_manual_cleaning_label'))
        ->set('result_with_visual_inspection_label', $form_state->getValue('result_with_visual_inspection_label'))
        ->set('result_with_hld_in_aer_label', $form_state->getValue('result_with_hld_in_aer_label'))
        ->set('result_with_dying_storage_label', $form_state->getValue('result_with_dying_storage_label'))
        ->set('result_with_reprocessing_costs_label', $form_state->getValue('result_with_reprocessing_costs_label'))
        ->set('result_with_preventable_infections_heading', $form_state->getValue('result_with_preventable_infections_heading'))
        ->set('result_with_preventable_infections_patient_infections_label', $form_state->getValue('result_with_preventable_infections_patient_infections_label'))
        ->set('result_with_cost_per_infection_label', $form_state->getValue('result_with_cost_per_infection_label'))
        ->set('result_with_preventable_infections_costs_label', $form_state->getValue('result_with_preventable_infections_costs_label'))
        ->set('result_with_main_heading', $form_state->getValue('result_with_main_heading'))
        ->set('result_with_sub_heading', $form_state->getValue('result_with_sub_heading'))
        ->set('result_with_repair_maintenance_costs_label', $form_state->getValue('result_with_repair_maintenance_costs_label'))
        ->set('result_with_grand_total_label', $form_state->getValue('result_with_grand_total_label'))
        ->set('scroll_text', $form_state->getValue('scroll_text'))
        ->set('download_button_text', $form_state->getValue('download_button_text'))

        ->save();
      parent::submitForm($form, $form_state);
    } catch (\Exception $e) {
      echo ($e->getMessage());
      die;
    }
  }
}
