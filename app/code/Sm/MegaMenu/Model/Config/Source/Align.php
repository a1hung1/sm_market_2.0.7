<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 17-12-2015
 * Time: 10:09
 */
namespace Sm\MegaMenu\Model\Config\Source;

class Align implements \Magento\Framework\Option\ArrayInterface
{
	const LEFT	= 1;
	const RIGHT	= 2;

	public function getOptionArray()
	{
		return [
			self::LEFT    => __('Left'),
			self::RIGHT   => __('Right')
		];
	}

	public function toOptionArray()
	{
		return [
			[
				'value'     => self::LEFT,
				'label'     => __('Left'),
			],
			[
				'value'     => self::RIGHT,
				'label'     => __('Right'),
			]
		];
	}
}