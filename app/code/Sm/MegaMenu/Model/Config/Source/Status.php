<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 21-12-2015
 * Time: 14:48
 */
namespace Sm\MegaMenu\Model\Config\Source;

class Status implements \Magento\Framework\Option\ArrayInterface
{
	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 2;

	public function getOptionArray()
	{
		return [
			self::STATUS_ENABLED    => __('Enable'),
			self::STATUS_DISABLED   => __('Disable')
		];
	}

	public function toOptionArray()
	{
		return [
			[
				'value'     => self::STATUS_ENABLED,
				'label'     => __('Enable'),
			],
			[
				'value'     => self::STATUS_DISABLED,
				'label'     => __('Disable'),
			]
		];
	}
}