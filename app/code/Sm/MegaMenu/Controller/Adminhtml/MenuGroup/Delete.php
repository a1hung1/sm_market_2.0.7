<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 16-12-2015
 * Time: 16:14
 */
namespace Sm\MegaMenu\Controller\Adminhtml\MenuGroup;

class Delete extends \Sm\MegaMenu\Controller\Adminhtml\MenuGroup
{
	/**
	 * Delete action
	 *
	 * @return \Magento\Backend\Model\View\Result\Redirect
	 */
	public function execute()
	{
		// check if we know what should be deleted
		$id = $this->getRequest()->getParam('group_id');
		/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
		$resultRedirect = $this->resultRedirectFactory->create();
		if ($id) {
			try {
				// init model and delete
				$model = $this->_objectManager->create('Sm\MegaMenu\Model\MenuGroup');
				$menuItems = $this->_objectManager->create('Sm\MegaMenu\Model\MenuItems');
				$model->load($id);
				$model->delete();
				$menuItems->getDeleteItemsByGroup($id);
//				$this->_eventManager->dispatch('megamenu_menuitems_deleteGroup_before', ['params' => $model]);
				// display success message
				$this->messageManager->addSuccess(__('You deleted the group.'));
				// go to grid
				return $resultRedirect->setPath('*/*/');
			}
			catch (\Exception $e)
			{
				// display error message
				$this->messageManager->addError($e->getMessage());
				// go back to edit form
				return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
			}
		}
		// display error message
		$this->messageManager->addError(__('We can\'t find a group to delete.'));
		// go to grid
		return $resultRedirect->setPath('*/*/');
	}
}