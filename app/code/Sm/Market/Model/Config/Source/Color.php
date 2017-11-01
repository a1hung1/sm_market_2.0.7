<?php
/*------------------------------------------------------------------------
# SM Market - Version 1.0.0
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\Market\Model\Config\Source;

class Color implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => 'yellow', 'label' => __('Yellow')],
			['value' => 'blue', 'label' => __('Blue')],
			['value' => 'green', 'label' => __('Green')],
			['value' => 'emerald', 'label' => __('Emerald')],
			['value' => 'tangerine', 'label' => __('Tangerine')],
			['value' => 'custom', 'label' => __('Custom')]
		];
	}
}