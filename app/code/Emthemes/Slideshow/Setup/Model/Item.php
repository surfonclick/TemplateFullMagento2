<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Emthemes\Slideshow\Setup\Model;

use Magento\Framework\Setup\SampleData\Context as SampleDataContext;

class Item
{
    /**
     * @var \Magento\Framework\Setup\SampleData\FixtureManager
     */
    private $fixtureManager;

    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvReader;

    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $itemFactory;

    /**
     * @param SampleDataContext $sampleDataContext
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     */
    public function __construct(
        SampleDataContext $sampleDataContext,
        \Emthemes\Slideshow\Model\ItemsFactory $itemFactory
    ) {
        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->itemFactory = $itemFactory;
    }

    /**
     * @param array $fixtures
     * @throws \Exception
     */
    public function install(array $fixtures)
    {
        foreach ($fixtures as $fileName) {
            $fileName = $this->fixtureManager->getFixture($fileName);
            if (!file_exists($fileName)) {
                continue;
            }

            $rows = $this->csvReader->getData($fileName);
            $header = array_shift($rows);

            foreach ($rows as $row) {
                $data = [];
                foreach ($row as $key => $value) {
                    $data[$header[$key]] = $value;
                }
                $row = $data;

                $this->itemFactory->create()
                    ->load($row['identity'], 'identity')
                    ->addData($row)
                    ->setStores([\Magento\Store\Model\Store::DEFAULT_STORE_ID])
                    ->save();
            }
        }
    }
}
