

<article class="module width_full">
		<header>
			<h3 class="tabs_involved"><?php __('Kunden');?></h3>
			
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th></th> 
    			<!--<th><?php __('ID');?></th>-->
					<th><?php __('Titel');?></th>
					<th><?php __('Vorname');?></th>
					<th><?php __('Nachname');?></th>
					<th><?php __('Organisation');?></th>
				<!--<th><?php __('Stra§e');?></th>
					<th><?php __('PLZ');?></th>
					<th><?php __('Stadt');?></th>-->
					<th><?php __('eMail');?></th>
				<!--<th><?php __('Tel.');?></th>
					<th><?php __('Fax.');?></th>
					<th><?php __('Passwort');?></th>
					<th><?php __('Erstellt');?></th>
					<th><?php __('Bearbeitet');?></th>-->
					<th class="actions"><?php __('');?></th>
				</tr> 
			</thead> 
			<tbody> 
				<?php
				$i = 0;
				foreach ($customers as $user):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				?>
				<tr<?php echo $class;?>>
					<td></td>
				<!--<td><?php echo $user['Customer']['id']; ?>&nbsp;</td>-->
					<td><?php echo $user['Customer']['title']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['first_name']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['last_name']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['organisation']; ?>&nbsp;</td>
				<!--<td><?php echo $user['Customer']['street']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['postal_code']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['city']; ?>&nbsp;</td>-->
					<td><?php echo $user['Customer']['email']; ?>&nbsp;</td>
				<!--<td><?php echo $user['Customer']['phone']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['fax']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['created']; ?>&nbsp;</td>
					<td><?php echo $user['Customer']['modified']; ?>&nbsp;</td>-->
					<td class="actions">
						
					
						<?php echo $this->Html->link($html->image("backend/icn_search.png"), array('action' => 'view', $user['Customer']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link($html->image("backend/icn_edit.png"), array('action' => 'edit', $user['Customer']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link($html->image("backend/icn_trash.png"), array('action' => 'delete', $user['Customer']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
					</td>
				</tr> 
				<?php endforeach; ?>
			</tbody>
			 
			</table>
			</div><!-- end of #tab1 -->
			
						
		</div><!-- end of .tab_container -->
		</article><!-- end of stats article -->
