<script>
	$(document).ready(function() {
			
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

<?php echo $this->Session->flash(); ?>
<table class="table table-striped">
	<tr>
		<th></th>
		<th>#</th>
		<th>pd-#</th>
		<th>Name</th>
		<th>Farbe</th>
	</tr>
	
		<?php 

			foreach ($this->data['CartProducts'] as $products) {
				echo '<tr>';		
					echo '<td>

						<button type="button" class="btn btn-danger btn-lg remove active" pdid="'.$products['Product']['cartProduct_id'].'">
							<span class="glyphicon glyphicon-trash"></i></span>
						</button>
					
						</td>';
					echo '<td>'.$products['Product']['amount'].'</td>';
					echo '<td>pd-'.$products['Product']['product_number'].'</td>';
					echo '<td>'.$products['Product']['name'].'</td>';
					echo '<td><div class="color" style="background-color: #'.$products['Color']['rgb'].'"></div></td>';
				echo '</tr>';
			}

		?>
</table>