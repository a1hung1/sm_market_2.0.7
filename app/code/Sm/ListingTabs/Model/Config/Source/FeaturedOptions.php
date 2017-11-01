<?php
/**
 * Created by PhpStorm.
 * User: Hoang Viet Tung
 * Date: 25-11-2015
 * Time: 11:21
 */
namespace Sm\ListingTabs\Model\Config\Source;
class FeaturedOptions implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value'=>0, 'label'=>__('Show')],
			['value'=>1, 'label'=>__('Hide')],
			['value'=>2, 'label'=>__('Only')]
		];
	}
}