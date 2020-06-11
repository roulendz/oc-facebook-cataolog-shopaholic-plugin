<?php namespace LoginGrupa\FacebookCatalogShopaholic\Classes\Helper;

use File;
use XMLWriter;
use October\Rain\Argon\Argon;

/**
 * Class GenerateXMLForFacebookCatalog
 *
 * @package LoginGrupa\FacebookCatalogShopaholic\Classes\Helper
 * @author  Sergey Zakharevich, s.zakharevich@lovata.com, LOVATA Group
 */
class GenerateXMLForFacebookCatalog
{
    const FILE_NAME = 'facebook_catalog.xml';
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
        $this->obXMLWriter->startElement('rss');
        $this->obXMLWriter->writeAttribute('version', '2.0');
        $this->obXMLWriter->writeAttribute('xmlns:g', 'http://base.google.com/ns/1.0');
        $this->obXMLWriter->writeAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom');
    }

    /**
     * Set content
     */
    protected function setContent()
    {
        // <shop>
        $this->obXMLWriter->startElement('channel');
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
        // $arCurrencyList = array_get($this->arShopData, 'currencies', []);
        // $arCategoryList = array_get($this->arShopData, 'categories', []);

        $this->obXMLWriter->writeElement('atom:link', array_get($this->arShopData, 'name'));
        $this->obXMLWriter->writeAttribute('href', url("/").'/storage/app/media/yandex_market.xml');
        $this->obXMLWriter->writeAttribute('rel', 'self');
        $this->obXMLWriter->writeAttribute('type', 'application/rss+xml');
        $this->obXMLWriter->writeElement('date', Argon::now()->format('Y-m-d h:i:s'));
        // <title>
        $this->obXMLWriter->writeElement('title', array_get($this->arShopData, 'name'));
        // </title>
        // <company>
        // $this->obXMLWriter->writeElement('company', array_get($this->arShopData, 'company'));
        // </company>
        // <link>
        $this->obXMLWriter->writeElement('link', array_get($this->arShopData, 'url'));
        // </link>
        // <platform>
        // $this->obXMLWriter->writeElement('platform', array_get($this->arShopData, 'platform'));
        // </platform>
        // <description>
        $this->obXMLWriter->writeElement('description', array_get($this->arShopData, 'agency'));
        // </description>
        // <email_agency>
        // $this->obXMLWriter->writeElement('email', array_get($this->arShopData, 'email_agency'));
        // </email_agency>

        // if (!empty($arCurrencyList)) {
        //     // <currencies>
        //     $this->obXMLWriter->startElement('currencies');
        //     // </currencies>
        //     foreach ($arCurrencyList as $arCurrency) {
        //         // <currency id='' rate=''>
        //         $this->obXMLWriter->startElement('currency');
        //         $this->obXMLWriter->writeAttribute('id', array_get($arCurrency, 'id'));
        //         $this->obXMLWriter->writeAttribute('rate', array_get($arCurrency, 'rate'));
        //         $this->obXMLWriter->endElement();
        //         // </currency>
        //     }
        //     // </currencies>
        //     $this->obXMLWriter->endElement();
        // }

        // if (!empty($arCategoryList)) {
        //     // <categories>
        //     $this->obXMLWriter->startElement('categories');
        //     foreach ($arCategoryList as $arCategory) {
        //         $iParentId = array_get($arCategory, 'parent_id');
        //         // <category id='' parentId=''>
        //         $this->obXMLWriter->startElement('category');
        //         $this->obXMLWriter->writeAttribute('id', array_get($arCategory, 'id'));
        //         if (!empty($iParentId)) {
        //             $this->obXMLWriter->writeAttribute('parentId', array_get($arCategory, 'parent_id'));
        //         }
        //         $this->obXMLWriter->text(array_get($arCategory, 'name'));
        //         $this->obXMLWriter->endElement();
        //         // </category>
        //     }
        //     // </categories>
        //     $this->obXMLWriter->endElement();
        // }
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

        // <offer id='' bid=''>
        $this->obXMLWriter->startElement('item');
        // $this->obXMLWriter->writeAttribute('id', array_get($arOffer, 'id'));
        // $this->obXMLWriter->writeAttribute('bid', array_get($arOffer, 'rate'));
        // </g:id>
        if (array_get($arOffer, 'offerCount') > 1) {
            $this->obXMLWriter->writeElement('g:item_group_id', array_get($arOffer, 'productId'));
        }
        $this->obXMLWriter->writeElement('g:id', array_get($arOffer, 'offerId'));
        // </g:id>

        // <g:title>
        $this->obXMLWriter->writeElement('g:title', array_get($arOffer, 'name'));
        // </g:title>

        // <g:description>
        $this->obXMLWriter->writeElement('g:description', array_get($arOffer, 'description'));
        // </g:description>

        // <g:link>
        $this->obXMLWriter->writeElement('g:link', array_get($arOffer, 'url'));
        // </g:link>
        
        // <g:image_link>
        $this->obXMLWriter->writeElement('g:image_link', !is_null(array_get($arOffer, 'offerImage')) ? array_get($arOffer, 'offerImage') : array_get($arOffer, 'productImage'));
        // </g:image_link>
        // <g:image_link>
        // $this->obXMLWriter->writeElement('g:offerImage', array_get($arOffer, 'offerImage'));
        // </g:image_link>

        // if (!empty($arImageList)) {
        //     foreach ($arImageList as $key => $sImageUrl) {
        //         // <picture>
        //         reset($arImageList);
        //         if ($key === key($arImageList))
        //         $this->obXMLWriter->writeElement('g:image_link', $sImageUrl);
        //         // </picture>
        //     }
        // }

        // <g:brand>
        $this->obXMLWriter->writeElement('g:brand', 'NAI_S cosmetics');
        // </g:brand>

        // <g:condition>
        $this->obXMLWriter->writeElement('g:condition', 'new');
        // </g:condition>

        // <g:availability>
        // $this->obXMLWriter->writeElement('g:availability', 'in stock');
        $this->obXMLWriter->writeElement('g:availability', array_get($arOffer, 'availability'));
        // $this->obXMLWriter->writeElement('g:visibility', array_get($arOffer, 'visibility'));
        $this->obXMLWriter->writeElement('g:inventory', array_get($arOffer, 'inventory'));
        // </g:availability>
        
        // <price>
        // </price>
        if (!empty($fManualOldPrice)) {
            // <price>
            // $this->obXMLWriter->writeElement('price', $fManualOldPrice . ' ' . array_get($arOffer, 'currency_id'));
            // </price>
            $this->obXMLWriter->writeElement('g:price', array_get($arOffer, 'price') . ' ' . array_get($arOffer, 'currency_id'));
            // $this->obXMLWriter->writeElement('g:sale_price', array_get($arOffer, 'price') . ' ' . array_get($arOffer, 'currency_id'));
        } else {
            $this->obXMLWriter->writeElement('g:price', array_get($arOffer, 'price') . ' ' . array_get($arOffer, 'currency_id'));
        }
        // <currencyId>
        // $this->obXMLWriter->writeElement('currencyId', array_get($arOffer, 'currency_id'));
        // </currencyId>
        // <categoryId>
        // $this->obXMLWriter->writeElement('categoryId', array_get($arOffer, 'category_id'));
        // </categoryId>

        if (!empty($arImageList)) {
            foreach ($arImageList as $sImageUrl) {
                // <picture>
                $this->obXMLWriter->writeElement('additional_image_link', $sImageUrl);
                // </picture>
            }
        }

        if (!empty(array_get($arOffer, 'color'))) {
            // <color>
            // $this->obXMLWriter->writeElement('color', array_get($arOffer, 'color'));
            // </color>
            // <additional_variant_attribute>
            $this->obXMLWriter->startElement('additional_variant_attribute');
            $this->obXMLWriter->writeElement('label', 'Select');
            $this->obXMLWriter->writeElement('value', array_get($arOffer, 'color'));
            $this->obXMLWriter->endElement();
            // </additional_variant_attribute>
        }

        // <g:shipping>
        $this->obXMLWriter->startElement('g:shipping');
        $this->obXMLWriter->writeElement('g:country', 'LV');
        $this->obXMLWriter->writeElement('g:service', 'Omniva');
        $this->obXMLWriter->writeElement('g:price', '2.34 EUR');
        $this->obXMLWriter->endElement();
        // </g:shipping>

        // <g:google_product_category>
        // $this->obXMLWriter->writeElement('g:google_product_category', 'Health & Beauty > Personal Care > Cosmetics > Cosmetic Tools	Nail Tools');
        $this->obXMLWriter->writeElement('g:google_product_category', '2975');
        // </g:google_product_category>

        // <g:custom_label_0>
        $this->obXMLWriter->writeElement('g:custom_label_0', 'Made in Latvia, EU');
        // </g:custom_label_0>

        // if (!empty($arPropertyList)) {
        //     foreach ($arPropertyList as $arProperty) {
        //         // <param name='' unit=''>
        //         $this->obXMLWriter->startElement('param');
        //         $this->obXMLWriter->writeAttribute('name', array_get($arProperty, 'name'));
        //         $this->obXMLWriter->writeAttribute('unit', array_get($arProperty, 'measure'));
        //         $this->obXMLWriter->text(array_get($arProperty, 'value'));
        //         $this->obXMLWriter->endElement();
        //         // </param>
        //     }
        // }
        // </offer>
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
