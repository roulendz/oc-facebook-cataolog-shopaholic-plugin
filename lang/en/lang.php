<?php return [
    'plugin'     => [
        'name'        => 'Export catalog for Facebook.Catalog',
        'description' => 'Generation XML file for integration with Facebook.Catalog',
    ],
    'menu'       => [
        'settings'             => 'Export to Facebook.Catalog',
        'settings_description' => 'Configure Export to Facebook.Catalog',
    ],
    'field'      => [
        'short_store_name'                           => 'Short store name',
        'short_store_name_placeholder'               => 'BestSeller',
        'full_company_name'                          => 'Full company name',
        'full_company_name_placeholder'              => 'Tne Best inc.',
        'store_homepage_url'                         => 'Store homepage URL',
        'store_homepage_url_placeholder'             => 'http://best.seller.ru',
        'agency'                                     => 'Name of agency that provides store technical support',
        'agency_placeholder'                         => 'Shopaholic team',
        'email_agency'                               => 'Email address of technical support agency',
        'email_agency_placeholder'                   => 'info@shopaholic.one',
        'use_main_currency_only'                     => 'Use only main currency',
        'default_currency_rates'                     => 'Use default currency rates',
        'currency_rates'                             => 'Currency rates',
        'offers_rate'                                => 'Offers rate (bid)',
        'field_enable_auto_discounts'                => 'Automatic calculation of discounts',
        'code_model_for_images'                      => 'Get images from:',
        'section_management_additional_fields_offer' => 'Additional fields',
        'section_yandex_market'                      => 'Facebook.Catalog',
    ],
    'button'     => [
        'export_catalog_to_xml' => 'Run :name export',
        'download'              => 'Download :name',
    ],
    'widget'     => [
        'export_catalog_to_xml_for_yandex_market' => 'Export to Facebook.Catalog',
    ],
    'permission' => [
        'yandexmarketsettings' => 'Manage settings of catalog export to Facebook.Catalog',
    ],
    'message'    => [
        'export_is_completed'           => ':name Export completed',
        'update_catalog_to_xml_confirm' => 'Run export :name  catalog to XML file?',
    ],
];
