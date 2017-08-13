<?php
namespace Emthemes\Slideshow\Block\Adminhtml\Form\Renderer;


class Option extends \Magento\Backend\Block\Widget\Form\Renderer\Fieldset\Element implements
       \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{
     
       protected $_template = 'Emthemes_Slideshow::renderer/form/option.phtml';

		public $val=0;
		

		
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
			\Emthemes\Slideshow\Model\Resource\Items\CollectionFactory  $modelNewsFactory
		) {
			
			$this->_modelitemsFactory = $modelNewsFactory;
			$this->_coreRegistry = $coreRegistry;			
			parent::__construct($context);
		}	

		
		public function optionLayout()
		{
			return $option =[
						'Boxed' => 'boxed',
						'Fullwidth' => 'fullwidth',
						'Fullscreen' => 'fullscreen',
						'Fillwidth'  => 'fillwidth',
						'Fullscreen' => 'fullscreen',
						'Autofill'   => 'autofill',
						'Partialview' => 'partialview'
					];
		}
		
		public function optionSlidetran()
		{
			return $option =[
						'Basic' => 'basic',
						'Fade' => 'fade',
						'Mask' => 'mask',
						'Wave'  => 'wave',
						'Flow'	=>	'flow',
						'Stack' =>  'scale',
						'Focus' => 'focus',
						'ParallaxMask' => 'parallaxMask',
						'PartialWave' => 'partialWave',
						'FadeBasic' => 'fadeBasic',
						'FadeWave' => 'fadeWave',
						'FadeFlow' => 'fadeFlow'
					];
		}
					
		
		
		public function optionSliderskin()
		{
			return $option =[
						'default' => 'ms-skin-default',
						'Light 2' => 'ms-skin-light-2',
						'Light 3' => 'ms-skin-light-3',
						'Light 4' => 'ms-skin-light-4',
						'Light 5' => 'ms-skin-light-5',
						'Light 6 ' => 'ms-skin-light-6',
						'Light 6 Round' => 'ms-skin-light-6 ms-skin-round',
						'Contrast' => 'ms-skin-contrast',
						'Black 1' => 'ms-skin-black-1',
						'Black 2' => 'ms-skin-black-2',
						'Black 2 Round' => 'ms-skin-black-2 ms-skin-round',
						'Metro' => 'ms-skin-metro'				
					];
		}
		
		public function optionData($id)
		{
			$newsModel = $this->_modelitemsFactory->create()->addFieldToFilter('id',$id);
			$option="";
			foreach ($newsModel as $slider) {
						$option= [
							'configure' => $slider->getData('configure_params'),
						];
			}
			return $option;
		}
		
       public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
       {
               $this->_element = $element;
               $html = $this->toHtml();
               return $html;
       }
}