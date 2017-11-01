<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 17-12-2015
 * Time: 13:42
 */
namespace Sm\MegaMenu\Controller\Adminhtml\MenuItems;

use Magento\Framework\App\Action\Context;
use Sm\MegaMenu\Model\MenuItems;

class GetChildItems extends \Magento\Backend\App\Action
{
	/**
	 * Mega Menu
	 *
	 * @var \Sm\MegaMenu\Helper\Data
	 */
	protected $_megaMenu;

	public function __construct(
		Context $context,
		MenuItems $menuItems,
		array $data = []
	)
	{
		$this->_megaMenu = $menuItems;
		parent::__construct($context);
	}

	public function createMenuItems(){
		return $this->_objectManager->create('Sm\MegaMenu\Model\MenuItems');
	}

	public function execute(){
		if($params = $this->getRequest()->getParams())
		{
			if($params['group'])
			{
				$paramsItem = $this->createMenuItems()->load($params['group']);
				$menuIemsByGroup = $this->createMenuItems()->load($params['group']);
				$data = $menuIemsByGroup->getData();

				$items_data = $this->createMenuItems()->getChildsDirectlyByItem($data, 1);
				$cols_num = 6;
				if($paramsItem->getColsNb()){
					$cols_num = $paramsItem->getColsNb();
				}
				$arr_items = [];
				$success = "true";

				if(count($items_data)){
					foreach ($items_data as $item){
						$arr_items[] = '{"id":"'.$item['items_id'].'", "title":'.json_encode('('.$item['items_id'].') '.$item['title']).'}';
						//$arr_items[] = '{"id":"'.$item->getItemsId().'", "title":'.json_encode('('.$item->getItemsId().') '.$item->getTitle()).'}';
					}
					header('Content-Type: application/x-json');
					echo '{"success":"", "items":' . json_encode($arr_items) . ', "col_max":"'.$cols_num.'"}';
				}
				else{
					echo '{"success":"", "items":' . json_encode($arr_items) . ', "col_max":"'.$cols_num.'"}';
				}
				die;
			}
		}
	}
}