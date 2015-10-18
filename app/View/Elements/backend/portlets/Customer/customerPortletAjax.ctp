<?php 
	echo $this->Html->script('jquery.dynamicSearch', false);
?>

<script>
$(document).ready(function() {
	
			
			$('.addCustomer').on('click', function(){
				
				var xhr = null,
				obj = $(this);
				
				obj.addClass('loading');

				xhr = $.ajax({
					 type: 'POST',
					 url:obj.attr('href'),
					 data: '',
					 success:function (data, textStatus) {
					 	
					 	obj.removeClass('loading');
					 	
					 	$('.wood_bg .pages').load('<?php echo FULL_BASE_URL.$this->base;?>/<?php echo $controller_name;?>/reloadSheet/<?php echo $controller_id;?>');

					 	$('#add_to_customer_modal').modal('hide')
					} 
				}); 
				
				return false;
			});
			
			$('#filter .search input').dynamicSearch({
				url: "<?php echo FULL_BASE_URL.$this->base;?>\/Customers\/search\/",
				renderTemplate: '/Elements/backend/portlets/Customer/customerPortletTableContentAjax',
				cancel: '.form-search .cancel',
				content: '.customerPortlet tbody',
				loadingClass: 'loadingSpinner',
				loadingElement: '#filter .search .input-group-addon i',
				admin: true
			});	
});



</script>

<article class="module width_full customerPortlet">
		<header>
			<h3><?php __('Kunden');?></h3>	
		</header>
		<section id="filter">
			<div class="input-group search form-search">
	            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
	         	<input class="text form-control search-query" placeholder="Suche"/>   
	         	<div class="cancel"><i class="glyphicon glyphicon-remove"></i></div>                                
	        </div>	
		</section>
		<div class="module_content">
			
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<?php
						if($this->request->is('ajax')) {
							echo '<th></th> ';
						}
					?> 
    				<th><?php echo('#');?></th>
					<!-- <th><?php echo('Anrede');?></th>
					<th><?php echo('Vorname');?></th>
					<th><?php echo('Nachname');?></th> -->
					<th><?php echo('Organisation');?></th>
					<!-- <th><?php echo('Abteilung');?></th> -->
				<!--<th><?php echo('Straße');?></th>
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
				<?php echo $this->element('backend/portlets/Customer/customerPortletTableContentAjax', array('customers' => $customers, 'id' => $controller_id)); ?>
			</tbody>
			 
			</table>
		</div><!-- end of #tab1 -->
	</article><!-- end of stats article -->
