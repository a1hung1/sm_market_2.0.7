<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 08-12-2015
 * Time: 17:46
 */
namespace Sm\MegaMenu\Controller\Adminhtml\MenuGroup;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Sm\MegaMenu\Controller\Adminhtml\MenuGroup
{
	protected $resultPageFactory;

	public function __construct(
		Context $context,
		Registry $coreRegistry,
		PageFactory $resultPageFactory
	)
	{
		$this->resultPageFactory = $resultPageFactory;
		parent::__construct($context, $coreRegistry);
	}

	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$this->_initAction($resultPage)->getConfig()->getTitle()->prepend(__('Manager Menu'));
		return $resultPage;
	}
}