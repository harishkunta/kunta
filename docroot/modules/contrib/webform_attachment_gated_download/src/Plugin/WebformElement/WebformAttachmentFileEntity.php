<?php

namespace Drupal\webform_attachment_gated_download\Plugin\WebformElement;

use Drupal\webform_attachment\Plugin\WebformElement\WebformAttachmentBase;

/**
 * Provides a 'webform_attachment_gated_download' element.
 *
 * @WebformElement(
 *   id = "webform_attachment_gated_download",
 *   label = @Translation("Attachment File (Gated Download)"),
 *   description = @Translation("Generates an attachment using a file entity."),
 *     category = @Translation("File attachment elements"),
 * )
 */
class WebformAttachmentFileEntity extends WebformAttachmentBase {

}
