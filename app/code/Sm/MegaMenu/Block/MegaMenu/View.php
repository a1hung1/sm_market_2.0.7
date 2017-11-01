<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 07-12-2015
 * Time: 17:49
 */
namespace Sm\MegaMenu\Block\MegaMenu;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\ObjectManagerInterface;
use Sm\MegaMenu\Helper\Defaults;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Url\DecoderInterface;
use Magento\Framework\Filter\Email;
use Magento\Catalog\Helper\Data;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Context as ViewContext;
use Sm\MegaMenu\Block\Cache\Lite;

class View extends Template
{
	/**
	 * @var \Magento\Framework\ObjectManagerInterface
	 */
	protected $_objectManager;

	/**
	 * @var \Magento\Framework\Url\DecoderInterface
	 */
	protected $_urlDecoder;

	/**
	 * Front controller
	 *
	 * @var FrontControllerInterface
	 */
	protected $_frontController;

	/**
	 * Symbol convert table
	 *
	 * @var convertTable
	 */
	protected $_convertTable = [
		'&amp;' => 'and',   '@' => 'at',    '©' => 'c', '®' => 'r', 'À' => 'a',
		'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'Å' => 'a', 'Æ' => 'ae','Ç' => 'c',
		'È' => 'e', 'É' => 'e', 'Ë' => 'e', 'Ì' => 'i', 'Í' => 'i', 'Î' => 'i',
		'Ï' => 'i', 'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Õ' => 'o', 'Ö' => 'o',
		'Ø' => 'o', 'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'Ý' => 'y',
		'ß' => 'ss','à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', 'å' => 'a',
		'æ' => 'ae','ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
		'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ò' => 'o', 'ó' => 'o',
		'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u',
		'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'þ' => 'p', 'ÿ' => 'y', 'Ā' => 'a',
		'ā' => 'a', 'Ă' => 'a', 'ă' => 'a', 'Ą' => 'a', 'ą' => 'a', 'Ć' => 'c',
		'ć' => 'c', 'Ĉ' => 'c', 'ĉ' => 'c', 'Ċ' => 'c', 'ċ' => 'c', 'Č' => 'c',
		'č' => 'c', 'Ď' => 'd', 'ď' => 'd', 'Đ' => 'd', 'đ' => 'd', 'Ē' => 'e',
		'ē' => 'e', 'Ĕ' => 'e', 'ĕ' => 'e', 'Ė' => 'e', 'ė' => 'e', 'Ę' => 'e',
		'ę' => 'e', 'Ě' => 'e', 'ě' => 'e', 'Ĝ' => 'g', 'ĝ' => 'g', 'Ğ' => 'g',
		'ğ' => 'g', 'Ġ' => 'g', 'ġ' => 'g', 'Ģ' => 'g', 'ģ' => 'g', 'Ĥ' => 'h',
		'ĥ' => 'h', 'Ħ' => 'h', 'ħ' => 'h', 'Ĩ' => 'i', 'ĩ' => 'i', 'Ī' => 'i',
		'ī' => 'i', 'Ĭ' => 'i', 'ĭ' => 'i', 'Į' => 'i', 'į' => 'i', 'İ' => 'i',
		'ı' => 'i', 'Ĳ' => 'ij','ĳ' => 'ij','Ĵ' => 'j', 'ĵ' => 'j', 'Ķ' => 'k',
		'ķ' => 'k', 'ĸ' => 'k', 'Ĺ' => 'l', 'ĺ' => 'l', 'Ļ' => 'l', 'ļ' => 'l',
		'Ľ' => 'l', 'ľ' => 'l', 'Ŀ' => 'l', 'ŀ' => 'l', 'Ł' => 'l', 'ł' => 'l',
		'Ń' => 'n', 'ń' => 'n', 'Ņ' => 'n', 'ņ' => 'n', 'Ň' => 'n', 'ň' => 'n',
		'ŉ' => 'n', 'Ŋ' => 'n', 'ŋ' => 'n', 'Ō' => 'o', 'ō' => 'o', 'Ŏ' => 'o',
		'ŏ' => 'o', 'Ő' => 'o', 'ő' => 'o', 'Œ' => 'oe','œ' => 'oe','Ŕ' => 'r',
		'ŕ' => 'r', 'Ŗ' => 'r', 'ŗ' => 'r', 'Ř' => 'r', 'ř' => 'r', 'Ś' => 's',
		'ś' => 's', 'Ŝ' => 's', 'ŝ' => 's', 'Ş' => 's', 'ş' => 's', 'Š' => 's',
		'š' => 's', 'Ţ' => 't', 'ţ' => 't', 'Ť' => 't', 'ť' => 't', 'Ŧ' => 't',
		'ŧ' => 't', 'Ũ' => 'u', 'ũ' => 'u', 'Ū' => 'u', 'ū' => 'u', 'Ŭ' => 'u',
		'ŭ' => 'u', 'Ů' => 'u', 'ů' => 'u', 'Ű' => 'u', 'ű' => 'u', 'Ų' => 'u',
		'ų' => 'u', 'Ŵ' => 'w', 'ŵ' => 'w', 'Ŷ' => 'y', 'ŷ' => 'y', 'Ÿ' => 'y',
		'Ź' => 'z', 'ź' => 'z', 'Ż' => 'z', 'ż' => 'z', 'Ž' => 'z', 'ž' => 'z',
		'ſ' => 'z', 'Ə' => 'e', 'ƒ' => 'f', 'Ơ' => 'o', 'ơ' => 'o', 'Ư' => 'u',
		'ư' => 'u', 'Ǎ' => 'a', 'ǎ' => 'a', 'Ǐ' => 'i', 'ǐ' => 'i', 'Ǒ' => 'o',
		'ǒ' => 'o', 'Ǔ' => 'u', 'ǔ' => 'u', 'Ǖ' => 'u', 'ǖ' => 'u', 'Ǘ' => 'u',
		'ǘ' => 'u', 'Ǚ' => 'u', 'ǚ' => 'u', 'Ǜ' => 'u', 'ǜ' => 'u', 'Ǻ' => 'a',
		'ǻ' => 'a', 'Ǽ' => 'ae','ǽ' => 'ae','Ǿ' => 'o', 'ǿ' => 'o', 'ə' => 'e',
		'Ё' => 'jo','Є' => 'e', 'І' => 'i', 'Ї' => 'i', 'А' => 'a', 'Б' => 'b',
		'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Ж' => 'zh','З' => 'z',
		'И' => 'i', 'Й' => 'j', 'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n',
		'О' => 'o', 'П' => 'p', 'Р' => 'r', 'С' => 's', 'Т' => 't', 'У' => 'u',
		'Ф' => 'f', 'Х' => 'h', 'Ц' => 'c', 'Ч' => 'ch','Ш' => 'sh','Щ' => 'sch',
		'Ъ' => '-', 'Ы' => 'y', 'Ь' => '-', 'Э' => 'je','Ю' => 'ju','Я' => 'ja',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e',
		'ж' => 'zh','з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l',
		'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
		'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
		'ш' => 'sh','щ' => 'sch','ъ' => '-','ы' => 'y', 'ь' => '-', 'э' => 'je',
		'ю' => 'ju','я' => 'ja','ё' => 'jo','є' => 'e', 'і' => 'i', 'ї' => 'i',
		'Ґ' => 'g', 'ґ' => 'g', 'א' => 'a', 'ב' => 'b', 'ג' => 'g', 'ד' => 'd',
		'ה' => 'h', 'ו' => 'v', 'ז' => 'z', 'ח' => 'h', 'ט' => 't', 'י' => 'i',
		'ך' => 'k', 'כ' => 'k', 'ל' => 'l', 'ם' => 'm', 'מ' => 'm', 'ן' => 'n',
		'נ' => 'n', 'ס' => 's', 'ע' => 'e', 'ף' => 'p', 'פ' => 'p', 'ץ' => 'C',
		'צ' => 'c', 'ק' => 'q', 'ר' => 'r', 'ש' => 'w', 'ת' => 't', '™' => 'tm',
	];

	/**
	 * Content data
	 *
	 * @var Data
	 */
	protected $_contentData = null;
	protected $_scopeConfigInterface;

	protected $_imageFactory;
	protected $_defaults = null;
	protected $_filter;
	protected $_helperMegaMenu;
	protected $_helperImgProducts;
	protected $_allLeafId;
	protected $_product;
	protected $_typeCurrentUrl = null;
	protected $_itemCurrentUrl = null;
	protected $_allActivedItems = null;
	protected $_allItemsFirstColumnId = null;

	public function __construct(
		Context $context,
		Defaults $defaults,
		ScopeConfigInterface $scopeConfigInterface,
		AbstractProduct $abstractProduct,
		ObjectManagerInterface $objectManager,
		DecoderInterface $urlDecoder,
		Filesystem $filesystem,
		Email $email,
		Image $image,
		Data $catalogData,
		\Magento\Framework\Image\AdapterFactory $imageFactory,
		ViewContext $viewContext,
		array $data = []
	)
	{
		parent::__construct($context, $data);
		$this->_objectManager = $objectManager;
		$this->_defaults = $defaults->get($data);
		$this->_urlDecoder = $urlDecoder;
		$this->_product = $abstractProduct;
		$this->_helperImgProducts = $image;
		$this->_directory = $filesystem;
		$this->_contentData = $catalogData;
		$this->_frontController = $viewContext;
		$this->_filter = $email;
		$this->_imageFactory = $imageFactory;
		$this->_scopeConfigInterface = $scopeConfigInterface;

		if(!$this->_defaults['isenabled'] || !$this->_defaults['group_id']) return;

		$menuItem = $this->createMenuItems();
		if($this->filterRouter()){
			if($this->_typeCurrentUrl == \Sm\MegaMenu\Model\Config\Source\Type::CMSPAGE ){
				$item_id = $this->_itemCurrentUrl;
			}
			if($this->_typeCurrentUrl == \Sm\MegaMenu\Model\Config\Source\Type::PRODUCT ){
				$item_id = 'product/'.$this->_itemCurrentUrl->getId();
			}
			if($this->_typeCurrentUrl == \Sm\MegaMenu\Model\Config\Source\Type::CATEGORY ){
				$item_id = 'category/'.$this->_itemCurrentUrl->getId();
			}

			// $this->_allActivedItems = $menuItem->getAllActivedItems($this->_typeCurrentUrl, $item_id, $this->_defaults['group_id']);
		}

		$itemsLeaf = $menuItem->getAllLeafByGroupId($this->_defaults['group_id']);
		$itemsids = $this->getAllItemsIds($itemsLeaf);
		$this->_allLeafId = ($itemsLeaf)?$itemsids:'';

		if(!$this->_allItemsFirstColumnId){
			$itemsFirstColumn = $menuItem->getAllItemsFirstByGroupId($this->_defaults['group_id']);
			$itemsids_firstcol = $this->getAllItemsIds($itemsFirstColumn);
			$this->_allItemsFirstColumnId = ($itemsFirstColumn)?$itemsids_firstcol:'';
		}

	}

	public function _getConfig($name=null, $value=null){
		if (is_null($this->_defaults)) $this->_defaults;
		if (!is_null($name) && !empty($name)){
			$valueRet = isset($this->_defaults[$name]) ? $this->_defaults[$name] : $value;
			return $valueRet;
		}
		return $this->_defaults;
	}

	public function _setConfig($name, $value = null)
	{
		if (is_null($this->_defaults)) $this->_defaults;
		if (is_array($name)) {
			$this->_defaults = array_merge($this->_defaults, $name);

			return;
		}
		if (!empty($name) && isset($this->_defaults[$name])) {
			$this->_defaults[$name] = $value;
		}
		return true;
	}

	protected function _toHtml()
	{
		if(!$this->_defaults['isenabled'] || !$this->_defaults['group_id']) return;

		$use_cache = (int)$this->_getConfig('use_cache');
		$cache_time = (int)$this->_getConfig('cache_time');
		$folder_cache = $this->_getCacheDir();
		$folder_cache = $folder_cache.'Sm/MegaMenu/';

		if(!file_exists($folder_cache))
			mkdir ($folder_cache, 0777, true);

		$options = array(
			'cacheDir' => $folder_cache,
			'lifeTime' => $cache_time
		);

		$Cache_Lite = new \Sm\MegaMenu\Block\Cache\Lite($options);

		if ($use_cache){
			$hash = md5( serialize($this->_getConfig()));
			if ($data = $Cache_Lite->get($hash)) {
				return  $data;
			} else {
				$template_file = $this->getTemplate();
				$template_file = (!empty($template_file)) ? $template_file : "Sm_MegaMenu::megamenu.phtml";
				$this->setTemplate($template_file);
				$data = parent::_toHtml();
				$Cache_Lite->save($data);
			}
		} else{
			if(file_exists($folder_cache))
				$Cache_Lite->_cleanDir($folder_cache);

			$template_file = $this->getTemplate();
			$template_file = (!empty($template_file)) ? $template_file : "Sm_MegaMenu::megamenu.phtml";
			$this->setTemplate($template_file);
		}
		return parent::_toHtml();
	}

	/**
	 * Retrieve front controller
	 *
	 * @return FrontControllerInterface
	 */
	public function getFrontController()
	{
		return $this->_frontController;
	}

	/*
	 * 	filter router current page
	 * 	return true mean url current have _typeCurrentUrl and _itemCurrentUrl
	 *  return false mean url current not
	 *  */
	public function filterRouter(){
		$stores = $this->_storeManager->getStore();
		$storesId = $stores->getId() ? $stores->getId() : \Magento\Store\Model\Store::DEFAULT_STORE_ID;
		$page = $this->_objectManager->create('Magento\Cms\Model\ResourceModel\Page')->checkIdentifier('home', $storesId);
		$current_page = '';
		/*
		* Check to see if its a CMS page
		* if it is then get the page identifier
		*/
		if($this->getFrontController()->getRequest()->getRouteName() == 'cms'){
			$this->_typeCurrentUrl = \Sm\MegaMenu\Model\Config\Source\Type::CMSPAGE ;
			$this->_itemCurrentUrl = $page;

			return true;
		}
		/*
		* If its not CMS page, then just get the route name
		*/
		if(empty($current_page)){
			$current_page = $this->getFrontController()->getRequest()->getRouteName();
		}
		/*
		* What if its a catalog page?
		* Then we can get the catalog category or catalog product :)
		*/
		if($current_page == 'catalog'){
			if($this->getRequest()->getControllerName()=='product') {
				$this->_typeCurrentUrl = \Sm\MegaMenu\Model\Config\Source\Type::PRODUCT ;
				$this->_itemCurrentUrl = $this->_objectManager->get('Magento\Framework\Registry')->registry('current_product');
				return true;
			}//do something
			if($this->getRequest()->getControllerName()=='category'){
				$this->_typeCurrentUrl = \Sm\MegaMenu\Model\Config\Source\Type::CATEGORY ;
				$this->_itemCurrentUrl = $this->_objectManager->get('Magento\Framework\Registry')->registry('current_category');
				return true;
			} //do others
		}
		return false;
		// 		else do not anything
	}

	public function getAllItemsIds($data)
	{
		$itemsids = [];
		if(count($data)>0)
		{
			foreach ($data as $item)
				$itemsids[] = $item['items_id'];

			return $itemsids;
		}
		return;
	}

	public function _helper(){
		return $this->_objectManager->get('Sm\MegaMenu\Helper\Data');
	}

	public function createMenuGroup(){
		return $this->_objectManager->get('Sm\MegaMenu\Model\MenuGroup');
	}

	public function createMenuItems(){
		return $this->_objectManager->get('Sm\MegaMenu\Model\MenuItems');
	}

	public function createMenuItemsCollection(){
		return $this->_objectManager->get('Sm\MegaMenu\Model\ResourceModel\MenuItems\Collection');
	}

	public function nameTable(){
		return $this->_objectManager->create('Sm\MegaMenu\Model\ResourceModel\MenuItems')->getMainTable();
	}

	public function _getCacheDir()
	{
		$cache = $this->_directory->getDirectoryWrite(DirectoryList::CACHE);
		return $cache->getAbsolutePath();
	}

	public function getConfigObject(){
		return $this->_defaults;
	}

	public function getItems()
	{
		$menuItems = $this->createMenuItems();
		$menuGroup = $this->createMenuGroup();
		$group_item = $menuGroup->load($this->_defaults['group_id']);
		if($group_item->getStatus() == \Sm\MegaMenu\Model\Config\Source\Status::STATUS_ENABLED){
			$collection_items = $menuItems->getItemsByLv($this->_defaults['group_id'], $this->_defaults['start_level']);
			return $collection_items;
		}
		else{
			return array();
		}
	}

	public function isLeaf($item)
	{
		return (in_array([$item['items_id']],[$this->_allLeafId]))?true:false;
	}

	public function hasConntentType($item){
		$contentType = [
			[\Sm\MegaMenu\Model\Config\Source\Type::CMSBLOCK],
			[\Sm\MegaMenu\Model\Config\Source\Type::CONTENT],
		];
		return (in_array([$item['type']],$contentType))?true:false;
	}

	public function hasLinkType($item){
		$linkType = [
			[\Sm\MegaMenu\Model\Config\Source\Type::EXTERNALLINK],
			[\Sm\MegaMenu\Model\Config\Source\Type::PRODUCT],
			[\Sm\MegaMenu\Model\Config\Source\Type::CATEGORY],
			[\Sm\MegaMenu\Model\Config\Source\Type::CMSPAGE],
		];
		return (in_array([$item['type']],$linkType))?true:false;
	}

	public function getLinkOfType($item){
		if($item['type'] == \Sm\MegaMenu\Model\Config\Source\Type::EXTERNALLINK){
			return $this->filterUrl($item);
		}
		elseif($item['type'] == \Sm\MegaMenu\Model\Config\Source\Type::PRODUCT){
			return $this->getProductLink($item);
		}
		elseif($item['type'] == \Sm\MegaMenu\Model\Config\Source\Type::CATEGORY){
			return $this->getCategoryLink($item);
		}
		elseif($item['type'] == \Sm\MegaMenu\Model\Config\Source\Type::CMSPAGE){
			return $this->getCMSPageLink($item);
		}
		else
			return '#';
	}

	public function getTargetAttr($type=''){
		$attribs = '';
		switch($type){
			default:
			case '0':
			case '':
				break;
			case '1':
			case '_blank':
				$attribs = "target=\"_blank\"";
				break;
			case '2':
			case '_popup':
				$attribs = "onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,false');return false;\"";
				break;
		}
		return $attribs;
	}

	public function getConvertTable()
	{
		return $this->_convertTable;
	}

	public function formatUrl($string)
	{
		return strtr($string, $this->getConvertTable());
	}

	public function filterUrl($item){
		/*$link = $this->_objectManager->create('Magento\Catalog\Model\Product\Url')->formatUrlKey(trim($item['data_type'])); // link bị validate chuyển các ký tự đặc biệt về dấu '-'*/
		$link = $this->formatUrl($item['data_type']);
		$link = strtolower($link);
		$haveHttp =  strpos($link, "http://");
		if(!$haveHttp && ($haveHttp!==0)){
			return "http://" . $link;
		}else {
			return $link;
		}
	}

	public function getProductLink($item){
		$filter = explode('/',$item['data_type']);	// product/3
		$productId = $filter[1];			//3
		$modelProducts = $this->_objectManager->create('Magento\Catalog\Model\Product');
		$product = $modelProducts->load($productId);
		return $product->getProductUrl();
	}

	public function getCategoryLink($item){
		$filter = explode('/',$item['data_type']);	// category/3
		$categoryId = $filter[1];			//3
		$modelCategory = $this->_objectManager->create('Magento\Catalog\Model\Category');
		$category = $modelCategory->load($categoryId);
		return $category->getUrl();
	}

	public function getCMSPageLink($item){
		$cmspageId = $item['data_type'];
		$helperPage = $this->_objectManager->get('Magento\Cms\Helper\Page');
		return $helperPage->getPageUrl($cmspageId);
	}

	public function isAlignRight($item){
		return ($item['align']==\Sm\MegaMenu\Model\Config\Source\Align::RIGHT)?true:false;
	}

	public function hasIcon($item){
		return ($item['icon_url'])?true:false;
	}

	public function filterImage($item){
		$params = explode('/',$item['icon_url']);
		$key = array_search('___directive', $params);
		if ($key)
		{
			$directive = $params[$key+1];
			$directive = $this->_urlDecoder->decode($directive);
			$url = $this->_filter->filter($directive);
			/*return $url;*/
			if($url)
			{
				return $item['icon_url'];
			}
		}
		else
		{
			return $this->_getMegaMenuDirMedia().$item['icon_url'];
		}
	}

	protected function _getBaseDirMedia()
	{
		$dir = $this->_directory->getDirectoryWrite(DirectoryList::MEDIA);
		return $dir->getAbsolutePath();
	}

	protected function _getMegaMenuDirMedia()
	{
		$dir = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		return $dir;
	}

	public function getContentType($item){
		if($item['type'] == \Sm\MegaMenu\Model\Config\Source\Type::CMSBLOCK){
			return $this->getBlockPageHtml($item);
		}
		elseif($item['type'] == \Sm\MegaMenu\Model\Config\Source\Type::CONTENT){
			return $this->getContentHtml($item);
		}
		else{
			return false;
		}
	}

	public function getBlockPageHtml($item){
		$blockId = $item['data_type'];
		$block = $this->getLayout()->createBlock('Magento\Cms\Block\Block')->setBlockId($blockId);
		return $block->toHtml();
	}

	public function getContentHtml($item){
		return $this->filterContent($item['content']);
	}

	public function filterContent($content){
		$helper = $this->_contentData;
		$processor = $helper->getPageTemplateProcessor();
		$html = $processor->filter($content);
		return $html;
	}

	public function isFirstCol($item){
		return (in_array([$item['items_id']],[$this->_allItemsFirstColumnId]))?true:false;
	}

	public function isDrop($item){
		// return ($item['show_as_group']==\Sm\MegaMenu\Model\Config\Source\Status::STATUS_DISABLED)?true:false;
		return (1 == \Sm\MegaMenu\Model\Config\Source\Status::STATUS_DISABLED)?true:false;
	}

	public function isLv($item, $lv){
		return (in_array([$item['items_id']],$lv))?true:false;
	}

	public function getItemHtml($item, $isFirstColumn =''){
		$align_right = '';
		$prefix = \Sm\MegaMenu\Model\Config\Source\Html::PREFIX;
		$divClassName = $prefix.'col_'.$item['cols_nb'];
		$firstClassName =($this->isFirstCol($item) OR $isFirstColumn)?$prefix.'firstcolumn ':'';
		$aClassName = ($this->isDrop($item))?$prefix.'drop':$prefix.'nodrop';
		$activedClassName = '';
		if($item['align'] && $item['align'] == \Sm\MegaMenu\Model\Config\Source\Align::RIGHT){
			$align_right = $prefix."right";
		}
		$html = '<div class="'.$divClassName.' '.$firstClassName.' '.$prefix.'id'.$item['items_id'].' '.$align_right.' '.$activedClassName.' '.$item['custom_class'].'">';
		$link = ($this->hasLinkType($item))?$this->getLinkOfType($item):'#';
		$title = ($item['show_title']==\Sm\MegaMenu\Model\Config\Source\Status::STATUS_ENABLED)?'<span class="'.$prefix.'title_lv-'.$item['depth'].'">'.$item['title'].'</span>':'&nbsp';
		$icon_title = ($this->hasIcon($item))?'<span class="icon_items_sub"><img src='.$this->filterImage($item).' alt="icon items sub" /></span><span class="'.$prefix.'icon">'.$title.'</span>':$title;

		if($this->isDrop($item) OR $this->hasLinkType($item)){
			$headTitle = '<a class="'.$aClassName.' '.$activedClassName.'" href="'.$link.'" '.$this->getTargetAttr($item['target']).' >'.$icon_title.'</a>';
		}
		else{
			$headTitle = $icon_title;
		}
		if($item['depth'] != $this->_defaults['start_level']){
			$html.= '<div class="'.$prefix.'head_item'.' '.$activedClassName.'">';

			if($item['show_title'] == \Sm\MegaMenu\Model\Config\Source\Status::STATUS_ENABLED OR $this->hasIcon($item)){
				$addClass['title'] = $prefix.'title';
				$html.= '<div class="'.implode(' ',$addClass).'">'.$headTitle.'</div>';
				$addClass=[];	//reset array
			}
			if($item['type'] == \Sm\MegaMenu\Model\Config\Source\Type::PRODUCT)
			{
				$html .= $this->getProduct($item);
			}

			if($item['type'] == \Sm\MegaMenu\Model\Config\Source\Type::CATEGORY)
			{
				$html.= $this->getCategory($item);
			}
			if($item['description']){
				$addClass['description'] = $prefix.'description';
				$html.= '<div class="'.implode(' ',$addClass).'"><p>'.$item['description'].'</p></div>';
			}

			$html.= '</div>';
		}

		$menuItems = $this->createMenuItems();

		$lv = $menuItems->getAllItemsInEqLv($item, 1, 'items_id');
		if(!$this->isLv($item, $lv)){
			if($item['depth']+1 <= $this->_defaults['end_level'])
			{
				$childItems = $menuItems->getAllItemsInEqLv($item, 1);
				if(!count($childItems)){	//fix issue: if item have child but child only and status child is disable
					if(!$this->hasLinkType($item)){
						$html.= '<div class="'.$prefix.'content">'.$this->getContentType($item).'</div>';
					}
					$html.= '</div>';
					return $html;
				}
				$cols_total = $item['cols_nb'];
				$cols_sub = intval($cols_total);
				foreach($childItems as $childItem){
					$cols_sub = $cols_sub - intval($childItem['cols_nb']);
					$isFirst = '';
					if($cols_sub < 0){			// if cols_sub
						$isFirst = 'isFirstColumn';
						// $cols_sub = $cols_total;	// this is bug, fix as below
						$cols_sub = $cols_total - intval($childItem['cols_nb']);	//reset cols_sub for new row
					}
					$html .= $this->getItemHtml($childItem, $isFirst);
				}
				$html .= '</div>';
			}else{
				if(!$this->hasLinkType($item)){
					$html.= '<div class="'.$prefix.'content">'.$this->getContentType($item).'</div>';
				}
				$html .= '</div>';
			}
		}else{
			if(!$this->hasLinkType($item)){
				$html.= '<div class="'.$prefix.'content">'.$this->getContentType($item).'</div>';
			}
			$html.= '</div>';
		}
		return $html;
	}

	public function getProductImage($product)
	{
		$baseDirMedia = $this->_getBaseDirMedia();
		$imgPro = ($product->getImage() != null) ? $product->getImage() : ($product->thumbnail != null ? $product->thumbnail : '');
		$_media_dir = $baseDirMedia.'catalog/product';
		$imagesUrl = $_media_dir . $imgPro;
		$images_path = [];
		if (file_exists($imagesUrl) || @getimagesize($imagesUrl) !== false) {
			array_push($images_path, $imagesUrl);
		}
		return is_array([$images_path]) && count($images_path) ? $images_path[0] : null;
	}

	protected function _getBaseDirPub()
	{
		$dir = $this->_directory->getDirectoryWrite(DirectoryList::PUB);
		return $dir->getAbsolutePath();
	}

	public function _resizeImage($image, $config,  $type = "product", $folder = 'resized')
	{

		$baseDirPub = $this->_getBaseDirPub();
		$baseDirMedia = $this->_getBaseDirMedia();
		if ($config['width'] <= 0) return $image;
		$_file_name = substr(strrchr($image, "/"), 1);
		$_media_dir = $baseDirMedia.'catalog'.'/'.$type.'/';
		$absPath = $image;
		$cache_dir = $_media_dir . $folder . '/' . $config['width']. '/' . md5(serialize($config));
		$dirImg = $baseDirPub.str_replace("/", "/", strstr($image, 'media'));
		$from_skin_nophoto = $baseDirPub.str_replace("/", "/", strstr($image, 'static'));
		$dirImg = strpos($dirImg, 'media') !== false ? $dirImg : '';
		$dirImg = (strpos($from_skin_nophoto, 'skin') !== false && $dirImg == '') ? $from_skin_nophoto : $dirImg;
		if (file_exists($cache_dir . '/' . $_file_name) && @getimagesize($cache_dir . '/' . $_file_name) !== false) {
			$new_image =$this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'catalog/' . $type . '/' . $folder . '/' . $config['width']. '/' . md5(serialize($config)) . '/' . $_file_name;
		} elseif ((file_exists($dirImg) && $dirImg != '')) {
			if (!is_dir($cache_dir)) {
				@mkdir($cache_dir, 0777, true);
			}
			$image = $this->_imageFactory->create();
			$image->open($absPath);
			$image->resize($config['width'], null);
			$image->save($cache_dir . '/' . $_file_name);
			$new_image = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'catalog/' . $type . '/' . $folder . '/' . $config['width'] . '/' . md5(serialize($config)) . '/' . $_file_name;
		} else {
			$new_image = $image;
			return $new_image;
		}
		return $new_image;
	}

	public function getProduct($item){
		$output = '';
		$prefix = \Sm\MegaMenu\Model\Config\Source\Html::PREFIX;
		$addClass['title'] = $prefix.'title';
		$filter = explode('/',$item['data_type']);	// product/3
		$productId = $filter[1];			//3
		$modelProducts = $this->_objectManager->create('Magento\Catalog\Model\Product');
		$modelReviewProducts = $this->_objectManager->create('Magento\Review\Model\Review\Summary');
		$product = $modelProducts->load($productId);
		$image = $this->getProductImage($product);
		$config = [
			'width' => 135
		];
		$productIdReview = $product->getId();
		$stores = $this->_storeManager->getStore();
		$storesId = $stores->getId() ? $stores->getId() : \Magento\Store\Model\Store::DEFAULT_STORE_ID;
		$summaryData = $modelReviewProducts->setStoreId($storesId)->load($productIdReview);
		$output .= '<div class="'.implode(' ', $addClass).' product-items">';
		if ($item['show_image_product'] == \Sm\MegaMenu\Model\Config\Source\Status::STATUS_ENABLED)
		{
			$output .= '<a href="'.$product->getProductUrl().'" '.$this->getTargetAttr($item['target']).' title="'.$this->escapeHtml($product->getName()).'" class="product-image"><img src="'.$this->_resizeImage($image, $config).'" alt="'.$this->escapeHtml($product->getName()).'" /></a>';
		}
		if ($item['show_title_product'] == \Sm\MegaMenu\Model\Config\Source\Status::STATUS_ENABLED)
		{
			$output .= '<h3 class="product-name"><a href="'.$product->getProductUrl().'" '.$this->getTargetAttr($item['target']).' title="'.$this->escapeHtml($product->getName()).'">'.$this->escapeHtml($product->getName()).'</a></h3>';
		}
		if ($item['show_rating_product'] == \Sm\MegaMenu\Model\Config\Source\Status::STATUS_ENABLED)
		{
			if ($summaryData['rating_summary'])
			{
				$output .= '<div class="product-reviews-summary short">';
				$output .= '<div class="rating-summary">';
				$output .= '<div class="rating-result" title="'.$summaryData['rating_summary'].'%">';
				$output .= '<span style="width:'.$summaryData['rating_summary'].'%;"><span>'.$summaryData['rating_summary'].'</span></span>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
			}
		}
		if ($item['show_price_product'] == \Sm\MegaMenu\Model\Config\Source\Status::STATUS_ENABLED)
		{
			$output .= '<div class="price-box">';
			$output .= '<span class="price-excluding-tax">';
			$output .= '<span class="price">'.$this->_product->getProductPrice($product).'</span>';
			$output .= '</span>';
			$output .= '</div>';
		}
		$output .= '</div>';
		return $output;
	}

	public function getCategory($item){
		$output = '';
		$dem = 0;
		$id_all_cat = '';
		$limitCat = (int)$item['limit_category'];
		$limitSubCat = (int)$item['limit_sub_category'];
		$limitSubCat = (int)$item['limit_sub_category'];
		$prefix = \Sm\MegaMenu\Model\Config\Source\Html::PREFIX;
		$activedClassName = '';
		$addClass['title'] = $prefix.'title';
		$aClassName = ($this->isDrop($item))?$prefix.'drop':$prefix.'nodrop';
		$filter = explode('/', $item['data_type']);
		$categoryId = $filter[1];
		$modelCategory = $this->_objectManager->create('Magento\Catalog\Model\Category');
		$category = $modelCategory->load($categoryId);
		$name_cat_parent = $category->getName();
		if ($category->getChildren())
		{
			$id_all_cat = explode(',', $category->getChildren());
		}
		if ($item['show_title_category'] == \Sm\MegaMenu\Model\Config\Source\Status::STATUS_ENABLED)
		{
			$output .= '<div class="'.implode(' ', $addClass).'">';
			$output .= '<h3 class="'.$aClassName.' '.$activedClassName.' title-cat">'.$name_cat_parent.'</h3>';
			$output .= '</div>';
		}
		if ($id_all_cat)
		{
			if (count($id_all_cat)>$limitCat)
				$limit = $limitCat;
			else
				$limit = count($id_all_cat);

			foreach ($id_all_cat as $ia)
			{
				$dem++;
				if (($limit == '') || ($dem <= $limit))
				{
					$categoryChild = $modelCategory->load($ia);
					$link = $categoryChild->getUrl();
					$title = '<span class="'.$prefix.'title_lv-'.$item['depth'].'">'.$categoryChild->getName().'</span>';
					$namecat = '<a class="'.$aClassName.' '.$activedClassName.'" href="'.$link.'" '.$this->getTargetAttr($item['target']).'>'.$title.'</a>';

					$output .= '<div class="'.implode(' ', $addClass).'">';
					$output .= $namecat;
					if ($item['show_sub_category'] == \Sm\MegaMenu\Model\Config\Source\Status::STATUS_ENABLED)
					{
						if ($categoryChild->getChildren()) {
							$id_all_cat_child = explode(',', $categoryChild->getChildren());
							if (count($id_all_cat_child) > $limitSubCat)
								$limitSub = $limitSubCat;
							else
								$limitSub = count($id_all_cat_child);

							$output .= $this->getCategoryChild($item, $id_all_cat_child, $limitSub);
						}
					}
					$output .= '</div>';
				}
			}
		}else
		{
			return;
		}
		return $output;
	}

	public function getCategoryChild($item, $id_all_cat_child, $limit)
	{
		$dem = 0;
		$output = '';
		$prefix = \Sm\MegaMenu\Model\Config\Source\Html::PREFIX;
		$aClassName = ($this->isDrop($item))?$prefix.'drop':$prefix.'nodrop';
		$activedClassName = '';
		$addClass['title'] = $prefix.'title';
		$modelCategory = $this->_objectManager->create('Magento\Catalog\Model\Category');
		if ($id_all_cat_child)
		{
			foreach ($id_all_cat_child as $iac)
			{
				$dem++;
				if (($limit == '') || ($dem <= $limit))
				{
					$category_child = $modelCategory->load($iac);
					$link = $category_child->getUrl();
					$title = '<span class="' . $prefix . 'title_lv-' . $item['depth'] . '">' . $category_child->getName() . '</span>';
					$namecat = '<a class="' . $aClassName . ' ' . $activedClassName . '" href="' . $link . '" ' . $this->getTargetAttr($item['target']) . ' >' . $title . '</a>';

					$output .= '<div class="' . implode(' ', $addClass) . '">';
					$output .= $namecat;
					if ($category_child->getChildren())
					{
						$id_all_cat_child = explode(',', $category_child->getChildren());
						$output .= $this->getCategoryChild($item, $id_all_cat_child, $limit);
					}
					$output .= '</div>';
				}
			}
		}else
		{
			return false;
		}
		return $output;
	}
}