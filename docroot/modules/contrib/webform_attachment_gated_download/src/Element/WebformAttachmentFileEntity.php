<?php

namespace Drupal\webform_attachment_gated_download\Element;

use Drupal\file\Entity\File;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform_attachment\Element\WebformAttachmentBase;

/**
 * Provides a 'webform_attachment_gated_download' element.
 *
 * @FormElement("webform_attachment_gated_download")
 */
class WebformAttachmentFileEntity extends WebformAttachmentBase {

  /**
   * {@inheritdoc}
   */
  public static function getFileContent(array $element, WebformSubmissionInterface $webform_submission) {
    try {
      $file = self::loadFileEntity($element, $webform_submission);
      if (empty($file)) {
        return '';
      }
      return file_get_contents($file->getFileUri());
    }
    catch (\Throwable $exception) {
      $content = '';
    }
    return (!empty($element['#trim'])) ? trim($content) : $content;
  }

  /**
   * {@inheritdoc}
   */
  public static function getFileName(array $element, WebformSubmissionInterface $webform_submission) {
    $file = self::loadFileEntity($element, $webform_submission);
    if (!empty($file)) {
     return $file->get('filename')->value;
    }
    else {
      return parent::getFileName($element, $webform_submission);
    }
  }

  /**
   * @param array $element
   * @param \Drupal\webform\WebformSubmissionInterface $webform_submission
   *
   * @return \Drupal\Core\Entity\EntityInterface|File|null
   */
  protected static function loadFileEntity(array $element, WebformSubmissionInterface $webform_submission) {
    $file = &drupal_static(__FUNCTION__);
    if (empty($file)) {
      $fid = $webform_submission->getData()['webform_attachment_gated_download_fid'];
      if (!empty($fid)) {
        $file = File::load($fid);
        return $file;
      }
      return NULL;
    }
    return $file;
  }
}
