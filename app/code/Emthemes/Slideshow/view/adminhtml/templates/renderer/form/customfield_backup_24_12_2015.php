<?php 
	$id= $block->getId();  
?>
<?php if($id!=0) : ?>
<?php
	$data= $block->numberImage($id);
	$num=(int)$data["number"];
	$dataimage=json_decode($data["slider_param"],true); 	
?>
<input id="item_number" name="number" data-ui-id="slideshow-items-edit-form-fieldset-element-hidden-number" value="<?php echo $num; ?>" type="hidden">
<table class="data-grid" id="emthemes_slideshow_slideshow_setting" style="margin-bottom:15px;">
	<thead>             
			<th data-sort="image" data-direction="asc" class="" style="text-align:center;"><span>Image</span></th>
			<th data-sort="insert" data-direction="asc" class="" style="text-align:center;"><span>Choose Image</span></th>		
			<th data-sort="description" data-direction="asc" class="" style="text-align:center;"><span>Description</span></th>                                      
			<th data-sort="url" data-direction="asc" class="" style="text-align:center;"><span>URL</span></th>      
			<th data-sort="id" data-direction="asc" class="" style="text-align:center;"><span>Position</span></th>  	
			<th data-sort="delete" data-direction="asc" class="" style="text-align:center;"><span>Delete</span></th>		
			
		</tr>
	</thead>
<tbody class="data-image-wrap" id="data_image_wrap">
<?php $i=1; ?>
<?php foreach ($dataimage as $datacontent) : ?>

	<tr class="data-image" id="<?php echo "data_image_".$i; ?>">
		<td class="" >
			<?php if($datacontent['image']!="") : ?>
				<a href="#"  class="a-image" data-ui-id="slideshow-items-edit-form-fieldset-element-file-image-link"><img src="<?php echo $block->imageResize($datacontent['image'],50,50); ?>" id="<?php echo "item_image_image_".$i; ?>" title="" alt="" height="50" width="50" class="small-image-preview v-middle" data-ui-id="slideshow-items-edit-form-fieldset-element-file-image"></a>
			<?php endif; ?>
		</td>
		<td class="">
			<div class="admin__field-control control">
				<input id="<?php echo "item_image_".$i; ?>" name="<?php echo "image_".$i; ?>" data-ui-id="slideshow-items-edit-form-fieldset-element-file-image" value="" title="Image" type="file" class="input-file new-image">
				<input type="hidden" name="<?php echo "image_".$i."[value]"; ?>" value="<?php echo $datacontent['image']; ?>" class="hidden">				
				<div class="note" id="image-note">File types: jpg, jpeg, gif, png</div>
			</div>
			
		</td>
		<td class="" >	

				<?php 
					$number_des=(int)$datacontent["number-description"];
					var_dump($number_des);
				?>
				<div class="wrap-desciption" id="wrap_desciption_<?php echo $i ?>">	
				<input type="hidden" class="number-description" name="number-description-<?php echo $i ?>"  value="<?php echo $number_des ?>"/>			
				<input type="hidden" class="number-index" name="number-index-<?php echo $i ?>"  value="<?php echo $number_des ?>"/>		
				<?php for($j=1;$j<=$number_des;$j++) : ?>	
				<?php $a="description".$j; ?>		
					<div class="wrap-desciption-content" id="wrap_desciption_content_<?php echo $j ?>">
						<div class="admin__field-control control">
							<textarea id="item_description_<?php echo $i ?>_<?php echo $j ?>" name="description_<?php echo $i ?>_<?php echo $j ?>" value="" title="Description" type="text" class="input-text-large input-description" innerHTML><?php echo $datacontent[$a] ?></textarea>	
						</div>	
						<div class="admin__field-control control">
							<a id="item_transition_<?php echo $i?>_<?php echo $j ?>" name="transition_<?php echo $i ?>_<?php echo $j ?>"  title="transition" class="show-transition">Show</a>	
						</div>	
						<div class="delete-data-direction-wrap">
							<a class="delete-desciption" id="delete_desciption_<?php echo $i ?>_<?php echo $j ?>" onclick="">-</a>
						</div>
					</div>	
				<?php endfor; ?>
					<div class="button-wrap-desciption" id="button_wrap_desciption_<?php echo $i ?>">
						<a class="create-desciption" id="create_desciption_<?php echo $i ?>">+</a>
					</div>					
				</div>				
		</td>
		<td class="">
			<div><input id="<?php echo "item_position_".$i; ?>" name="<?php echo "position_".$i; ?>" value="<?php echo $datacontent["position"]; ?>" title="Item Position" type="text" class="input-text-small position-new"></div>
		</td>
		<td class="">
				<input id="<?php echo "item_url_".$i; ?>" name="<?php echo "link_url_".$i; ?>"  value="<?php echo $datacontent["url"]; ?>" title="URL" type="text" class="input-text  input-url"> 		
		</td>
		<td class="">
				<input type="checkbox" name="<?php echo "delete_image_".$i ?>" value="1" class="checkbox" id="<?php echo "delete_image_".$i; ?>" />	
		</td>		
	</tr>
	<?php $i=$i+1; ?>
<?php endforeach; ?>
<?php else: ?>
<input id="item_number" name="number" data-ui-id="slideshow-items-edit-form-fieldset-element-hidden-number" value="1" type="hidden">
<table class="data-grid" id="emthemes_slideshow_slideshow_setting">
	<thead>
		<tr>	                                       
			<th data-sort="image" data-direction="asc" class="" style="text-align:center;"><span>Image</span></th>
			<th data-sort="insert" data-direction="asc" class="" style="text-align:center;"><span>Choose Image</span></th>
			<!--th data-sort="delete" data-direction="asc" class="" style="text-align:center;"><span>Delete Image</span></th-->			
			<th data-sort="description" data-direction="asc" class="" style="text-align:center;"><span>Description</span></th>                                      
			<th data-sort="url" data-direction="asc" class="" style="text-align:center;"><span>URL</span></th>      
			<th data-sort="id" data-direction="asc" class="" style="text-align:center;"><span>Position</span></th>  	
			<th data-sort="delete" data-direction="asc" class="" style="text-align:center;"><span>Delete</span></th>				
		</tr>
	</thead>
<tbody class="data-image-wrap" id="data_image_wrap">
	<tr class="data-image" id="data_image_1" style="">
		<td></td>
		<td class="" >
			<div class="admin__field-control control">
				<input id="item_image_1" name="image_1" data-ui-id="slideshow-items-edit-form-fieldset-element-file-image" value="" title="Image" type="file" class="input-file new-image">
				<div class="note" id="image-note">Allowed file types: jpg, jpeg, gif, png</div>
			</div>
		</td>
				
		<td class="" >	
			<div class="wrap-desciption" id="wrap_desciption_1">
				<input type="hidden" class="number-description" name="number-description-1"  value="1"/>		
				<input type="hidden" class="number-index" name="number-index-1"  value="1"/>					
				<div class="wrap-desciption-content" id="wrap_desciption_content_1">
					<div class="admin__field-control control">
						<textarea id="item_description_1_1" name="description_1_1" data-ui-id="slideshow-items-edit-form-fieldset-element-text-description" value="" title="Description" type="text" class="input-text-large input-description" innerHTML></textarea>	
					</div>	
					<div class="admin__field-control control">
						<a id="item_transition_1_1" name="transition_1_1"  title="transition" class="show-transition">Show</a>	
					</div>	
					<div class="delete-data-direction-wrap">
						<a class="delete-desciption" id="delete_desciption_1_1" onclick="">-</a>
					</div>
				</div>
				<div class="button-wrap-desciption" id="button_wrap_desciption_1">
					<a class="create-desciption" id="create_desciption_1">+</a>
				</div>
			</div>
		</td>	
		<td class=" " data-ui-id="">
			<div class="admin__field-control control">	
				<input id="item_url_1" name="link_url_1"  value="" title="URL" type="text" class="input-text input-url"> 	
			</div>	
		</td>
		<td class="" data-ui-id="" >
			<div class="admin__field-control control">
				<input id="item_position_1" name="position_1"  value="1" title="Item Position" type="text" class="input-text-small position-new"> 
			</div>
		</td>	
		<td class="">
				<input type="checkbox" name="delete_image_1" value="1" class="checkbox" id="delete_image_1" />	
		</td>		
	</tr>

<?php endif ;?>
</tbody>
</table>
<div class="admin__field field field-width " data-ui-id="slideshow-items-edit-form-fieldset-element-form-field-width" style="margin-top:15px;">
	<button id="create_new_image" title="create_new" type="button" class="action-default scalable save primary ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-ui-id="#" role="button" aria-disabled="false"><span class="ui-button-text">
    <span>Create New Slider</span>
	</span></button>
</div>
<div class="admin__field field field-width " data-ui-id="slideshow-items-edit-form-fieldset-element-form-field-width">
	<button id="delete_new_image" title="delete_new" type="button" class="action-default scalable save primary ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-ui-id="#" role="button" aria-disabled="false"><span class="ui-button-text">
    <span>Delete Slider</span>
	</span></button>
</div>
<script type="text/javascript">
	require([
        "jquery",
		"jquery/ui"
		],function($){
			$( "a.create-desciption,a.delete-desciption, button" )
			  .button()
			  .click(function( event ) {
				a=$(this).attr("id");
				b=$(this).attr("class");
				if(a=="create_new_image")
				{
					var $div = $('tr[id^="data_image"]:last');
					var id= parseInt( $div.prop("id").match(/\d+/g), 10 );
					var num = id +1;
					alert($div.attr("id"));
					var $klon = $div.clone(true).prop('id', 'data_image_'+num ).insertAfter($('tr[id^="data_image"]:last'));
					// position
					$klon.find('.position-new').prop('id', 'item_position_'+num);
					$klon.find('.position-new').prop('name', 'position_'+num);
					$klon.find('.position-new').prop('value', '1');
					//image
					$klon.find('.small-image-preview').remove();
					$klon.find('.delete-image').remove();
					$klon.find('.new-image').prop('id','item_image_'+num);
					$klon.find('.new-image').prop('name','image_'+num);
					$klon.find('.new-image').prop('value',"");
					$klon.find('.hidden').remove();								
					//url
					$klon.find('.input-url').prop('name','link_url_'+num);
					$klon.find('.input-url').prop('id','item_url_'+num);		
					$klon.find('.input-url').prop('value','');	
					//delete
					$klon.find('.checkbox').prop('name','delete_image_'+num);
					$klon.find('.checkbox').prop('id','delete_image_'+num);		
					$klon.find('.checkbox').prop('value','0');		
					$klon.find('.create-desciption').prop('id','create_desciption_'+num);
					//index
					$klon.find('.number-index').prop('name','number-index-'+num);
					$klon.find('.number-index').prop('value',1);			
					$klon.find('.create-desciption').prop('id','create_desciption_'+num);					
					//button show-transition
					$klon.find(".wrap-desciption").prop("id","wrap_desciption_"+num);
					//remove some element				
					$numdes=$klon.find('.number-description').val();
					$klon.find(".number-description").prop("name","number-description-"+num);						
					$klon.find(".number-description").prop("value",1);	
					//description
					$klon.find('.input-description').prop('id','item_description_'+num+"_1");
					$klon.find('.input-description').prop('name','description_'+num+"_1");		
					$klon.find('.input-description').prop('value','');						
					if($numdes>1)
					{
						for(z=2;z<=$numdes;z++)
						{
							$namedel="#wrap_desciption_content_"+z;
							$klon.find($namedel).remove();
						}
					}
					$('#item_number').prop('value',num);						
				}
				else if(b.indexOf("create-desciption")!=-1)
				{
					var $parentdiv=$(this).parent().parent();
					var $content_des=$parentdiv.find(".wrap-desciption-content").last();
					var numpa = parseInt($content_des.prop("id").match(/\d+/g), 10 )+1;
					var wrapnum = parseInt( $parentdiv.prop("id").match(/\d+/g), 10 );
					var $cloneparent = $content_des.clone(true).prop('id', 'wrap_desciption_content_'+numpa ).insertAfter($content_des);		
						$parentdiv.find(".number-description").prop('value',numpa);
						$cloneparent.find('.input-description').prop('id','item_description_'+wrapnum+'_'+numpa);
						$cloneparent.find('.input-description').prop('name','description_'+wrapnum+'_'+numpa);		
						$cloneparent.find('.input-description').prop('value','');	
						$cloneparent.find('.delete-desciption').prop('id','delete_desciption_'+wrapnum+'_'+numpa);
						$parentdiv.find('.number-index').prop('value',numpa);
				}
				else if(b.indexOf("delete-desciption")!=-1)
				{
					// alert(b);
					value=$(this).parent().parent().parent().find(".number-description").val();
					value=parseInt(value)-1;				
					$(this).parent().parent().parent().find(".number-description").prop("value",value);
					var parentdiv=$(this).parent().parent();
					parentdiv.remove();
				}
				// else
				// {
					// alert("123");
				// }
				event.preventDefault();
			  });
        });
</script>