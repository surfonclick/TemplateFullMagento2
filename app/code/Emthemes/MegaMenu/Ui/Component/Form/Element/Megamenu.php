<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\MegaMenu\Ui\Component\Form\Element;

use Magento\Framework\Data\Form\Element\Editor;
use Magento\Framework\Data\Form;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\DataObject;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Wysiwyg\ConfigInterface;

/**
 * Class Input
 */
class Megamenu extends \Magento\Ui\Component\Form\Element\AbstractElement
{
    const NAME = 'megamenu';

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var Editor
     */
    protected $editor;

    /**
     * @param ContextInterface $context
     * @param FormFactory $formFactory
     * @param ConfigInterface $wysiwygConfig
     * @param array $components
     * @param array $data
     * @param array $config
     */
    public function __construct(
        ContextInterface $context,
        FormFactory $formFactory,
        ConfigInterface $wysiwygConfig,
        \Emthemes\MegaMenu\Block\Adminhtml\Menu\FormFactory $blockFactory,
        array $components = [],
        array $data = [],
        array $config = []
    ) {
        $wysiwygConfigData = isset($config['wysiwygConfigData']) ? $config['wysiwygConfigData'] : [];
        $this->form = $formFactory->create();
        /*$this->editor = $this->form->addField(
            $context->getNamespace() . '_' . $data['name'],
            'Magento\Framework\Data\Form\Element\Editor',
            [
                'force_load' => true,
                'rows' => 20,
                'name' => $data['name'],
                'config' => $wysiwygConfig->getConfig($wysiwygConfigData),
                'wysiwyg' => isset($config['wysiwyg']) ? $config['wysiwyg'] : null,
            ]
        );*/
        $this->block = $blockFactory->create();
        $this->block->setTemplate('Emthemes_MegaMenu::menu_edit.phtml');
        //$data['config']['content'] = $this->editor->getElementHtml();
        $data['config']['content'] = $this->block->toHtml();

        parent::__construct($context, $components, $data);
    }

    /**
     * Get component name
     *
     * @return string
     */
    public function getComponentName()
    {
        return static::NAME;
    }
}
