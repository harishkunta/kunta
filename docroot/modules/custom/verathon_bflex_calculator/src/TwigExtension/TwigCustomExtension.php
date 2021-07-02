<?php

namespace Drupal\verathon_bflex_calculator\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigCustomExtension extends AbstractExtension
{
  /**
   * This is the same name we used on the services.yml file
   */
  public function getName()
  {
    return 'verathon_bflex_calculator.twig_custom_extension';
  }

  // Basic definition of the filter. You can have multiple filters of course.
  public function getFilters()
  {
    return [
      new TwigFilter('currency', [$this, 'currency']),
    ];
  }
  // The actual implementation of the filter.
  public function currency($context, $decimal = 0, $symbol = '$')
  {
    if (($context) || $context == 0) {
      $context =  $symbol . number_format($context, $decimal);
    }
    return $context;
  }
}
