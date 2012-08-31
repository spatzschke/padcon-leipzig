<?php 

	echo $this->Html->script('jquery.dynamicSearch', false);

?>	
	
	<script>
	
	$(document).ready(function() {
	
		$('#topNavigation .search input').dynamicSearch({
			url: "<?php echo FULL_BASE_URL.$this->base;?>/Products/search/",
			content: '.searchContent .result',
			ajaxLoader: '.searchContent .headLoader',
			originContent: '#content',
			cancel: '#topNavigation .search .cancel',
			showAnimation: false
		});
	});
	
	</script>
	
	
	
	
	<?php

	echo '
		<ul>
		
			<li>' 
		 		.$this->Html->link('<div class="image"></div><div class="linkText">Produkte</div>','/Produkte', array('class'=>'product', 'escape'=>false)).
			'</li>
			
			<li>'
				.$this->Html->link('<div class="image"></div><div class="linkText">Kataloge</div>','/Kataloge', array('class'=>'catalog', 'escape'=>false)).
			'</li>
			
			<li>'
				.$this->Html->link('<div class="image"></div><div class="linkText">Fachhandel</div>','/Fachhandel', array('class'=>'partner', 'escape'=>false)).
			'</li>
		</ul>
		
		<div class="search">
			<div class="cancel"></div>
			<input class="text" placeholder="Suche"/>
		</div>

';
	
?>	