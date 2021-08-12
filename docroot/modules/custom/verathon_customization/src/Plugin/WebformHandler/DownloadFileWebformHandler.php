<?php

namespace Drupal\verathon_customization\Plugin\WebformHandler;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Create a PDF file link.
 *
 * @WebformHandler(
 *   id = "pdf_file",
 *   label = @Translation("PDF file download link"),
 *   category = @Translation("External"),
 *   description = @Translation("Allows Webform settings to be overridden based on submission data."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_OPTIONAL,
 *   tokens = TRUE,
 * )
 */
class DownloadFileWebformHandler extends WebformHandlerBase {

  /**
   * The HTTP client to fetch the feed data with.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Contains the configuration object factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The database object.
   *
   * @var object
   */
  protected $database;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->httpClient = $container->get('http_client');
    $instance->configFactory = $container->get('config.factory');
    $instance->database = $container->get('database');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {
    $form_state->setRedirect('verathon_customization.thank_you');
    return;
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE) {
    global $base_url;

    try {
      // Getting config from the form settings for URL.
      $config = $this->configFactory->get('verathon_bflex_calculator.settings')->get();
      // Get an array of the values from the submission.
      $values = $webform_submission->getData();
      $fileName = $values['file_name'];
      $query = $this->database->select('file_managed', 'f');
      $query->fields('f', ['uri']);
      $query->condition('filename', $fileName);
      $uri = $query->execute()->fetchField();
      $options = [
        'attributes' => [
          'target' => '_blank',
          'class' => ['download']
        ]
      ];
      $urlObject = Url::fromUri($uri, $options);
      // Forming the default URL for pardot form handler.
      $download_file_link = Link::fromTextAndUrl($fileName, $urlObject)->toString();
      $webform = $webform_submission->getWebform();
      $webform->setSetting('confirmation_message', t('Here is your file: @title', ['@title' => $download_file_link]));
      // Forming the default URL for pardot form handler.
      // $url = !empty($config['bflex_pardot_url']) ? $config['bflex_pardot_url'] : 'http://www2.verathon.com/l/708283/2021-07-02/297dgm';
      // // HTTP post call to submit data to pardot endpoint.
      // $response = $instance->httpClient->post($url, [
      //   'verify' => true,
      //   'form_params' => $values,
      //   'headers' => [
      //     'Content-type' => 'application/x-www-form-urlencoded',
      //   ],
      // ])->getBody()->getContents();
      // // Logging the information.
      // \Drupal::logger('verathon_customization_webform')->notice(print_r($response, 1));
    } catch (\Exception $e) {
      \Drupal::logger('verathon_customization_webform')->error($e->getMessage());
    }
  }
}
