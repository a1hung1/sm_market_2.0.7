<?php
/*------------------------------------------------------------------------
# SM Market - Version 1.0.0
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\Market\Model\Config\Source;

class ListHeaderStyles implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => '1', 'label' => __('Header Style 1')],
			['value' => '2', 'label' => __('Header Style 2')],
			['value' => '3', 'label' => __('Header Style 3')],
			['value' => '4', 'label' => __('Header Style 4')],
		];
	}
}