<?php 
namespace Emthemes\Slideshow\Block\Widget;

use Magento\Framework\App\Filesystem\DirectoryList;

class Slideshow extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
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
        \Emthemes\Slideshow\Model\Resource\Items\CollectionFactory  $modelNewsFactory,
        array $data = []
    ) {
		
        $this->_modelitemsFactory = $modelNewsFactory;
		$this->_filesystem = $context->getFilesystem();
		$this->_storeManager = $context->getStoreManager();
		$this->_directory = $this->_filesystem->getDirectoryWrite(DirectoryList::MEDIA);
		$this->_imageFactory = $imageFactory;			
		$this->_coreRegistry = $coreRegistry;
        parent::__construct(
            $context,
            $data
        );
    }
	
	
	public function imageResize($name,$w,$h){

		$image=$name;

		$absPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath().$image;

		$imageResized = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('emthemes/resized/frontend/').$image;


		$imageResize = $this->_imageFactory->create();

		$imageResize->open($absPath);

		$imageResize->constrainOnly(TRUE);

		$imageResize->keepTransparency(TRUE);

		if($w!=""&&$h!="")
		{
			$imageResize->resize($w,$h);
		}
		else
		{
			$imageResize=$imageResize;
		}
		$dest = $imageResized ;

		$imageResize->save($dest);


		return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'emthemes/resized/frontend/'.$image;

	}		
		
	
	public function getSlideshow($id)
	{
		 $newsModel = $this->_modelitemsFactory->create()
								->addFieldToFilter('status','1')
								->addFieldToFilter('id',$id);
		$option="";
		foreach ($newsModel as $slider) {
					$option	= [
						'number' => $slider->getNumber(),
						'slider' => $slider->getData("slider_params"),
						'option' => $slider->getData("configure_params"),
						'id'	 => $slider->getIdentity(),
						'w'		 => $slider->getwidth(),
						'h' 	 => $slider->getHeight(),
						'effect' => $slider->getData("transition_effect"),
					];
		}
		 return $option;
	}	
	
	
	public function _toHtml()
    {

		$this->setTemplate('widget/slideshow_widget.phtml');
		return parent::_toHtml();
    }
}