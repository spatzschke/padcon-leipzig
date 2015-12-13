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
    			<!--<th><?php echo('ID');?></th>-->
    				<th><?php echo('Name');?></th>
					<th><?php echo('eMail');?></th>
					<th><?php echo('Rolle');?></th>
					<th><?php echo('Letzter Login');?></th>
					<!--<th><?php echo('Erstellt');?></th>
					<th><?php echo('Bearbeitet');?></th>-->
					<th class="actions"><?php __('');?></th>
				</tr> 
			</thead> 
			<tbody> 
				<?php
				$i = 0;
				foreach ($users as $user):
					$class = null;
					if ($user['User']['role'] != 'anonymous') {
						
					
				?>
				<tr>
					<td></td>
				<!--<td><?php echo $user['User']['id']; ?>&nbsp;</td>-->
					<td><?php 
						if(!empty($user['User']['name'])) {
						echo $user['User']['name'];} ?>&nbsp;</td>
					<td><?php echo $user['User']['username']; ?>&nbsp;</td>
					<td><?php echo $user['User']['role']; ?>&nbsp;</td>
					<td><?php echo $user['User']['last_login'];?>&nbsp;</td>
				<!--<td><?php echo $user['User']['created']; ?>&nbsp;</td>
					<td><?php echo $user['User']['modified']; ?>&nbsp;</td>-->
					<td class="actions">
						
					
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('action' => 'view', $user['User']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('action' => 'edit', $user['User']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('action' => 'delete', $user['User']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
					</td>
				</tr> 
				<?php } endforeach; ?>
			</tbody>
			 
			</table>
			</div><!-- end of #tab1 -->
			
		</div><!-- end of .tab_container -->
		</article><!-- end of stats article -->
