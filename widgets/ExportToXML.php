<?php namespace LoginGrupa\FacebookCatalogShopaholic\Widgets;

use Flash;
use Storage;
use Backend\Classes\ReportWidgetBase;
use LoginGrupa\FacebookCatalogShopaholic\Classes\Helper\ExportCatalogHelper;
use LoginGrupa\FacebookCatalogShopaholic\Classes\Helper\ExportCatalogFacebookHelper;
use LoginGrupa\FacebookCatalogShopaholic\Classes\Helper\GenerateXML;
use LoginGrupa\FacebookCatalogShopaholic\Classes\Helper\GenerateXMLForFacebookCatalog;

/**
 * Class ExportToXML
 *
 * @package LoginGrupa\FacebookCatalogShopaholic\Widgets
 * @author  Sergey Zakharevich, s.zakharevich@lovata.com, LOVATA Group
 */
class ExportToXML extends ReportWidgetBase
{
    /**
     * Render method
     * @return mixed|string
     * @throws \SystemException
     */
    public function render()
    {
        // $this->vars['sFileUrl'] = $this->getFileUrl();

        return $this->makePartial('widget');
    }

    /**
     * Generate xml for yandex market
     */
    public function onGenerateXMLFileYandexMarket()
    {
        $obDataCollection = new ExportCatalogHelper();
        $obDataCollection->run();
        // \Artisan::call('shopaholic:catalog_export.yandex_market');
        Flash::info(trans('logingrupa.facebookcatalogshopaholic::lang.message.export_is_completed', [ 'name' => 'Yandex.Market' ]));

        $this->vars['sFileUrl'] = url('/').'/storage/'.GenerateXML::getFilePath();
    }

    /**
     * Generate xml for yandex market
     */
    public function onGenerateXMLFileFacebookCatalog()
    {
        $obDataCollection = new ExportCatalogFacebookHelper();
        $obDataCollection->run();
        // \Artisan::call('shopaholic:catalog_export.facebook_catalog');
        Flash::info(trans('logingrupa.facebookcatalogshopaholic::lang.message.export_is_completed', [ 'name' => 'Facebook.Catalog' ]));

        $this->vars['sFileUrl'] = url('/').'/storage/'.GenerateXMLForFacebookCatalog::getFilePath();
    }

    /**
     * Get fie url
     *
     * @return string
     */
    // protected function getFileUrl()
    // {
    //     $sFilePath = GenerateXML::getFilePath();
    //     $sFullFilePath = storage_path($sFilePath);
    //     if (!file_exists($sFullFilePath)) {
    //         return null;
    //     }

    //     $sStorageFilePath = url('/').'/storage/'.$sFilePath;

    //     return $sStorageFilePath;
    // }
}
