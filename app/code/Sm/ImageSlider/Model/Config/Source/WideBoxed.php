<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 01-01-2016
 * Time: 23:56
 */
namespace Sm\ImageSlider\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class WideBoxed implements ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => 'wide', 'label' => __('Wide')],
			['value' => 'boxed', 'label' => __('Boxed')]
		];
	}
}