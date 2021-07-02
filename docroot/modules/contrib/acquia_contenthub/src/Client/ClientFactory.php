<?php

namespace Drupal\acquia_contenthub\Client;

use Acquia\ContentHubClient\CDF\ClientCDFObject;
use Acquia\ContentHubClient\ContentHubClient;
use Acquia\ContentHubClient\Settings;
use Acquia\Hmac\Exception\KeyNotFoundException;
use Acquia\Hmac\KeyLoader;
use Acquia\Hmac\RequestAuthenticator;
use Drupal\acquia_contenthub\AcquiaContentHubEvents;
use Drupal\acquia_contenthub\Event\AcquiaContentHubSettingsEvent;
use Drupal\acquia_contenthub\Event\BuildClientCdfEvent;
use Drupal\Component\Uuid\Uuid;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\UploadedFileFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Instantiates an Acquia ContentHub Client object.
 *
 * @see \Acquia\ContentHubClient\ContentHub
 */
class ClientFactory {

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $dispatcher;

  /**
   * The contenthub client object.
   *
   * @var \Acquia\ContentHubClient\ContentHubClient
   */
  protected $client;

  /**
   * Settings Provider.
   *
   * @var string
   */
  protected $settingsProvider;

  /**
   * Settings object.
   *
   * @var \Acquia\ContentHubClient\Settings
   */
  protected $settings;

  /**
   * Logger Factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

  /**
   * Client CDF object.
   *
   * @var \Acquia\ContentHubClient\CDF\ClientCDFObject
   */
  protected $clientCDFObject;

  /**
   * The module extension list.
   *
   * @var \Drupal\Core\Extension\ModuleExtensionList
   */
  protected $moduleList;

  /**
   * ClientManagerFactory constructor.
   *
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
   *   The event dispatcher.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   The logger factory.
   * @param \Drupal\Core\Extension\ModuleExtensionList $module_list
   *   The module extension list.
   */
  public function __construct(EventDispatcherInterface $dispatcher, LoggerChannelFactoryInterface $logger_factory, ModuleExtensionList $module_list) {
    $this->dispatcher = $dispatcher;
    $this->loggerFactory = $logger_factory;
    $this->moduleList = $module_list;

    // Whenever a new client is constructed, make sure settings are invoked.
    $this->populateSettings();
  }

  /**
   * Call the event to populate contenthub settings.
   */
  protected function populateSettings() {
    $event = new AcquiaContentHubSettingsEvent();
    $this->dispatcher->dispatch(AcquiaContentHubEvents::GET_SETTINGS, $event);
    $this->settings = $event->getSettings();
    $this->settingsProvider = $event->getProvider();
  }

  /**
   * Instantiates the content hub client.
   *
   * @return \Acquia\ContentHubClient\ContentHubClient|bool
   *   The ContentHub Client
   */
  public function getClient(Settings $settings = NULL) {
    $validate = (bool) !$settings;
    if (!$settings) {
      if (isset($this->client)) {
        return $this->client;
      }
      $settings = $this->getSettings();
    }

    // If any of these variables is empty, then we do NOT have a valid
    // connection.
    // @todo add validation for the Hostname.
    if (!$settings
      || !Uuid::isValid($settings->getUuid())
      || empty($settings->getName())
      || empty($settings->getUrl())
      || empty($settings->getApiKey())
      || empty($settings->getSecretKey())
    ) {
      return FALSE;
    }

    // Override configuration.
    $languages_ids = array_keys(\Drupal::languageManager()->getLanguages());
    array_push($languages_ids, ClientCDFObject::LANGUAGE_UNDETERMINED);

    $config = [
      'base_url' => $settings->getUrl(),
      'client-languages' => $languages_ids,
      'client-user-agent' => $this->getClientUserAgent(),
    ];

    $this->client = new ContentHubClient(
      $config,
      $this->loggerFactory->get('acquia_contenthub'),
      $settings,
      $settings->getMiddleware(),
      $this->dispatcher
    );

    if ($validate && $this->client->getRemoteSettings()) {
      $event = new BuildClientCdfEvent(ClientCDFObject::create($settings->getUuid(), ['settings' => $settings->toArray()]));
      $this->dispatcher->dispatch(AcquiaContentHubEvents::BUILD_CLIENT_CDF, $event);
      $this->clientCDFObject = $event->getCdf();
      $this->updateClientCdf();
    }
    return $this->client;
  }

  /**
   * Returns Client's user agent.
   *
   * @return string
   *   User Agent.
   */
  protected function getClientUserAgent() {
    // Find out the module version in use.
    $module_info = $this->moduleList->getExtensionInfo('acquia_contenthub');
    $module_version = (isset($module_info['version'])) ? $module_info['version'] : '0.0.0';
    $drupal_version = (isset($module_info['core'])) ? $module_info['core'] : '0.0.0';

    return 'AcquiaContentHub/' . $drupal_version . '-' . $module_version;
  }

  /**
   * Gets the settings provider from the settings event for contenthub settings.
   *
   * @return string
   *   The name of settings' provider.
   */
  public function getProvider() {
    return $this->settingsProvider;
  }

  /**
   * Returns a settings object containing CH credentials and other related info.
   *
   * @return \Acquia\ContentHubClient\Settings
   *   ContentHub Client settings.
   */
  public function getSettings() {
    return $this->settings;
  }

  /**
   * Makes a call to get a client response based on the client name.
   *
   * Note, this receives a Symfony request, but uses a PSR7 Request to Auth.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Request.
   *
   * @return \Acquia\Hmac\KeyInterface|bool
   *   Authentication Key, FALSE otherwise.
   */
  public function authenticate(Request $request) {
    if (!$this->getClient()) {
      return FALSE;
    }

    $keys = [
      $this->client->getSettings()->getApiKey() => $this->client->getSettings()->getSecretKey(),
      'Webhook' => $this->client->getSettings()->getSharedSecret(),
    ];
    $keyLoader = new KeyLoader($keys);

    $authenticator = new RequestAuthenticator($keyLoader);

    // Authentication requires a PSR7 compatible request.
    if (class_exists(DiactorosFactory::class)) {
      $httpMessageFactory = new DiactorosFactory();
    }
    else {
      $httpMessageFactory = new PsrHttpFactory(new ServerRequestFactory(), new StreamFactory(), new UploadedFileFactory(), new ResponseFactory());
    }
    $psr7_request = $httpMessageFactory->createRequest($request);

    try {
      return $authenticator->authenticate($psr7_request);
    }
    catch (KeyNotFoundException $exception) {
      $this->loggerFactory
        ->get('acquia_contenthub')
        ->debug('HMAC validation failed. [authorization_header = %authorization_header]', [
          '%authorization_header' => $request->headers->get('authorization'),
        ]);
    }

    return FALSE;
  }

  /**
   * Update Client CDF.
   *
   * @return bool
   *   TRUE if successful; FALSE otherwise.
   *
   * @throws \ReflectionException
   */
  public function updateClientCdf() {
    /** @var \Acquia\ContentHubClient\CDF\ClientCDFObject $remote_cdf */
    $remote_cdf = $this->client->getEntity($this->settings->getUuid());
    // Don't update the ClientCDF if the remote object matches the local one.
    if ($remote_cdf instanceof ClientCDFObject &&
      $remote_cdf->getAttribute('hash') &&
      $remote_cdf->getAttribute('hash')->getValue()['und'] === $this->clientCDFObject->getAttribute('hash')->getValue()['und']) {
      return TRUE;
    }
    // Send the clientCDFObject because it doesn't exist in CH yet or doesn't
    // match what exists in CH today.
    $response = $this->client->putEntities($this->clientCDFObject);
    if ($response->getStatusCode() === 202) {
      return TRUE;
    }
    else {
      $this->loggerFactory->get('acquia_contenthub')->debug('Updating clientCDF failed with http status %error', [
        '%error' => $response->getStatusCode(),
      ]);
      return FALSE;
    }
  }

  /**
   * Wrapper for register method.
   *
   * @param string $name
   *   The client name.
   * @param string $url
   *   The content hub api hostname.
   * @param string $api_key
   *   The api key.
   * @param string $secret
   *   The secret key.
   * @param string $api_version
   *   The api version, default v1.
   *
   * @return \Acquia\ContentHubClient\ContentHubClient
   *   Return Content Hub client.
   *
   * @throws \Exception
   *
   * @see \Acquia\ContentHubClient\ContentHubClient::register()
   */
  public function registerClient(string $name, string $url, string $api_key, string $secret, string $api_version = 'v2') {
    return ContentHubClient::register($this->loggerFactory->get('acquia_contenthub'), $this->dispatcher, $name, $url, $api_key, $secret, $api_version);
  }

}
