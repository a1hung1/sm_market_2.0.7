<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 27-02-2016
 * Time: 15:55
 */
namespace Sm\Deals\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Target implements ArrayInterface
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