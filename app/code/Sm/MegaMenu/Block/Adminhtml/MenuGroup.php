<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 08-12-2015
 * Time: 17:10
 */
namespace Sm\MegaMenu\Block\Adminhtml;

class MenuGroup extends \Magento\Backend\Block\Widget\Grid\Container
{

	protected function _construct()
	{
		$this->_blockGroup = 'Sm_MegaMenu';
		$this->_controller = 'adminhtml_menuGroup';
		$this->_headerText = __('Manager Menu');
//		$this->_addButtonLabel = __('Add New Groups');
		parent::_construct();

		if ($this->_isAllowedAction('Sm_MegaMenu::save')) {
			$this->buttonList->update('add', 'label', __('Add New Menu'));
		} else {
			$this->buttonList->remove('add');
		}
	}

	protected function _isAllowedAction($resourceId)
	{
		return $this->_authorization->isAllowed($resourceId);
	}
}