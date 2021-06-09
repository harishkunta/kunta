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
    $values = $form_state->getValues();
    // Setting up various sections on the configurable values.
    $form['common'] = [
      '#title' => $this->t('Global Parameters'),
      '#type' => 'container',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    ];
    $form['common']['current_su_blex_usage'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Current SU Blex Usage'),
      '#description' => $this->t("Current SU Blex Usage"),
      '#default_value' => !empty($values['current_su_blex_usage']) ? $values['current_su_blex_usage'] : $config['current_su_blex_usage'],
    ];
    $form['common']['cross_contamination_factor_a'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cross Contamination Factor : A'),
      '#description' => $this->t("Cross Contamination Factor : A"),
      '#default_value' => !empty($values['cross_contamination_factor_a']) ? $values['cross_contamination_factor_a'] : $config['cross_contamination_factor_a'],
    ];
    $form['common']['cross_contamination_factor_b'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cross Contamination Factor : B'),
      '#description' => $this->t("Cross Contamination Factor : B"),
      '#default_value' => !empty($values['cross_contamination_factor_b']) ? $values['cross_contamination_factor_b'] : $config['cross_contamination_factor_b'],

    ];
    $form['common']['cost_per_infection'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cost Per Infection'),
      '#description' => $this->t("Cost per infection"),
      '#default_value' => !empty($values['cost_per_infection']) ? $values['cost_per_infection'] : $config['cost_per_infection'],

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
      '#default_value' => !empty($values['reprocessing_factor_low']) ? $values['reprocessing_factor_low'] : $config['reprocessing_factor_low'],

    ];
    $form['reprocessing_cost']['reprocessing_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => !empty($values['reprocessing_factor_average']) ? $values['reprocessing_factor_average'] : $config['reprocessing_factor_average'],

    ];
    $form['reprocessing_cost']['reprocessing_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => !empty($values['reprocessing_factor_high']) ? $values['reprocessing_factor_high'] : $config['reprocessing_factor_high'],
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
      '#default_value' => !empty($values['bedside_preclean_factor_low']) ? $values['bedside_preclean_factor_low'] : $config['bedside_preclean_factor_low'],

    ];
    $form['bedside_preclean']['bedside_preclean_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => !empty($values['bedside_preclean_factor_average']) ? $values['bedside_preclean_factor_average'] : $config['bedside_preclean_factor_average'],

    ];
    $form['bedside_preclean']['bedside_preclean_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => !empty($values['bedside_preclean_factor_high']) ? $values['bedside_preclean_factor_high'] : $config['bedside_preclean_factor_high'],

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
      '#default_value' => !empty($values['manual_cleaning_factor_low']) ? $values['manual_cleaning_factor_low'] : $config['manual_cleaning_factor_low'],

    ];
    $form['manual_cleaning']['manual_cleaning_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => !empty($values['manual_cleaning_factor_average']) ? $values['manual_cleaning_factor_average'] : $config['manual_cleaning_factor_average'],

    ];
    $form['manual_cleaning']['manual_cleaning_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => !empty($values['manual_cleaning_factor_high']) ? $values['manual_cleaning_factor_high'] : $config['manual_cleaning_factor_high'],

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
      '#default_value' => !empty($values['visual_inspection_factor_low']) ? $values['visual_inspection_factor_low'] : $config['visual_inspection_factor_low'],

    ];
    $form['visual_inspection']['visual_inspection_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => !empty($values['visual_inspection_factor_average']) ? $values['visual_inspection_factor_average'] : $config['visual_inspection_factor_average'],

    ];
    $form['visual_inspection']['visual_inspection_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => !empty($values['visual_inspection_factor_high']) ? $values['visual_inspection_factor_high'] : $config['visual_inspection_factor_high'],

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
      '#default_value' => !empty($values['hld_in_aer_factor_low']) ? $values['hld_in_aer_factor_low'] : $config['hld_in_aer_factor_low'],

    ];
    $form['hld_in_aer']['hld_in_aer_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => !empty($values['hld_in_aer_factor_average']) ? $values['hld_in_aer_factor_average'] : $config['hld_in_aer_factor_average'],

    ];
    $form['hld_in_aer']['hld_in_aer_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => !empty($values['hld_in_aer_factor_high']) ? $values['hld_in_aer_factor_high'] : $config['hld_in_aer_factor_high'],

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
      '#default_value' => !empty($values['dying_storage_factor_low']) ? $values['dying_storage_factor_low'] : $config['dying_storage_factor_low'],

    ];
    $form['dying_storage']['dying_storage_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#description' => $this->t("Factor's AVERAGE value."),
      '#default_value' => !empty($values['dying_storage_factor_average']) ? $values['dying_storage_factor_average'] : $config['dying_storage_factor_average'],

    ];
    $form['dying_storage']['dying_storage_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => !empty($values['dying_storage_factor_high']) ? $values['dying_storage_factor_high'] : $config['dying_storage_factor_high'],
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
