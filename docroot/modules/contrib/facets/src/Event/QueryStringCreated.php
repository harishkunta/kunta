<?php

namespace Drupal\facets\Event;

use Drupal\facets\FacetInterface;
use Drupal\facets\Result\ResultInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Implements the query string created event.
 *
 * This event allows modules to change the facet's query string if needed.
 */
final class QueryStringCreated extends Event {

  const NAME = 'facets.query_string_created';

  /**
   * The get parameters.
   *
   * @var \Symfony\Component\HttpFoundation\ParameterBag
   */
  private $queryParameters;

  /**
   * The filter parameters.
   *
   * @var array
   */
  private $filterParameters;

  /**
   * The facet result.
   *
   * @var \Drupal\facets\Result\ResultInterface
   */
  private $facetResult;

  /**
   * The active filters.
   *
   * @var array
   */
  private $activeFilters;

  /**
   * The facet.
   *
   * @var \Drupal\facets\FacetInterface
   */
  private $facet;

  /**
   * QueryStringCreated constructor.
   *
   * @param \Symfony\Component\HttpFoundation\ParameterBag $queryParameters
   *   The get parameters to use.
   * @param array $filterParameters
   *   The filter parameters to use.
   * @param \Drupal\facets\Result\ResultInterface $facetResult
   *   The facet result.
   * @param array $activeFilters
   *   The active filters.
   * @param \Drupal\facets\FacetInterface $facet
   *   The facet.
   */
  public function __construct(ParameterBag $queryParameters, array $filterParameters, ResultInterface $facetResult, array $activeFilters, FacetInterface $facet) {
    $this->queryParameters = $queryParameters;
    $this->filterParameters = $filterParameters;
    $this->facetResult = $facetResult;
    $this->activeFilters = $activeFilters;
    $this->facet = $facet;
  }

  /**
   * Get the get parameters.
   *
   * @return \Symfony\Component\HttpFoundation\ParameterBag
   *   The get parameters.
   */
  public function getQueryParameters() {
    return $this->queryParameters;
  }

  /**
   * Get the filter parameters.
   *
   * @return array
   *   The filter parameters.
   */
  public function getFilterParameters() {
    return $this->filterParameters;
  }

  /**
   * Set the filter parameters.
   *
   * @param array $filterParameters
   *   The filter parameters to set.
   */
  public function setFilterParameters($filterParameters) {
    $this->filterParameters = $filterParameters;
  }

  /**
   * Get the facet result.
   *
   * Only to be used as context, because changing this will not result in any
   * changes to the final url.
   *
   * @return \Drupal\facets\Result\ResultInterface
   *   The facet result.
   */
  public function getFacetResult() {
    return $this->facetResult;
  }

  /**
   * Get the active filters.
   *
   * Only to be used as context, because changing this will not result in any
   * changes to the final url.
   *
   * @return array
   */
  public function getActiveFilters() {
    return $this->activeFilters;
  }

  /**
   * Get the facet.
   *
   * Only to be used as context, because changing this will not result in any
   * changes to the final url.
   *
   * @return \Drupal\facets\FacetInterface
   */
  public function getFacet() {
    return $this->facet;
  }

}
