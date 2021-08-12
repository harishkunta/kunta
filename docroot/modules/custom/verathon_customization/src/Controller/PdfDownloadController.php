<?php

namespace Drupal\verathon_customization\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * {@inheritdoc}
 */
class PdfDownloadController extends ControllerBase {

  /**
   * Function to download contants as PDF.
   */
  public function downloadPdf() {
    $element = array();
    if (!empty($_COOKIE['gatedFile'])) {
      $fileName = end(explode('/', $_COOKIE['gatedFile']));
      $query =  \Drupal::database()->select('file_managed', 'f');
      $query->fields('f', ['uri']);
      $query->condition('filename', $fileName);
      $uri = $query->execute()->fetchField();
      $brochure_url = file_create_url($uri);
      $element = array( 
        '#markup' => '<div align="center" class="coh-container-boxed"><h3>Thank you for your Interest!</h3><a align="center" href=' .$brochure_url. ' download>' .t("Click Here to Download the Brochure") . '</a></div>', 
      ); 
      setcookie("gatedFile", null, -1);
      return $element;
    }
    $element = array( 
      '#markup' => '<div align="center" class="coh-container-boxed"><h3>Thank you for your Interest!</h3></div>', 
    ); 
    return $element;
  }
}