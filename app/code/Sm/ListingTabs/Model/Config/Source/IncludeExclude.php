<?php
/**
 * Created by PhpStorm.
 * User: Hoang Viet Tung
 * Date: 25-11-2015
 * Time: 10:46
 */
namespace Sm\ListingTabs\Model\Config\Source;
class IncludeExclude implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value'=>1, 'label'=>__('Include')],
			['value'=>0, 'label'=>__('Exclude')]
		];
	}
}