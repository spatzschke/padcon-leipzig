<?php

				$i = 0;
				foreach ($customers as $user):
					$class = null;
					
				?>
				<tr<?php echo $class;?>>
				<?php if($this->request->is('ajax')) { ?>
					<td><?php echo $this->Html->link('<i class="glyphicon glyphicon-open"></i>', array('admin' => true, 'controller' => $controller_name, 'action' => 'update', $user['Customer']['id'], $controller_id), array('escape' => false, 'class' => 'addToCart addCustomer')); ?></td>
				<?php } ?>
					<td><?php echo $user['Customer']['id']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['salutation']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['first_name']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['last_name']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['organisation']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['department']; ?>&nbsp;</td>
				<!--<td><?php echo $user['Customer']['street']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['postal_code']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['city']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['email']; ?>&nbsp;</td>
				<td><?php echo $user['Customer']['phone']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['fax']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['created']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['modified']; ?>&nbsp;</td>-->
					<?php if(!$this->request->is('ajax')) { ?>
						<td class="actions">
							<?php echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('action' => 'view', $user['Customer']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('action' => 'edit', $user['Customer']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('action' => 'delete', $user['Customer']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $user['Customer']['id'])); ?>
						</td>
					<?php } ?>
					
				</tr> 
				<?php endforeach; ?>