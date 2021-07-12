<?php

namespace Drupal\webform_attachment_gated_download;

use Drupal\Component\Utility\Crypt;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Site\Settings;

class QueryParser {

  /**
   * @param $fid
   *
   * @return string
   */
  public static function getQueryValueFromFid($fid) {
    $hmac = Crypt::hmacBase64($fid, Settings::getHashSalt());
    return $fid . '|' . $hmac;
  }

  /**
   * @return int|null
   */
  public static function getFidFromUrlParameters() {
    $fid = &drupal_static('webform_attachment_gated_download_fid');
    if (empty($fid)) {
      $param = Xss::filter(\Drupal::request()->query->get('gated_fid'));
      if (empty($param)) {
        return NULL;
      }
      $params = explode('|', $param);
      // check it hasn't been altered
      // get salt hash
      try {
        $hmac = Crypt::hmacBase64($params[0], Settings::getHashSalt());
        if ($hmac != $params[1]) {
          return NULL;
        }
      } catch (\Throwable $ex) {
        return NULL;
      }
      $fid = $params[0];
    }
    return $fid;
  }
}
