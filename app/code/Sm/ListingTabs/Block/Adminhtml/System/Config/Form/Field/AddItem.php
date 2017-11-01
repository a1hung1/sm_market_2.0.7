<?php
/**
 * Created by PhpStorm.
 * User: Hoang Viet Tung
 * Date: 25-11-2015
 * Time: 17:03
 */
namespace Sm\ListingTabs\Block\Adminhtml\System\Config\Form\Field;
use \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
class AddItem extends AbstractFieldArray
{
	protected function _construct()
	{
		$this->addColumn('title', [
			'label' => __('Title '),
			'style' => 'width:120px'
		]);
		$this->addColumn('link', [
			'label' => __('Link'),
			'style' => 'width:120px'
		]);
		$this->addColumn('image', [
			'label' => __('Media'),
			'style' => 'width:120px'
		]);
		$this->addColumn('content', [
			'label' => __('Content'),
			'style' => 'width:220px'
		]);
		$this->_addAfter = false;
		$this->_addButtonLabel = __('Add Items');
		parent::_construct();
	}
	
	 protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $this->setElement($element);
        $html = $this->_toHtml();
        $this->_arrayRowsCache = null; // doh, the object is used as singleton!
        $html = '<div id="basicproducts_source_product_additem">' . $html . '</div>';
        return $html;
    }
}