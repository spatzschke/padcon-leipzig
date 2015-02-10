<div class="buttons">

	<!-- <div id="settings" class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
		<a href="#" class="btn btn-default">Einstellungen</a>
	 </div> -->
	
	<div id="print" class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-print"></i></span>
		<?php echo $this->Html->link('Drucken', '/admin/billings/createPdf/'.$this->data['Billing']['id'], array('escape' => false, 'class' => 'btn btn-default', 'target' => '_blank')); ?>
	</div>
</div>