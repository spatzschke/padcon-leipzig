<div class="buttons">
		     
	    <!-- <div id="addToCustomer" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span> 
			<a href="#" class="btn btn-default">Kunde hinzufügen</a>
		</div> -->
		<div id="additionalAddress" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span> 
			<a href="#" class="btn btn-default">Weitere Adressen</a>
		</div>
		<!--
		<div id="addToOffer" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-th-large"></i></span>
			<a  href="#" class="btn btn-default">Produkt hinzufügen</a>
		 </div> -->
		<!-- <div id="settings" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
			<a href="#" class="btn btn-default">Einstellungen</a>
		 </div>
		 <br /> -->
		 <div id="createBilling" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
			<?php echo $this->Html->link('Rechnung erstellen', '/admin/Billings/convert/'.$this->data['Delivery']['id'], array('escape' => false, 'class' => 'btn btn-default')); ?>
		</div>
		 <div id="print" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-print"></i></span>
			<?php echo $this->Html->link('Drucken', '/admin/Deliveries/createPdf/'.$this->data['Delivery']['id'], array('escape' => false, 'class' => 'btn btn-default', 'target' => '_blank')); ?>
		</div>
		
	</div>