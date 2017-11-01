<?php
/**
 * Created by PhpStorm.
 * User: Hoang Viet Tung
 * Date: 24-11-2015
 * Time: 23:12
 */
namespace Sm\ListingTabs\Model\Config\Source;

class ListingTabs implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => 'categories', 'label' => __('Categories')],
			['value' => 'fieldproducts', 'label' => __('Field Products')]
		];
	}
}