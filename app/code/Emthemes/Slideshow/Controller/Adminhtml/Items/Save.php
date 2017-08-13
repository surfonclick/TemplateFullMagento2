<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 */

namespace Emthemes\Slideshow\Controller\Adminhtml\Items;
use Magento\Framework\App\Filesystem\DirectoryList;
class Save extends \Emthemes\Slideshow\Controller\Adminhtml\Items
{
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                $model = $this->_objectManager->create('Emthemes\Slideshow\Model\Items');
                $data = $this->getRequest()->getPostValue();
                $inputFilter = new \Zend_Filter_Input(
                    [],
                    [],
                    $data
                );
                $data = $inputFilter->getUnescaped();

                $id = $this->getRequest()->getParam('id');
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        throw new \Magento\Framework\Exception\LocalizedException(__('The wrong item is specified.'));
                    }
                }
				//newcode//
				$data_option["auto"]=$data["autoplay"];
				$data_option["loop"]=$data["loop"];
				$data_option["layout"]=$data["layout"];
				$data_option["change_trans"]=$data["change_trans"];
				$data_option["slider_skin"]=$data["slider_skin"];
				$data["configure_params"]=json_encode($data_option);
				$num_data=(int)$data['number'];
				$count_del=0;
				for($i=1;$i<=$num_data;$i++)
				{
					$deleteimage="delete_image_".$i;
					if(!isset($data[$deleteimage]))
					{
						$image_name="image_".$i;
						$positon_data="position_".$i;

						$url_data="link_url_".$i;
						try{
							$image123[$i]['image'] = $this->uploadimage($image_name);
						}catch (\Exception $e) {
							if ($e->getCode() == 0) {
								$this->messageManager->addError($e->getMessage());
							}
							$image123[$i]['image']=$this->checkvalue($image_name,$data);
						}
						$image123[$i]['position']=$data[$positon_data];
						$effect[$i]['position']=$data[$positon_data];
						$image123[$i]['url']=$data[$url_data];	
						$name_number_des="number-description-".$i;
						$name_number_index="number-index-".$i;
						$numberdes=(int)$data[$name_number_des];
						$numberindex=(int)$data[$name_number_index];						
						$image123[$i]["number-description"]=$numberdes;
						$t=1;
						// print_r($data);
						// exit;
						for($j=1;$j<=$numberdes;$j++)
						{
							$description_text="description".$j;
							$showdelay="showdelay".$j;
							$showduration="showduration".$j;
							$showease="showease".$j;
							$showeffect="showeffect".$j;
							
							$hidetime="hidetime".$j;
							$hideduration="hideduration".$j;
							$hideease="hideease".$j;
							$hideeffect="hideeffect".$j;				

							$data_offset_x="offset_x".$j;
							$data_offset_y="offset_y".$j;
							$data_origin="origin".$j;
							for($k=$t;$k<=$numberindex;$k++)
							{
								$getdata1="description_".$i."_".$k;
								$getdata2="show-delay-".$i."-".$k;
								$getdata3="show-duration-".$i."-".$k;
								$getdata4="show-ease-".$i."-".$k;
								$getdata5="show-effect-".$i."-".$k;
								$getdata6="hide-time-".$i."-".$k;
								$getdata7="hide-duration-".$i."-".$k;
								$getdata8="hide-ease-".$i."-".$k;
								$getdata9="hidden-effect-".$i."-".$k;
								$getdata10="offset-x-".$i."-".$k;
								$getdata11="offset-y-".$i."-".$k;
								$getdata12="origin-".$i."-".$k;
								if(isset($data[$getdata1]))
								{
									$t=$k+1;
									$data_des=$data[$getdata1];
									$data_show_delay=$data[$getdata2];
									$data_show_duration=$data[$getdata3];
									$data_show_ease=$data[$getdata4];
									$data_show_effect=$data[$getdata5];
									$data_hide_time=$data[$getdata6];
									$data_hide_duration=$data[$getdata7];
									$data_hide_ease=$data[$getdata8];
									$data_hide_effect=$data[$getdata9];
									$data_offsetx=$data[$getdata10];
									$data_offsety=$data[$getdata11];
									$dataorigin=$data[$getdata12];
									break 1;
								}
							}
							$image123[$i][$description_text]=$data_des;
							$effect[$i][$showdelay]=$data_show_delay;
							$effect[$i][$showduration]=$data_show_duration;
							$effect[$i][$showease]=$data_show_ease;
							$effect[$i][$showeffect]=$data_show_effect;
							$effect[$i][$hideease]=$data_hide_ease;
							$effect[$i][$hidetime]=$data_hide_time;
							$effect[$i][$hideduration]=$data_hide_duration;
							$effect[$i][$hideeffect]=$data_hide_effect;
							$effect[$i][$data_offset_x]=$data_offsetx;
							$effect[$i][$data_offset_y]=$data_offsety;
							$effect[$i][$data_origin]=$dataorigin;
						}								
					}
					else
					{
						$count_del=$count_del+1;					
					}
				}
				if($count_del!=0){
					$j=1;
					foreach($image123 as $value123)
					{
						$newimage[$j]=$value123;
						$j++;
					}
					$k=1;
					foreach($effect as $value456)
					{
						$neweffect[$k]=$value456;
						$k++;
					}	
				}
				else
				{
					$newimage=$image123;
					$neweffect=$effect;
				}
				$newimage=json_encode($newimage);
				$neweffect=json_encode($neweffect);
				$data["number"]=$num_data-$count_del;
				$data['slider_params']=$newimage;	
				$data["transition_effect"]=$neweffect;
                $model->setData($data);
                $session = $this->_objectManager->get('Magento\Backend\Model\Session');
                $session->setPageData($model->getData());
                $model->save();
                $this->messageManager->addSuccess(__('You saved the item.'));
                $session->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('emthemes_slideshow/*/edit', ['id' => $model->getId()]);
                    return;
                }
                $this->_redirect('emthemes_slideshow/*/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                $id = (int)$this->getRequest()->getParam('id');
                if (!empty($id)) {
                    $this->_redirect('emthemes_slideshow/*/edit', ['id' => $id]);
                } else {
                    $this->_redirect('emthemes_slideshow/*/new');
                }
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the item data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);
                $this->_redirect('emthemes_slideshow/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->_redirect('emthemes_slideshow/*/');
    }

	public function uploadimage($name)
	{
			$uploader = $this->_objectManager->create(
				'Magento\MediaStorage\Model\File\Uploader',
				['fileId' => $name]
			);
			$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

			/** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
			$imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();

			$uploader->addValidateCallback($name, $imageAdapter, 'validateUploadFile');
			$uploader->setAllowRenameFiles(true);
			$uploader->setFilesDispersion(true);

			/** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
			$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
								   ->getDirectoryRead(DirectoryList::MEDIA);
			$result = $uploader->save($mediaDirectory->getAbsolutePath('emthemes/slideshow'));
			$a= 'emthemes/slideshow'.$result['file'];
			return $a;
	
	}
	
	public function checkvalue($name,$data){
		if (isset($data[$name]) && isset($data[$name]['value'])) {
			if (isset($data[$name]['delete'])) {
				$data[$name] = "";
				// $data['delete_image'] = true;
			} else if (isset($data[$name]['value'])) {
				$data[$name] = $data[$name]['value'];
			} else {
				$data[$name] = "";
			}
		}
		return $data[$name];
		
	}	
}
