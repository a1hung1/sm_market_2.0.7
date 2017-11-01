<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 24-11-2015
 * Time: 22:46
 */
namespace Sm\ImageSlider\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ColumnDevices implements ArrayInterface
{
	public function toOptionArray()
	{
		$array = [1,2,3,4,5,6];
		$data = [];
		foreach ($array as $a)
		{
			$data[] = ['value' => $a, 'label' => __($a)];
		}
		return $data;
	}
}
