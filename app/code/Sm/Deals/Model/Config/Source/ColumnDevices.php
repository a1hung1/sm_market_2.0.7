<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 27-02-2016
 * Time: 15:59
 */
namespace Sm\Deals\Model\Config\Source;

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
