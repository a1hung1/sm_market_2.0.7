<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 23-12-2015
 * Time: 08:44
 */
namespace Sm\MegaMenu\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Defaults extends AbstractHelper
{
	CONST INENABLE = 1;
	CONST GROUP_ID = 1;
	CONST THEME = 1;
	CONST EFFECT = 1;
	CONST EFFECT_DURATION = 800;
	CONST START_LEVEL = 1;
	CONST END_LEVEL = 5;
	CONST INCLUDE_JQUERY = 1;

	protected $_defaults;
	protected $_scopeConfigInterface;

	public function __construct(
		Context $context,
		ScopeConfigInterface $scopeConfigInterface
	){
		$this->_scopeConfigInterface = $scopeConfigInterface;
		$this->_defaults = [
			/* General options */
			'isenabled'		    => self::INENABLE,
			'group_id'			=> self::GROUP_ID,
			'theme' 			=> self::THEME,			//default = Horizontal
			'effect'			=> self::EFFECT,		//default = css
			'effect_duration'   => self::EFFECT_DURATION,
			'start_level'		=> self::START_LEVEL,
			'end_level'			=> self::END_LEVEL,

			/* advanced options*/
			'include_jquery'	=> self::INCLUDE_JQUERY,
		];
		parent::__construct($context);
	}

	public function get($attributes = [])
	{
		$data       = $this->_defaults;
		$general    = $this->_scopeConfigInterface->getValue('megamenu/general');
		$advanced   = $this->_scopeConfigInterface->getValue('megamenu/advanced');
		if (!is_array($attributes))
			$attributes = [$attributes];

		if (is_array($general))
			$data = array_merge($data, $general);

		if (is_array($advanced))
			$data = array_merge($data, $advanced);

		return array_merge($data, $attributes);;
	}
}