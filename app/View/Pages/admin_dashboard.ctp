
<div>
	<!--
	- analytics
	
	
	- Offene Angebote
	
	- Lieferungen ohen Trackingcode
	
	- Offene Rechnungen
	
	- Rechnung in Mahnverfahren
	
	- Meistbestelle Produkte
	
	- Bester Kunde
	
	- Monatliche Ein- / Ausgaben
-->
</div>

<div class="container">    
        <div style="margin-top:50px;" class="mainbox col-md-3 col-md-offset-4 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-body" >
                    	<div class="col-md-12 text-center" >
	                    	<b><?php 
	                    	setlocale(LC_ALL, 'de_DE', 'German_Germany.1252');
	                    	echo date('F'); ?></b>
	                    </div>
                    	<div class="col-md-12 text-center" >
                    		<h1><?php echo $this->Number->currency($diff,'EUR', array('wholePosition' => 'after')); ?></h1>
	                    </div>
	                    <div class="row">
		                    <div class="col-md-6 pull-left" >
		                    	<b><?php echo $this->Number->currency($einnahme,'EUR', array('wholePosition' => 'after')); ?>    </b><i class="glyphicon glyphicon-circle-arrow-up" style="color: green; cursor: pointer; font-size: 22px; vertical-align: bottom;" data-toggle="popover" data-trigger="hover" data-placement="bottom"
									 data-content="Einnahmen"></i>
		                    </div>
		                    <div class="col-md-6pull-right text-right" >
		                    	<i class="glyphicon glyphicon-circle-arrow-down" style="color: red; cursor: pointer; font-size: 22px; vertical-align: bottom;" data-toggle="popover" data-trigger="hover" data-placement="bottom"
									 data-content="Ausgaben"></i>    <b><?php echo $this->Number->currency($ausgabe,'EUR', array('wholePosition' => 'after')); ?></b>
		                    </div>
	                    </div>
	                    
             </div>
        </div>
</div>






