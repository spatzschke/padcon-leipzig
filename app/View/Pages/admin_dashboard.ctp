
<div>
	<!--
	- analytics
	
	- Lieferungen ohen Trackingcode
	

-->
</div>

<div class="container">   
	<div class="row">
		
<!-- Überfällige Rechnungen -->
	<?php  if(!empty($warningBilling)) {?>
		 <div style="margin-top:50px;" class="col-md-4">                    
            <div class="panel panel-danger" >
            	 <div class="panel-heading">
		        	<h4><i style="color: red; font-size: 20px; left: -10px; padding: 0 5px 0 10px; top: 3px;" class="glyphicon glyphicon-alert"></i>Überfällige Rechnungen</h4>
		         </div>
                 <div class="panel-body" >
                 	<table class="table table-striped">
					  	<thead> 
					  		<tr> 
					  			<th>#</th> 
					  			<th>Rechnung</th> 
					  			<th style="text-align: right">Überfällig seit</th>
					  		</tr> 
					  	</thead> 
					  	<tbody> 
					  		<?php foreach ($warningBilling as $key => $value) { 
								echo '<tr>'; 									
									echo '<td><b>'.($key + 1).'</b></td>'; 
									echo '<td><b>'.$value['number'].'</td>'; 
									echo '<td style="text-align: right"><b>'.$value['interval'].' Tag(e)</b></td>'; 
	
								echo '</tr>';  
							} ?>
					  	</tbody>
					</table>  
                 </div>
            </div>
        </div>
<?php }?>
<!-- Umsatzübersicht -->		
        <div style="margin-top:50px;" class="col-md-3 col-md-offset-<?php  if(!empty($warningBilling)) {echo '0';} else { echo '4'; } ?>">                    
            <div class="panel panel-info" >
                 <div class="panel-body" >
                    <?php
                    	$month = intval(date('m', strtotime('now')));
                    ?>
                    	
                    	<div class="col-md-12 text-center" >
	                    	<h3><b><?php echo $umsatz[$month-1]['MONAT']; ?></b></h3>
	                    </div>
                    	<div class="col-md-12 text-center" style="margin-bottom: 15px;">
                    		<h1><?php echo $this->Number->currency($umsatz[$month-1]['DIFFERENZ'],'EUR', array('wholePosition' => 'after')); ?></h1>
	                    </div>
	                    
	                    <div class="row">
		                    <div class="col-md-6 pull-left" >
		                    	<b><?php echo $this->Number->currency($umsatz[$month-1]['EINNAHME'],'EUR', array('wholePosition' => 'after')); ?>    </b><i class="glyphicon glyphicon-circle-arrow-up" style="color: green; cursor: pointer; font-size: 22px; vertical-align: bottom;" data-toggle="popover" data-trigger="hover" data-placement="bottom"
									 data-content="Einnahmen"></i>
		                    </div>
		                    <div class="col-md-6pull-right text-right" >
		                    	<i class="glyphicon glyphicon-circle-arrow-down" style="color: red; cursor: pointer; font-size: 22px; vertical-align: bottom;" data-toggle="popover" data-trigger="hover" data-placement="bottom"
									 data-content="Ausgaben"></i>    <b><?php echo $this->Number->currency($umsatz[$month-1]['AUSGABE'],'EUR', array('wholePosition' => 'after')); ?></b>
		                    </div>
	                    </div>
	                    
             </div>
        	</div>
       </div> 

       <div style="padding-left: 0" class="col-md-12">                    
            <div class="panel panel-info" >
                 <div class="panel-body">
                 	<table class="table table-striped visible-sm">
					  	<thead> 
					  		<tr>
					  			<th></th>
					  			<th style="text-align: center">Rechnungen</th>
					  			<th style="text-align: center">Lieferanten</th>
					  			<th style="text-align: center">Ergebnis</th>
					  		</tr> 
					  	</thead>				  
					  	<tbody> 
					  		<?php foreach ($umsatz as $key => $value) {
					  		echo '<tr>';
					  			echo '<td style="text-align: left">';																	 								
									echo $value['MONAT']; 
								echo '</td>';
									
								echo '<td style="text-align: center">';									
								if($value['EINNAHME'])   								
									echo $this->Number->currency($value['EINNAHME'],'EUR', array('wholePosition' => 'after')); 
								echo '</td>';
								
								echo '<td style="text-align: center">';									
								if($value['AUSGABE'])   								
									echo $this->Number->currency($value['AUSGABE'],'EUR', array('wholePosition' => 'after')); 
								echo '</td>';	
									
					  			echo '<td style="text-align: center"><b>';									
								if($value['DIFFERENZ'])   								
									echo $this->Number->currency($value['DIFFERENZ'],'EUR', array('wholePosition' => 'after')); 
								echo '</b></td>';
							echo '</tr>';
						} ?>
					  	</tbody>
					</table>
                 	
                 	
                 	
	            	<table class="table table-striped hidden-sm">
					  	<thead> 
					  		<tr>
					  			<th></th>
					  			<?php
					  				foreach ($umsatz as $key => $value) {
										  echo '<th style="text-align: center">'.$value['MONATSHORT'].'</th>';
									 }					  			
					  			?> 
					  		</tr> 
					  	</thead> 
					  	<tbody> 
					  		<tr>
					  		<td>Rechnungen</td>
					  		<?php foreach ($umsatz as $key => $value) {
					  			echo '<td style="text-align: center">';									
								if($value['EINNAHME'])   								
									echo $this->Number->currency($value['EINNAHME'],'EUR', array('wholePosition' => 'after')); 
								echo '</td>';
							} ?>
							</tr>
							<tr>
							<td>Lieferanten</td>
							<?php foreach ($umsatz as $key => $value) {
								echo '<td style="text-align: center">';									
								if($value['AUSGABE'])   								
									echo $this->Number->currency($value['AUSGABE'],'EUR', array('wholePosition' => 'after')); 
								echo '</td>';
							} ?>
							</tr>
							<tr>
							<td style="font-weight: bold">Ergebnis</td>
							<?php foreach ($umsatz as $key => $value) {
								echo '<td style="text-align: center; font-weight: bold">';									
								if($value['DIFFERENZ'])   								
									echo $this->Number->currency($value['DIFFERENZ'],'EUR', array('wholePosition' => 'after')); 
								echo '</td>';
							} ?></tr>
							
					  	</tbody>
					</table>    	
	    		</div>
        	</div>
       </div>
  </div>
  
<?php 
	$chartSize = '110';
	$defaultColor = '#008080';
	$defaultHighlightColor = '#FF5A5E';
	$defaultTransparentColor = '#f5f5f5';
	
	
?>
  
  
  <div class="col-md-12">   
  	<div class="panel panel-info" >
    <div class="panel-body">
  	<div class="row">
  		
  		<?php 
  		foreach($cheetCharts as $info) {?>
  		
		 <div class="chartEntry col-md-3">
        	<div class="title"><?php echo $info['title'] ?></div>
        	<div class="chart">
        		<div class="data"><?php echo $info['percent'] ?></div>
        		<div id="canvas-holder">
					<canvas id="chart-<?php echo $info['data'] ?>" width="<?php echo $chartSize ?>" height="<?php echo $chartSize ?>"/>
					<script>
						var data<?php echo $info['data'] ?> = [
							{
								value: <?php echo $info['ownCount'] ?>,
								color:'<?php echo $defaultColor ?>',
								highlight: '<?php echo $defaultHighlightColor ?>'
							}
							<?php if($info['percent'] != "100%" ) {?>
							,
							{
								value: <?php echo $info['allCount'] ?>,
								color: '<?php echo $defaultTransparentColor ?>',
								highlight: '<?php echo $defaultTransparentColor ?>'
								
							}
							<?php } ?>
						];
						var ctx<?php echo $info['data'] ?> = document.getElementById("chart-<?php echo $info['data'] ?>").getContext("2d");
						window.myPie = new Chart(ctx<?php echo $info['data'] ?>).<?php echo $info['type'] ?>(data<?php echo $info['data'] ?>, {});
						
					</script> 
				</div>
			</div>
        </div> 
        <?php } ?>                       
	</div>
	</div>
	</div>
  </div>
					
  
        
    <div class="col-md-12">  
    	<div class="row">            
	        <div class="col-md-6">
	        	<div class="panel panel-info ">
		        	<div class="panel-heading">
		        		<h4>Top 5 der umsatzstärksten <u><b>Kunden</b></u> im laufenden Kalenderjahr</h4>
		        	</div>
		            <div class="panel-body" >
		            	<table class="table table-striped">
						  	<thead> 
						  		<tr> 
						  			<th>#</th> 
						  			<th>Kunde</th> 
						  			<th style="text-align: right">Umsatz</th>
						  		</tr> 
						  	</thead> 
						  	<tbody> 
						  		<?php foreach ($topCustomer as $key => $value) { 
									echo '<tr>'; 
										if($key == 0) {
											echo '<td><b>'.($key + 1).'</b></td>'; 
											echo '<td><b>'.$value['PR']['KUNDENNUMMER'].' - '.$value['CU']['KUNDENNAME'].'</b></td>'; 
											echo '<td style="text-align: right"><b>'.$this->Number->currency($value[0]['SUMME'],'EUR', array('before' => false)).' €</b></td>'; 
										} else {
											echo '<td>'.($key + 1).'</td>'; 
											echo '<td>'.$value['PR']['KUNDENNUMMER'].' - '.$value['CU']['KUNDENNAME'].'</td>'; 
											echo '<td style="text-align: right">'.$this->Number->currency($value[0]['SUMME'],'EUR', array('before' => false)).' €</td>'; 	
										};
									
										
									echo '</tr>';  
								} ?>
						  	</tbody>
						</table>    	
		    		</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-info" >
		        	<div class="panel-heading">
		        		<h4>Top 5 der meistbestellten <u><b>Produkte</b></u> im laufenden Kalenderjahr</h4>
		        	</div>
		            <div class="panel-body" >
		            	<table class="table table-striped">
						  	<thead> 
						  		<tr> 
						  			<th>#</th> 
						  			<th>Produkt</th> 
						  			<th style="text-align: right">Anzahl</th>
						  		</tr> 
						  	</thead> 
						  	<tbody> 
						  		<?php foreach ($topProduct as $key => $value) { 
									echo '<tr>'; 
										if($key == 0) {
											echo '<td><b>'.($key + 1).'</b></td>'; 
											echo '<td><b>'.$value['PO']['NUMBER'].' - '.$value['PO']['NAME'].'</b></td>'; 
											echo '<td style="text-align: right"><b>'.$value[0]['ANZAHL'].'</b></td>'; 
										} else {
											echo '<td>'.($key + 1).'</td>'; 
											echo '<td>'.$value['PO']['NUMBER'].' - '.$value['PO']['NAME'].'</td>'; 
											echo '<td style="text-align: right">'.$value[0]['ANZAHL'].'</td>'; 	
										};
									
										
									echo '</tr>';  
								} ?>
						  	</tbody>
						</table>    	
		    		</div>
	    		</div>
			</div>
		</div>
	</div>
</div>






