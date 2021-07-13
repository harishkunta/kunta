<?php

namespace Drupal\webform_attachment_gated_download\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Crypt;
use Drupal\Core\Extension\ModuleHandler;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Site\Settings;
use Drupal\Core\Url;
use Drupal\media\Entity\Media;
use Drupal\webform\Entity\Webform;
use Drupal\webform_attachment_gated_download\QueryParser;

/**
 * Plugin implementation of the 'webform_link_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "webform_link_field_formatter",
 *   label = @Translation("Webform Gated Download Link"),
 *   field_types = {
 *     "entity_reference",
 *     "file",
 *     "image",
 *   }
 * )
 */
class WebformLinkFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    // only allow on file and media entity reference fields
    $target_type = $field_definition->getFieldStorageDefinition()->getSetting('target_type');
    $types = [
      'media',
      'file',
    ];
    return in_array($target_type, $types);
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'button_text' => '',
      'webform_url' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $extra_form['button_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Button text'),
      '#required' => TRUE,
      '#default_value' => $this->getSetting('button_text'),
    ];
    $webform_id = $this->getSetting('webform_url');
    $extra_form['webform_url'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Webform'),
      '#required' => TRUE,
      '#default_value' => empty($webform_id) ? '' : Webform::load($webform_id),
      '#link_type' => 'internal',
      '#target_type' => 'webform',
      '#attributes' => [
        'data-autocomplete-first-character-blacklist' => '/#?',
      ],
    ];
    return $extra_form + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();

    $button_text = $this->getSetting('button_text');
    $webform_url = $this->getSetting('webform_url');

    $summary[] = $this->t('Button text: @button_text', ['@button_text' => $button_text]);
    $summary[] = $this->t('Webform: @webform_url', ['@webform_url' => $webform_url]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    // get salt hash - use the highlight error in field display only
    try {
      $salt = Settings::getHashSalt();
    }
    catch (\Throwable $ex) {
      // do nothing
    }

    $elements = [];
    /** @var FieldItemInterface $item */
    foreach ($items as $delta => $item) {
      // display missing salt error
      if (empty($salt)) {
        $elements[$delta] = ['#markup' => $this->t('Missing $settings[\'hash_salt\'] in settings.php')];
        continue;
      }
      try {
        // get the file ID from file and media item storage
        switch ($item->getFieldDefinition()->getFieldStorageDefinition()->getSetting('target_type')) {
          case 'file':
            $fid = $item->target_id;
            break;
          case 'media':
            $media = Media::load($item->target_id);
            $fid = $media->getSource()->getSourceFieldValue($media);
        }
        // should never happen, but handle just in case
        if (empty($fid)) {
          $elements[$delta] = ['#markup' => $this->t('No matching fid')];
          continue;
        }
        // get a secure URL parameter key
        $key = QueryParser::getQueryValueFromFid($fid);
      }
      catch (\Throwable $ex) {
        // do nothing
      }
      // handle key failure
      if (empty($key)) {
        $elements[$delta] = ['#markup' => $this->t('Could not generate key')];
      }
      // handle no webform link
      elseif (empty($this->settings['webform_url'])) {
        $elements[$delta] = ['#markup' => $this->t('No link provided')];
      }
      else {
        try {
          // build a link from the webform URL and key parameter
          $uri = Url::fromUri('internal:/webform/' . $this->settings['webform_url']);
          $uri->setOption('query', ['gated_fid' => $key]);
          // allow other modules to alter the URL
          \Drupal::moduleHandler()
            ->alter('webform_attachment_gated_download_url', $uri);
          // build the link
          $options = [
            'langcode' => $langcode,
          ];
          $link_text = $this->t($this->getSetting('button_text'), [], $options);
          $link = Link::fromTextAndUrl($link_text, $uri);
          $elements[$delta] = ['#markup' => $link->toString()];
        }
        catch (\Throwable $ex) {
          \Drupal::logger('webform_attachment_gated_download')-> error($ex->getMessage());
          $elements[$delta] = ['#markup' => $this->t('Error generating link')];
        }
      }
    }

    return $elements;
  }
}
