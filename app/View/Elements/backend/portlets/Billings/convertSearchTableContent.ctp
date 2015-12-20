<label>Suchergebnis</label>
<table>
  <tbody>
		<?php	
			foreach ($data as $item):
			
				if($item['Confirmation']['cart_id'] != 0) {				
		?>
				<tr>
					<td>
						<?php 
							if(empty($item['Cart']['count']) || $item['Confirmation']['order_date'] == '0000-00-00' || empty($item['Confirmation']['customer_id']) || empty($item['Confirmation']['offer_number']) || empty($item['Confirmation']['confirmation_price'])) {
																						
							} else {
								echo $this->Html->link('<i class="glyphicon glyphicon-open"></i>', array('admin' => true, 'controller' => 'Billings', 'action' => 'convert', $item['Confirmation']['id']), array('escape' => false)); 
							}
							?>
					</td>
					<td>
						<?php echo $item['Confirmation']['confirmation_number']; ?>
					</td>
					<td>
						<?php echo $this->Time->format($item['Confirmation']['created'], '%d.%m.%Y'); ?>
					</td>				
				</tr> 
		<?php } endforeach; ?>
	</tbody>
</table>