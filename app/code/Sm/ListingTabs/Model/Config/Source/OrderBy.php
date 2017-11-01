<?php
/**
 * Created by PhpStorm.
 * User: Hoang Viet Tung
 * Date: 25-11-2015
 * Time: 11:25
 */
namespace Sm\ListingTabs\Model\Config\Source;
class OrderBy implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value'=>'name', 'label'=>__('Name')],
			['value'=>'entity_id', 'label'=>__('Id')],
			['value'=>'created_at', 'label'=>__('Date Created')],
			['value'=>'price', 'label'=>__('Price')],
			['value'=>'lastest_product', 'label'=>__('Lastest Product')],
			['value'=>'top_rating', 'label'=>__('Top Rating')],
			['value'=>'most_reviewed', 'label'=>__('Most Reviews')],
			['value'=>'most_viewed', 'label'=>__('Most Viewed')],
			['value'=>'best_sales', 'label'=>__('Most Selling')],
			['value'=>'random', 'label'=>__('Random')]
		];
	}
}