<?php
/*------------------------------------------------------------------------
# SM QuickView - Version 3.0.0
# Copyright (c) 2015 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/
namespace Sm\QuickView\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\ResourceConnection;


class Index extends \Magento\Catalog\Controller\Product
{
	/**
	 * Core registry
	 *
	 * @var \Magento\Framework\Registry
	 */
	protected $_coreRegistry;

	/**
	 * Catalog session
	 *
	 * @var \Magento\Catalog\Model\Session
	 */
	protected $_catalogSession;

	/**
	 * @var  \Magento\Framework\View\Result\Page
	 */
	protected $resultPageFactory;

	/**
	* @var ProductRepositoryInterface
	*/
	protected $productRepository;

	/**
	 * @var CategoryRepositoryInterface
	 */
	protected $categoryRepository;

	/**
	 * @var \Magento\Store\Model\StoreManagerInterface
	 */
	protected $_storeManager;

	/**
	 * @var \Psr\Log\LoggerInterface
	 */
	protected $_logger;

	/**
	 * Resource
	 *
	 * @var \Magento\Framework\App\ResourceConnection
	 */
	protected $_resource;

	/**
	 * Catalog design
	 *
	 * @var \Magento\Catalog\Model\Design
	 */
	protected $_catalogDesign;

	/**
	 * @var \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator
	 */
	protected $categoryUrlPathGenerator;

	/**
	 * @var \Magento\Framework\Controller\Result\ForwardFactory
	 */
	protected $resultForwardFactory;

	/**
	 * @var \Magento\Catalog\Helper\Product\View
	 */
	protected $viewHelper;

	/**
	 * @param \Magento\Framework\App\Action\Context $context
	 * @param \Magento\Store\Model\StoreManagerInterface $storeManager
	 * @param \Magento\Catalog\Model\Design $catalogDesign
	 * @param ProductRepositoryInterface $productRepository
	 * @param \Magento\Framework\App\ResourceConnection $resourceConnection
	 * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
	 */
	public function __construct(
		Context $context,
		\Magento\Catalog\Helper\Product\View $viewHelper,
		ResourceConnection $resourceConnection,
		 \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
		PageFactory $resultPageFactory
	)
	{
		$this->viewHelper = $viewHelper;
		$this->_resource = $resourceConnection;
		$this->resultPageFactory = $resultPageFactory;
		parent::__construct($context);
	}
	
	 protected function noProductRedirect()
    {
        $store = $this->getRequest()->getQuery('store');
        if (isset($store) && !$this->getResponse()->isRedirect()) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('');
        } elseif (!$this->getResponse()->isRedirect()) {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('noroute');
            return $resultForward;
        }
    }

	
	/**
	 * Blog Index, shows a list of recent blog posts.
	 *
	 * @return \Magento\Framework\View\Result\PageFactory
	 */
	public function execute()
	{
		// get store id
		$om = \Magento\Framework\App\ObjectManager::getInstance();
		$manager = $om->get('Magento\Store\Model\StoreManagerInterface');
		$store_id =  $manager->getStore()->getId();
		// get connnect pdo
		$conn =  $this->_resource->getConnection('core_read');
		$_path = $this->getRequest()->getParam('path') ? $this->getRequest()->getParam('path') : strstr($this->_request->getRequestUri(), '/path');
		$_path = str_replace("/path/",'',$_path );
		$_path = (strpos($_path, '?') !== false) ? substr($_path , strpos($_path, '?') ) : $_path;
		// escape url path
		$str = $conn->quote($_path);
		$url_rewrite = $this->_resource->getTableName('url_rewrite');
		$select =  $conn->select()
			->from(array('rp' => $url_rewrite), new \Zend_Db_Expr('entity_id'))
			->where('rp.request_path in ('.$str.')')
			->where('rp.store_id = ?', $store_id);
		$productId =  $conn->fetchOne($select);
		
		if (!$productId) {
			return false;
		}
		$categoryId = (int) $this->getRequest()->getParam('category', false);
		$specifyOptions = $this->getRequest()->getParam('options');
		
        $params = new \Magento\Framework\DataObject();
        $params->setCategoryId($categoryId);
        $params->setSpecifyOptions($specifyOptions);

        // Render page
        try {
            $page = $this->resultPageFactory->create(false, ['isIsolated' => true]);
            $this->viewHelper->prepareAndRender($page, $productId, $this, $params);
            return $page;
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return $this->noProductRedirect();
        } catch (\Exception $e) {
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('noroute');
            return $resultForward;
        }
	}
}