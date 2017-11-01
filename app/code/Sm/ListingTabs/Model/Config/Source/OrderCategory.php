<?php
/**
 * Created by PhpStorm.
 * User: Hoang Viet Tung
 * Date: 25-11-2015
 * Time: 11:59
 */
namespace Sm\ListingTabs\Model\Config\Source;
class OrderCategory implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value'=>'name', 'label'=>__('Name')],
			['value'=>'position', 'label'=>__('Position')],
			['value'=>'random', 'label'=>__('Random')]
		];
	}
}