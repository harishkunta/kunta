<?php

namespace Drupal\verathon_bflex_calculator\Controller;

use CloudConvert\CloudConvert;
use Dompdf\Dompdf;
use Drupal\Core\Controller\ControllerBase;
use CloudConvert\Models\ImportUploadTask;
use CloudConvert\Models\Task;
use CloudConvert\Models\Job;
use Drupal\file\Entity\File;
use Drupal\verathon_bflex_calculator\Calculator;
use Drupal\verathon_bflex_calculator\PdfGenerator;
use Mpdf\Mpdf;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
  protected $calculations;
  protected $pdfService;

  /**
   * The controller constructor.
   *
   * @param \Drupal\example\ExampleInterface $verathon_bflex_calculator_pdf_generator
   *   The verathon_bflex_calculator.pdf_generator service.
   */
  public function __construct(Calculator $verathon_bflex_calculator_pdf_generator)
  {
    $this->calculator = $verathon_bflex_calculator_pdf_generator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('verathon_bflex_calculator.calculator')
    );
  }

  /**
   * Builds the response.
   */
  public function build()
  {
    try {
      // Getting all query parameters from the URL to generate the calculations for PDF.
      $request = \Drupal::request();
      $query_params = $request->query->all();
      $config = \Drupal::config('verathon_bflex_calculator.settings')->get();
      // If Query Parameters empty then redirect to Calculator page.
      if (empty($query_params)) {
        $response = new RedirectResponse("/bflex-calculator");
        $response->send();
      }

      // Calling CloudConvert API for PDF generation.
      $cloudconvert = new CloudConvert([
        'api_key' => $config['cc_api_key'],
        'sandbox' => false
      ]);
      // Getting All HTML pages to generate the PDF.
      $page1 = [
        '#theme' => 'pdf__verathon_bflex_calculator__page1',
        '#config' => ['facility_name' => $query_params['fn']],
      ];
      $page2 = [
        '#theme' => 'pdf__verathon_bflex_calculator__page2'
      ];
      $page3 = [
        '#theme' => 'pdf__verathon_bflex_calculator__page3',
        '#calculation' => $this->calculator->calculate(
          $query_params['fn'],
          (int) $query_params['tp'],
          (int) $query_params['sup'],
          $query_params['bbp'],
          (int) $query_params['crq'],
          (int) $query_params['casp'],
          $query_params['rcm'],
          (int) $query_params['caoraf']
        ),
        '#config' => $config,
      ];

      // Calling theme renderer to parse the HTML with values provided as arguments.
      $page1 = \Drupal::service('renderer')->render($page1);
      $page2 = \Drupal::service('renderer')->render($page2);
      $page3 = \Drupal::service('renderer')->render($page3);
      $html  = $page1 . $page2 . $page3;
      // Setting up cloudconvert API jobs.
      $job = (new Job())
        ->addTask(
          (new Task('import/raw', 'upload-html'))
            ->set('file', $html)
            ->set('filename', 'bflex-savings.html')
            ->set('engine', 'wkhtml')
            ->set('page_width', 21.59)
            ->set('page_height', 27.94)
            ->set('margin_top', 0)
            ->set('margin_right', 0)
            ->set('margin_bottom', 0)
            ->set('margin_left', 0)
        )
        ->addTask(
          (new Task('convert', 'html2pdf'))
            ->set('input_format', 'html')
            ->set('output_format', 'pdf')
            ->set('engine', 'chrome')
            ->set('input', ["upload-html"])
            ->set('zoom', 1)
            ->set('print_background', true)
            ->set('display_header_footer', false)
            ->set('wait_until', 'load')
        )
        ->addTask(
          (new Task('export/url', 'output'))
            ->set('input', ["html2pdf"])
            ->set('inline', true)
            ->set('archive_multiple_files', false)
        );

      // Setting up cloud convert API call for creation of jobs and execution.
      $cloudconvert->jobs()->create($job);
      $cloudconvert->jobs()->wait($job); // Wait for job completion

      // Fetching all URLs and sending them as for preview.
      foreach ($job->getExportUrls() as $file) {
        $response = new RedirectResponse($file->url);
        $response->send();
      }
      exit(0);
    } catch (\Exception $e) {
      \Drupal::logger('bflex-calculator')->error($e->getMessage());
      $response = new RedirectResponse("/bflex-calculator");
      $response->send();
    }
  }
}
