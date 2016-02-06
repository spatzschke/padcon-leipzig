<?php 
	echo $this->Html->script('jquery.caret.1.02.min', false);
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.lazyload.min', false);
?>

<script>

$(document).ready(function() {
						
			
			$('.addAdditionalAddress').on('click', function(){
								
				
				var customerID = $(this).attr('cusId');
				var addressID = $(this).attr('addId');
				var offerID = <?php echo $controller_id;?>
				
				var obj = $(this);			
				obj.addClass('loading');
				
				var xhr = $.ajax({
					 type: 'POST',
					 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/<?php echo $controller_name; ?>/update/'+customerID+'/'+offerID+'/'+addressID,
					 success:function (data, textStatus) {
					 	
					 	window.location = '<?php echo FULL_BASE_URL.$this->base;?>/admin/<?php echo $controller_name;?>/edit/<?php echo $controller_id;?>';

					 }
				}); 
				
				return false;
			}); 
			
			$('#addAddress').on('click', function(){
				
				$('#address_add .modal-content').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Addresses\/add\/0\/<?php echo $customer['Customer']['id']; ?>\/<?php echo $type; ?>');
				$('#address_add').modal('show');
				$('#address_add').css('zIndex','5000')
				$('#address_add').css('display','block')
				
				return false;
			});
			
});



</script>
    <article class="module width_full productPortlet">
		<header>
			<?php
				
					//echo '<span>Addressen zu Kunde: '.$customer['Customer']['id'].' - '.$customer['Customer']['organisation'].'/span>';
					echo '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>';
			?>
			
		</header>
		<section id="filter">
			<div class="input-group search form-search">
	            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
	         	<input class="text form-control search-query" placeholder="Suche"/>   
	         	<div class="cancel"><i class="glyphicon glyphicon-remove"></i></div>                                
	        </div>	
		</section>

		<div class="module_content">
			
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th><?php __('');?></th>
					<th><?php echo('Abteilung');?></th>
					<th><?php echo('Anrede');?></th>
					<th><?php echo('Nachname');?></th>
					<th><?php echo('Straße');?></th>
					<th><?php echo('Stadt');?></th>
				</tr> 
			</thead> 
			<tbody> 
				<!-- <tr>
					<td colspan="4">
						<a id="addAddress">Adresse hinzufügen</a>
					</td>
				 --></tr>
				<?php 				
					foreach ($addresses as $address):?>	
						<tr>
							<?php	
																
							echo '<td>';
								echo $this->Html->link('<i class="glyphicon glyphicon-open"></i>', '', array('escape' => false, 'class' => 'addAdditionalAddress', 'addId' => $address['Address']['id'],
								 	'cusId' => $address['AddressAddresstype']['customer_id']));
							echo '</td>';	
							?>
							<td><?php echo $address['Address']['department']; ?>&nbsp;</td>
							<td><?php echo $address['Address']['salutation']; ?>&nbsp;</td>
							<td><?php echo $address['Address']['last_name']; ?>&nbsp;</td>
							<td><?php echo $address['Address']['street']; ?>&nbsp;</td>
							<td><?php echo $address['Address']['postal_code']; ?>&nbsp;<?php echo $address['Address']['city']; ?>&nbsp;</td>
						</tr> 
				<?php endforeach; ?>
			</tbody>
			 
			</table>
			
		</div><!-- end of .tab_container -->
		</article><!-- end of stats article -->