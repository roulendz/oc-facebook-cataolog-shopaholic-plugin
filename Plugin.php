<?php namespace LoginGrupa\FacebookCatalogShopaholic;

use Event;
use System\Classes\PluginBase;

// Command
use LoginGrupa\FacebookCatalogShopaholic\Classes\Console\CatalogExportForYandexMarket;
use LoginGrupa\FacebookCatalogShopaholic\Classes\Console\CatalogExportForFacebookCatalog;
use LoginGrupa\FacebookCatalogShopaholic\Classes\Console\CatalogExportForKurPirktCatalog;
// Offer event
// use LoginGrupa\FacebookCatalogShopaholic\Classes\Event\Offer\ExtendOfferFieldsHandler;
// use LoginGrupa\FacebookCatalogShopaholic\Classes\Event\Offer\OfferModelHandler;
// Product event
// use LoginGrupa\FacebookCatalogShopaholic\Classes\Event\Product\ExtendProductFieldsHandler;
// use LoginGrupa\FacebookCatalogShopaholic\Classes\Event\Product\ProductModelHandler;

/**
 * Class Plugin
 *
 * @package LoginGrupa\FacebookCatalogShopaholic
 * @author  Sergey Zakharevich, s.zakharevich@lovata.com, LOVATA Group
 */
class Plugin extends PluginBase
{
    /** @var array Plugin dependencies */
    public $require = ['Lovata.Shopaholic', 'Lovata.Toolbox'];

    /**
     * Register settings
     * @return array
     */
    public function registerSettings()
    {
        return [
            'config'    => [
                'label'       => 'logingrupa.facebookcatalogshopaholic::lang.menu.settings',
                'description' => 'logingrupa.facebookcatalogshopaholic::lang.menu.settings_description',
                'category'    => 'lovata.shopaholic::lang.tab.settings',
                'icon'        => 'icon-upload',
                'class'       => 'LoginGrupa\FacebookCatalogShopaholic\Models\YandexMarketSettings',
                'permissions' => ['shopaholic-menu-yandex-market-export'],
                'order'       => 9000,
            ],
        ];
    }

    /**
     * Plugin boot method
     */
    public function boot()
    {
        // // Offer event
        // Event::subscribe(ExtendOfferFieldsHandler::class);
        // Event::subscribe(OfferModelHandler::class);
        // // Product event
        // Event::subscribe(ExtendProductFieldsHandler::class);
        // Event::subscribe(ProductModelHandler::class);
    }

    /**
     * Register artisan command
     */
    public function register()
    {
        $this->registerConsoleCommand('shopaholic:catalog_export.yandex_market', CatalogExportForYandexMarket::class);
        $this->registerConsoleCommand('shopaholic:catalog_export.facebook_catalog', CatalogExportForFacebookCatalog::class);
        $this->registerConsoleCommand('shopaholic:catalog_export.kurpirkt_catalog', CatalogExportForKurPirktCatalog::class);
        
    }

    /**
     * @return array
     */
    public function registerReportWidgets()
    {
        return [
            'LoginGrupa\FacebookCatalogShopaholic\Widgets\ExportToXML' => [
                'label' => 'logingrupa.facebookcatalogshopaholic::lang.widget.export_catalog_to_xml_for_yandex_market',
            ],
        ];
    }
}
