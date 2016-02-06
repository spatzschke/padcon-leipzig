<?php 

foreach ($processes as $process): 	
		$offerActive = false;		$confirmationActive = false;		$deliveryActive = false;		$billingActive = false;		
		
		if($process['Offer']['id']) { $offerActive = true; } 
		if($process['Confirmation']['id']) { $confirmationActive = true; } 
		if($process['Delivery']['id']) { $deliveryActive = true; } 
		if($process['Billing']['id']) { $billingActive = true; } 
		
		$action = 'view';
		if($process['Confirmation']['custom']) { $action = 'edit_individual';}
	?>
	
	<div class="col-md-12 process">
		<div class="col-md-1 processStepContainer">
			<div class="processStep status-open">
				<?php echo $this->Html->link('
				<i class="glyphicon glyphicon-user">
			</i>', array('controller' => 'customers', 'action' => $action, $process['Customer']['id']), array('escape' => false)); ?>
			</div>
			<div class="stepLabel"><?php echo $process['Process']['customer_id'];?></div>
			
		</div>
		<div class="col-md-1 processStepContainer">
			<?php 
			
			$icon = '';
			if($process['Confirmation']['custom']) { $icon = 'hand-right';}
			elseif($process['Process']['type'] == "full") { $icon = 'file';}
			elseif($process['Process']['type'] == "part") { $icon = 'duplicate';}
			
			
			echo '<div class="stepType processStep '.( $icon != '' ? 'status-open' : '').'"><i class="glyphicon glyphicon-'.$icon.'"></i></div>';  ?>
		</div>
		
		<div class="col-md-2 processStepContainer stepOffer">
			<div class="processLine <?php echo ($confirmationActive && $offerActive ? 'success' : ''); ?>"></div>
			<?php if($process['Offer']['id']) { echo '<div class="stepId">'.$process['Offer']['id'].'</div>'; } ?>
			<div class="processStep <?php echo ($offerActive ? 'status-'.$process['Offer']['status'] : ''); ?>">
			<?php 
			if($process['Offer']['id']) {
				echo $this->Html->link('
				<i class="glyphicon glyphicon-send">
				</i>', array('controller' => 'offers', 'action' => $action, $process['Offer']['id']), array('escape' => false));
			} else {
				echo '<i class="glyphicon glyphicon-send"></i>';
			}
			 ?>
			</div>
			<?php if($process['Offer']['id']) { echo '<div class="stepLabel">AN: '.$process['Offer']['offer_number'].'</div>'; } ?>
		</div>

		<div class="col-md-3 processStepContainer stepConfirmation">
			<div class="processLine <?php echo ($deliveryActive ? 'success' : ''); ?> <?php echo (!$process['Process']['delivery_id'] && $process['Process']['billing_id'] ? 'success' : ''); ?>"></div>
			<?php if($process['Confirmation']['id']) { echo '<div class="stepId">'.$process['Confirmation']['id'].'</div>'; } ?>
			<div class="processStep <?php echo ($confirmationActive ? 'status-'.$process['Confirmation']['status'] : ''); ?>">
				<?php 
				if($process['Confirmation']['id']) {
					 echo $this->Html->link('
					<i class="glyphicon glyphicon-check">
					</i>',
					array('admin' => true, 'controller' => 'Confirmations', 'action' => $action, $process['Confirmation']['id']), array('escape' => false));	
				} else {
					echo '<i class="glyphicon glyphicon-check"></i>';
				}
				?>
			</div>
			<?php if($process['Confirmation']['id']) { echo '<div class="stepLabel">AB: '.$process['Confirmation']['confirmation_number'].'</div>'; } ?>
		</div>
		
		<?php
			$deliveryIcon = 'qrcode';
			if($process['Confirmation']['pattern'] == 1) { $deliveryIcon = 'th';}
			elseif(!$process['Process']['delivery_id'] && $process['Process']['billing_id']) { $deliveryIcon = 'briefcase';}
		?>
		
		<div class="col-md-3 processStepContainer stepDelivery">
			<div class="processLine <?php echo ($billingActive ? 'success' : ''); ?>"></div>
			<?php if($process['Delivery']['id']) { echo '<div class="stepId">'.$process['Delivery']['id'].'</div>'; } ?>
			<div class="processStep <?php echo ($deliveryActive ? 'status-'.$process['Delivery']['status'] : ''); ?> <?php echo (!$process['Process']['delivery_id'] && $process['Process']['billing_id'] ? 'status-open' : ''); ?>">
				<?php 
				if($process['Delivery']['id']) {
					echo $this->Html->link('
					<i class="glyphicon glyphicon-'.$deliveryIcon.'">
					</i>', array('controller' => 'deliveries', 'action' => $action, $process['Delivery']['id']), array('escape' => false, 'class' => 'diabled')); 
				} else {
					echo '<i class="glyphicon glyphicon-'.$deliveryIcon.'"></i>';
				}				
				?>
			</div>
			<?php if($process['Delivery']['id']) { echo '<div class="stepLabel">LS: '.$process['Delivery']['delivery_number'].'</div>'; } ?>
		</div>
		
		<div class="col-md-2 processStepContainer stepBilling">
			<?php if($process['Billing']['id']) { echo '<div class="stepId">'.$process['Billing']['id'].'</div>'; } ?>
			<div class="processStep <?php echo ($billingActive ? 'status-'.$process['Billing']['status'] : ''); ?>">
				<?php 
				if($process['Billing']['id']) {
					echo $this->Html->link('<i class="glyphicon glyphicon-euro" >
					</i>', array('controller' => 'billings', 'action' => 'view', $process['Billing']['id']), array('escape' => false)); 
				} else {
					echo '<i class="glyphicon glyphicon-eur"></i>';
				}
				?>
			</div>
			<?php if($process['Billing']['id']) { echo '<div class="stepLabel">RE: '.$process['Billing']['billing_number'].'</div>'; } ?>		
		</div>
	</div>
	
<?php endforeach; ?>