<script>
$(document).ready(function() {
	
			
			$('.addCustomer').live('click', function(){
				
				var xhr = null,
				obj = $(this);
				
				obj.addClass('loading');

				xhr = $.ajax({
					 type: 'POST',
					 url:obj.attr('href'),
					 data: '',
					 success:function (data, textStatus) {
					 	
					 	obj.removeClass('loading');
					 	
					 	$('.wood_bg .pages').load('<?php echo FULL_BASE_URL.$this->base;?>/Offers/reloadOfferSheetProducts');
					 	
					} 
				}); 
				
				return false;
			});
});



</script>

<article class="module width_full">
		<header>
			<h3><?php __('Kunden');?></h3>
			
		</header>

		

		<div class="module_content">
			
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th></th> 
    			<!--<th><?php __('ID');?></th>-->
					<th><?php __('Anrede');?></th>
					<th><?php __('Vorname');?></th>
					<th><?php __('Nachname');?></th>
					<th><?php __('Organisation');?></th>
					<th><?php __('Abteilung');?></th>
				<!--<th><?php __('Stra�e');?></th>
					<th><?php __('PLZ');?></th>
					<th><?php __('Stadt');?></th>
					<th><?php __('eMail');?></th>
					<th><?php __('Tel.');?></th>
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
					
				?>
				<tr<?php echo $class;?>>
					<td><?php echo $this->Html->link('', array('admin' => true, 'controller' => 'Offers', 'action' => 'updateOffer', $user['Customer']['id']), array('escape' => false, 'class' => 'addToCart addCustomer')); ?></td>
				<!--<td><?php echo $user['Customer']['id']; ?>&nbsp;</td>-->
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
					<td class="actions">
						
					
						<?php echo $this->Html->link($this->Html->image("backend/icn_search.png"), array('action' => 'view', $user['Customer']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link($this->Html->image("backend/icn_edit.png"), array('action' => 'edit', $user['Customer']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link($this->Html->image("backend/icn_trash.png"), array('action' => 'delete', $user['Customer']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
					</td>
				</tr> 
				<?php endforeach; ?>
			</tbody>
			 
			</table>
		</div><!-- end of #tab1 -->
	</article><!-- end of stats article -->
