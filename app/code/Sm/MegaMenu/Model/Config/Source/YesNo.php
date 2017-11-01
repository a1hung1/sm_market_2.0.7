<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 19-12-2015
 * Time: 10:22
 */
namespace Sm\MegaMenu\Model\Config\Source;

class YesNo implements \Magento\Framework\Option\ArrayInterface
{
	const YES	= 1;
	const NO	= 2;

	public function getOptionArray()
	{
		return [
			self::YES    => __('Yes'),
			self::NO   => __('No')
		];
	}

	public function toOptionArray()
	{
		return [
			[
				'value'     => self::YES,
				'label'     => __('Yes'),
			],
			[
				'value'     => self::NO,
				'label'     => __('No'),
			]
		];
	}
}