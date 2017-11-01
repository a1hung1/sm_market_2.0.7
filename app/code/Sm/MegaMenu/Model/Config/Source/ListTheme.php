<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 28-06-2015
 * Time: 23:41
 */
namespace Sm\MegaMenu\Model\Config\Source;
class ListTheme implements \Magento\Framework\Option\ArrayInterface
{
	const HORIZONTAL =	1;
	const VERTICAL	 =	2;

	public function getOptionArray()
	{
		return [
			self::HORIZONTAL 		=> __('Horizontal'),
			self::VERTICAL			=> __('Vertical'),
		];
	}
	public function toOptionArray()
	{
		return [
			[
				'value'     => self::HORIZONTAL,
				'label'     => __('Horizontal'),
			],
			[
				'value'     => self::VERTICAL,
				'label'     => __('Vertical'),
			],
		];
	}
}