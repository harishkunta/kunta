<?php

namespace Drupal\verathon_bflex_calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Verathon Bflex Calculator form.
 */
class BronchoscopeUsageForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'verathon_bflex_calculator_bronchoscope_usage';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['facility_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Facility name'),
      '#required' => TRUE,
      '#placeholder' => $this->t('Enter Facility Name here')
    ];

    $form['total_annual_bronchoscopy_procedures'] = [
      '#type' => 'range',
      '#title' => $this->t('Total annual bronchoscopy procedures'),
      '#required' => TRUE,
      '#placeholder' => $this->t('Enter Facility Name here'),
    ];
    $form['procedures_count_single_usage'] = [
      '#type' => 'range',
      '#title' => $this->t('Number of procedures that could be performed with single-use bronchoscopes'),
      '#required' => TRUE,
      '#placeholder' => $this->t('Enter Facility Name here'),
    ];
    $form['total_annual_bronchoscopy_procedures'] = [
      '#type' => 'range',
      '#title' => $this->t('Total annual bronchoscopy procedures'),
      '#required' => TRUE,
      '#placeholder' => $this->t('Enter Facility Name here'),
    ];
    $form['your_bronchoscope_price'] = [
      '#type' => 'number',
      '#title' => $this->t('Your bronchoscope price'),
      '#required' => TRUE,
      '#placeholder' => $this->t('Enter Facility Name here'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (mb_strlen($form_state->getValue('message')) < 10) {
      $form_state->setErrorByName('name', $this->t('Message should be at least 10 characters.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('<front>');
  }

}
