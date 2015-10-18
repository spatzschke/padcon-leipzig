<div class="buttons">

	    <div id="addCustomer_btn" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span> 
			<a href="#" class="btn btn-default">Kunde hinzufügen</a>
		</div>
		<div id="additionalAddress_btn" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span> 
			<a href="#" class="btn btn-default">Weitere Adressen</a>
		</div>
		<div id="addProduct_btn" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-th-large"></i></span>
			<a  href="#" class="btn btn-default">Produkt hinzufügen</a>
		 </div>
		<div id="settings_btn" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
			<a href="#" class="btn btn-default">Einstellungen</a>
		 </div>
		 <br />
		 <div id="createConfirmation" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
			<?php echo $this->Html->link('AB erstellen', '/admin/Confirmations/convert/'.$this->data['Offer']['id'], array('escape' => false, 'class' => 'btn btn-default')); ?>
		</div>
		 <div id="print_btn" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-print"></i></span>
			<?php echo $this->Html->link('Drucken', '/admin/offers/createPdf', array('escape' => false, 'class' => 'btn btn-default', 'target' => '_blank')); ?>
		</div>
		
	</div>