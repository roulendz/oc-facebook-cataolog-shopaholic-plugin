<?php namespace LoginGrupa\FacebookCatalogShopaholic\Classes\Console;

use Illuminate\Console\Command;
use LoginGrupa\FacebookCatalogShopaholic\Classes\Helper\ExportCatalogFacebookHelper;

/**
 * Class CatalogExportForYandexMarket
 *
 * @package LoginGrupa\FacebookCatalogShopaholic\Classes\Console
 * @author  Sergey Zakharevich, s.zakharevich@lovata.com, LOVATA Group
 */
class CatalogExportForFacebookCatalog extends Command
{
    /**
     * @var string command name.
     */
    protected $name = 'shopaholic:catalog_export.facebook_catalog';

    /**
     * @var string The console command description.
     */
    protected $description = 'Generate xml file for Facebook.Catalog in sites default language';

    /**
     * Execute the console command.
     * @throws \Throwable
     */
    public function handle()
    {
        $obDataCollection = new ExportCatalogFacebookHelper();
        $obDataCollection->run();
    }
}
