<?php $users = $this->requestAction('Users/getUser/');?>

<article class="module width_full">
		<header>
			<h3><?php __('Kundenkonto');?></h3>
		</header>

		<div class="module_content">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th></th> 
    			<!--<th><?php __('ID');?></th>-->
					<th><?php __('eMail');?></th>
					<th><?php __('Letzter Login');?></th>
					<!--<th><?php __('Erstellt');?></th>
					<th><?php __('Bearbeitet');?></th>-->
					<th class="actions"><?php __('');?></th>
				</tr> 
			</thead> 
			<tbody> 
				<?php
				$i = 0;
				foreach ($users as $user):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				?>
				<tr<?php echo $class;?>>
					<td></td>
				<!--<td><?php echo $user['User']['id']; ?>&nbsp;</td>-->
					<td><?php echo $user['User']['username']; ?>&nbsp;</td>
					<td><?php echo $user['User']['role']; ?>&nbsp;</td>
					<td><?php echo $user['User']['last_login']; ?>&nbsp;</td>
				<!--<td><?php echo $user['User']['created']; ?>&nbsp;</td>
					<td><?php echo $user['User']['modified']; ?>&nbsp;</td>-->
					<td class="actions">
						
					
						<?php echo $this->Html->link($this->Html->image("backend/icn_search.png"), array('action' => 'view', $user['User']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link($this->Html->image("backend/icn_edit.png"), array('action' => 'edit', $user['User']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link($this->Html->image("backend/icn_trash.png"), array('action' => 'delete', $user['User']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
					</td>
				</tr> 
				<?php endforeach; ?>
			</tbody>
			 
			</table>
			</div><!-- end of #tab1 -->
			
		</div><!-- end of .tab_container -->
		</article><!-- end of stats article -->
