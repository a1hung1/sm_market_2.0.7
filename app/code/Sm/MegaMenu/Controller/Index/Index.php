<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 07-12-2015
 * Time: 17:07
 */
namespace Sm\MegaMenu\Controller\Index;

use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $resultPageFactory;

	public function __construct(
		Context $context,
		PageFactory $pageFactory
	)
	{
		$this->resultPageFactory = $pageFactory;
		parent::__construct($context);
	}

	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend(__('Sm Mega Menu'));
		return $resultPage;
	}
}