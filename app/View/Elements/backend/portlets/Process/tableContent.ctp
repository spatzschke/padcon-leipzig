<?php 

foreach ($processes as $key => $process): 	
		$offerActive = false;		$confirmationActive = false;		$deliveryActive = false;		$billingActive = false;		
		
		if($process['Offer']['id']) { $offerActive = true; } 
		if($process['Confirmation']['id']) { $confirmationActive = true; } 
		if($process['Delivery']['id']) { $deliveryActive = true; } 
		if($process['Billing']['id']) { $billingActive = true; } 
		
		$action = 'view';
		if($process['Confirmation']['custom']) { $action = 'edit_individual';}
		
		if(isset($processes[$key+1]))
			if($process['Process']['offer_id'] != 0 && $process['Process']['confirmation_id'] == 0) {
				$isPartProcess = false;
			} else {
				$isPartProcess = $process['Process']['confirmation_id'] == $processes[$key+1]['Process']['confirmation_id'];
			}
		else
			$isPartProcess = false;
	?>
	
	<div class="col-md-12 col-xs-12 process">
		<div class="col-md-1 col-xs-1 processStepContainer">
			<div class="processStep status-open">
				<?php echo $this->Html->link('
				<i class="glyphicon glyphicon-user">
			</i>', array('controller' => 'customers', 'action' => $action, $process['Customer']['id']), array('escape' => false)); ?>
			</div>
			<div class="stepLabel"><?php echo $process['Process']['customer_id'];?></div>
			
		</div>
		<div class="col-md-1 col-xs-1  processStepContainer">
			<?php 
			
			$icon = ''; $text = '';
			if($process['Confirmation']['custom']) { $icon = 'hand-right'; $text = 'Individual';}
			elseif($process['Process']['type'] == "full") { $icon = 'file';$text = 'Voll-Lieferschein';}
			elseif($process['Process']['type'] == "part" || $isPartProcess) { $icon = 'duplicate';$text = 'Teil-Lieferschein';}
			
			
			echo '<div class="stepType hidden-sm processStep '.( $icon != '' ? 'status-open' : '').'"><i class="glyphicon glyphicon-'.$icon.'" style="cursor: default"
					 data-toggle="popover"
					 data-content="'.$text.'"
					 data-trigger="hover"
					 data-placement="top"">
			</i></div>';  ?>
		</div>
		
		<div class="col-md-2 col-xs-2 processStepContainer stepOffer">
			<div class="processLine <?php echo ($confirmationActive && $offerActive && !$isPartProcess ? 'success' : ''); ?>"></div>
			<?php if($process['Offer']['id'] && !$isPartProcess) { echo '<div class="stepId">'.$process['Offer']['id'].'</div>'; } ?>
			<?php if(!$isPartProcess || $process['Process']['offer_id'] != 0) { ?>
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
			<?php } else { ?>
				<div class="processStep"><i class="glyphicon glyphicon-send"></i></div>
			<?php }  ?>
			<?php if($process['Offer']['id'] && !$isPartProcess) { echo '<div class="stepLabel"><span class="hidden-sm">AN: </span>'.$process['Offer']['offer_number'].'</div>'; } ?>
		</div>

		<div class="col-md-3 col-xs-3 processStepContainer stepConfirmation">
			<div class="processLine <?php echo ($deliveryActive ? 'success' : ''); ?> <?php echo (!$process['Process']['delivery_id'] && $process['Process']['billing_id'] ? 'success' : ''); ?>"></div>
			<?php if($process['Confirmation']['id'] && !$isPartProcess) { echo '<div class="stepId">'.$process['Confirmation']['id'].'</div>'; } ?>
			
			<?php if(!$isPartProcess || $process['Process']['confirmation_id'] == 0) { ?>
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
			<?php } else { ?>
				<div class="processLine processNodeConnector <?php echo ($confirmationActive ? 'success': ''); ?>"></div>
				<div class="processStep processNode <?php echo ($confirmationActive ? 'status-'.$process['Confirmation']['status'] : ''); ?>"></div>
			<?php }  ?>
			<?php if($process['Confirmation']['id'] && !$isPartProcess) { echo '<div class="stepLabel"><span class="hidden-sm">AB: </span>'.$process['Confirmation']['confirmation_number'].'</div>'; } ?>
		</div>
		
		<?php
			$deliveryIcon = 'qrcode';
			if($process['Confirmation']['pattern'] == 1) { $deliveryIcon = 'th';}
			elseif(!$process['Process']['delivery_id'] && $process['Process']['billing_id']) { $deliveryIcon = 'briefcase';}
		?>
		
		<div class="col-md-3 col-xs-3 processStepContainer stepDelivery">
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
			<?php if($process['Delivery']['id']) { echo '<div class="stepLabel"><span class="hidden-sm">LS: </span>'.$process['Delivery']['delivery_number'].'</div>'; } ?>
		</div>
		
		<div class="col-md-2 col-xs-2 processStepContainer stepBilling">
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
			<?php if($process['Billing']['id']) { echo '<div class="stepLabel"><span class="hidden-sm">RE: </span>'.$process['Billing']['billing_number'].'</div>'; } ?>	
			<?php echo '<div class=" processId stepId hidden-sm">'.$process['Process']['id'].'</div>'; ?>	
		</div>
		
	
	</div>
	
<?php endforeach; ?>