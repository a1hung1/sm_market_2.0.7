<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 28-06-2015
 * Time: 23:42
 */
namespace Sm\MegaMenu\Model\Config\Source;
class ListEffect implements \Magento\Framework\Option\ArrayInterface
{
	const CSS		 	=	1;
	const ANIMATION	 	=	2;
	const TOGGLE 		=	3;

	public function getOptionArray()
	{
		return [
			self::CSS 				=> __('Css'),
			self::ANIMATION			=> __('Animation'),
			self::TOGGLE			=> __('toggle'),
		];
	}
	public function toOptionArray()
	{
		return [
			[
				'value'     => self::CSS,
				'label'     => __('Css'),
			],
			[
				'value'     => self::ANIMATION,
				'label'     => __('Animation'),
			],
			[
				'value'     => self::TOGGLE,
				'label'     => __('Toggle'),
			],
		];
	}
}