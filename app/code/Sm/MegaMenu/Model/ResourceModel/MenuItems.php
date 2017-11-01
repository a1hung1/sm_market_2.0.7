<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 17-12-2015
 * Time: 01:37
 */
namespace Sm\MegaMenu\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;

class MenuItems extends AbstractDb
{
	public function __construct(
		Context $context,
		StoreManagerInterface $storeManager,
		$connectionName = null
	)
	{
		parent::__construct($context, $connectionName);
		$this->_storeManager = $storeManager;
	}

	public function _construct()
	{
		$this->_init('sm_megamenu_items', 'items_id');
	}
}