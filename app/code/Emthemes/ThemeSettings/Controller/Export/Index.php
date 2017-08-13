<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\ThemeSettings\Controller\Export;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Catalog\Controller\Product
{
	private $_themeCollection;
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Cms\Model\ResourceModel\Page\Collection $pageCollection,
		\Magento\Cms\Model\ResourceModel\Block\Collection $blockCollection,
		\Magento\Cms\Model\Block $block,
		\Magento\Widget\Model\ResourceModel\Widget\Instance\Collection $widgetCollection,
		\Magento\Theme\Model\ResourceModel\Theme\Collection $themeCollection,
		\Magento\Widget\Model\Widget\InstanceFactory $widgetFactory
		)
	{
		$this->_widgetFactory = $widgetFactory;
		$this->pageCollection = $pageCollection;
		$this->blockCollection = $blockCollection;
		$this->widgetCollection = $widgetCollection;
		$this->_themeCollection = $themeCollection;
		$this->block = $block;
		parent::__construct($context);
	}
	public function execute()
	{
		$code = "";
		$name = "";
		if($this->getRequest()->getParam('code'))
			$code = $this->getRequest()->getParam('code');
		if($this->getRequest()->getParam('name'))
			$name = $this->getRequest()->getParam('name');
		if($name)
			$this->_themeCollection->addFieldToFilter('main_table.code',array('like'=>'%'.$name.'%'));    	
		$this->exportPage($code, $name);
		$this->exportBlock($code, $name);
		$this->exportWidget($code, $name);
		exit;
	}

	public function exportPage($theme_code, $theme_name)
	{
		$path = dirname(dirname(__DIR__)).'/fixtures/page';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		
		$this->pageCollection->addFieldToSelect('*');	

		
		
		foreach ($this->_themeCollection as $theme) {
			$list = array (
				array('title','page_layout','meta_keywords','meta_description','identifier','content_heading','content','is_active','sort_order','layout_update_xml','custom_theme','custom_root_template','custom_layout_update_xml','custom_theme_from','custom_theme_to')
			);
			$pageMatch = null;
			$pageMatch = $this->pageCollection->addFieldToFilter('identifier',array('like' => $theme_name.'%'));		
			$theme_path = $theme->getData('theme_path');
			$theme_identifier = str_replace('Emthemes/','',$theme_path);														
			foreach($pageMatch as $page){
				$data = [];
				foreach($list[0] as $attribute){
					$data[] = $page->getData($attribute);
				}
				$list[] = $data;
			}
			
			$fp = fopen($path.'/'.$theme_identifier.'.csv', 'w');

			foreach ($list as $fields) {
				fputcsv($fp, $fields);
			}

			fclose($fp);
		}		
		echo 'export page finish'.'<br/>';
	}

	protected function _initWidgetInstance($widget)
	{
		/** @var $widgetInstance \Magento\Widget\Model\Widget\Instance */
		$widgetInstance = $this->_widgetFactory->create();

		$code = 'cms_static_block';
		$instanceId = $widget->getInstanceId();
		if ($instanceId) {
			$widgetInstance->load($instanceId)->setCode($code);
			if (!$widgetInstance->getId()) {
				$this->messageManager->addError(__('Please specify a correct widget.'));
				return false;
			}
		} else {
            // Widget id was not provided on the query-string.  Locate the widget instance
            // type (namespace\classname) based upon the widget code (aka, widget id).
			$themeId = $widget->getThemeId();
			$type = $code != null ? $widgetInstance->getWidgetReference('code', $code, 'type') : null;
			$widgetInstance->setType($type)->setCode($code)->setThemeId($themeId);
		}
		return $widgetInstance;
	}

	public function exportWidget($theme_code, $theme_name)
	{
		$path = dirname(dirname(__DIR__)).'/fixtures/widget';	
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}			
		$widgetCollection = $this->widgetCollection->addFieldToSelect('*');
		$widgetCollection->join(array('t' => 'theme'), 'main_table.theme_id = t.theme_id',array('theme_path'));
		foreach ($this->_themeCollection as $theme) {
			$list = array (
				array('block_identifier', 'type_code', 'theme_path', 'title', 'page_groups', 'sort_order')
			);					
			$theme_path = $theme->getThemePath();
			$prefix = "Emthemes"."/".$theme_name."_";			
			$theme_identifier = str_replace('Emthemes/','',$theme_path);										
			foreach($widgetCollection as $widget){	
				if($widget->getData('theme_path') == $theme->getData('theme_path'))
				{			
					$data = array();
					$widget = $this->_initWidgetInstance($widget);
					$params = $widget->getWidgetParameters();
					$data['block_identifier'] = $this->block->load($params['block_id'])->getData('identifier');
					$data['type_code'] = 'cms_static_block';
					$data['theme_path'] = 'frontend/'.$theme->getData('theme_path');
					$data['title'] = $widget->getTitle();
					
					$pageGroups = $widget->getPageGroups();
					$tmpPg = [];
					foreach($pageGroups as $pageGroup){
						$tmp = [];
						$pg = $pageGroup['page_group'];
						$tmp['page_group'] = $pg;
						$tmp[$pg] = [];
						$tmp[$pg]['for'] = $pageGroup['page_for'];
						$tmp[$pg]['layout_handle'] = $pageGroup['layout_handle'];
						$tmp[$pg]['block'] = $pageGroup['block_reference'];
						//$tmp[$pg]['template'] = $pageGroup['page_template'];
						//$tmp[$pg]['page_id'] = '';
						$tmpPg[] = $tmp;
						unset($tmp);
					}
					$pageGroups = $tmpPg;
					$data['page_groups'] = serialize($pageGroups);
					
					$data['sort_order'] = $widget->getData('sort_order');
					$list[] = $data;
					unset($data);
				}
				}

				$fp = fopen($path.'/'.$theme_identifier.'.csv', 'w');			
				foreach ($list as $fields) {
					fputcsv($fp, $fields);
			}

			fclose($fp);
			unset($widgetThemeCollection);
			unset($list);
			unset($fp);
		}
		//$widgetCollection->addFieldToFilter('instance_id',20);
		//$widgetCollection->join(array('wip' => 'widget_instance_page'), 'main_table.instance_id = wip.instance_id');		
		$list = array (
			array('block_identifier', 'type_code', 'theme_path', 'title', 'page_groups', 'sort_order')
			);
		foreach($this->widgetCollection as $widget){
			
			$data = array();
			$widget = $this->_initWidgetInstance($widget);
			$params = $widget->getWidgetParameters();
			$data['block_identifier'] = $this->block->load($params['block_id'])->getData('identifier');
			$data['type_code'] = 'cms_static_block';
			$data['theme_path'] = 'frontend/'.$widget->getData('theme_path');
			$data['title'] = $widget->getTitle();
			//$data['page_group'] = $widget->getPageGroup();
			//$params = [];
			//$params['block'] = $widget->getData('block_reference');
			//$params['layout_handle'] = $widget->getData('layout_handle');
			$pageGroups = $widget->getPageGroups();
			$tmpPg = [];
			foreach($pageGroups as $pageGroup){
				$tmp = [];
				$pg = $pageGroup['page_group'];
				$tmp['page_group'] = $pg;
				$tmp[$pg] = [];
				$tmp[$pg]['for'] = $pageGroup['page_for'];
				$tmp[$pg]['layout_handle'] = $pageGroup['layout_handle'];
				$tmp[$pg]['block'] = $pageGroup['block_reference'];
				//$tmp[$pg]['template'] = $pageGroup['page_template'];
				//$tmp[$pg]['page_id'] = '';
				$tmpPg[] = $tmp;
			}
			$pageGroups = $tmpPg;
			$data['page_groups'] = serialize($pageGroups);
			
			$data['sort_order'] = $widget->getData('sort_order');
			$list[] = $data;
		}

		$fp = fopen($path.'/widgets.csv', 'w');

		foreach ($list as $fields) {
			fputcsv($fp, $fields);
		}

		fclose($fp);
		echo 'export widget finish'.'<br/>';
	}

	public function exportBlock($theme_code, $theme_name)
	{
		$path = dirname(dirname(__DIR__)).'/fixtures/block';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}				
		$this->blockCollection->addFieldToSelect('*');		
		$this->blockCollection->addFieldToFilter('identifier',array('like' => $theme_code.'%'));							
		foreach ($this->_themeCollection as $theme) {
			$blockMatch = $this->blockCollection->getData();
			$list = null;
			$data = null;	
			$list = array (
			array('title', 'identifier', 'content')
			);			
			
			$theme_path = $theme->getData('theme_path');			
			$theme_identifier = str_replace('Emthemes/','',$theme_path);
			$arrTemp = explode("_", $theme_identifier);		
			if($arrTemp[1] != 'default')
				$prefix = $theme_code.'-'.$arrTemp[1];		
			else
				$prefix = $theme_code;			
								
			foreach($blockMatch as $block){
				
				$data = [];				
				if(strpos($block['identifier'],$prefix)!== false)
				{	foreach($list[0] as $attribute){					
						$data[] = $block[$attribute];
					}				
					$list[] = $data;
				}
			}

			$fp = fopen($path.'/'.$theme_identifier.'.csv', 'w');

			foreach ($list as $fields) {
				fputcsv($fp, $fields);
			}

			fclose($fp);
		}	
					
		echo 'export block finish'.'<br/>';
	}
}

