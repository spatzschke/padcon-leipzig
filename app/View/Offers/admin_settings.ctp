<script>
	$(document).ready(function() {
	
		$('#saveSettings').on('click', function(){
			
			<?php 
			
				$data = $this->Js->get('#OfferAdminSettingsForm')->serializeForm(array('isForm' => true, 'inline' => true)); 
			?>
			
			var xhr = null,
			obj = $(this);			
			obj.addClass('loading');
				xhr = $.ajax({
					 type: 'POST',
					 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/offers/settings',
					 data: <?php echo $data ?>,
					 success:function (data, textStatus) {
					 	
					 	obj.removeClass('loading');
					 	
						$("#offerSettigs_modal .modal-body").html(data);
						$('.wood_bg .pages').load('<?php echo FULL_BASE_URL.$this->base;?>/Offers/reloadOfferSheetProducts');
					 } 
				 }); 
				
			

			
			return false;
		});
		
		$('.remove').on('click', function() {
			var xhr = null,
			obj = $(this);					
			xhr = $.ajax({
				 type: 'POST',
				 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/offers/removeProductFromOffer/'+obj.attr('pdid'),
				 data: obj.attr('pdid'),
				 success:function (data, textStatus) {				 	
					$("#offerSettigs_modal .productTable").html(data);
					$('.wood_bg .pages').load('<?php echo FULL_BASE_URL.$this->base;?>/Offers/reloadOfferSheetProducts');
				 } 
			}); 			
			return false;
		})
	});

</script>

<div class="offer form">

<article class="module width_full customerPortlet">
		
		<div class="module_content row-fluid">
			
			<?php echo $this->Session->flash(); ?>
			
					<?php echo $this->Form->create('Offer');?>
					
					<div class="span7 productTable">
						
						<?php echo $this->element('backend/portlets/settingsProductTable'); ?>
					
					</div>
					<div class="span4">
						
					<?php
						echo $this->Form->input('request_date', array(
						    'label' => 'Angebotsdatum',
						    'type' => 'date',
							'dateFormat' => 'DMY',
							'class'=> 'span4 date',
							'separator' => '',
							'minYear' => date('Y') - 3,
    						'maxYear' => date('Y')));
							
						echo $this->Form->input('discount', array(
						    'label' => 'Rabatt',
						    'class'=> 'span3',
						    'after' => ' %',
							'min' => 0,
    						'max' => 100,
							'default' => 0));
						if(isset($this->data['Customer']['last_discount'])) {	
							echo "<div class='span12'>Letzter Rabatt bei diesem Kunden: ".$this->data['Customer']['last_discount']." %</div>";
						}
							
						echo $this->Form->input('additional_text', array(
						    'label' => 'Angebotstext'));
						
					?>
					
					</div>
					
					<div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
				        <button type="button" id="saveSettings" class="btn btn-primary">Speichern</button>
				      </div>
					

		</div><!-- end of .tab_container --> 
	</article><!-- end of stats article -->



</div>