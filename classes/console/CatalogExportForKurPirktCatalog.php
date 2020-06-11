<?php namespace LoginGrupa\FacebookCatalogShopaholic\Classes\Console;

use Illuminate\Console\Command;
use LoginGrupa\FacebookCatalogShopaholic\Classes\Helper\ExportCatalogKurPirktHelper;

/**
 * Class CatalogExportForYandexMarket
 *
 * @package LoginGrupa\FacebookCatalogShopaholic\Classes\Console
 * @author  Sergey Zakharevich, s.zakharevich@lovata.com, LOVATA Group
 */
class CatalogExportForKurPirktCatalog extends Command
{
    /**
     * @var string command name.
     */
    protected $name = 'shopaholic:catalog_export.kurpirkt_catalog';

    /**
     * @var string The console command description.
     */
    protected $description = 'Generate xml file for KurPirkt.Catalog in sites default language';

    /**
     * Execute the console command.
     * @throws \Throwable
     */
    public function handle()
    {
        $obDataCollection = new ExportCatalogKurPirktHelper();
        $obDataCollection->run();
    }
}
