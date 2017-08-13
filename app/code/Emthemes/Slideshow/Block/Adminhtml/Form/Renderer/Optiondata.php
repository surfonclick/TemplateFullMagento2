<?php
namespace Emthemes\Slideshow\Block\Adminhtml\Form\Renderer;
use Magento\Framework\App\Filesystem\DirectoryList;

class Optiondata extends \Magento\Backend\Block\Widget\Form\Renderer\Fieldset\Element implements
       \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{
     
       protected $_template = 'Emthemes_Slideshow::renderer/form/option.phtml';

		public $val=0;
		
		public function getTitle()
		{
			return "Foo Bar Baz";
		}
		
		public function setId($id)
		{
			$this->val=$id;
		}
		
		public function getId()
		{
			return $this->val;
		}		
		
		protected $_modelitemsFactory;
		 
		 
		public function __construct(
			\Magento\Backend\Block\Template\Context $context,
			\Magento\Framework\Registry $coreRegistry,
			// \Magento\Store\Model\StoreManagerInterface $storeManager,

			// \Magento\Framework\Filesystem $filesystem,

			\Magento\Framework\Image\AdapterFactory $imageFactory,
			
			\Emthemes\Slideshow\Model\Resource\Items\CollectionFactory  $modelNewsFactory
		) {
			
			$this->_modelitemsFactory = $modelNewsFactory;
			$this->_coreRegistry = $coreRegistry;
			$this->_filesystem = $context->getFilesystem();

			$this->_storeManager =$context->$getStoreManager();

			$this->_directory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);

			$this->_imageFactory = $imageFactory;			
			parent::__construct($context);
		}	

		
		public function numberImage($id)
		{
			$newsModel = $this->_modelitemsFactory->create()->addFieldToFilter('id',$id);
			foreach ($newsModel as $slider) {
						$option= [
							'name' => $slider->getName(),
							'slider_param' => $slider->getData('slider_params'),
							'number' => $slider->getNumber(),
						];
			}
			return $option;
		}
		
		
		// function resize image on admin
		public function imageResize($name,$w,$h){


		$image=$name;

		$absPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath().$image;

		$imageResized = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('emthemes/resized/admin/').$image;


		$imageResize = $this->_imageFactory->create();

		$imageResize->open($absPath);

		$imageResize->constrainOnly(TRUE);

		$imageResize->keepTransparency(TRUE);


		$imageResize->resize($w,$h);


		$dest = $imageResized ;

		$imageResize->save($dest);


		return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'emthemes/resized/admin/'.$image;

		}		
		
		
       public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
       {
               $this->_element = $element;
               $html = $this->toHtml();
               return $html;
       }
}