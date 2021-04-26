<?php

/**
 * @file
 * Expectation for view configuration entity translation scenario.
 */

use Drupal\Core\Entity\EntityInterface;
use Drupal\Tests\acquia_contenthub\Kernel\Stubs\CdfExpectations;

$data = [
  'langcode' => 'en',
  'status' => TRUE,
  'dependencies' =>
    [
      'module' =>
        [
          0 => 'node',
          1 => 'user',
        ],
    ],
  'id' => 'content',
  'label' => 'Content',
  'module' => 'node',
  'description' => 'Find and manage content.',
  'tag' => 'default',
  'base_table' => 'node_field_data',
  'base_field' => 'nid',
  'display' =>
    [
      'default' =>
        [
          'display_options' =>
            [
              'access' =>
                [
                  'type' => 'perm',
                  'options' =>
                    [
                      'perm' => 'access content overview',
                    ],
                ],
              'cache' =>
                [
                  'type' => 'tag',
                ],
              'query' =>
                [
                  'type' => 'views_query',
                ],
              'exposed_form' =>
                [
                  'type' => 'basic',
                  'options' =>
                    [
                      'submit_button' => 'Filter',
                      'reset_button' => TRUE,
                      'reset_button_label' => 'Reset',
                      'exposed_sorts_label' => 'Sort by',
                      'expose_sort_order' => TRUE,
                      'sort_asc_label' => 'Asc',
                      'sort_desc_label' => 'Desc',
                    ],
                ],
              'pager' =>
                [
                  'type' => 'full',
                  'options' =>
                    [
                      'items_per_page' => 50,
                      'tags' =>
                        [
                          'previous' => '‹ Previous',
                          'next' => 'Next ›',
                          'first' => '« First',
                          'last' => 'Last »',
                        ],
                    ],
                ],
              'style' =>
                [
                  'type' => 'table',
                  'options' =>
                    [
                      'grouping' =>
                        [],
                      'row_class' => '',
                      'default_row_class' => TRUE,
                      'override' => TRUE,
                      'sticky' => TRUE,
                      'caption' => '',
                      'summary' => '',
                      'description' => '',
                      'columns' =>
                        [
                          'node_bulk_form' => 'node_bulk_form',
                          'title' => 'title',
                          'type' => 'type',
                          'name' => 'name',
                          'status' => 'status',
                          'changed' => 'changed',
                          'edit_node' => 'edit_node',
                          'delete_node' => 'delete_node',
                          'dropbutton' => 'dropbutton',
                          'timestamp' => 'title',
                        ],
                      'info' =>
                        [
                          'node_bulk_form' =>
                            [
                              'align' => '',
                              'separator' => '',
                              'empty_column' => FALSE,
                              'responsive' => '',
                            ],
                          'title' =>
                            [
                              'sortable' => TRUE,
                              'default_sort_order' => 'asc',
                              'align' => '',
                              'separator' => '',
                              'empty_column' => FALSE,
                              'responsive' => '',
                            ],
                          'type' =>
                            [
                              'sortable' => TRUE,
                              'default_sort_order' => 'asc',
                              'align' => '',
                              'separator' => '',
                              'empty_column' => FALSE,
                              'responsive' => '',
                            ],
                          'name' =>
                            [
                              'sortable' => FALSE,
                              'default_sort_order' => 'asc',
                              'align' => '',
                              'separator' => '',
                              'empty_column' => FALSE,
                              'responsive' => 'priority-low',
                            ],
                          'status' =>
                            [
                              'sortable' => TRUE,
                              'default_sort_order' => 'asc',
                              'align' => '',
                              'separator' => '',
                              'empty_column' => FALSE,
                              'responsive' => '',
                            ],
                          'changed' =>
                            [
                              'sortable' => TRUE,
                              'default_sort_order' => 'desc',
                              'align' => '',
                              'separator' => '',
                              'empty_column' => FALSE,
                              'responsive' => 'priority-low',
                            ],
                          'edit_node' =>
                            [
                              'sortable' => FALSE,
                              'default_sort_order' => 'asc',
                              'align' => '',
                              'separator' => '',
                              'empty_column' => FALSE,
                              'responsive' => '',
                            ],
                          'delete_node' =>
                            [
                              'sortable' => FALSE,
                              'default_sort_order' => 'asc',
                              'align' => '',
                              'separator' => '',
                              'empty_column' => FALSE,
                              'responsive' => '',
                            ],
                          'dropbutton' =>
                            [
                              'sortable' => FALSE,
                              'default_sort_order' => 'asc',
                              'align' => '',
                              'separator' => '',
                              'empty_column' => FALSE,
                              'responsive' => '',
                            ],
                          'timestamp' =>
                            [
                              'sortable' => FALSE,
                              'default_sort_order' => 'asc',
                              'align' => '',
                              'separator' => '',
                              'empty_column' => FALSE,
                              'responsive' => '',
                            ],
                        ],
                      'default' => 'changed',
                      'empty_table' => TRUE,
                    ],
                ],
              'row' =>
                [
                  'type' => 'fields',
                ],
              'fields' =>
                [
                  'node_bulk_form' =>
                    [
                      'id' => 'node_bulk_form',
                      'table' => 'node',
                      'field' => 'node_bulk_form',
                      'label' => '',
                      'exclude' => FALSE,
                      'alter' =>
                        [
                          'alter_text' => FALSE,
                        ],
                      'element_class' => '',
                      'element_default_classes' => TRUE,
                      'empty' => '',
                      'hide_empty' => FALSE,
                      'empty_zero' => FALSE,
                      'hide_alter_empty' => TRUE,
                      'plugin_id' => 'node_bulk_form',
                      'entity_type' => 'node',
                    ],
                  'title' =>
                    [
                      'id' => 'title',
                      'table' => 'node_field_data',
                      'field' => 'title',
                      'label' => 'Title',
                      'exclude' => FALSE,
                      'alter' =>
                        [
                          'alter_text' => FALSE,
                        ],
                      'element_class' => '',
                      'element_default_classes' => TRUE,
                      'empty' => '',
                      'hide_empty' => FALSE,
                      'empty_zero' => FALSE,
                      'hide_alter_empty' => TRUE,
                      'entity_type' => 'node',
                      'entity_field' => 'title',
                      'type' => 'string',
                      'settings' =>
                        [
                          'link_to_entity' => TRUE,
                        ],
                      'plugin_id' => 'field',
                    ],
                  'type' =>
                    [
                      'id' => 'type',
                      'table' => 'node_field_data',
                      'field' => 'type',
                      'relationship' => 'none',
                      'group_type' => 'group',
                      'admin_label' => '',
                      'label' => 'Content type',
                      'exclude' => FALSE,
                      'alter' =>
                        [
                          'alter_text' => FALSE,
                          'text' => '',
                          'make_link' => FALSE,
                          'path' => '',
                          'absolute' => FALSE,
                          'external' => FALSE,
                          'replace_spaces' => FALSE,
                          'path_case' => 'none',
                          'trim_whitespace' => FALSE,
                          'alt' => '',
                          'rel' => '',
                          'link_class' => '',
                          'prefix' => '',
                          'suffix' => '',
                          'target' => '',
                          'nl2br' => FALSE,
                          'max_length' => 0,
                          'word_boundary' => TRUE,
                          'ellipsis' => TRUE,
                          'more_link' => FALSE,
                          'more_link_text' => '',
                          'more_link_path' => '',
                          'strip_tags' => FALSE,
                          'trim' => FALSE,
                          'preserve_tags' => '',
                          'html' => FALSE,
                        ],
                      'element_type' => '',
                      'element_class' => '',
                      'element_label_type' => '',
                      'element_label_class' => '',
                      'element_label_colon' => TRUE,
                      'element_wrapper_type' => '',
                      'element_wrapper_class' => '',
                      'element_default_classes' => TRUE,
                      'empty' => '',
                      'hide_empty' => FALSE,
                      'empty_zero' => FALSE,
                      'hide_alter_empty' => TRUE,
                      'click_sort_column' => 'target_id',
                      'type' => 'entity_reference_label',
                      'settings' =>
                        [
                          'link' => FALSE,
                        ],
                      'group_column' => 'target_id',
                      'group_columns' =>
                        [],
                      'group_rows' => TRUE,
                      'delta_limit' => 0,
                      'delta_offset' => 0,
                      'delta_reversed' => FALSE,
                      'delta_first_last' => FALSE,
                      'multi_type' => 'separator',
                      'separator' => ', ',
                      'field_api_classes' => FALSE,
                      'entity_type' => 'node',
                      'entity_field' => 'type',
                      'plugin_id' => 'field',
                    ],
                  'name' =>
                    [
                      'id' => 'name',
                      'table' => 'users_field_data',
                      'field' => 'name',
                      'relationship' => 'uid',
                      'label' => 'Author',
                      'exclude' => FALSE,
                      'alter' =>
                        [
                          'alter_text' => FALSE,
                        ],
                      'element_class' => '',
                      'element_default_classes' => TRUE,
                      'empty' => '',
                      'hide_empty' => FALSE,
                      'empty_zero' => FALSE,
                      'hide_alter_empty' => TRUE,
                      'plugin_id' => 'field',
                      'type' => 'user_name',
                      'entity_type' => 'user',
                      'entity_field' => 'name',
                    ],
                  'status' =>
                    [
                      'id' => 'status',
                      'table' => 'node_field_data',
                      'field' => 'status',
                      'label' => 'Status',
                      'exclude' => FALSE,
                      'alter' =>
                        [
                          'alter_text' => FALSE,
                        ],
                      'element_class' => '',
                      'element_default_classes' => TRUE,
                      'empty' => '',
                      'hide_empty' => FALSE,
                      'empty_zero' => FALSE,
                      'hide_alter_empty' => TRUE,
                      'type' => 'boolean',
                      'settings' =>
                        [
                          'format' => 'custom',
                          'format_custom_true' => 'Published',
                          'format_custom_false' => 'Unpublished',
                        ],
                      'plugin_id' => 'field',
                      'entity_type' => 'node',
                      'entity_field' => 'status',
                    ],
                  'changed' =>
                    [
                      'id' => 'changed',
                      'table' => 'node_field_data',
                      'field' => 'changed',
                      'label' => 'Updated',
                      'exclude' => FALSE,
                      'alter' =>
                        [
                          'alter_text' => FALSE,
                        ],
                      'element_class' => '',
                      'element_default_classes' => TRUE,
                      'empty' => '',
                      'hide_empty' => FALSE,
                      'empty_zero' => FALSE,
                      'hide_alter_empty' => TRUE,
                      'type' => 'timestamp',
                      'settings' =>
                        [
                          'date_format' => 'short',
                          'custom_date_format' => '',
                          'timezone' => '',
                        ],
                      'plugin_id' => 'field',
                      'entity_type' => 'node',
                      'entity_field' => 'changed',
                    ],
                  'operations' =>
                    [
                      'id' => 'operations',
                      'table' => 'node',
                      'field' => 'operations',
                      'relationship' => 'none',
                      'group_type' => 'group',
                      'admin_label' => '',
                      'label' => 'Operations',
                      'exclude' => FALSE,
                      'alter' =>
                        [
                          'alter_text' => FALSE,
                          'text' => '',
                          'make_link' => FALSE,
                          'path' => '',
                          'absolute' => FALSE,
                          'external' => FALSE,
                          'replace_spaces' => FALSE,
                          'path_case' => 'none',
                          'trim_whitespace' => FALSE,
                          'alt' => '',
                          'rel' => '',
                          'link_class' => '',
                          'prefix' => '',
                          'suffix' => '',
                          'target' => '',
                          'nl2br' => FALSE,
                          'max_length' => 0,
                          'word_boundary' => TRUE,
                          'ellipsis' => TRUE,
                          'more_link' => FALSE,
                          'more_link_text' => '',
                          'more_link_path' => '',
                          'strip_tags' => FALSE,
                          'trim' => FALSE,
                          'preserve_tags' => '',
                          'html' => FALSE,
                        ],
                      'element_type' => '',
                      'element_class' => '',
                      'element_label_type' => '',
                      'element_label_class' => '',
                      'element_label_colon' => TRUE,
                      'element_wrapper_type' => '',
                      'element_wrapper_class' => '',
                      'element_default_classes' => TRUE,
                      'empty' => '',
                      'hide_empty' => FALSE,
                      'empty_zero' => FALSE,
                      'hide_alter_empty' => TRUE,
                      'destination' => TRUE,
                      'plugin_id' => 'entity_operations',
                    ],
                ],
              'filters' =>
                [
                  'title' =>
                    [
                      'id' => 'title',
                      'table' => 'node_field_data',
                      'field' => 'title',
                      'relationship' => 'none',
                      'group_type' => 'group',
                      'admin_label' => '',
                      'operator' => 'contains',
                      'value' => '',
                      'group' => 1,
                      'exposed' => TRUE,
                      'expose' =>
                        [
                          'operator_id' => 'title_op',
                          'label' => 'Title',
                          'description' => '',
                          'use_operator' => FALSE,
                          'operator' => 'title_op',
                          'identifier' => 'title',
                          'required' => FALSE,
                          'remember' => FALSE,
                          'multiple' => FALSE,
                          'remember_roles' =>
                            [
                              'authenticated' => 'authenticated',
                              'anonymous' => '0',
                              'administrator' => '0',
                            ],
                          'operator_limit_selection' => FALSE,
                          'operator_list' =>
                            [],
                        ],
                      'is_grouped' => FALSE,
                      'group_info' =>
                        [
                          'label' => '',
                          'description' => '',
                          'identifier' => '',
                          'optional' => TRUE,
                          'widget' => 'select',
                          'multiple' => FALSE,
                          'remember' => FALSE,
                          'default_group' => 'All',
                          'default_group_multiple' =>
                            [],
                          'group_items' =>
                            [],
                        ],
                      'plugin_id' => 'string',
                      'entity_type' => 'node',
                      'entity_field' => 'title',
                    ],
                  'type' =>
                    [
                      'id' => 'type',
                      'table' => 'node_field_data',
                      'field' => 'type',
                      'relationship' => 'none',
                      'group_type' => 'group',
                      'admin_label' => '',
                      'operator' => 'in',
                      'value' =>
                        [],
                      'group' => 1,
                      'exposed' => TRUE,
                      'expose' =>
                        [
                          'operator_id' => 'type_op',
                          'label' => 'Content type',
                          'description' => '',
                          'use_operator' => FALSE,
                          'operator' => 'type_op',
                          'identifier' => 'type',
                          'required' => FALSE,
                          'remember' => FALSE,
                          'multiple' => FALSE,
                          'remember_roles' =>
                            [
                              'authenticated' => 'authenticated',
                              'anonymous' => '0',
                              'administrator' => '0',
                            ],
                          'reduce' => FALSE,
                          'operator_limit_selection' => FALSE,
                          'operator_list' =>
                            [],
                        ],
                      'is_grouped' => FALSE,
                      'group_info' =>
                        [
                          'label' => '',
                          'description' => '',
                          'identifier' => '',
                          'optional' => TRUE,
                          'widget' => 'select',
                          'multiple' => FALSE,
                          'remember' => FALSE,
                          'default_group' => 'All',
                          'default_group_multiple' =>
                            [],
                          'group_items' =>
                            [],
                        ],
                      'plugin_id' => 'bundle',
                      'entity_type' => 'node',
                      'entity_field' => 'type',
                    ],
                  'status' =>
                    [
                      'id' => 'status',
                      'table' => 'node_field_data',
                      'field' => 'status',
                      'relationship' => 'none',
                      'group_type' => 'group',
                      'admin_label' => '',
                      'operator' => '=',
                      'value' => '1',
                      'group' => 1,
                      'exposed' => TRUE,
                      'expose' =>
                        [
                          'operator_id' => '',
                          'label' => 'Status',
                          'description' => '',
                          'use_operator' => FALSE,
                          'operator' => 'status_op',
                          'identifier' => 'status',
                          'required' => FALSE,
                          'remember' => FALSE,
                          'multiple' => FALSE,
                          'remember_roles' =>
                            [
                              'authenticated' => 'authenticated',
                            ],
                          'operator_limit_selection' => FALSE,
                          'operator_list' =>
                            [],
                        ],
                      'is_grouped' => TRUE,
                      'group_info' =>
                        [
                          'label' => 'Published status',
                          'description' => '',
                          'identifier' => 'status',
                          'optional' => TRUE,
                          'widget' => 'select',
                          'multiple' => FALSE,
                          'remember' => FALSE,
                          'default_group' => 'All',
                          'default_group_multiple' =>
                            [],
                          'group_items' =>
                            [
                              1 =>
                                [
                                  'title' => 'Published',
                                  'operator' => '=',
                                  'value' => '1',
                                ],
                              2 =>
                                [
                                  'title' => 'Unpublished',
                                  'operator' => '=',
                                  'value' => '0',
                                ],
                            ],
                        ],
                      'plugin_id' => 'boolean',
                      'entity_type' => 'node',
                      'entity_field' => 'status',
                    ],
                  'langcode' =>
                    [
                      'id' => 'langcode',
                      'table' => 'node_field_data',
                      'field' => 'langcode',
                      'relationship' => 'none',
                      'group_type' => 'group',
                      'admin_label' => '',
                      'operator' => 'in',
                      'value' =>
                        [],
                      'group' => 1,
                      'exposed' => TRUE,
                      'expose' =>
                        [
                          'operator_id' => 'langcode_op',
                          'label' => 'Language',
                          'description' => '',
                          'use_operator' => FALSE,
                          'operator' => 'langcode_op',
                          'identifier' => 'langcode',
                          'required' => FALSE,
                          'remember' => FALSE,
                          'multiple' => FALSE,
                          'remember_roles' =>
                            [
                              'authenticated' => 'authenticated',
                              'anonymous' => '0',
                              'administrator' => '0',
                            ],
                          'reduce' => FALSE,
                          'operator_limit_selection' => FALSE,
                          'operator_list' =>
                            [],
                        ],
                      'is_grouped' => FALSE,
                      'group_info' =>
                        [
                          'label' => '',
                          'description' => '',
                          'identifier' => '',
                          'optional' => TRUE,
                          'widget' => 'select',
                          'multiple' => FALSE,
                          'remember' => FALSE,
                          'default_group' => 'All',
                          'default_group_multiple' =>
                            [],
                          'group_items' =>
                            [],
                        ],
                      'plugin_id' => 'language',
                      'entity_type' => 'node',
                      'entity_field' => 'langcode',
                    ],
                  'status_extra' =>
                    [
                      'id' => 'status_extra',
                      'table' => 'node_field_data',
                      'field' => 'status_extra',
                      'operator' => '=',
                      'value' => FALSE,
                      'plugin_id' => 'node_status',
                      'group' => 1,
                      'entity_type' => 'node',
                      'expose' =>
                        [
                          'operator_limit_selection' => FALSE,
                          'operator_list' =>
                            [],
                        ],
                    ],
                ],
              'sorts' =>
                [],
              'title' => 'Content',
              'empty' =>
                [
                  'area_text_custom' =>
                    [
                      'id' => 'area_text_custom',
                      'table' => 'views',
                      'field' => 'area_text_custom',
                      'empty' => TRUE,
                      'content' => 'No content available.',
                      'plugin_id' => 'text_custom',
                    ],
                ],
              'arguments' =>
                [],
              'relationships' =>
                [
                  'uid' =>
                    [
                      'id' => 'uid',
                      'table' => 'node_field_data',
                      'field' => 'uid',
                      'admin_label' => 'author',
                      'required' => TRUE,
                      'plugin_id' => 'standard',
                    ],
                ],
              'show_admin_links' => FALSE,
              'filter_groups' =>
                [
                  'operator' => 'AND',
                  'groups' =>
                    [
                      1 => 'AND',
                    ],
                ],
              'display_extenders' =>
                [],
            ],
          'display_plugin' => 'default',
          'display_title' => 'Master',
          'id' => 'default',
          'position' => 0,
          'cache_metadata' =>
            [
              'contexts' =>
                [
                  0 => 'languages:language_content',
                  1 => 'languages:language_interface',
                  2 => 'url',
                  3 => 'url.query_args',
                  4 => 'user',
                  5 => 'user.node_grants:view',
                  6 => 'user.permissions',
                ],
              'max-age' => 0,
              'tags' =>
                [],
            ],
        ],
      'page_1' =>
        [
          'display_options' =>
            [
              'path' => 'admin/content/node',
              'menu' =>
                [
                  'type' => 'default tab',
                  'title' => 'Content',
                  'description' => '',
                  'menu_name' => 'admin',
                  'weight' => -10,
                  'context' => '',
                ],
              'tab_options' =>
                [
                  'type' => 'normal',
                  'title' => 'Content',
                  'description' => 'Find and manage content',
                  'menu_name' => 'admin',
                  'weight' => -10,
                ],
              'display_extenders' =>
                [],
            ],
          'display_plugin' => 'page',
          'display_title' => 'Page',
          'id' => 'page_1',
          'position' => 1,
          'cache_metadata' =>
            [
              'contexts' =>
                [
                  0 => 'languages:language_content',
                  1 => 'languages:language_interface',
                  2 => 'url',
                  3 => 'url.query_args',
                  4 => 'user',
                  5 => 'user.node_grants:view',
                  6 => 'user.permissions',
                ],
              'max-age' => 0,
              'tags' =>
                [],
            ],
        ],
    ],
];

$expectation = new CdfExpectations($data);
$expectation->setEntityLoader('acquia_contenthub_test_view_config_load');

function acquia_contenthub_test_view_config_load(): EntityInterface {
  return \Drupal::service('entity_type.manager')
    ->getStorage('view')
    ->load('content');
}

return [
  '0204f032-73dd-4d0f-83df-019631d86563' => $expectation,
];
