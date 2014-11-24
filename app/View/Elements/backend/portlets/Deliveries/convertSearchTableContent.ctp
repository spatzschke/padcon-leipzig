<label>Suchergebnis</label>
<table>
  <tbody>
		<?php	
			foreach ($data as $item):
			
				if($item['Offer']['cart_id'] != 0) {				
		?>
				<tr>
					<td>
						<?php 
							if(empty($item['Cart']['count']) || $item['Offer']['request_date'] == '0000-00-00' || empty($item['Offer']['customer_id']) || empty($item['Offer']['offer_number']) || empty($item['Offer']['offer_price'])) 
							{
															
							} else {
								echo $this->Html->link('<i class="glyphicon glyphicon-open"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'convert', $item['Offer']['id']), array('escape' => false)); 
							}
							?>
					</td>
					<td>
						<?php echo $item['Offer']['offer_number']; ?>
					</td>
					<td>
						<?php echo $this->Time->format($item['Offer']['created'], '%d.%m.%Y'); ?>
					</td>				
				</tr> 
		<?php } endforeach; ?>
	</tbody>
</table>