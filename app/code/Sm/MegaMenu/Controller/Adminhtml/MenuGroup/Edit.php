<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 16-12-2015
 * Time: 10:17
 */
namespace Sm\MegaMenu\Controller\Adminhtml\MenuGroup;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;

	protected $_coreRegistry;

	public function __construct(
		Context $context,
		Registry $registry,
		PageFactory $resultPageFactory
	) {
		$this->resultPageFactory = $resultPageFactory;
		$this->_coreRegistry = $registry;
		parent::__construct($context, $registry);
	}

	protected function _initAction()
	{
		// load layout, set active menu and breadcrumbs
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu('Sm_MegaMenu::megamenu_menugroup')
			->addBreadcrumb(__('Manager Menu'), __('Manager Menu'))
			->addBreadcrumb(__('Manager Menu'), __('Manager Menu'));
		return $resultPage;
	}

	public function execute()
	{
		// 1. Get ID and create model
		$id = $this->getRequest()->getParam('id');
		$model = $this->_objectManager->create('Sm\MegaMenu\Model\MenuGroup');

		// 2. Initial checking
		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				$this->messageManager->addError(__('This group no longer exists.'));
				/** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
				$resultRedirect = $this->resultRedirectFactory->create();

				return $resultRedirect->setPath('*/*/');
			}
		}
		if ($model->getGroupId() || $id == 0) {
			// 3. Set entered data if was error when we do save
			$data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			// 4. Register model to use later in blocks
			$this->_coreRegistry->register('megamenu_menugroup', $model);
			//		$this->_coreRegistry->register('megamenu_menuitems', $modelItems);

			// 5. Build edit form
			/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
			$resultPage = $this->_initAction();
			$resultPage->addBreadcrumb(
				$id ? __('Edit Group') : __('New Group'),
				$id ? __('Edit Group') : __('New Group')
			);
			$resultPage->addContent(
				$this->_view->getLayout()->createBlock('\Sm\MegaMenu\Block\Adminhtml\MenuGroup\Edit')
			);
			$resultPage->addLeft(
				$this->_view->getLayout()->createBlock('\Sm\MegaMenu\Block\Adminhtml\MenuGroup\Edit\Tabs')
			);

			$resultPage->getConfig()->getTitle()->prepend(__('Menu Group'));
			$resultPage->getConfig()->getTitle()
				->prepend($model->getId() ? $model->getTitle() : __('New Group'));
			return $resultPage;
		}
	}
}