<?php 
	echo $this->Html->script('jquery.bootstrap.tooltip', false);
	echo $this->Html->script('jquery.bootstrap.popover', false);
	echo $this->Html->css('productItem');
	
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.lazyload.min', false);

?>

<script>

$(document).ready(function() {
			
	$(".module form").liveValidation({
						url: '<?php echo FULL_BASE_URL.$this->base;?>\/Products\/liveValidate\/',
						urlBase: '<?php echo FULL_BASE_URL.$this->base;?>',
						autoSave: false});
						
	$("img.lazy").lazyload();
	
	$('.imageBox select').live('change', function() {
		var str = "";
	    $(".imageBox select option:selected").each(function () {
	            str = $(this).val();
	            
	            if(str == '') {
		            str = '99';
	            }
	          });
	          
	    loadIframe('ProductImageUpload', updateURL($('#ProductImageUpload').attr('src'), 'c', str))

	});
			
});

function saveImageInDb(response) {
				 
	 var data = {
		    data: {
				product_number : response['data']['product_number'],
				color : response['data']['color'],
				path : response['data']['path'],
				ext : response['data']['ext']
			}
     };
     
     
	 
	 $.ajax({
		 type: 'POST',
		 url:'<?php echo FULL_BASE_URL.$this->base;?>\/Images\/add\/',
		 data: response,
		 success:function (data, textStatus) {
				$('.imageBox').find('img').attr('src',response['data']['path']+'t.'+response['data']['ext']+'?'+new Date().getTime());
				//$.colorbox.close();
		 } 
		 
		
	 }); 
	 
}
			
function loadIframe(iframeName, url) {
    var $iframe = $('#' + iframeName);
    if ( $iframe.length ) {
        $iframe.attr('src',url);   
        return false;
    }
    return true;
}

function updateURL(currUrl, param, paramVal){
    var url = currUrl
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var aditionalURL = tempArray[1]; 
    var temp = "";
    if(aditionalURL)
    {
        var tempArray = aditionalURL.split("&");
        for ( i=0; i<tempArray.length; i++ ){
            if( tempArray[i].split('=')[0] != param ){
                newAdditionalURL += temp+tempArray[i];
                temp = "&";
            }
        }
    }
    var rows_txt = temp+""+param+"="+paramVal;
    var finalURL = baseURL+"?"+newAdditionalURL+rows_txt;
    return finalURL;
}
</script>


<article class="module width_full productPortlet">
		<header>
			<?php 	
				if(empty($this->data['Product']['product_number'])) {
			?>
				<h3 class=""><?php __('Produkte hinzufuegen');?></h3>
			<?php
				} else {
			?>
				<h3 class=""><?php __('Produkte bearbeiten');?></h3>
			<?php
				}
			?>
				
		</header>
		<div class="module_content row-fluid">
					<?php echo $this->Form->create('Product', array('data-model' => 'Product'));?>
					
					<div class="span4">
					
					<?php
						
						echo $this->Form->input('id', array( 'data-field' => 'id'));
						echo $this->Form->input('product_number', array('label' => 'Produktnummer',  'data-field' => 'product_number'));
						
						echo $this->Form->input('name', array('label' => 'Produktname',  'data-field' => 'name'));
						echo $this->Form->input('category_id', array('label' => 'Kategorie', 'empty' => 'Bitte Kategorie wählen',  'data-field' => 'category_id'));
						echo $this->Form->input('material_id', array('label' => 'Material', 'empty' => 'Bitte Material ählen',  'data-field' => 'material_id'));
						echo $this->Form->input('price', array('label' => 'Preis',  'data-field' => 'price'));
						echo $this->Form->input('size_id', array('label' => 'Größe', 'empty' => 'Bitte Größe wählen',  'data-field' => 'size_id'));
					?>
					</div>
					<div class="span4">
					<?php	
						echo $this->Form->input('description', array('label' => 'Beschreibung',  'data-field' => 'description'));
						echo $this->Form->input('featurelist', array('label' => 'Featureliste',  'data-field' => 'featurelist'));
						
						
						echo $this->Form->input('active', array('label' => 'Aktiv',  'data-field' => 'active'));
						echo $this->Form->input('new', array('label' => 'Neuheit',  'data-field' => 'new'));
					?>
					
					</div>
					<div class="span3 imageBox">
						
						<?php 	
						if(!empty($this->data['Image'])) {
						?>
							<label for="ProductImageUpload">Aktuelles Bild</label>
							<img src="<?php echo $this->data['Image'][0]['path'].'t.'.$this->data['Image'][0]['ext']; ?>" />
						<?php
						}
						?>
						<?php 	
						if(!empty($this->data['Product']['product_number'])) {
						?>
							<label for="ProductImageUpload">Neues Bild hochladen</label>
							<iframe id="ProductImageUpload" class="iframe" width="250" height="250" frameborder="0" src="<?php echo FULL_BASE_URL; ?>/media/index.php?p=<?php echo $this->data['Product']['product_number'];?>&c=99"></iframe>
						<?php
						}
						?>
					<?php 	
						if(!empty($this->data['Material']))
							echo $this->Form->select('Color',$colors, null, array('empty' => 'Allgemein', 'class' => 'noValid'));
					?>
					</div>
					<div class="span10">
					
						<?php echo $this->Form->end(__('Submit', true));?>	
					
					</div>
					<div class="livePreview">
						
					</div>

		</div><!-- end of .tab_container -->
	</article><!-- end of stats article -->
	<script>





</script>


