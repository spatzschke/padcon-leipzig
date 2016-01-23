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
	  <div class="panel-heading">Rechnungen</div>
	  <div class="panel-body">
	    <?php echo $this->Html->link('Rechnungen korrigieren', '/admin/billings/fillBillingPrice', array('class' => 'btn btn-danger')); ?>
	  </div>
	</div>
</div>                    
		
	</div>
</form>
</div>