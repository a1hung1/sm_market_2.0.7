<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 17-12-2015
 * Time: 10:34
 */
namespace Sm\MegaMenu\Helper;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\DB\QueryInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	protected $_objectManager;
	protected $_storeManager;
	protected $_directory;
	protected $_query;

	public function __construct(
		Context $context,
		Filesystem $filesystem,
		QueryInterface $queryInterface,
		ObjectManagerInterface $objectManager,
		StoreManagerInterface $storeManagerInterface
	){
		parent::__construct($context);
		$this->_objectManager = $objectManager;
		$this->_storeManager = $storeManagerInterface;
		$this->_directory = $filesystem;
		$this->_query = $queryInterface;
	}

	public function _modelMenuItems()
	{
		return $this->_objectManager->create('Sm\MegaMenu\Model\MenuItems');
	}

	public function _modelMenuGroup()
	{
		return $this->_objectManager->create('Sm\MegaMenu\Model\MenuGroup');
	}
}