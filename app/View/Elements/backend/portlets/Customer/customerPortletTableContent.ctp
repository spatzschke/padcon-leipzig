<?php

				$i = 0;
				foreach ($customers as $user):
					$class = null;
					
				?>
				<tr <?php echo $class;?>>
					<td><?php echo $user['Customer']['id']; ?>&nbsp;
						<?php if($user['Customer']['merchant']) {?><i class='glyphicon glyphicon-briefcase' style='color: teal; cursor: pointer'
						 data-toggle='popover'
						 data-content='Handelsvertreter'
						 data-trigger='hover'
						 data-placement='top'
					></i><?php } ?></td>
					<td><?php echo $user['Customer']['organisation']; ?>&nbsp;</td>
				
					<td class="actions">
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('action' => 'view', $user['Customer']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('action' => 'edit', $user['Customer']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('action' => 'delete', $user['Customer']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $user['Customer']['id'])); ?>
					</td>
				</tr> 
				<?php endforeach; ?>