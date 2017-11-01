<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 01-01-2016
 * Time: 23:09
 */
namespace Sm\ImageSlider\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;
class Theme implements  ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => 'theme1', 'label' => __('Theme 1')],
			['value' => 'theme2', 'label' => __('Theme 2')]
		];
	}
}