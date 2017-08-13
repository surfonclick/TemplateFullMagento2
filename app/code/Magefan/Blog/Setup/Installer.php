<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magefan\Blog\Setup;

use Magento\Framework\Setup;

class Installer implements Setup\SampleData\InstallerInterface
{
    /**
     * @var \Magento\CatalogSampleData\Model\Category
     */
    private $item;

    /**
     * @param \Magento\CatalogSampleData\Model\Category $category
     * @param \Magento\ThemeSampleData\Model\Css $css
     * @param \Emthemes\ThemeSettings\Model\Setup\Page $page
     * @param \Emthemes\ThemeSettings\Model\Setup\Block $block
     */
    public function __construct(
        \Magefan\Blog\Setup\Model\Post $post
    ) {
        $this->post = $post;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        $this->post->install(['Magefan_Blog::fixtures/posts.csv']);
    }
}
