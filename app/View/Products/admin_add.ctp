<div class="container" style="padding-top: 50px">
	
	<?php echo $this->Form->create('Product', array(
		'class' => 'form-horizontal'
	)); ?> 
	
		<?php echo $this->element('backend/portlets/Product/productDetailPortlet'); ?>
		
		<div class="col-sm-12 controls">                          
			<?php 		
					echo '<input type="submit" value="Anlegen" class="btn btn-success form-control">';
			?>
		</div>
	</form>
	
	
</div>