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
    			<!--<th><?php echo('ID');?></th>-->
					<th><?php echo('Anrede');?></th>
					<th><?php echo('Vorname');?></th>
					<th><?php echo('Nachname');?></th>
					<th><?php echo('Organisation');?></th>
					<th><?php echo('Abteilung');?></th>
				<!--<th><?php echo('Stra�e');?></th>
					<th><?php echo('PLZ');?></th>
					<th><?php echo('Stadt');?></th>
					<th><?php echo('eMail');?></th>
					<th><?php echo('Tel.');?></th>
					<th><?php echo('Fax.');?></th>
					<th><?php echo('Passwort');?></th>
					<th><?php echo('Erstellt');?></th>
					<th><?php echo('Bearbeitet');?></th>-->
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
					<td><?php echo $this->Html->link('<i class="glyphicon glyphicon-open"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'updateOffer', $user['Customer']['id']), array('escape' => false, 'class' => 'addToCart addCustomer')); ?></td>
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
						
					
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('action' => 'view', $user['Customer']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('action' => 'edit', $user['Customer']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('action' => 'delete', $user['Customer']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
					</td>
				</tr> 
				<?php endforeach; ?>
			</tbody>
			 
			</table>
		</div><!-- end of #tab1 -->
	</article><!-- end of stats article -->
