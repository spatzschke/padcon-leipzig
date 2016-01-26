<?php
	
	$catalog = $this->data['Catalogs'][0]['Catalog'];
	
?>


<article class="module width_full sheet deckblatt">
		<?php echo $this->Html->image('http://media.padcon-leipzig.de/media/catalog/images/'.$this->data['Catalogs'][0]['Category']['short'].'.png', array('alt' => $this->data['Catalogs'][0]['Category']['name']))?>		
</article>
