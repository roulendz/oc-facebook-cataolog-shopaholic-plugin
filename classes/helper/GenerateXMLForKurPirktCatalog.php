<?php namespace LoginGrupa\FacebookCatalogShopaholic\Classes\Helper;

use File;
use XMLWriter;
use October\Rain\Argon\Argon;

/**
 * Class GenerateXMLForKurPirktCatalog
 *
 * @package LoginGrupa\FacebookCatalogShopaholic\Classes\Helper
 * @author  Sergey Zakharevich, s.zakharevich@lovata.com, LOVATA Group
 */
class GenerateXMLForKurPirktCatalog
{
    const FILE_NAME = 'kurpirkt_catalog.xml';
    const DEFAULT_DIRECTORY = 'app/media/';

    /**
     * @var array
     */
    protected $arShopData = [];

    /**
     * @var array
     */
    protected $arOffersData = [];

    /**
     * Generated content
     */
    protected $sContent;

    /**
     * @var XMLWriter
     */
    protected $obXMLWriter;

    /**
     * Get path to file relative to storage folder
     * @return string
     */
    public static function getFilePath()
    {
        $sResult = self::DEFAULT_DIRECTORY.self::FILE_NAME;

        return $sResult;
    }

    /**
     * Generate
     *
     * @param array $arData
     */
    public function generate($arData)
    {
        $this->arShopData   = (array) array_get($arData, 'shop', []);
        $this->arOffersData = (array) array_get($arData, 'offers', []);
        if (empty($this->arShopData) || empty($this->arOffersData)) {
            return;
        }

        $this->start();
        $this->setContent();
        $this->stop();

        $this->save();
    }

    /**
     * Start xml content generation
     */
    protected function start()
    {
        $this->obXMLWriter = new XMLWriter();
        $this->obXMLWriter->openMemory();
        $this->obXMLWriter->setIndent(1);
        $this->obXMLWriter->startDocument('1.0', 'UTF-8');
        // $this->obXMLWriter->startElement('rss');
        // $this->obXMLWriter->writeAttribute('version', '2.0');
        // $this->obXMLWriter->writeAttribute('xmlns:g', 'http://base.google.com/ns/1.0');
        // $this->obXMLWriter->writeAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom');
    }

    /**
     * Set content
     */
    protected function setContent()
    {
        // <shop>
        $this->obXMLWriter->startElement('root');
        $this->setShopElement();
        $this->setOffersElement();
        // </shop>
        $this->obXMLWriter->endElement();
    }

    /**
     * Set shop element
     */
    protected function setShopElement()
    {
        $this->obXMLWriter->writeElement('date', Argon::now()->format('Y-m-d h:i:s'));        
    }

    /**
     * Set offers element
     */
    protected function setOffersElement()
    {
        // <offers>
        // $this->obXMLWriter->startElement('offers');
        foreach ($this->arOffersData as $arOffer) {
            $this->setOfferElement($arOffer);
        }
        // </offers>
        $this->obXMLWriter->endElement();
    }

    /**
     * Set offer element
     *
     * @param array $arOffer
     */
    protected function setOfferElement($arOffer)
    {
        // $fOldPrice       = array_get($arOffer, 'old_price');
        $fManualOldPrice = array_get($arOffer, 'manual_sales_price');
        // $variation       = array_get($arOffer, 'color');
        // $sBrandName      = array_get($arOffer, 'brand_name');
        $arImageList     = array_get($arOffer, 'images', []);
        // $arPropertyList  = array_get($arOffer, 'properties', []);

        // <item>
        $this->obXMLWriter->startElement('item');
        // $this->obXMLWriter->writeAttribute('id', array_get($arOffer, 'id'));
        // $this->obXMLWriter->writeAttribute('bid', array_get($arOffer, 'rate'));
        // </g:id>
        // if (array_get($arOffer, 'offerCount') > 1) {
        //     $this->obXMLWriter->writeElement('g:item_group_id', array_get($arOffer, 'productId'));
        // }
        // $this->obXMLWriter->writeElement('g:id', array_get($arOffer, 'offerId'));
        // </g:id>

        // <g:title>
        $this->obXMLWriter->writeElement('name', array_get($arOffer, 'name'));
        // </g:title>

        // <link>
        $this->obXMLWriter->writeElement('link', array_get($arOffer, 'url'));
        // </link>
        // <price>
        $this->obXMLWriter->writeElement('price', array_get($arOffer, 'price') . ' ' . array_get($arOffer, 'currency_id'));
        // </price>
        // <image>
        $this->obXMLWriter->writeElement('image', !is_null(array_get($arOffer, 'offerImage')) ? array_get($arOffer, 'offerImage') : array_get($arOffer, 'productImage'));
        // </image>
        // <manufacturer>
        $this->obXMLWriter->writeElement('manufacturer', 'NAI_S cosmetics');
        // </manufacturer>
        // <category>
        $this->obXMLWriter->writeElement('category', 'Manikīra piederumi');
        // </category>

        // <category_full>
        $this->obXMLWriter->writeElement('category_full', 'Manikīra piederumi > Gēllakas');
        // </category_full>

        // <category_link>
        $this->obXMLWriter->writeElement('category_link', 'https://naiscosmetics.lv/lv/manikirspedikirs');
        // </category_link>
        
        // <in_stock>
        $this->obXMLWriter->writeElement('in_stock', array_get($arOffer, 'inventory'));
        // </in_stock>

        // <used>
        $this->obXMLWriter->writeElement('used', '0');
        // </used>

        // <delivery_cost_riga>
        $this->obXMLWriter->writeElement('delivery_cost_riga', '2.34');
        // </delivery_cost_riga>

        
      
        // </item>
        $this->obXMLWriter->endElement();
    }

    /**
     * End xml content generation
     */
    protected function stop()
    {
        $this->obXMLWriter->endElement();
        $this->obXMLWriter->endDocument();
        $this->sContent = $this->obXMLWriter->outputMemory();
    }

    /**
     * Save generated content
     */
    protected function save()
    {
        $sMediaPath = self::getFilePath();
        $sFilePath = storage_path($sMediaPath);

        if (file_exists($sFilePath)) {
            unlink($sFilePath);
        }

        File::put($sFilePath, $this->sContent);
    }
}
