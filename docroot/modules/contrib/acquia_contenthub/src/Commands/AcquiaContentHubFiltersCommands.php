<?php

namespace Drupal\acquia_contenthub\Commands;

use Drupal\acquia_contenthub\Client\ClientFactory;
use Drupal\Component\Uuid\Uuid;
use Drush\Commands\DrushCommands;
use Drush\Log\LogLevel;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Drush command to interact with Acquia Content Hub filters.
 *
 * @package Drupal\acquia_contenthub\Commands
 */
class AcquiaContentHubFiltersCommands extends DrushCommands {

  /**
   * Client Factory.
   *
   * @var \Drupal\acquia_contenthub\Client\ClientFactory
   */
  protected $clientFactory;

  /**
   * Maximum characters length for cell's value in console table.
   */
  protected const STRING_VALUE_MAX_LENGTH = 32;

  /**
   * {@inheritdoc}
   */
  public function __construct(ClientFactory $clientFactory) {
    $this->clientFactory = $clientFactory;
  }

  /**
   * Prints cloud filters list.
   *
   * @command acquia:contenthub-filters
   * @aliases ach-cf
   *
   * @option webhook
   * @option interactive
   *
   * @default webhook null
   * @default interactive false
   *
   * @usage acquia:contenthub-filters
   *   Prints cloud filters list.
   * @usage acquia:contenthub-filters --interactive
   *   Allows user to select webhook to display related filters.
   * @usage acquia:contenthub-filters --webhook=[WEBHOOK_URL]
   *   Allows user to define webhook to display related filters.
   *
   * @throws \Exception
   */
  public function listFilters(): void {
    $client = $this->clientFactory->getClient();
    $webhooks = $client->getWebHooks();
    // User can reduce filters list by site (webhook).
    $webhook = $this->input->getOption('webhook');
    $isInteractive = $this->input->getOption('interactive');

    $filters = $this->buildCloudFiltersList($webhooks, $webhook, $isInteractive);
    if (empty($filters)) {
      $this->logger->log(LogLevel::CANCEL, 'There are no cloud filters defined in this subscription.');
      return;
    }

    $rows = $this->buildRows($filters, $webhooks);
    (new Table($this->output))
      ->setHeaders(['#', 'UUID', 'Name', 'Assigned to', 'Is real time filter'])
      ->setRows($rows)
      ->render();
  }

  /**
   * Attaches filter to site.
   *
   * @param string $uuid
   *   Filter UUID.
   * @param string $url
   *   Webhook URL (e.g. http://example.com/acquia-contenthub/webhook).
   *
   * @command acquia:contenthub-filters:attach
   * @aliases ach-cfa
   *
   * @usage acquia:contenthub-filters:attach 00000000-0000-0000-0000-000000000000 http://example.com/acquia-contenthub/webhook
   *   Attaches filter to site.
   *
   * @throws \Exception
   */
  public function attachFilter(string $uuid, string $url): void {
    $client = $this->clientFactory->getClient();
    $webhook = $client->getWebHook($url);

    if (empty($webhook)) {
      $this->logger->log(
        LogLevel::CANCEL,
        'Webhook with following URL {url} or UUID {uuid} not exist.',
        ['url' => $url, 'uuid' => $uuid]
      );
      return;
    }

    if (in_array($uuid, $webhook->getFilters())) {
      $this->logger->log(LogLevel::CANCEL, 'Filter already attached to {url}.', ['url' => $url]);
      return;
    }

    $response = $client->addFilterToWebhook($uuid, $webhook->getUuid());
    if (empty($response)) {
      return;
    }

    if (isset($response['success'], $response['error']) && !$response['success']) {
      $context = [
        'code' => $response['error']['code'],
        'reason' => $response['error']['message'],
      ];
      $this->logger->log(LogLevel::ERROR, 'Operation failed (code: {code}). {reason}', $context);
      return;
    }

    $this->logger->log(LogLevel::SUCCESS, 'Filter successfully attached to {url}.', ['url' => $url]);
  }

  /**
   * Detaches filter from site.
   *
   * @param string $uuid
   *   Filter UUID.
   * @param string $url
   *   Webhook URL.
   *
   * @command acquia:contenthub-filters:detach
   * @aliases ach-cfd
   *
   * @usage acquia:contenthub-filters:detach 00000000-0000-0000-0000-000000000000 http://example.com/acquia-contenthub/webhook
   *   Detaches filter from site.
   *
   * @throws \Exception
   */
  public function detachFilter(string $uuid, string $url): void {
    $client = $this->clientFactory->getClient();
    $webhook = $client->getWebHook($url);

    if (empty($webhook) || empty($webhook->getFilters())) {
      $message = 'Webhook with following URL {url} does not exist or no filters attached to this webhook.';
      $this->logger->log(LogLevel::CANCEL, $message, ['url' => $url]);
      return;
    }

    if (!in_array($uuid, $webhook->getFilters(), TRUE)) {
      $this->logger->log(LogLevel::CANCEL, 'Nothing to detach.');
      return;
    }

    $response = $client->removeFilterFromWebhook($uuid, $webhook->getUuid());
    if (empty($response)) {
      return;
    }

    $message = 'Filter {filter} successfully detached from {url}.';
    $context = [
      'filter' => $uuid,
      'url' => $url,
    ];
    $this->logger->log(LogLevel::SUCCESS, $message, $context);
  }

  /**
   * Prints filter details.
   *
   * @param string $uuid
   *   Cloud filter's UUID.
   *
   * @command acquia:contenthub-filter-details
   * @aliases ach-cfds
   *
   * @usage acquia:contenthub-filter-details 00000000-0000-0000-0000-000000000000
   *   Prints filter details.
   */
  public function filterDetails(string $uuid): void {
    try {
      $filter = $this->fetchFilterInfo($uuid);
    }
    catch (\Exception $exception) {
      $this->io()->error($exception->getMessage());
      return;
    }

    $rows = [
      dt('UUID: {uuid}', ['uuid' => $filter['data']['uuid']]),
      dt('Name: {name}', ['name' => $filter['data']['name']]),
      dt('Query: {query}', ['query' => json_encode($filter['data']['data']['query'])]),
      dt('Metadata: {meta}', ['meta' => json_encode($filter['data']['metadata'])]),
    ];

    $this->writeln($rows);
  }

  /**
   * Builds cloud filters list.
   *
   * @param array|null $webhooks
   *   Webhooks list.
   * @param string|null $webhook
   *   Webhook URL.
   * @param bool $isInteractive
   *   Interactive mode flag.
   *
   * @return array
   *   Cloud filters list.
   *
   * @throws \Exception
   */
  protected function buildCloudFiltersList(?array $webhooks, ?string $webhook, bool $isInteractive = FALSE): array {
    $client = $this->clientFactory->getClient();
    $cloudFilters = $client->listFilters();
    if (empty($cloudFilters['data'])) {
      $this->logger->log(LogLevel::CANCEL, dt('There are no cloud filters defined in this subscription.'));
      return [];
    }

    $cloudFilters = $cloudFilters['data'];

    if (empty($webhooks)) {
      $this->logger->log(LogLevel::CANCEL, dt('There are no registered webhooks in this subscription.'));
      return [];
    }

    // In interactive mode webhook will be overridden.
    if ($isInteractive) {
      $webhook = $this->selectWebhook($webhooks);
    }

    $cloudFilters = $this->reduceFilterByWebhook($cloudFilters, $webhooks, $webhook);
    if (empty($cloudFilters)) {
      $this->logger->log(LogLevel::CANCEL, dt('There are no cloud filters defined in this subscription.'));
      return [];
    }

    return $cloudFilters;
  }

  /**
   * Asks user to select webhook.
   *
   * @param array $webhooks
   *   Webhooks list.
   *
   * @return string
   *   Webhook chosen by user.
   */
  protected function selectWebhook(array $webhooks): string {
    $choices = [];
    foreach ($webhooks as $wh) {
      $choices[] = $wh->getUrl();
    }
    $question = new ChoiceQuestion('Please select webhook:', $choices);
    $webhook = $this->getDialog()
      ->ask($this->input, $this->output, $question);

    return $webhook;
  }

  /**
   * Returns filters related to specified webhook.
   *
   * @param array $filters
   *   Cloud filters list.
   * @param \Acquia\ContentHubClient\Webhook[] $webhooks
   *   All available webhooks list.
   * @param string|null $webhook
   *   Webhook URL.
   *
   * @return array
   *   Webhooks filtered.
   */
  protected function reduceFilterByWebhook(array $filters, array $webhooks, ?string $webhook): array {
    if (empty($webhook)) {
      return $filters;
    }

    // Build a map of webhook => filters.
    $map = [];
    foreach ($webhooks as $wh) {
      $map[$wh->getUrl()] = $wh->getFilters();
    }
    if (empty($map[$webhook]) || !is_array($map[$webhook])) {
      return [];
    }

    $ids = $map[$webhook];
    $reducer = function ($carry, $item) use ($ids) {
      if (in_array($item['uuid'], $ids, TRUE)) {
        $carry[] = $item;
      }

      return $carry;
    };

    return array_reduce($filters, $reducer, []);
  }

  /**
   * Returns rows of result table.
   *
   * @param array $filters
   *   Cloud filters list.
   * @param \Acquia\ContentHubClient\Webhook[] $webhooks
   *   Webhooks for client.
   *
   * @return array
   *   Rows array.
   */
  protected function buildRows(array $filters, array $webhooks): array {
    if (count($filters) > 1) {
      $comparator = function ($a, $b) {
        return strcmp($a['name'], $b['name']);
      };

      usort($filters, $comparator);
    }

    $urlToFiltersMap = [];
    foreach ($webhooks as $wh) {
      $urlToFiltersMap[$wh->getUrl()] = $wh->getFilters();
    }
    $mapper = function (array $item, $index) use ($urlToFiltersMap) {
      $sites = $this->buildAssignedSitesList($urlToFiltersMap, $item['uuid']);

      return [
        'index' => $index + 1,
        'uuid' => $item['uuid'],
        'name' => $this->truncateString($item['name']),
        'sites' => implode(', ', $sites),
        'is_real_time' => $item['real_time_filter'],
      ];
    };

    return array_map($mapper, $filters, array_keys($filters));
  }

  /**
   * Builds list of assigned sites.
   *
   * @param array $urlToFiltersMap
   *   Webhooks list.
   * @param string $uuid
   *   Filter UUID.
   *
   * @return array
   *   Sites list.
   */
  protected function buildAssignedSitesList(array $urlToFiltersMap, string $uuid): array {
    $sites = [];
    foreach ($urlToFiltersMap as $url => $webhookFilters) {
      if (!is_array($webhookFilters) || !in_array($uuid, $webhookFilters, TRUE)) {
        continue;
      }

      $parsedUrl = parse_url($url);
      $sites[] = sprintf('%s://%s', $parsedUrl['scheme'], $parsedUrl['host']);
    }
    return $sites;
  }

  /**
   * Truncates string.
   *
   * @param string $value
   *   String to truncate.
   * @param string $marker
   *   Truncation marker.
   *
   * @return string
   *   Truncated string.
   */
  protected function truncateString(string $value, string $marker = '...'): string {
    $markerLength = mb_strlen($marker);
    return mb_strlen($value) <= self::STRING_VALUE_MAX_LENGTH ? $value :
      mb_substr($value, 0, self::STRING_VALUE_MAX_LENGTH - $markerLength) . $marker;
  }

  /**
   * Fetches filter info.
   *
   * @param string $uuid
   *   Cloud filter's UUID.
   *
   * @return array
   *   Filter info if filter exists. Otherwise throws exception.
   *
   * @throws \Exception
   */
  protected function fetchFilterInfo(string $uuid): array {
    if (!Uuid::isValid($uuid)) {
      $errorMessage = dt('Provided value "{value}" is not a valid UUID.', ['value' => $uuid]);
      throw new \InvalidArgumentException($errorMessage);
    }

    try {
      $client = $this->clientFactory->getClient();
      $info = $client->getFilter($uuid);
    }
    catch (\Exception $exception) {
      throw $exception;
    }

    if (empty($info)) {
      $errorMessage = dt('Filter with UUID = "{uuid}" does not exist.', ['uuid' => $uuid]);
      throw new \InvalidArgumentException($errorMessage);
    }

    if (isset($info['success'], $info['error']) && !$info['success']) {
      $context = [
        'code' => $info['error']['code'],
        'reason' => $info['error']['message'],
        'id' => $info['request_id'],
      ];
      $errorMessage = dt('Operation failed (code: {code}, Request ID: {id}). {reason}', $context);
      throw new \Exception($errorMessage);
    }

    return $info;
  }

}
