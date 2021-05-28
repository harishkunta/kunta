<?php

namespace Drupal\verathon_bflex_calculator\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Verathon Bflex Calculator settings for this site.
 */
class BflexCalculatorContentForm extends ConfigFormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'verathon_bflex_calculator_bflex_calculator_content';
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

    // Step One Section Fields.
    $form['step_one'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#collapsible' => TRUE,
      '#title' => $this->t('Step 1 - Current bronchoscope usage : Labels'),
    ];
    $form['step_one']['facility_name_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Facility name : Field Label'),
      '#default_value' => !empty($values['facility_name_label']) ? $values['facility_name_label'] : $config['facility_name_label'],
    ];
    $form['step_one']['total_annual_bronchoscopy_procedures_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Total Annual Bronchoscopy Procedures : Field Label'),
      '#default_value' => !empty($values['total_annual_bronchoscopy_procedures_label']) ? $values['total_annual_bronchoscopy_procedures_label'] : $config['total_annual_bronchoscopy_procedures_label'],
    ];
    $form['step_one']['total_annual_bronchoscopy_procedures_helptext'] = [
      '#type' => 'text_format',
      '#format' => 'filtered_html',
      '#allowed_formats' => array('filtered_html'),
      '#title' => $this->t('Total Annual Bronchoscopy Procedures : Help text'),
      '#default_value' => !empty($values['total_annual_bronchoscopy_procedures_helptext']) ? $values['total_annual_bronchoscopy_procedures_helptext'] : $config['total_annual_bronchoscopy_procedures_helptext'],
    ];
    $form['step_one']['procedures_count_single_usage_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Procedures Count Single Usage : Field Label'),
      '#default_value' => !empty($values['procedures_count_single_usage_label']) ? $values['procedures_count_single_usage_label'] : $config['procedures_count_single_usage_label'],
    ];
    $form['step_one']['your_bronchoscope_price_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Bronchscope Price : Field Label'),
      '#default_value' => !empty($values['your_bronchoscope_price_label']) ? $values['your_bronchoscope_price_label'] : $config['your_bronchoscope_price_label'],
    ];
    $form['step_one']['your_bronchoscope_price_description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Bronchscope Price : Field Description'),
      '#default_value' => !empty($values['your_bronchoscope_price_description']) ? $values['your_bronchoscope_price_description'] : $config['your_bronchoscope_price_description'],
    ];
    $form['step_one']['your_bronchoscope_price_helptext'] = [
      '#type' => 'text_format',
      '#format' => 'filtered_html',
      '#allowed_formats' => array('filtered_html'),
      '#title' => $this->t('Bronchscope Price : Help text'),
      '#default_value' => !empty($values['your_bronchoscope_price_helptext']) ? $values['your_bronchoscope_price_helptext'] : $config['your_bronchoscope_price_helptext'],
    ];

    $form['step_one']['step_one_result_string'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result String'),
      '#default_value' => !empty($values['step_one_result_string']) ? $values['step_one_result_string'] : $config['step_one_result_string'],
    ];

    // Step Two Section Fields.
    $form['step_two'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Step 2 - Repair and maintenance : Labels'),
    ];
    $form['step_two']['total_reusable_bronchoscopes_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Total Number of Reusable Bronchoscopes : Field Label'),
      '#default_value' => !empty($values['total_reusable_bronchoscopes_label']) ? $values['total_reusable_bronchoscopes_label'] : $config['total_reusable_bronchoscopes_label'],
    ];
    $form['step_two']['annual_service_cost_per_bronchoscope_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual cost of service agreement per bronchoscope : Field Label'),
      '#default_value' => !empty($values['annual_service_cost_per_bronchoscope_label']) ? $values['annual_service_cost_per_bronchoscope_label'] : $config['annual_service_cost_per_bronchoscope_label'],
    ];
    $form['step_two']['annual_out_of_pocket_repair_cost_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual out-of-pocket repair costs : Field Label'),
      '#default_value' => !empty($values['annual_out_of_pocket_repair_cost_label']) ? $values['annual_out_of_pocket_repair_cost_label'] : $config['annual_out_of_pocket_repair_cost_label'],
    ];
    $form['step_two']['annual_out_of_pocket_repair_cost_helptext'] = [
      '#type' => 'text_format',
      '#format' => 'filtered_html',
      '#allowed_formats' => array('filtered_html'),
      '#title' => $this->t('Annual out-of-pocket repair costs : Help text'),
      '#default_value' => !empty($values['annual_out_of_pocket_repair_cost_helptext']) ? $values['annual_out_of_pocket_repair_cost_helptext'] : $config['annual_out_of_pocket_repair_cost_helptext'],
    ];
    $form['step_two']['step_two_result_string'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result String'),
      '#default_value' => !empty($values['step_two_result_string']) ? $values['step_two_result_string'] : $config['step_two_result_string'],
    ];
    // Step Three Section Fields.
    $form['step_three'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Step 3 - Hidden reprocessing costs : Labels'),
    ];
    $form['step_three']['reprocessing_costs_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Reprocessing costs : Field Label'),
      '#default_value' => !empty($values['reprocessing_costs_label']) ? $values['reprocessing_costs_label'] : $config['reprocessing_costs_label'],
    ];
    $form['step_three']['reprocessing_range_low_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Range Low - Label'),
      '#default_value' => !empty($values['reprocessing_range_low_label']) ? $values['reprocessing_range_low_label'] : $config['reprocessing_range_low_label'],
    ];
    $form['step_three']['reprocessing_range_average_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Range Average - Label'),
      '#default_value' => !empty($values['reprocessing_range_average_label']) ? $values['reprocessing_range_average_label'] : $config['reprocessing_range_average_label'],
    ];
    $form['step_three']['reprocessing_range_high_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Range High - Label'),
      '#default_value' => !empty($values['reprocessing_range_high_label']) ? $values['reprocessing_range_high_label'] : $config['reprocessing_range_high_label'],
    ];
    $form['step_three']['step_three_result_string'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result String'),
      '#default_value' => !empty($values['step_three_result_string']) ? $values['step_three_result_string'] : $config['step_three_result_string'],
    ];

    // Step Three Section Fields.
    $form['step_four'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Step 4 - Preventable infections : Labels'),
    ];
    $form['step_four']['step_four_result_string'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result String'),
      '#default_value' => !empty($values['step_four_result_string']) ? $values['step_four_result_string'] : $config['step_four_result_string'],
    ];
    $form['step_four']['step_four_final_cost_string'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Estimated annual treatment cost Label'),
      '#default_value' => !empty($values['step_four_final_cost_string']) ? $values['step_four_final_cost_string'] : $config['step_four_final_cost_string'],
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
