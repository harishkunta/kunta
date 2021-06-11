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
    // Global Form
    $form['global'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#collapsible' => TRUE,
      '#title' => $this->t('Global : Labels')
    ];
    $form['global']['result_section_copy'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result Section : Field Label'),
      '#default_value' => $config['result_section_copy'],
    ];
    $form['global']['result_button_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result Button : Label'),
      '#default_value' => $config['result_button_label'],
    ];
    // Step One Section Fields.
    $form['step_one'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#collapsible' => TRUE,
      '#title' => $this->t('Step 1 - Current bronchoscope usage : Labels'),
    ];
    $form['step_one']['step_one_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Step One - Section Heading'),
      '#default_value' => $config['step_one_heading'],
    ];
    $form['step_one']['step_one_description'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Step One - Section Description'),
      '#default_value' => $config['step_one_description']['value'],
    ];
    $form['step_one']['facility_name_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Facility name : Field Label'),
      '#default_value' => $config['facility_name_label'],
    ];
    $form['step_one']['total_annual_bronchoscopy_procedures_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Total Annual Bronchoscopy Procedures : Field Label'),
      '#default_value' => $config['total_annual_bronchoscopy_procedures_label'],
    ];
    $form['step_one']['total_annual_bronchoscopy_procedures_helptext'] = [
      '#type' => 'text_format',
      '#format' => 'filtered_html',
      '#allowed_formats' => array('filtered_html'),
      '#title' => $this->t('Total Annual Bronchoscopy Procedures : Help text'),
      '#default_value' => $config['total_annual_bronchoscopy_procedures_helptext']['value'],
    ];
    $form['step_one']['procedures_count_single_usage_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Procedures Count Single Usage : Field Label'),
      '#default_value' => $config['procedures_count_single_usage_label'],
    ];
    $form['step_one']['your_bronchoscope_price_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Bronchscope Price : Field Label'),
      '#default_value' => $config['your_bronchoscope_price_label'],
    ];
    $form['step_one']['your_bronchoscope_price_description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Bronchscope Price : Field Description'),
      '#default_value' => $config['your_bronchoscope_price_description'],
    ];
    $form['step_one']['your_bronchoscope_price_helptext'] = [
      '#type' => 'text_format',
      '#format' => 'filtered_html',
      '#allowed_formats' => array('filtered_html'),
      '#title' => $this->t('Bronchscope Price : Help text'),
      '#default_value' => $config['your_bronchoscope_price_helptext']['value'],
    ];

    $form['step_one']['step_one_result_string'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result String'),
      '#default_value' => $config['step_one_result_string'],
    ];

    // Step Two Section Fields.
    $form['step_two'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Step 2 - Repair and maintenance : Labels')
    ];
    $form['step_two']['step_two_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Step Two - Section Heading'),
      '#default_value' => $config['step_two_heading'],
    ];
    $form['step_two']['step_two_description'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Step Two - Section Description'),
      '#default_value' => $config['step_two_description']['value'],
    ];
    $form['step_two']['total_reusable_bronchoscopes_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Total Number of Reusable Bronchoscopes : Field Label'),
      '#default_value' => $config['total_reusable_bronchoscopes_label'],
    ];
    $form['step_two']['annual_service_cost_per_bronchoscope_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual cost of service agreement per bronchoscope : Field Label'),
      '#default_value' => $config['annual_service_cost_per_bronchoscope_label'],
    ];
    $form['step_two']['annual_out_of_pocket_repair_cost_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual out-of-pocket repair costs : Field Label'),
      '#default_value' => $config['annual_out_of_pocket_repair_cost_label'],
    ];
    $form['step_two']['annual_out_of_pocket_repair_cost_helptext'] = [
      '#type' => 'text_format',
      '#format' => 'filtered_html',
      '#allowed_formats' => array('filtered_html'),
      '#title' => $this->t('Annual out-of-pocket repair costs : Help text'),
      '#default_value' => $config['annual_out_of_pocket_repair_cost_helptext']['value'],
    ];
    $form['step_two']['step_two_result_string'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result String'),
      '#default_value' => $config['step_two_result_string'],
    ];
    // Step Three Section Fields.
    $form['step_three'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Step 3 - Hidden reprocessing costs : Labels'),
    ];
    $form['step_three']['step_three_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Step Three - Section Heading'),
      '#default_value' => $config['step_two_heading'],
    ];
    $form['step_three']['step_three_description'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Step Three - Section Description'),
      '#default_value' => $config['step_three_description']['value'],
    ];
    $form['step_three']['reprocessing_costs_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Reprocessing costs : Field Label'),
      '#default_value' => $config['reprocessing_costs_label'],
    ];
    $form['step_three']['reprocessing_range_low_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Range Low - Label'),
      '#default_value' => $config['reprocessing_range_low_label'],
    ];
    $form['step_three']['reprocessing_range_average_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Range Average - Label'),
      '#default_value' => $config['reprocessing_range_average_label'],
    ];
    $form['step_three']['reprocessing_range_high_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Range High - Label'),
      '#default_value' => $config['reprocessing_range_high_label'],
    ];
    $form['step_three']['step_three_result_string'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result String'),
      '#default_value' => $config['step_three_result_string'],
    ];

    // Step Three Section Fields.
    $form['step_four'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Step 4 - Preventable infections : Labels'),
    ];
    $form['step_four']['step_four_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Step Four - Section Heading'),
      '#default_value' => $config['step_four_heading'],
    ];
    $form['step_four']['step_four_description'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Step Four - Section Description'),
      '#default_value' => $config['step_four_description']['value'],
    ];
    $form['step_four']['step_four_result_string'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result String'),
      '#default_value' => $config['step_four_result_string'],
    ];
    $form['step_four']['step_four_final_cost_string'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Estimated annual treatment cost Label'),
      '#default_value' => $config['step_four_final_cost_string'],
    ];

    return parent::buildForm($form, $form_state);
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    try {
      $this->config('verathon_bflex_calculator.settings')
        ->set("result_section_copy", $form_state->getValue("result_section_copy"))
        ->set("result_button_label", $form_state->getValue("result_button_label"))
        ->set("facility_name_label", $form_state->getValue("facility_name_label"))
        ->set("total_annual_bronchoscopy_procedures_label", $form_state->getValue("total_annual_bronchoscopy_procedures_label"))
        ->set("total_annual_bronchoscopy_procedures_helptext", $form_state->getValue("total_annual_bronchoscopy_procedures_helptext"))
        ->set("procedures_count_single_usage_label", $form_state->getValue("procedures_count_single_usage_label"))
        ->set("your_bronchoscope_price_label", $form_state->getValue("your_bronchoscope_price_label"))
        ->set("your_bronchoscope_price_description", $form_state->getValue("your_bronchoscope_price_description"))
        ->set("your_bronchoscope_price_helptext", $form_state->getValue("your_bronchoscope_price_helptext"))
        ->set("step_one_result_string", $form_state->getValue("step_one_result_string"))
        ->set("total_reusable_bronchoscopes_label", $form_state->getValue("total_reusable_bronchoscopes_label"))
        ->set("annual_service_cost_per_bronchoscope_label", $form_state->getValue("annual_service_cost_per_bronchoscope_label"))
        ->set("annual_out_of_pocket_repair_cost_label", $form_state->getValue("annual_out_of_pocket_repair_cost_label"))
        ->set("annual_out_of_pocket_repair_cost_helptext", $form_state->getValue("annual_out_of_pocket_repair_cost_helptext"))
        ->set("step_two_result_string", $form_state->getValue("step_two_result_string"))
        ->set("reprocessing_costs_label", $form_state->getValue("reprocessing_costs_label"))
        ->set("reprocessing_range_low_label", $form_state->getValue("reprocessing_range_low_label"))
        ->set("reprocessing_range_average_label", $form_state->getValue("reprocessing_range_average_label"))
        ->set("reprocessing_range_high_label", $form_state->getValue("reprocessing_range_high_label"))
        ->set("step_three_result_string", $form_state->getValue("step_three_result_string"))
        ->set("step_four_result_string", $form_state->getValue("step_four_result_string"))
        ->set("step_four_final_cost_string", $form_state->getValue("step_four_final_cost_string"))

        ->set("step_one_heading", $form_state->getValue("step_one_heading"))
        ->set("step_two_heading", $form_state->getValue("step_two_heading"))
        ->set("step_three_heading", $form_state->getValue("step_three_heading"))
        ->set("step_four_heading", $form_state->getValue("step_four_heading"))
        ->set("step_one_description", $form_state->getValue("step_one_description"))
        ->set("step_two_description", $form_state->getValue("step_two_description"))
        ->set("step_three_description", $form_state->getValue("step_three_description"))
        ->set("step_four_description", $form_state->getValue("step_four_description"))
        ->save();
      parent::submitForm($form, $form_state);
    } catch (\Exception $e) {
      \Drupal::messagener()->error($e->getMessage());
    }
  }
}
