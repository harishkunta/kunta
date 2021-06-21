<?php

namespace Drupal\verathon_bflex_calculator;

use Dompdf\Dompdf;
use Mpdf\Mpdf;


/**
 * PdfGenerator service.
 */
class PdfGenerator extends Dompdf
{
  protected $_serviceId;

  public function __construct($params = [])
  {
  }
}
