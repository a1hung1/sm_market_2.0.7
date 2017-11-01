<?php
/**
 * Created by PhpStorm.
 * User: Vu Van Phan
 * Date: 09-12-2015
 * Time: 14:46
 */
namespace Sm\MegaMenu\Block\Adminhtml\MenuGroup\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
	protected function _prepareForm()
	{
		/** @var \Magento\Framework\Data\Form $form */
		$form = $this->_formFactory->create(
			[
				'data' => [
					'id' => 'edit_form',
					'action' => $this->getData('action'), 'method' => 'post'
				]
			]
		);
		$form->setUseContainer(true);
		$this->setForm($form);
		return parent::_prepareForm();
	}
}