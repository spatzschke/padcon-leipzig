<?php
				$i = 0;
				foreach ($customers as $user):
					$class = null;					
				?>
				<tr<?php echo $class;?>>
					<td><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i>', array('admin' => true, 'controller' => $controller_name, 'action' => 'update', $user['Customer']['id'], $controller_id), array('escape' => false, 'class' => 'addCustomer')); ?></td>
					<td><?php echo $user['Customer']['id']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['organisation']; ?>&nbsp;</td>

				</tr> 
				<?php endforeach; ?>