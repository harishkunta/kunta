<?php

namespace Drupal\verathon_bflex_calculator\Plugin\WebformHandler;

use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\Plugin\WebformHandlerInterface;

/**
 * Create a new node entity from a webform submission.
 *
 * @WebformHandler(
 *   id = "bflex_calculator",
 *   label = @Translation("Bflex - Custom Handler"),
 *   category = @Translation("Verathon"),
 *   description = @Translation("This sends the webform data to a custom handler via a post http call."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */


class BflexWebformHandler extends WebformHandlerBase
{
  /**
   * {@inheritdoc}
   */

  // Function to be fired after submitting the Webform.
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE)
  {
    try {
      // Getting config from the form settings for URL.
      $config = \Drupal::service('config.factory')->getEditable('verathon_bflex_calculator.settings')->get();
      // Get an array of the values from the submission.
      $values = $webform_submission->getData();
      // Forming the default URL for pardot form handler.
      $url = !empty($config['bflex_pardot_url']) ? $config['bflex_pardot_url'] : 'http://www2.verathon.com/l/708283/2021-07-02/297dgm';
      // HTTP post call to submit data to pardot endpoint.
      $response = \Drupal::httpClient()->post($url, [
        'verify' => true,
        'form_params' => $values,
        'headers' => [
          'Content-type' => 'application/x-www-form-urlencoded',
        ],
      ])->getBody()->getContents();
      // Logging the information.
      \Drupal::logger('verathon_bflex_calculator')->notice(print_r($response, 1));
    } catch (\Exception $e) {
      \Drupal::logger('verathon_bflex_calculator')->error($e->getMessage());
    }
  }
}
