<?php

namespace Drupal\verathon_bflex_calculator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\verathon_bflex_calculator\Calculator;
use Drupal\verathon_bflex_calculator\PdfGenerator;
use Mpdf\Mpdf;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Verathon Bflex Calculator routes.
 */
class VerathonBflexPdfController extends ControllerBase
{

  /**
   * The verathon_bflex_calculator.pdf_generator service.
   *
   * @var \Drupal\example\ExampleInterface
   */
  protected $verathonBflexCalculatorPdfGenerator;
  protected $pdfService;

  /**
   * The controller constructor.
   *
   * @param \Drupal\example\ExampleInterface $verathon_bflex_calculator_pdf_generator
   *   The verathon_bflex_calculator.pdf_generator service.
   */
  // public function __construct(PdfGenerator $pdf_service, Calculator $verathon_bflex_calculator_pdf_generator)
  // {
  //   $this->verathonBflexCalculatorPdfGenerator = $verathon_bflex_calculator_pdf_generator;
  //   $this->pdfService = $pdf_service;
  // }

  // /**
  //  * {@inheritdoc}
  //  */
  // public static function create(ContainerInterface $container)
  // {
  //   return new static(
  //     $container->get('verathon_bflex_calculator.pdf_generator'),
  //     $container->get('verathon_bflex_calculator.calculator')
  //   );
  // }

  /**
   * Builds the response.
   */
  public function build()
  {
    $this->pdfService = new Mpdf();

    $module_handler = \Drupal::service('module_handler');
    $module_path = $module_handler->getModule('verathon_bflex_calculator')->getPath();

    $css_page =  file_get_contents($module_path . '/css/pdf_page1.css');
    $css_page .=  file_get_contents($module_path . '/css/pdf_page2.css');
    $css_page .=  file_get_contents($module_path . '/css/pdf_page3.css');
    $css_page .= "<style>" . $css_page . "</style>";

    $page1 = [
      '#theme' => 'pdf__verathon_bflex_calculator__page1'
    ];
    $page2 = [
      '#theme' => 'pdf__verathon_bflex_calculator__page2'
    ];
    $page3 = [
      '#theme' => 'pdf__verathon_bflex_calculator__page3'
    ];
    $page1 = \Drupal::service('renderer')->render($page1);
    $page2 = \Drupal::service('renderer')->render($page2);
    $page3 = \Drupal::service('renderer')->render($page3);
    $this->pdfService->WriteHTML($css_page, 1);;
    $this->pdfService->WriteHTML($page1 . $page2 . $page3, 2);
    $this->pdfService->Output();
  }
}
