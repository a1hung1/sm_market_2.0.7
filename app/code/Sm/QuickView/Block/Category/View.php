<?php
/*------------------------------------------------------------------------
# SM QuickView - Version 3.0.0
# Copyright (c) 2015 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/
namespace Sm\QuickView\Block\Category;
class View extends \Magento\Catalog\Block\Category\View
{
	/**
	 * @return string
	 */
	public function getProductListHtml()
	{
		return $this->getChildHtml('product_list');
	}
}