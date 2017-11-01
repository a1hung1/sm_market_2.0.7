<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 18-12-2015
 * Time: 09:42
 */
namespace Sm\MegaMenu\Model\Config\Source;

class PositionItem implements \Magento\Framework\Option\ArrayInterface
{
	const BEFORE    = 1;
	const AFTER	    = 2;
	const FIRST		= 3;

	public function getOptionArray()
	{
		return [
			self::AFTER     => __('After'),
			self::BEFORE    => __('Before')
		];
	}

	public function toOptionArray()
	{
		return [
			[
				'value'     => self::AFTER,
				'label'     => __('After'),
			],
			[
				'value'     => self::BEFORE,
				'label'     => __('Before'),
			]
		];
	}
}