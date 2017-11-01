<?php
/**
 * Created by PhpStorm.
 * User: Hoang Viet Tung
 * Date: 24-11-2015
 * Time: 17:37
 */
namespace Sm\ListingTabs\Model\Config\Source;

class Target implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => '_self', 'label' => __('Same Window')],
			['value' => '_blank', 'label' => __('New Window')],
			['value' => '_windowopen', 'label' => __('Popup Window')]
		];
	}
}