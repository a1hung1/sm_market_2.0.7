<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 15-12-2015
 * Time: 15:50
 */
namespace Sm\MegaMenu\Model\ResourceModel\MenuGroup;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	protected function _construct()
	{
		$this->_init('Sm\MegaMenu\Model\MenuGroup', 'Sm\MegaMenu\Model\ResourceModel\MenuGroup');
	}
}