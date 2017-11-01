<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 16-12-2015
 * Time: 17:49
 */
namespace Sm\MegaMenu\Controller\Adminhtml\MenuItems;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends \Magento\Backend\App\Action
{
	protected $resultForwardFactory;

	public function __construct(
		Context $context,
		Registry $coreRegistry,
		ForwardFactory $resultForwardFactory
	) {
		$this->resultForwardFactory = $resultForwardFactory;
		parent::__construct($context, $coreRegistry);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Sm_MegaMenu::save');
	}

	public function execute()
	{
		/** @var \Magento\Framework\Controller\Result\Forward $resultForward */
		$resultForward = $this->resultForwardFactory->create();
		return $resultForward->forward('edit');
	}
}