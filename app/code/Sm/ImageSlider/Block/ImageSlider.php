<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 02-01-2016
 * Time: 00:41
 */
namespace Sm\ImageSlider\Block;

use Magento\Store\Model\StoreManagerInterface;

use Magento\Framework\Filesystem;
use Sm\ImageSlider\Block\Cache\Lite;
use Magento\Catalog\Block\Product\Context;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ImageSlider extends AbstractProduct
{
	protected $_directory;
	protected $_config = null;
	protected $_storeId = null;
	protected $_objectManager;
	protected $_scopeConfigInterface;

	public function __construct(
		StoreManagerInterface $storeManagerInterface,
		ScopeConfigInterface $scopeConfigInterface,
		ObjectManagerInterface $objectManager,
		PageFactory $resultPageFactory,
		Filesystem $filesystem,
		Context $context,
		array $data = [],
		$attr = null
	)
	{

		$this->_scopeConfigInterface = $scopeConfigInterface;
		$this->_config = $this->_getCfg($attr);
		$this->_directory = $filesystem;
		$this->resultPageFactory = $resultPageFactory;
		$this->_objectManager = $objectManager;
		$this->_storeId = $storeManagerInterface->getStore()->getId();
		if (!$this->_getConfig('isenabled', 1)) $this->_toHtml();
		parent::__construct($context, $data);
	}

	public function _prepareLayout()
	{
		return parent::_prepareLayout();
	}

	public function _getCfg($attr = null)
	{
		// get default config.xml
		$defaults = [];
		$collection = $this->_scopeConfigInterface->getValue('imageslider', \Magento\Store\Model\ScopeInterface::SCOPE_STORES,$this->_storeId);

		if (empty($collection)) return;
		$groups = [];
		foreach ($collection as $def_key => $def_cfg) {
			$groups[] = $def_key;
			foreach ($def_cfg as $_def_key => $cfg) {
				$defaults[$_def_key] = $cfg;
			}
		}

		// get configs after change
		$_configs = $this->_scopeConfigInterface->getValue('imageslider', \Magento\Store\Model\ScopeInterface::SCOPE_STORES,$this->_storeId);
		if (empty($_configs)) return;
		$cfgs = [];

		foreach ($groups as $group) {
			$_cfgs = $this->_scopeConfigInterface->getValue('imageslider/'.$group.'', \Magento\Store\Model\ScopeInterface::SCOPE_STORES,$this->_storeId);
			foreach ($_cfgs as $_key => $_cfg) {
				$cfgs[$_key] = $_cfg;
			}
		}

		// get output config
		$configs = [];
		foreach ($defaults as $key => $def) {
			if (isset($defaults[$key])) {
				$configs[$key] = $cfgs[$key];
			} else {
				unset($cfgs[$key]);
			}
		}
		$this->_config = ($attr != null) ? array_merge($configs, $attr) : $configs;
		return $this->_config;
	}

	public function _getConfig($name = null, $value_def = null)
	{
		if (is_null($this->_config)) $this->_getCfg();
		if (!is_null($name)) {
			$value_def = isset($this->_config[$name]) ? $this->_config[$name] : $value_def;
			return $value_def;
		}
		return $this->_config;
	}

	public function _setConfig($name, $value = null)
	{

		if (is_null($this->_config)) $this->_getCfg();
		if (is_array($name)) {
			$this->_config = array_merge($this->_config, $name);

			return;
		}
		if (!empty($name) && isset($this->_config[$name])) {
			$this->_config[$name] = $value;
		}
		return true;
	}

	protected function _toHtml()
	{
		if (!$this->_getConfig('isenabled', 1)) return;
		$use_cache = (int)$this->_getConfig('use_cache');
		$cache_time = (int)$this->_getConfig('cache_time');
		$folder_cache = $this->_directory->getDirectoryWrite(DirectoryList::CACHE)->getAbsolutePath();
		$folder_cache = $folder_cache.'Sm/ImageSlider/';
		if(!file_exists($folder_cache))
			mkdir ($folder_cache, 0777, true);

		$options = [
			'cacheDir' => $folder_cache,
			'lifeTime' => $cache_time
		];
		$Cache_Lite = new \Sm\ImageSlider\Block\Cache\Lite($options);
		if ($use_cache){
			$hash = md5( serialize($this->_getConfig()) );
			if ($data = $Cache_Lite->get($hash)) {
				return  $data;
			} else {
				$template_file = $this->getTemplate();
				$template_file = (!empty($template_file)) ? $template_file : "Sm_ImageSlider::default.phtml";
				$this->setTemplate($template_file);
				$data = parent::_toHtml();
				$Cache_Lite->save($data);
			}
		}else{
			if(file_exists($folder_cache))
				$Cache_Lite->_cleanDir($folder_cache);
			$template_file = $this->getTemplate();
			$template_file = (!empty($template_file)) ? $template_file : "Sm_ImageSlider::default.phtml";
			$this->setTemplate($template_file);
		}

		return parent::_toHtml();
	}

	public function _helper(){
		return $this->_objectManager->get('\Sm\ImageSlider\Helper\Data');
	}

	public function _getProductMedia()
	{
		$items = $this->_getConfig('product_additem');
		$items = unserialize($items);
		if (empty($items)) return;
		return $items;
	}

	protected function _getMegaMenuDirMedia()
	{
		$dir = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		return $dir;
	}

	public function _getProducts()
	{
		$helper = $this->_helper();
		$items = $this->_getProductMedia();

		$image_config = [
			'width' => (int)$this->_getConfig('img_width', 200),
			'height' => (int)$this->_getConfig('img_height', 200),
			'background' => (string)$this->_getConfig('img_background'),
			'function' => (int)$this->_getConfig('img_function')
		];
//var_dump((int)$this->_getConfig('img_width', 200));
//var_dump($this->_getConfig('img_height', null));
		$list = [];
		$i = 0;
		if (!empty($items)) {
			foreach ($items as $item) {
				$i++;
				$item['id'] = $i;
				if ($item['image'] != '' && $item['title'] != '') {
					$item['image'] = (strpos($item['image'], 'http') !== false) ? $item['image'] : $this->_getMegaMenuDirMedia() . $item['image'];
					if ($this->_getConfig('img_function') == 1) {
						$item['_image'] = $helper->_resizeImage($item['image'], $image_config);
					} else {
						$item['_image'] = $item['image'];
					}

					if (@getimagesize($item['_image']) == false) {
						if ($this->_getConfig('img_function') == 1) {
							$img_placeholder = $this->_getMegaMenuDirMedia() . $this->_getConfig('img_replacement');
							$item['_image'] = $helper->_resizeImage($img_placeholder, $image_config);
						} else {
							$item['_image'] = $this->_getMegaMenuDirMedia() . $this->_getConfig('img_replacement');
						}
					}

					$_title = $helper->_cleanText($item['title']);
					$item['title'] = $helper->truncate($_title, $this->_getConfig('product_title_maxlength'));

					$description = $helper->_cleanText($item['content']);
					$description = $helper->truncate($description, $this->_getConfig('product_description_maxlength'));
					$item['_description'] = $description;
					$list[] = (object)$item;
				}
			}
		}
		return $list;
	}


}