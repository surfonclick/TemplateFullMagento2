<?php
namespace Emthemes\Slideshow\Block\Adminhtml\Form\Renderer;
use Magento\Framework\App\Filesystem\DirectoryList;

class Customfield extends \Magento\Backend\Block\Widget\Form\Renderer\Fieldset\Element implements
       \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{
     
       protected $_template = 'Emthemes_Slideshow::renderer/form/customfield.phtml';

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

			$this->_storeManager = $context->getStoreManager();

			$this->_directory = $this->_filesystem->getDirectoryWrite(DirectoryList::MEDIA);

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
							'effect' => $slider->getData("transition_effect"),
						];
			}
			return $option;
		}
		
		
		// function resize image on admin
		public function imageResize($name,$w,$h){

			$image=$name;

			$absPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath().$image;

			$imageResized = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('emthemes/slideshow/resized/admin/').$image;


			$imageResize = $this->_imageFactory->create();

			$imageResize->open($absPath);

			$imageResize->constrainOnly(TRUE);

			$imageResize->keepTransparency(TRUE);


			$imageResize->resize($w,$h);


			$dest = $imageResized ;

			$imageResize->save($dest);


			return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'emthemes/slideshow/resized/admin/'.$image;

		}		
		
		
       public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
       {
               $this->_element = $element;
               $html = $this->toHtml();
               return $html;
       }
	   
	   public function optionEase()
		{
			return $option =[
					   "easeInCubic"=>"easeInCubic",
					   "easeOutCubic"=>"easeOutCubic",
					   "easeInOutCubic"=>"easeInOutCubic",
					   "easeInCirc"=>"easeInCirc",
					   "easeOutCirc"=>"easeOutCirc",
					   "easeInOutCirc"=>"easeInOutCirc",
					   "easeInExpo"=>"easeInExpo",
					   "easeOutExpo"=>"easeOutExpo",
					   "easeInOutExpo"=>"easeInOutExpo",
					   "easeInQuad"=>"easeInQuad",
					   "easeOutQuad"=>"easeOutQuad",
					   "easeInOutQuad"=>"easeInOutQuad",
					   "easeInQuart"=>"easeInQuart",
					   "easeOutQuart"=>"easeOutQuart",
					   "easeInOutQuart"=>"easeInOutQuart",
					   "easeInQuint"=>"easeInQuint",
					   "easeOutQuint"=>"easeOutQuint",
					   "easeInOutQuint"=>"easeInOutQuint",
					   "easeInSine"=>"easeInSine",
					   "easeOutSine"=>"easeOutSine",
					   "easeInOutSine"=>"easeInOutSine",
					   "easeInBack"=>"easeInBack",
					   "easeOutBack"=>"easeOutBack",
					];
		}
		
		public function optionEffect()
		{
			return $option =[

					 "fade"=>"fade",
					 "left(short)"=>"left(short)",
					 "left(long)"=>"left(long)",
					 "left(short,false)"=>"left(short,false)",
					 "left(long,false)"=>"left(long,false)",
					 "left(800)"=>"left(800)",
					 "left(200|800)"=>"left(200|800)",
					 "right(short)"=>"right(short)",
					 "right(long)"=>"right(long)",
					 "right(short,false)"=>"right(short,false)",
					 "right(long,false)"=>"right(long,false)",
					 "right(800)"=>"right(800)",
					 "right(200|800)"=>"right(200|800)",
					 "top(short)"=>"top(short)",
					 "top(long)"=>"top(long)",
					 "top(short,false)"=>"top(short,false)",
					 "top(long,false)"=>"top(long,false)",
					 "top(800"=>"top(800)",
					 "top(200|800)"=>"top(200|800)",
					 "bottom(short)"=>"bottom(short)",
					 "bottom(long)"=>"bottom(long)",
					 "bottom(short,false)"=>"bottom(short,false)",
					 "bottom(long,false)"=>"bottom(long,false)",
					 "bottom(800)"=>"bottom(800)",
					 "bottom(200|800)"=>"bottom(200|800)",
					 "rotate(50,c)"=>"rotate(50,c)",
					 "rotate(150,tl)"=>"rotate(150,tl)",
					 "rotate(-150,b)"=>"rotate(-150,b)",
					 "rotate(90,tr)"=>"rotate(90,tr)",
					 "rotate(-180,br)"=>"rotate(-180,br)",
					 "rotate(20,br)"=>"rotate(20,br)",
					 "rotate(20|180,l)"=>"rotate(20|180,l)",
					 "rotate(180|300)"=>"rotate(180|300)",
					 "rotate(-180|180,bl)"=>"rotate(-180|180,bl)",
					 "rotate(-360|360,tr)"=>"rotate(-360|360,tr)",
					 "rotateleft(40,50,c)"=>"rotateleft(40,50,c)",
					 "rotateleft(150,short,tl)"=>"rotateleft(150,short,tl)",
					 "rotateleft(-150,long,b)"=>"rotateleft(-150,long,b)",
					 "rotateleft(90,400,tr)"=>"rotateleft(90,400,tr)",
					 "rotateleft(-180,800,br)"=>"rotateleft(-180,800,br)",
					 "rotateleft(20,120,br)"=>"rotateleft(20,120,br)",
					 "rotateleft(20|180,100|300,l)"=>"rotateleft(20|180,100|300,l)",
					 "rotateleft(180|300,long)"=>"rotateleft(180|300,long)",
					 "rotateleft(-180|180,30,bl)"=>"rotateleft(-180|180,30,bl)",
					 "rotateleft(-360|360,10|120,tr)"=>"rotateleft(-360|360,10|120,tr)",
					 "rotateright(40,50,c)"=>"rotateright(40,50,c)",
					 "rotateright(150,short,tl)"=>"rotateright(150,short,tl)",
					 "rotateright(-150,long,b)"=>"rotateright(-150,long,b)",
					 "rotateright(90,400,tr)"=>"rotateright(90,400,tr)",
					 "rotateright(-180,800,br)"=>"rotateright(-180,800,br)",
					 "rotateright(20,120,br)"=>"rotateright(20,120,br)",
					 "rotateright(20|180,100|300,l)"=>"rotateright(20|180,100|300,l)",
					 "rotateright(180|300,long)"=>"rotateright(180|300,long)",
					 "rotateright(-180|180,30,bl)"=>"rotateright(-180|180,30,bl)",
					 "rotateright(-360|360,10|120,tr)"=>"rotateright(-360|360,10|120,tr)",
					 "rotatetop(40,50,c)"=>"rotatetop(40,50,c)",
					 "rotatetop(150,short,tl)"=>"rotatetop(150,short,tl)",
					 "rotatetop(-150,long,b)"=>"rotatetop(-150,long,b)",
					 "rotatetop(90,400,tr)"=>"rotatetop(90,400,tr)",
					 "rotatetop(-180,800,br)"=>"rotatetop(-180,800,br)",
					 "rotatetop(20,120,br)"=>"rotatetop(20,120,br)",
					 "rotatetop(20|180,100|300,l)"=>"rotatetop(20|180,100|300,l)",
					 "rotatetop(180|300,long)"=>"rotatetop(180|300,long)",
					 "rotatetop(-180|180,30,bl)"=>"rotatetop(-180|180,30,bl)",
					 "rotatetop(-360|360,10|120,tr)"=>"rotatetop(-360|360,10|120,tr)",
					 "rotatebottom(40,50,c)"=>"rotatebottom(40,50,c)",
					 "rotatebottom(150,short,tl)"=>"rotatebottom(150,short,tl)",
					 "rotatebottom(-150,long,b)"=>"rotatebottom(-150,long,b)",
					 "rotatebottom(90,400,tr)"=>"rotatebottom(90,400,tr)",
					 "rotatebottom(-180,800,br)"=>"rotatebottom(-180,800,br)",
					 "rotatebottom(20,120,br)"=>"rotatebottom(20,120,br)",
					 "rotatebottom(20|180,100|300,l)"=>"rotatebottom(20|180,100|300,l)",
					 "rotatebottom(180|300,long)"=>"rotatebottom(180|300,long)",
					 "rotatebottom(-180|180,30,bl)"=>"rotatebottom(-180|180,30,bl)",
					 "rotatebottom(-360|360,10|120,tr)"=>"rotatebottom(-360|360,10|120,tr)",
					 "skewleft(15,long)"=>"skewleft(15,long)",
					 "skewleft(-15,long)"=>"skewleft(-15,long)",
					 "skewleft(10,150)"=>"skewleft(10,150)",
					 "skewleft(-10,150)"=>"skewleft(-10,150)",
					 "skewleft(23,500)"=>"skewleft(23,500)",
					 "skewleft(20|30,200|400)"=>"skewleft(20|30,200|400)",
					 "skewright(15,long)"=>"skewright(15,long)",
					 "skewright(-15,long)"=>"skewright(-15,long)",
					 "skewright(10,150)"=>"skewright(10,150)",
					 "skewright(-10,150)"=>"skewright(-10,150)",
					 "skewright(23,500)"=>"skewright(23,500)",
					 "skewright(20|30,200|400)"=>"skewright(20|30,200|400)",
					 "skewtop(15,long)"=>"skewtop(15,long)",
					 "skewtop(-15,long)"=>"skewtop(-15,long)",
					 "skewtop(10,150)"=>"skewtop(10,150)",
					 "skewtop(-10,150)"=>"skewtop(-10,150)",
					 "skewtop(23,500)"=>"skewtop(23,500)",
					 "skewtop(20|30,200|400)"=>"skewtop(20|30,200|400)",
					 "skewbottom(15,long)"=>"skewbottom(15,long)",
					 "skewbottom(-15,long)"=>"skewbottom(-15,long)",
					 "skewbottom(10,150)"=>"skewbottom(10,150)",
					 "skewbottom(-10,150)"=>"skewbottom(-10,150)",
					 "skewbottom(23,500)"=>"skewbottom(23,500)",
					 "skewbottom(20|30,200|400)"=>"skewbottom(20|30,200|400)",
					 "front(long)"=>"front(long)",
					 "front(800)"=>"front(800)",
					 "front(1300)"=>"front(1300)",
					 "front(200|800)"=>"front(200|800)",
					 "back(long)"=>"back(long)",
					 "back(1300)"=>"back(1300)",
					 "back(800)"=>"back(800)",
					 "back(200|800)"=>"back(200|800)",
					 "rotatefront(40,400,c)"=>"rotatefront(40,400,c)",
					 "rotatefront(150,600,tl)"=>"rotatefront(150,600,tl)",
					 "rotatefront(-150,600,b)"=>"rotatefront(-150,600,b)",
					 "rotatefront(90,600,tr)"=>"rotatefront(90,600,tr)",
					 "rotatefront(-180,1300,br)"=>"rotatefront(-180,1300,br)",
					 "rotatefront(20,620,br)"=>"rotatefront(20,620,br)",
					 "rotatefront(20|180,500|1000,l)"=>"rotatefront(20|180,500|1000,l)",
					 "rotatefront(180|300,500)"=>"rotatefront(180|300,500)",
					 "rotatefront(-180|180,700,bl)"=>"rotatefront(-180|180,700,bl)",
					 "rotatefront(-360|360,400|900,tr)"=>"rotatefront(-360|360,400|900,tr)",
					 "rotateback(40,400,c)"=>"rotateback(40,400,c)",
					 "rotateback(150,600,tl)"=>"rotateback(150,600,tl)",
					 "rotateback(-150,600,b)"=>"rotateback(-150,600,b)",
					 "rotateback(90,600,tr)"=>"rotateback(90,600,tr)",
					 "rotateback(-180,1300,br)"=>"rotateback(-180,1300,br)",
					 "rotateback(20,620,br)"=>"rotateback(20,620,br)",
					 "rotateback(20|180,500|1000,l)"=>"rotateback(20|180,500|1000,l)",
					 "rotateback(180|300,500)"=>"rotateback(180|300,500)",
					 "rotateback(-180|180,700,bl)"=>"rotateback(-180|180,700,bl)",
					 "rotateback(-360|360,400|900,tr)"=>"rotateback(-360|360,400|900,tr)",
					 "rotate3dleft(90,0,0,0)"=>"rotate3dleft(90,0,0,0)",
					 "rotate3dleft(0,90,0,0)"=>"rotate3dleft(0,90,0,0)",
					 "rotate3dleft(45,0,0,0)"=>"rotate3dleft(45,0,0,0)",
					 'rotate3dleft(0,45,0,0)"'=>"rotate3dleft(0,45,0,0)",
					 "rotate3dleft(180,0,0,0)"=>"rotate3dleft(180,0,0,0)",
					 'rotate3dleft(0,180,0,0)"'=>"rotate3dleft(0,180,0,0)",
					 "rotate3dleft(0,180,0,0,r)"=>"rotate3dleft(0,180,0,0,r)",
					 "rotate3dleft(0,180,0,0,l)"=>"rotate3dleft(0,180,0,0,l)",
					 "rotate3dleft(180,0,0,0,t)"=>"rotate3dleft(180,0,0,0,t)",
					 "rotate3dleft(180,0,0,0,b)"=>"rotate3dleft(180,0,0,0,b)",
					 "rotate3dleft(80,0,0,short)"=>"rotate3dleft(80,0,0,short)",
					 "rotate3dleft(80,0,0,long)"=>"rotate3dleft(80,0,0,long)",
					 'rotate3dleft(30,0,0,10)"'=>"rotate3dleft(30,0,0,10)",
					 "rotate3dleft(30,50,0,50)"=>"rotate3dleft(30,50,0,50)",
					 "rotate3dleft(180,50,0,200)"=>"rotate3dleft(180,50,0,200)",
					 "rotate3dleft(-30,50,0,50)"=>"rotate3dleft(-30,50,0,50)",
					 "rotate3dleft(180,-50,0,100)"=>"rotate3dleft(180,-50,0,100)",
					 "rotate3dleft(180|360,-50|50,0,100|400,br)"=>"rotate3dleft(180|360,-50|50,0,100|400,br)",
					 "rotate3dright(80,0,0,short)"=>"rotate3dright(80,0,0,short)",
					 "rotate3dright(80,0,0,long)"=>"rotate3dright(80,0,0,long)",
					 "rotate3dright(30,0,0,10)"=>"rotate3dright(30,0,0,10)",
					 "rotate3dright(30,50,0,50)"=>"rotate3dright(30,50,0,50)",
					 "rotate3dright(180,50,0,200)"=>"rotate3dright(180,50,0,200)",
					 "rotate3dright(-30,50,0,50)"=>"rotate3dright(-30,50,0,50)",
					 "rotate3dright(180,-50,0,100)"=>"rotate3dright(180,-50,0,100)",
					 "rotate3dright(180|360,-50|50,0,100|400,br)"=>"rotate3dright(180|360,-50|50,0,100|400,br)",
					 "rotate3dtop(80,0,0,short)"=>"rotate3dtop(80,0,0,short)",
					 "rotate3dtop(80,0,0,long)"=>"rotate3dtop(80,0,0,long)",
					 "rotate3dtop(30,0,0,10)"=>"rotate3dtop(30,0,0,10)",
					 "rotate3dtop(30,50,0,50)"=>"rotate3dtop(30,50,0,50)",
					 "rotate3dtop(180,50,0,200)"=>"rotate3dtop(180,50,0,200)",
					 "rotate3dtop(-30,50,0,50)"=>"rotate3dtop(-30,50,0,50)",
					 "rotate3dtop(180,-50,0,100)"=>"rotate3dtop(180,-50,0,100)",
					 "rotate3dtop(180|360,-50|50,0,100|400,br)"=>"rotate3dtop(180|360,-50|50,0,100|400,br)",
					 "rotate3dbottom(80,0,0,short)"=>"rotate3dbottom(80,0,0,short)",
					 "rotate3dbottom(80,0,0,long)"=>"rotate3dbottom(80,0,0,long)",
					 "rotate3dbottom(30,0,0,10)"=>"rotate3dbottom(30,0,0,10)",
					 "rotate3dbottom(30,50,0,50)"=>"rotate3dbottom(30,50,0,50)",
					 "rotate3dbottom(180,50,0,200)"=>"rotate3dbottom(180,50,0,200)",
					 "rotate3dbottom(-30,50,0,50)"=>"rotate3dbottom(-30,50,0,50)",
					 "rotate3dbottom(180,-50,0,100)"=>"rotate3dbottom(180,-50,0,100)",
					 "rotate3dbottom(180|360,-50|50,0,50|100,br)"=>"rotate3dbottom(180|360,-50|50,0,50|100,br)",

					];
		}

		public function originData()
		{
			return $option=[
					   "Top left"=>"tl",
					   "Top center"=>"tc",
					   "Top right"=>"tr",
					   "Middle left"=>"ml",
					   "Middle center"=>"mc",
					   "Middle right"=>"mr",
					   "Bottom left"=>"bl",
					   "Bottom center"=>"bc",
					   "Bottom right"=>"br",				
			];
		}
}
