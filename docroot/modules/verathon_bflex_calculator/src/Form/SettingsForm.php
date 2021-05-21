<?php

namespace Drupal\verathon_bflex_calculator\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Verathon Bflex Calculator settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'verathon_bflex_calculator_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['verathon_bflex_calculator.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Setting up various sections on the configurable values.
    $form['common'] = [
      '#title' => $this->t('Global Parameters'),
      '#type' => 'container',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
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
      '#default_value' => $form_state->getValue('reprocessing_factor_low'),
    ];
    $form['reprocessing_cost']['reprocessing_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#default_value' => $form_state->getValue('reprocessing_factor_average'),
      '#description' => $this->t("Factor's AVERAGE value."),
    ];
    $form['reprocessing_cost']['reprocessing_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => $form_state->getValue('reprocessing_factor_high'),
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
      '#default_value' => $form_state->getValue('bedside_preclean_factor_low'),
    ];
    $form['bedside_preclean']['bedside_preclean_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#default_value' => $form_state->getValue('bedside_preclean_factor_average'),
      '#description' => $this->t("Factor's AVERAGE value."),
    ];
    $form['bedside_preclean']['bedside_preclean_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => $form_state->getValue('rbedside_preclean_factor_high'),
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
        '#default_value' => $form_state->getValue('manual_cleaning_factor_low'),
      ];
    $form['manual_cleaning']['manual_cleaning_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#default_value' => $form_state->getValue('manual_cleaning_factor_average'),
      '#description' => $this->t("Factor's AVERAGE value."),
    ];
    $form['manual_cleaning']['manual_cleaning_factor_high'] = [
        '#type' => 'textfield',
        '#title' => $this->t('High value'),
        '#description' => $this->t("Factor's HIGH value."),
        '#default_value' => $form_state->getValue('manual_cleaning_factor_high'),
      ];

    // Visual Inspection Factor
    $form['visual_inspection'] = [
      '#title' => $this->t('Manual Cleaning Factor'),
      '#type' => 'fieldset',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    ];
    $form['visual_inspection']['visual_inspection_factor_low'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Low value'),
        '#description' => $this->t("Factor's LOW value."),
        '#default_value' => $form_state->getValue('visual_inspection_factor_low'),
      ];
    $form['visual_inspection']['visual_inspection_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#default_value' => $form_state->getValue('visual_inspection_factor_average'),
      '#description' => $this->t("Factor's AVERAGE value."),
    ];
    $form['visual_inspection']['visual_inspection_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => $form_state->getValue('visual_inspection_factor_high'),
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
      '#default_value' => $form_state->getValue('hld_in_aer_factor_low'),
    ];
    $form['hld_in_aer']['hld_in_aer_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#default_value' => $form_state->getValue('hld_in_aer_factor_average'),
      '#description' => $this->t("Factor's AVERAGE value."),
    ];
    $form['hld_in_aer']['hld_in_aer_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => $form_state->getValue('hld_in_aer_factor_high'),
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
      '#default_value' => $form_state->getValue('dying_storage_factor_low'),
    ];
    $form['dying_storage']['dying_storage_factor_average'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Average value'),
      '#default_value' => $form_state->getValue('dying_storage_factor_average'),
      '#description' => $this->t("Factor's AVERAGE value."),
    ];
    $form['dying_storage']['dying_storage_factor_high'] = [
      '#type' => 'textfield',
      '#title' => $this->t('High value'),
      '#description' => $this->t("Factor's HIGH value."),
      '#default_value' => $form_state->getValue('dying_storage_factor_high'),
    ];


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('example') != 'example') {
      $form_state->setErrorByName('example', $this->t('The value is not correct.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('verathon_bflex_calculator.settings')
      ->set('example', $form_state->getValue('example'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
