<?php $users = $this->requestAction('Users/getUser/');?>

<article class="module width_full">
		<header>
			<h3 class="tabs_involved"><?php __('Benutzer');?></h3>
			<ul class="tabs">
	   			<li><a href="#tab1">Posts</a></li>
	    		<li><a href="#tab2">Comments</a></li>
			</ul>
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
				foreach ($users as $user):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				?>
				<tr<?php echo $class;?>>
					<td></td>
				<!--<td><?php echo $user['User']['id']; ?>&nbsp;</td>-->
					<td><?php echo $user['User']['title']; ?>&nbsp;</td>
					<td><?php echo $user['User']['first_name']; ?>&nbsp;</td>
					<td><?php echo $user['User']['last_name']; ?>&nbsp;</td>
					<td><?php echo $user['User']['organisation']; ?>&nbsp;</td>
				<!--<td><?php echo $user['User']['street']; ?>&nbsp;</td>
					<td><?php echo $user['User']['postal_code']; ?>&nbsp;</td>
					<td><?php echo $user['User']['city']; ?>&nbsp;</td>-->
					<td><?php echo $user['User']['email']; ?>&nbsp;</td>
				<!--<td><?php echo $user['User']['phone']; ?>&nbsp;</td>
					<td><?php echo $user['User']['fax']; ?>&nbsp;</td>
					<td><?php echo $user['User']['password']; ?>&nbsp;</td>
					<td><?php echo $user['User']['created']; ?>&nbsp;</td>
					<td><?php echo $user['User']['modified']; ?>&nbsp;</td>-->
					<td class="actions">
						
					
						<?php echo $this->Html->link($html->image("backend/icn_search.png"), array('action' => 'view', $user['User']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link($html->image("backend/icn_edit.png"), array('action' => 'edit', $user['User']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link($html->image("backend/icn_trash.png"), array('action' => 'delete', $user['User']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
					</td>
				</tr> 
				<?php endforeach; ?>
			</tbody>
			 
			</table>
			</div><!-- end of #tab1 -->
			
			<div id="tab2" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th></th> 
    				<th>Comment</th> 
    				<th>Posted by</th> 
    				<th>Posted On</th> 
    				<th>Actions</th> 
				</tr> 
			</thead> 
			<tbody> 
				<tr> 
   					<td><input type="checkbox"></td> 
    				<td>Lorem Ipsum Dolor Sit Amet</td> 
    				<td>Mark Corrigan</td> 
    				<td>5th April 2011</td> 
    				<td><input type="image" src="images/icn_edit.png" title="Edit"><input type="image" src="images/icn_trash.png" title="Trash"></td> 
				</tr> 
				<tr> 
   					<td><input type="checkbox"></td> 
    				<td>Ipsum Lorem Dolor Sit Amet</td> 
    				<td>Jeremy Usbourne</td> 
    				<td>6th April 2011</td> 
   				 	<td><input type="image" src="images/icn_edit.png" title="Edit"><input type="image" src="images/icn_trash.png" title="Trash"></td> 
				</tr>
				<tr> 
   					<td><input type="checkbox"></td> 
    				<td>Sit Amet Dolor Ipsum</td> 
    				<td>Super Hans</td> 
    				<td>10th April 2011</td> 
    				<td><input type="image" src="images/icn_edit.png" title="Edit"><input type="image" src="images/icn_trash.png" title="Trash"></td> 
				</tr> 
				<tr> 
   					<td><input type="checkbox"></td> 
    				<td>Dolor Lorem Amet</td> 
    				<td>Alan Johnson</td> 
    				<td>16th April 2011</td> 
   				 	<td><input type="image" src="images/icn_edit.png" title="Edit"><input type="image" src="images/icn_trash.png" title="Trash"></td> 
				</tr> 
				<tr> 
   					<td><input type="checkbox"></td> 
    				<td>Dolor Lorem Amet</td> 
    				<td>Dobby</td> 
    				<td>16th April 2011</td> 
   				 	<td><input type="image" src="images/icn_edit.png" title="Edit"><input type="image" src="images/icn_trash.png" title="Trash"></td> 
				</tr> 
			</tbody> 
			</table>

			</div><!-- end of #tab2 -->
			
		</div><!-- end of .tab_container -->
		</article><!-- end of stats article -->
