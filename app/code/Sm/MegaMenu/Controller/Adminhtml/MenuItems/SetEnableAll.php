<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 28-12-2015
 * Time: 02:50
 */
namespace Sm\MegaMenu\Controller\Adminhtml\MenuItems;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class SetEnableAll extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;

	public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
		array $data = []
	)
	{
		$this->resultPageFactory = $resultPageFactory;
		parent::__construct($context, $data);
	}

	public function createMenuItemsResource()
	{
		return $this->_objectManager->create('Sm\MegaMenu\Model\ResourceModel\MenuItems');
	}

	public function createMenuItemsCollection()
	{
		return $this->_objectManager->create('Sm\MegaMenu\Model\ResourceModel\MenuItems\Collection');
	}

	public function execute()
	{
		$groupId = $this->getRequest()->getParam('gid');
		if ($groupId)
		{
			$mainTable = $this->createMenuItemsResource()->getMainTable();
			$resultRedirect = $this->resultRedirectFactory->create();
			try{
				$this->createMenuItemsCollection()->setEnableAll($mainTable, $groupId);
				$this->messageManager->addSuccess(__('You enable all items was successfully.'));
				return $resultRedirect->setPath('*/*/newaction', [
					'gid' => $groupId,
					'activeTab' => 'menuitems'
				]);
			} catch (\Exception $e) {
				$this->messageManager->addError($e->getMessage());
				return $resultRedirect->setPath('*/*/newaction', [
					'gid' => $groupId,
					'activeTab' => 'menuitems'
				]);
			}
		}
	}
}