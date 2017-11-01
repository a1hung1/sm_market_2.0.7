<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 15-12-2015
 * Time: 15:50
 */
namespace Sm\MegaMenu\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;

class MenuGroup extends AbstractDb
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
		$this->_init('sm_megamenu_groups', 'group_id');
	}
}