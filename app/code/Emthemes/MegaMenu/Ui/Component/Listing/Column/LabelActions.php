<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\MegaMenu\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class BlockActions
 */
class LabelActions extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT = 'megamenu/menu/edit';
    const URL_PATH_DELETE = 'megamenu/menu/delete';
    const URL_PATH_DETAILS = 'megamenu/menu/details';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $items
     * @return array
     */
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['menu_id'])) {
                    $label=$item['name'];
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'menu_id' => $item['menu_id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        /*'details' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DETAILS,
                                [
                                    'menu_id' => $item['menu_id']
                                ]
                            ),
                            'label' => __('Details')
                        ],*/
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'menu_id' => $item['menu_id']
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __("Delete $label"),
                                'message' => __("Are you sure you want to delete a $label record?")
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
