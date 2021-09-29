<?php
namespace TemplateMonster\AjaxCatalog\Model;

use \Magento\CatalogSearch\Model\Price\Interval;
use \Magento\Catalog\Model\ResourceModel\Layer\Filter\Price;

class PriceSlider extends Interval
{
    public function __construct(
        Price $resource)
    {
        $this->_resource = $resource;

        parent::__construct($resource);
    }

    /**
     * @return array
     */
    public function getAllPrices()
    {
        return $this->_resource->loadPrices(0);
    }

    /**
     * @return mixed
     */
    public function getMaxPrice()
    {
		if(count($this->getAllPrices())) {
			return max($this->getAllPrices());
		} else {
			return 0;
		}
        
    }

    /**
     * @return mixed
     */
    public function getMinPrice()
    {
		if(count($this->getAllPrices())) {
			return min($this->getAllPrices());
		} else {
			return 0;
		}
        
    }

}