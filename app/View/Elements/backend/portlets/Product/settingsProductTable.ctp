<script>
	$(document).ready(function() {
			
		$('.remove').on('click', function() {
			var xhr = null,
			obj = $(this);					
			xhr = $.ajax({
				 type: 'POST',
				 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/<?php echo $controller;?>/removeProductFrom<?php echo $controller;?>/'+obj.attr('pdid')+'/<?php echo $controller_id;?>',
				 data: obj.attr('pdid'),
				 success:function (data, textStatus) {				 	
					$("#settigs_modal .productTable").html(data);
					$('.wood_bg .pages').load('<?php echo FULL_BASE_URL.$this->base;?>/<?php echo $controller;?>/reloadSheet/<?php echo $controller_id;?>');
				 } 
			}); 			
			return false;
		})
	
		$('.color').popover()
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
					echo '<td><div class="color" style="background-color: #'.$products['Color']['rgb'].'"data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="'.$products['Color']['name'].'"></div></td>';
				echo '</tr>';
			}

		?>
</table>