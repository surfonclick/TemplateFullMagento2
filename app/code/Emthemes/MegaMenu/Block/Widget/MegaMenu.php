<?php 
namespace Emthemes\MegaMenu\Block\Widget;

use Magento\Framework\App\Filesystem\DirectoryList;

class MegaMenu extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    
    
    protected $_modelitemsFactory;
    protected $_storeManager;
    protected $_filesystem;
    protected $_directory;
    protected $_imageFactory;
    protected $_coreRegistry;
     
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Emthemes\MegaMenu\Model\MenuFactory $menuFactory,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        /*\Magento\Store\Model\StoreManagerInterface $storeManager,*/
        array $data = []
    ) {
        $this->_menuFactory = $menuFactory;
        $this->_filterProvider = $filterProvider;
        $this->_storeManager = $context->getstoreManager();
        parent::__construct(
            $context,
            $data
        );
    }
    
    public function getMenu()
    {
        $menuId = $this->getMenuId();
        $menu = $this->_menuFactory->create()->load($menuId);
        $storeId = $this->_storeManager->getStore()->getId();
        $html = $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($menu->getFrontend());
        return $html;
    }

    public function getEnable()
    {
        $menuId = $this->getMenuId();
        $menu = $this->_menuFactory->create()->load($menuId);
        $storeId = $this->_storeManager->getStore()->getId();
        $enable= $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($menu->getIsActive());
        return $enable;
    }

    public function getIdMenu(){
        $menuId = $this->getMenuId();
        $menu = $this->_menuFactory->create()->load($menuId);
        $storeId = $this->_storeManager->getStore()->getId();
        $idmenu= $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($menu->getIdentifier());
        return $idmenu;        
    }
    
    public function getTypeMenu(){
        $menuId = $this->getMenuId();
        $menu = $this->_menuFactory->create()->load($menuId);
        $storeId = $this->_storeManager->getStore()->getId();
        $typemenu= $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($menu->getType());
        return $typemenu;        
    }

    public function _toHtml()
    {
        $this->setTemplate('widget/megamenu_widget.phtml');
        return parent::_toHtml();
    }
}
