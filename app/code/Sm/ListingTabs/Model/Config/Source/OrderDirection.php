<?php
/**
 * Created by PhpStorm.
 * User: Hoang Viet Tung
 * Date: 25-11-2015
 * Time: 11:59
 */
namespace Sm\ListingTabs\Model\Config\Source;
class OrderDirection implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value'=>'ASC', 'label'=>__('Asc')],
			['value'=>'DESC', 'label'=>__('Desc')]
		];
	}
}