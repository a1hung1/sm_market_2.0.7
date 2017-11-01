<?php
/**
 * Created by PhpStorm.
 * User: Hoang Viet Tung
 * Date: 24-11-2015
 * Time: 17:37
 */
namespace Sm\ListingTabs\Model\Config\Source;

class Loadmore implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => 'loadmore', 'label' => __('Loadmore')],
			['value' => 'slider', 'label' => __('Slider')]
		];
	}
}