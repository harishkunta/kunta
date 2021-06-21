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
    try {
      $this->pdfService = new Dompdf();
      $cloudconvert = new CloudConvert([
        // FIXME REPLACE WITH PRODUCTION ENV VAR
        //'api_key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZTAxOThlNWRjODVkYWNhNDU4YThhNDhjZWFkNDc5NTllNjRkNTViNmNlMzk2ZjFlZmFjZWVkZjE0NGVkYzg2MzJhOGU3MGEzNTAxNWFjNWEiLCJpYXQiOiIxNjA3OTY5ODk4LjA3ODU2MCIsIm5iZiI6IjE2MDc5Njk4OTguMDc4NTYzIiwiZXhwIjoiNDc2MzY0MzQ5OC4wMzA5OTAiLCJzdWIiOiI0NzU5NTcyNSIsInNjb3BlcyI6WyJ0YXNrLndyaXRlIiwidGFzay5yZWFkIl19.HmEWMxShHnW0k4bOyChJDKFpo_WGBowgPV6bVne_DHMFFBaEgxx73DIZYc7im3uzajgZI8vn8z1Lsh7V5ZqWlIW28lkJI1TsSKLR1DP-kTQBpO_xvEiD1e8msHOYCV9bUp6kNk-r5Wp3i4j_Z2LsuXfUSLXBxm3ItNAJTra9VRcX0FwSe-DLAyA0YGO1SjTh3eakh6-uaisWmqNATavAgjfDW-YQFzcwkiSztSWHO-5RtvsjCDRXNQVtGAvS75aiNSURXaWEigmb8urGdk3NKFWCpsOzmNyneLZhNboPtb6sRIjPLDiicWWol4KfrYfIsJF7BSnkuYHDanbtX2koeCXClGOxGqfNqkZ_HlKPD9ssTNY-uZahMy1qJvBfR7h5BZeFje_azTixrHqHsuBhIUCbQIjC5B54z1hduCHZ7539RHP9xPVHMuD1cCOHxChZTYoLn4bcfef68npKSmOX3jKbdIrviAuUZec6NT9OsFqYdNxfGMduvGJMjEYatcRLlT4KguMkmBLk0r60szWRCy-7sTMhpqgi3hM7xlUDlVSOB8tRj-TGRbbmt6et1kh_AYGl4GGKcKpuYCGDa6lfA8tt5-kTzsueIuBCDbFvKZ-5aRLzSBfQsQ3xnUxd-Gqj0W3LEcoDdp4zoceO1UC15vjseWo8lEXSNaryciX3E6U',
        'api_key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiN2U3NDYyNjYzYTMxZTI0NDU5ZWQ1YjJhZjNkYzc1ZTM1NDBiNmNlYjlkMzdlN2QzY2IzYWNhMGU2ZTRiZGRhZGVmOGU3NDFhM2UyOGY3OWIiLCJpYXQiOiIxNjE2MDE3MDk3Ljc1NjkyMiIsIm5iZiI6IjE2MTYwMTcwOTcuNzU2OTI1IiwiZXhwIjoiNDc3MTY5MDY5Ny43MTU3NjIiLCJzdWIiOiI0OTcyNjI3NSIsInNjb3BlcyI6WyJ0YXNrLnJlYWQiLCJ0YXNrLndyaXRlIl19.cb_As43_tQZvoytXOa5eUDhLy_RcTf7u5UOg9yeTxkUI8cb0A-tWdQoDH9JhUj18yH2jfM5zfOrzQnsfsrfnZAN9334SM_K1mXvZxbRbjqhV66v0Q-oqKlEcu0XCHYkUNZTuxWtjqafvEQP9lUTf9iZ3auQYluMcobcM98mVh_ENTLsud7vzoI50prbkcyDVKFcnzAJCXkyJjdI2Pwpbe86htwsykQQyqQY_VQZafY_nr7DUTc9Hpx9LRzyxxsE8CIJNAGxsend9lH89DxkKcxpAEopX6_re1SsOGgbMFX00KypFflEvpruqk7zQHkYRxkXEqkWIB39LaMfTvhfeWa8sHuQJMO5gJpbt_wEUdXajUySIRX0qQmLvh3M2wBDQWaAQQNe97ENOA6rk8Jct9rx3JAaGxgFSTE2eh3zt3PQlMLnXn1fF2E1HoSN-Pqp-tH3kiAnnOcfMOpedpjwOCBThKZkVGy4jjlc74bQXzqlHNKMJkj4OVCr5WHL3y4ncl1vqZvnFMPDpiOU8LI31Tzin7TnAHXGbMlVYg3bWB8VDXzvXL9TEUFmUtEzrqSJO-Bs2k7KPFbbDie_p5lowEWCd9_76WgPDkl9bziv8k11CjG8qCtby6tHoJd-Jx_LlUr6KlEUNd6quILs-b8wtKawax0EYZnqBVozWFACmS_w',
        'sandbox' => false
      ]);


      $module_handler = \Drupal::service('module_handler');
      $module_path = $module_handler->getModule('verathon_bflex_calculator')->getPath();

      $css_page =  file_get_contents($module_path . '/css/pdf_page1.css');
      $css_page .=  file_get_contents($module_path . '/css/pdf_page2.css');
      $css_page .=  file_get_contents($module_path . '/css/pdf_page3.css');
      $css_page .= "<style>" . $css_page . "</style>";

      $more .= '<link type="text/css" href="' . $module_path . '/css/pdf_page1.css" rel="stylesheet"  />';
      $more .= '<link type="text/css" href="' . $module_path . '/css/pdf_page2.css" rel="stylesheet" />';
      $more .= '<link type="text/css" href="' . $module_path . '/css/pdf_page3.css" rel="stylesheet" />';

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
      $html  = $page1 . $page2 . $page3;

      $job = (new Job())
        ->addTask(
          (new Task('import/raw', 'upload-html'))
            ->set('file', $html)
            ->set('filename', 'bflex-calculator.html')
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

      $cloudconvert->jobs()->create($job);
      $cloudconvert->jobs()->wait($job); // Wait for job completion
      foreach ($job->getExportUrls() as $file) {
        $response = new RedirectResponse($file->url);
        $response->send();
      }
    } catch (\Exception $e) {
      print $e->getMessage();
      die;
    }
  }
}
