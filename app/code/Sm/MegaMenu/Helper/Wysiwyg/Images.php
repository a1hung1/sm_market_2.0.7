<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 02-03-2016
 * Time: 15:19
 */
namespace Sm\MegaMenu\Helper\Wysiwyg;

class Images extends \Magento\Cms\Helper\Wysiwyg\Images
{
	/**
	 * Prepare Image insertion declaration for Wysiwyg or textarea(as_is mode)
	 *
	 * @param string $filename Filename transferred via Ajax
	 * @param bool $renderAsTag Leave image HTML as is or transform it to controller directive
	 * @return string
	 */
	public function getImageHtmlDeclaration($filename, $renderAsTag = false)
	{
		$fileurl = $this->getCurrentUrl() . $filename;
		$mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		$mediaPath = str_replace($mediaUrl, '', $fileurl);
		$directive = sprintf('{{media url="%s"}}', $mediaPath);

		if ($renderAsTag) {
			$html = sprintf('<img src="%s" alt="" />', $this->isUsingStaticUrlsAllowed() ? $fileurl : $directive);
		} else {
			if ($this->isUsingStaticUrlsAllowed()) {
				$html = $fileurl; // $mediaPath;
			} else {
				$directive = $this->urlEncoder->encode($directive);
				$html = $mediaPath;
			}
		}
		return $html;
	}
}