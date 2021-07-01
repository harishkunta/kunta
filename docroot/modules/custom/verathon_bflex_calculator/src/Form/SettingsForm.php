<?php

namespace Drupal\verathon_bflex_calculator\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Verathon Bflex Calculator settings for this site.
 */
class SettingsForm extends ConfigFormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'verathon_bflex_calculator_settings';
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
    // Setting up various sections on the configurable values.
    $form['common'] = [
      '#title' => $this->t('Global Parameters'),
      '#type' => 'container',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    ];
    $form['common']['default_bronchoscope_price'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Default Bronchoscope Price'),
      '#description' => $this->t("This price will be used for calculation if nothing is provided."),
      '#default_value' => $config['default_bronchoscope_price'],
      '#required' => TRUE,
    ];
    $form['common']['annual_oop_repair_factor_low'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual OOP Repair Price Factor : LOW'),
      '#description' => $this->t("Calculation Factor"),
      '#default_value' => $config['annual_oop_repair_factor_low'],
      '#required' => TRUE,
    ];
    $form['common']['annual_oop_repair_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual OOP Repair Price Factor : AVERAGE'),
      '#description' => $this->t("Calculation Factor"),
      '#default_value' => $config['annual_oop_repair_factor_average'],
      '#required' => TRUE,
    ];
    $form['common']['annual_oop_repair_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Annual OOP Repair Price Factor : HIGH'),
      '#description' => $this->t("Calculation Factor"),
      '#default_value' => $config['annual_oop_repair_factor_high'],
      '#required' => TRUE,
    ];

    $form['common']['current_su_blex_usage'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Current SU Blex Usage'),
      '#description' => $this->t("Current SU Blex Usage"),
      '#required' => TRUE,
      '#default_value' => $config['current_su_blex_usage'],
    ];
    $form['common']['cross_contamination_factor_a'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cross Contamination Factor : A'),
      '#description' => $this->t("Cross Contamination Factor : A"),
      '#required' => TRUE,
      '#default_value' => $config['cross_contamination_factor_a'],
    ];
    $form['common']['cross_contamination_factor_b'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cross Contamination Factor : B'),
      '#description' => $this->t("Cross Contamination Factor : B"),
      '#default_value' => $config['cross_contamination_factor_b'],

    ];
    $form['common']['cost_per_infection'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cost Per Infection'),
      '#description' => $this->t("Cost per infection"),
      '#default_value' => $config['cost_per_infection'],

    ];
    $form['cloud_convert'] = [
      '#title' => $this->t('CloudConvert API'),
      '#type' => 'fieldset',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    ];
    $form['cloud_convert']['cc_api_key'] = [
      '#title' => $this->t('CloudConvert API KEY'),
      '#description' => $this->t('The PDF generation will be done via CloudConvert API.'),
      '#required' => TRUE,
      '#default_value' => $config['cc_api_key'],
    ];
    // Reprocessing Factors.
    $form['reprocessing_cost'] = [
      '#title' => $this->t('Reprocessing Cost'),
      '#type' => 'fieldset',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    ];
    $form['reprocessing_cost']['reprocessing_factor_low'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Low value'),
      '#description' => $this->t("Factor's LOW value."),
      '#default_value' => $config['reprocessing_factor_low'],

    ];
    $form['reprocessing_cost']['reprocessing_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => $config['reprocessing_factor_average'],

    ];
    $form['reprocessing_cost']['reprocessing_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => $config['reprocessing_factor_high'],
    ];

    // Bedside Preclean Factors
    $form['bedside_preclean'] = [
      '#title' => $this->t('Bedside Preclean'),
      '#type' => 'fieldset',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    ];
    $form['bedside_preclean']['bedside_preclean_factor_low'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Low value'),
      '#description' => $this->t("Factor's LOW value."),
      '#default_value' => $config['bedside_preclean_factor_low'],

    ];
    $form['bedside_preclean']['bedside_preclean_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => $config['bedside_preclean_factor_average'],

    ];
    $form['bedside_preclean']['bedside_preclean_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => $config['bedside_preclean_factor_high'],

    ];

    // Manual Cleaning
    $form['manual_cleaning'] = [
      '#title' => $this->t('Manual Cleaning Factor'),
      '#type' => 'fieldset',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    ];
    $form['manual_cleaning']['manual_cleaning_factor_low'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Low value'),
      '#description' => $this->t("Factor's LOW value."),
      '#default_value' => $config['manual_cleaning_factor_low'],

    ];
    $form['manual_cleaning']['manual_cleaning_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => $config['manual_cleaning_factor_average'],

    ];
    $form['manual_cleaning']['manual_cleaning_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => $config['manual_cleaning_factor_high'],

    ];

    // Visual Inspection Factor
    $form['visual_inspection'] = [
      '#title' => $this->t('Visual Inspection Factor'),
      '#type' => 'fieldset',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    ];
    $form['visual_inspection']['visual_inspection_factor_low'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Low value'),
      '#description' => $this->t("Factor's LOW value."),
      '#default_value' => $config['visual_inspection_factor_low'],

    ];
    $form['visual_inspection']['visual_inspection_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => $config['visual_inspection_factor_average'],

    ];
    $form['visual_inspection']['visual_inspection_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => $config['visual_inspection_factor_high'],

    ];

    // HLD IN AER Factor
    $form['hld_in_aer'] = [
      '#title' => $this->t('HLD in AER Factor'),
      '#type' => 'fieldset',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    ];
    $form['hld_in_aer']['hld_in_aer_factor_low'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Low value'),
      '#description' => $this->t("Factor's LOW value."),
      '#default_value' => $config['hld_in_aer_factor_low'],

    ];
    $form['hld_in_aer']['hld_in_aer_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => $config['hld_in_aer_factor_average'],

    ];
    $form['hld_in_aer']['hld_in_aer_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => $config['hld_in_aer_factor_high'],

    ];

    // Dying Storage Factor
    $form['dying_storage'] = [
      '#title' => $this->t('Dying Storage Factor'),
      '#type' => 'fieldset',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    ];
    $form['dying_storage']['dying_storage_factor_low'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Low value'),
      '#description' => $this->t("Factor's LOW value."),
      '#default_value' => $config['dying_storage_factor_low'],

    ];
    $form['dying_storage']['dying_storage_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => $config['dying_storage_factor_average'],

    ];
    $form['dying_storage']['dying_storage_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => $config['dying_storage_factor_high'],
    ];



    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->config('verathon_bflex_calculator.settings')
      ->set('current_su_blex_usage', $form_state->getValue('current_su_blex_usage'))
      ->set('cross_contamination_factor_a', $form_state->getValue('cross_contamination_factor_a'))
      ->set('cross_contamination_factor_b', $form_state->getValue('cross_contamination_factor_b'))
      ->set('cost_per_infection', $form_state->getValue('cost_per_infection'))
      ->set('reprocessing_factor_low', $form_state->getValue('reprocessing_factor_low'))
      ->set('reprocessing_factor_average', $form_state->getValue('reprocessing_factor_average'))
      ->set('reprocessing_factor_high', $form_state->getValue('reprocessing_factor_high'))
      ->set('bedside_preclean', $form_state->getValue('bedside_preclean'))
      ->set('bedside_preclean_factor_low', $form_state->getValue('bedside_preclean_factor_low'))
      ->set('bedside_preclean_factor_average', $form_state->getValue('bedside_preclean_factor_average'))
      ->set('bedside_preclean_factor_high', $form_state->getValue('bedside_preclean_factor_high'))
      ->set('manual_cleaning_factor_low', $form_state->getValue('manual_cleaning_factor_low'))
      ->set('manual_cleaning_factor_average', $form_state->getValue('manual_cleaning_factor_average'))
      ->set('manual_cleaning_factor_high', $form_state->getValue('manual_cleaning_factor_high'))
      ->set('visual_inspection_factor_low', $form_state->getValue('visual_inspection_factor_low'))
      ->set('visual_inspection_factor_average', $form_state->getValue('visual_inspection_factor_average'))
      ->set('visual_inspection_factor_high', $form_state->getValue('visual_inspection_factor_high'))
      ->set('hld_in_aer_factor_low', $form_state->getValue('hld_in_aer_factor_low'))
      ->set('hld_in_aer_factor_average', $form_state->getValue('hld_in_aer_factor_average'))
      ->set('hld_in_aer_factor_high', $form_state->getValue('hld_in_aer_factor_high'))
      ->set('dying_storage_factor_low', $form_state->getValue('dying_storage_factor_low'))
      ->set('dying_storage_factor_average', $form_state->getValue('dying_storage_factor_average'))
      ->set('dying_storage_factor_high', $form_state->getValue('dying_storage_factor_high'))
      ->set('default_bronchoscope_price', $form_state->getValue('default_bronchoscope_price'))
      ->set('annual_oop_repair_factor_low', $form_state->getValue('annual_oop_repair_factor_low'))
      ->set('annual_oop_repair_factor_average', $form_state->getValue('annual_oop_repair_factor_average'))
      ->set('annual_oop_repair_factor_high', $form_state->getValue('annual_oop_repair_factor_high'))
      ->set('cc_api_key', $form_state->getValue('cc_api_key'))

      ->save();
    parent::submitForm($form, $form_state);
  }
}
