<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 */
namespace Emthemes\Slideshow\Block\Adminhtml\Items\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('emthemes_items_form');
        $this->setTitle(__('Slideshow Configure'));
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('emthemes_slideshow/items/save'),
                    'method' => 'post',
					'enctype' => 'multipart/form-data',
                ],
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
