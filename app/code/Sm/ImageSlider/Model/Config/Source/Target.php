<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 24-11-2015
 * Time: 17:37
 */
namespace Sm\ImageSlider\Model\Config\Source;

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