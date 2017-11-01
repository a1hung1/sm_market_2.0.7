<?php
/**
 * Created by PhpStorm.
 * User: Hoang Viet Tung
 * Date: 24-11-2015
 * Time: 22:46
 */
namespace Sm\ListingTabs\Model\Config\Source;
class ColumnDevices implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		$array = array(1,2,3,4,5,6);
		$data = [];
		foreach ($array as $a)
		{
			$data[] = ['value' => $a, 'label' => __($a)];
		}
		$option =  [];
		foreach ($data as $d)
		{
			$option[] = $d;
		}
		return $option;
	}
}
