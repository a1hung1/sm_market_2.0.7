<?php
/*------------------------------------------------------------------------
# SM Categories - Version 3.0.0
# Copyright (c) 2015 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\Categories\Model\Config\Source;

class OrderDirection implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value'=>'ASC', 'label'=>__('Asc')],
			['value'=>'DESC', 'label'=>__('Desc')]
		];
	}
}