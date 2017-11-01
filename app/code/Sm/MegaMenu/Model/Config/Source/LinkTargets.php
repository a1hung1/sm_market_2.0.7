<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 18-12-2015
 * Time: 10:36
 */
namespace Sm\MegaMenu\Model\Config\Source;

class LinkTargets implements \Magento\Framework\Option\ArrayInterface
{
	const _BLANK		= 1;
	const _POPUP		= 2;
	const _SELF			= 3;

	public function getOptionArray()
	{
		return [
			self::_BLANK    => __('New Window'),
			self::_POPUP    => __('Popup Window'),
			self::_SELF     => __('Same Window')
		];
	}

	public function toOptionArray()
	{
		return [
			[
				'value'     => self::_BLANK,
				'label'     => __('New Window'),
			],
			[
				'value'     => self::_POPUP,
				'label'     => __('Popup Window'),
			],
			[
				'value'     => self::_SELF,
				'label'     => __('Same Window'),
			]
		];
	}
}