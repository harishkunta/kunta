<?php

namespace Drupal\acquia_contenthub\Event;

use Acquia\ContentHubClient\CDFDocument;
use Drupal\acquia_contenthub\EntityCdfSerializer;
use Drupal\depcalc\DependencyStack;
use Symfony\Component\EventDispatcher\Event;

/**
 * An event for responding to failed imports.
 */
class FailedImportEvent extends Event {

  /**
   * The CDF Document.
   *
   * @var \Acquia\ContentHubClient\CDFDocument
   */
  protected $cdf;

  /**
   * The dependency stack.
   *
   * @var \Drupal\depcalc\DependencyStack
   */
  protected $stack;

  /**
   * The count of processed items.
   *
   * @var int
   */
  protected $count;

  /**
   * The exception to return if any.
   *
   * @var \Exception
   */
  protected $exception;

  /**
   * The entity cdf serializer.
   *
   * @var \Drupal\acquia_contenthub\EntityCdfSerializer
   */
  protected $serializer;

  /**
   * FailedImportEvent constructor.
   *
   * @param \Acquia\ContentHubClient\CDFDocument $cdf
   *   The CDF Document being processed during failure.
   * @param \Drupal\depcalc\DependencyStack $stack
   *   The dependency stack being populated during failure.
   * @param int $count
   *   The count of items processed before failure.
   * @param \Drupal\acquia_contenthub\EntityCdfSerializer $serializer
   *   The entity cdf serializer.
   */
  public function __construct(CDFDocument $cdf, DependencyStack $stack, $count, EntityCdfSerializer $serializer) {
    $this->cdf = $cdf;
    $this->stack = $stack;
    $this->count = $count;
    $this->serializer = $serializer;
  }

  /**
   * Returns the CDF Document which failed to import.
   *
   * @return \Acquia\ContentHubClient\CDFDocument
   *   The CDF document.
   */
  public function getCdf(): CDFDocument {
    return $this->cdf;
  }

  /**
   * Returns the populated dependency stack.
   *
   * @return \Drupal\depcalc\DependencyStack
   *   The dependency stack.
   */
  public function getStack(): DependencyStack {
    return $this->stack;
  }

  /**
   * Returns the count of processed items before failure.
   *
   * @return int
   *   The count.
   */
  public function getCount(): int {
    return $this->count;
  }

  /**
   * Determines if an event subscriber has created an exception to throw.
   *
   * @return bool
   *   Whether or not an exception has been added to this event.
   */
  public function hasException(): bool {
    return (bool) $this->exception;
  }

  /**
   * The exception to throw when all event subscribers are finished.
   *
   * @return \Exception
   *   The exception to be thrown when all IMPORT_FAILURE subscribers have run.
   */
  public function getException(): \Exception {
    return $this->exception;
  }

  /**
   * Set the exception to throw on event failure.
   *
   * @param \Exception $exception
   *   The exception to set.
   */
  public function setException(\Exception $exception) {
    $this->exception = $exception;
  }

  /**
   * Get the serializer instance that invoked the failure event.
   *
   * @return \Drupal\acquia_contenthub\EntityCdfSerializer
   *   Entity CDF Serializer.
   */
  public function getSerializer() : EntityCdfSerializer {
    return $this->serializer;
  }

}
