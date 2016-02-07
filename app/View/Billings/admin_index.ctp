<?php 
	echo $this->Html->script('jquery.dynamicSearch', false);
?>

<script>
$(document).ready(function() {
		
			$('#filter .search input').dynamicSearch({
			url: "<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Billings\/search\/",
			renderTemplate: '/Elements/backend/portlets/Billings/tableContent',
			cancel: '.form-search .cancel',
			loadingClass: 'loadingSpinner',
			loadingElement: '#filter .search .input-group-addon i',
			admin: true,
			content: '.offersIndex tbody'
		});	
		
		$('.glyphicon').popover({
            html:true
        });
        <?php
		 $id = "tableSetting";
		 $modalSize = "modal-md";
		 $backdrop = "true";
		?>
	
		$('.<?php echo $id;?>_btn').parent('a').on('click',function() {
			$('#<?php echo $id;?>_modal .modal-body').load($(this).attr('href'));
			$('#<?php echo $id;?>_modal').modal('show');
			return false;
		})
	
		$("#<?php echo $id;?>_modal").on("hidden.bs.modal", function(){ 
			$(this).removeData("modal");
			window.location = '';
		});
		
		<?php
		 $id_payed = "payed";
		 $modalSize = "modal-md";
		 $backdrop = "true";
		?>
	
		$('.<?php echo $id_payed;?>_btn').on('click',function() {
			$('#<?php echo $id_payed;?>_modal .modal-body').load($(this).attr('href'));
			$('#<?php echo $id_payed;?>_modal').modal('show');
			return false;
		})
	
		$("#<?php echo $id_payed;?>_modal").on("hidden.bs.modal", function(){ 
			$(this).removeData("modal");
			window.location = '';
		});
});

</script>

<div class="modal" id="<?php echo $id;?>_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" data-backdrop="<?php echo (isset($backdrop) ? $backdrop : "true");?>">
	<div class="modal-dialog <?php echo (isset($modalSize) ? $modalSize : "modal-lg");?> offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body">
				<?php echo $this->element('backend/helper/loadingHelper', array("size" => "large")); ?>	
			</div>
		</div>
	</div>
</div>

<div class="modal" id="<?php echo $id_payed;?>_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" data-backdrop="<?php echo (isset($backdrop) ? $backdrop : "true");?>">
	<div class="modal-dialog <?php echo (isset($modalSize) ? $modalSize : "modal-lg");?> offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body">
				<?php echo $this->element('backend/helper/loadingHelper', array("size" => "large")); ?>	
			</div>
		</div>
	</div>
</div>

<article class="module width_full offersIndex">
		<header>
			<div class="panel-title"><?php echo $title_for_panel; ?></div>
			<?php
				if($this->request->is('ajax')) {
					echo '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>';
				}
			?>
			
		</header>
		<section id="filter">
			<div class="input-group search form-search">
	            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
	         	<input class="text form-control search-query" placeholder="Suche"/>   
	         	<div class="cancel"><i class="glyphicon glyphicon-remove"></i></div>                                
	        </div>	
		</section>
		
	
	<nav>
	  <ul class="pagination">
	    <li>
	      <span aria-hidden="true"><?php echo $this->Paginator->prev('<<', array(), null, array('class' => 'prev disabled')); ?></span>
	    </li>
	    <?php echo $this->Paginator->numbers(array('before' => '<li>', 'after' => '</li>', 'separator' => '')); ?>
	    <li>
	        <span aria-hidden="true"><?php echo $this->Paginator->next(' >>', array(), null, array('class' => 'next disabled')); ?></span>
	     
	    </li>
	  </ul>
	</nav>

		<div class="module_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th></th>					
					<th><?php echo('Nr');?></th>
					<th><?php echo('Kunde');?></th>
					<th><?php echo('Summe');?></th>
					<th ><?php echo '<i class="glyphicon glyphicon-info-sign" style="color: teal; cursor: pointer"
										 data-toggle="popover"
										 data-content="Skonto"
										 data-trigger="hover"
										 data-placement="top"
									
									></i>  ';
									echo('sk');?></th>
					<th><?php echo('Zahlungsziel');?></th>
					<th><?php echo('Gezahlt am');?></th>
					<th><?php echo('AB');?></th>
					<th><?php echo('LI');?></th>
					<th><?php echo('Erstellt');?></th>
					<!-- <th><?php echo('Bearbeitungsdatum');?></th> -->
					<th class="actions"><?php __('');?></th>
				</tr> 
			</thead> 
			<tbody> 
							
				<?php echo $this->element('backend/portlets/Billings/tableContent', array('offers' => $data)); ?>


				
			</tbody>
			 
			</table>
			
					<nav>
		  <ul class="pagination">
		    <li>
		      <span aria-hidden="true"><?php echo $this->Paginator->prev('<<', array(), null, array('class' => 'prev disabled')); ?></span>
		    </li>
		    <?php echo $this->Paginator->numbers(array('before' => '<li>', 'after' => '</li>', 'separator' => '')); ?>
		    <li>
		        <span aria-hidden="true"><?php echo $this->Paginator->next(' >>', array(), null, array('class' => 'next disabled')); ?></span>
		     
		    </li>
		  </ul>
		</nav>
			
		</div><!-- end of .tab_container -->
</article><!-- end of stats article -->