<?php 
	echo $this->Html->script('jquery.dynamicSearch', false);
?>

<script>
$(document).ready(function() {
		
			$('#filter .search input').dynamicSearch({
			url: "<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Processes\/search\/",
			renderTemplate: '/Elements/backend/portlets/Process/tableContent',
			cancel: '.form-search .cancel',
			loadingClass: 'loadingSpinner',
			loadingElement: '#filter .search .input-group-addon i',
			admin: true,
			content: '#processOverview .content'
		});	
	
});

</script>

<article class="module width_full offersIndex" id="processOverview">
		<div class="modal fade" id="product_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false" style="display: none;">
			<div class="modal-dialog modal-sm">
			 	<div class="modal-content">
					<div class="modal-body"></div>
				</div>
			</div>
		</div>
		<header>
			<div class="panel-title"><?php echo __('Alle Vorgänge'); ?></div>
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
		<?php if($this->Paginator->numbers()){ ?>
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
		<?php } ?>
		<div class="module_content">
			
		<div class="col-md-12 col-xs-12 processHeader">
			<div class="col-md-1 col-xs-1 stepCustomer"><h3><b>Kunde</b></h3></div>
			<div class="col-md-1 col-xs-1 "></div>
			<div class="col-md-2 col-xs-2 stepOffer"><h3><b>Angebot</b></h3></div>
			<div class="col-md-3 col-xs-3 stepConfirmation"><h3><b class="hidden-sm">Auftragsbestätigung</b><b class="visible-sm">AB</b></h3></div>
			<div class="col-md-3 col-xs-3 stepDelivery"><h3><b>Lieferschein</b></h3></div>
			<div class="col-md-2 col-xs-2 stepBilling"><h3><b>Rechnung</b></h3></div>
		</div>
		<div class="col-md-12 content">
			<?php 
			
			echo $this->element('backend/portlets/Process/tableContent', array('processes' => $processes)); ?>
		</div>		
			
		<?php if($this->Paginator->numbers()){ ?>
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
		<?php } ?>
		
		<div>&nbsp;</div>
			
		</div><!-- end of .tab_container -->
</article><!-- end of stats article -->

