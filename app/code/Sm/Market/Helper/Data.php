<?php
/*------------------------------------------------------------------------
# SM Market - Version 1.0.0
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\Market\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

	public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }
	
	public function getGeneral($name)
	{
        return $this->scopeConfig->getValue(
            'market/general/'.$name,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );		
	}
	
	public function getThemeLayout($name)
	{
        return $this->scopeConfig->getValue(
            'market/theme_layout/'.$name,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );		
	}
	
	public function getProductListing($name)
	{
        return $this->scopeConfig->getValue(
            'market/product_listing/'.$name,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );		
	}	
	
	public function getProductDetail($name)
	{
        return $this->scopeConfig->getValue(
            'market/product_detail/'.$name,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );		
	}

	public function getSocial($name)
	{
        return $this->scopeConfig->getValue(
            'market/socials/'.$name,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );		
	}
	
	public function getAdvanced($name)
	{
        return $this->scopeConfig->getValue(
            'market/advanced/'.$name,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );		
	}
	
}