<?php

namespace Drupal\Tests\acquia_contenthub\Kernel;

/**
 * Tests importing and exporting nodes.
 *
 * @group acquia_contenthub
 * @group orca_ignore
 *
 * @package Drupal\Tests\acquia_contenthub\Kernel
 */
class NodeImportUpdateExportTest extends ImportExportTestBase {

  protected $fixtures = [
    [
      'cdf' => 'node/node_page.json',
      'expectations' => 'expectations/node/node_page.php',
    ],
    [
      'cdf' => 'node/node_page_update.json',
      'expectations' => 'expectations/node/node_page_update.php',
    ],
    [
      'cdf' => 'node/node_term_page.json',
      'expectations' => 'expectations/node/node_term_page.php',
    ],
    [
      'cdf' => 'node/node_term_page_update.json',
      'expectations' => 'expectations/node/node_term_page_update.php',
    ],
  ];

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'system',
    'user',
    'node',
    'field',
    'depcalc',
    'acquia_contenthub',
    'acquia_contenthub_subscriber',
  ];

  /**
   * EntityCdfSerializer service.
   *
   * @var \Drupal\acquia_contenthub\EntityCdfSerializer
   */
  protected $serializer;

  /**
   * {@inheritdoc}
   *
   * @throws \Exception
   */
  protected function setUp() {
    parent::setUp();
    $this->installEntitySchema('user');
    $this->installSchema('user', ['users_data']);
    $this->installEntitySchema('node');
    $this->installSchema('node', ['node_access']);
    $this->installSchema('acquia_contenthub_subscriber', 'acquia_contenthub_subscriber_import_tracking');
  }

  /**
   * Tests Node entity create and update.
   *
   * @param int $delta
   *   Fixture delta.
   * @param int $update_delta
   *   "Update" fixture delta.
   * @param array $validate_data
   *   Data.
   * @param string $export_type
   *   Exported entity type.
   * @param string $export_uuid
   *   Entity UUID.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   *
   * @dataProvider nodeImportUpdateExportDataProvider
   */
  public function testNodeImportUpdateExport($delta, $update_delta, array $validate_data, $export_type, $export_uuid) {
    parent::contentEntityImportExport($delta, $validate_data, $export_type, $export_uuid);
    parent::contentEntityImportExport($update_delta, $validate_data, $export_type, $export_uuid);
  }

  /**
   * Data provider for testNodeImportUpdateExport.
   *
   * @return array
   *   Data provider for testNodeImportUpdateExport.
   */
  public function nodeImportUpdateExportDataProvider() {
    $export_uuid = [
      '5d1ba3c3-d527-4328-8fce-a6b714c5ef79',
      '40253012-2a03-47c1-86b8-87e4d0adf091',
    ];

    if (version_compare(\Drupal::VERSION, '8.8.0', '<')) {
      $export_uuid = [
        '38f023d8-b0d8-4e8c-9c06-8b547d8a0a85',
        '1264093e-bdad-41a7-a059-1904a5e6d8d6',
      ];
    }

    return [
      [
        0,
        1,
        [['type' => 'node', 'uuid' => $export_uuid[0]]],
        'node',
        $export_uuid[0],
      ],
      [
        2,
        3,
        [['type' => 'node', 'uuid' => $export_uuid[1]]],
        'node',
        $export_uuid[1],
      ],
    ];
  }

}
