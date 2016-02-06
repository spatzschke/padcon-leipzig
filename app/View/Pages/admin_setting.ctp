<div class="container"> 
      
<div class="mainbox ">                    
	<div class="panel panel-default  col-md-12">
	  <div class="panel-heading">Bilder-Datenbank</div>
	  <div class="panel-body">
	    <?php echo $this->Html->link('Bilder zu Produkt neu generierten', '/admin/images/findProductToImage', array('class' => 'btn btn-warning')); ?>
	  </div>
	</div>
	
	<div class="panel panel-default col-md-6">
	  <div class="panel-heading">Platzhalter erzeugen</div>
	  <div class="panel-body">
	    <?php echo $this->Html->link('Platzhalter für Lieferschein erstellen', '/admin/deliveries/add_placeholder', array('class' => 'btn btn-default')); ?>
		<?php echo $this->Html->link('Platzhalter für Rechnung erstellen', '/admin/billings/add_placeholder', array('class' => 'btn btn-default')); ?>
	  </div>
	</div>
	
	<div class="panel panel-default col-md-12">
	  <div class="panel-heading">Auftragsbestätigung</div>
	  <div class="panel-body">
	    <?php // echo $this->Html->link('AB-Kosten korrigieren', '/admin/Confirmations/fillConfirmationCosts', array('class' => 'btn btn-danger')); ?>
	  </div>
	</div>
	
	<div class="panel panel-default col-md-12">
	  <div class="panel-heading">Rechnungen</div>
	  <div class="panel-body">
	    <?php // echo $this->Html->link('Rechnungen korrigieren', '/admin/billings/fillBillingPrice', array('class' => 'btn btn-danger')); ?>
	  </div>
	</div>
	
	<div class="panel panel-default col-md-12">
	  <div class="panel-heading">Vorgänge</div>
	  <div class="panel-body">
	    <?php // echo $this->Html->link('Vorgänge generieren', '/admin/confirmations/fillPorcessIndex', array('class' => 'btn btn-danger')); ?>
	  </div>
	</div>
	
	<div class="panel panel-default col-md-12">
	  <div class="panel-heading">Produkte</div>
	  <div class="panel-body">
	    <?php  echo $this->Html->link('Akutelle Produktpreise in CartProducts übertrage', '/admin/products/fillCustomerProductPrice', array('class' => 'btn btn-danger')); ?>
	  </div>
	</div>
</div>                    
		
</div>
</form>
</div>