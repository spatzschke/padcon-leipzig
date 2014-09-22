<div id="catalogs">
	<?php
		$i = 0;
		foreach ($catalogs as $catalog):
		
			if ($i++ % 2 == 0) {
				$itemAlign = ' categoryItemLeft';
			} else {
				$itemAlign = ' categoryItemRight';
			}
		
			echo $this->Html->link('<div id="c'.$catalog['Catalog']['id'].'" class="categoryItem'.$itemAlign.' categoryItem-'.$catalog['Category']['short'].'"><div class="text">'.$catalog['Category']['name'].'<br />'.$catalog['Catalog']['catalog_date'].'</div></div>',array('controller'=>'Catalogs', 'action'=>'view', $catalog['Catalog']['id']), array('escape'=>false, 'class' => 'categoryItemLink'));
		
		endforeach; ?>
        
        <?php echo $this->Html->css('colorbox');?>
		<?php echo $this->Html->script('jquery.colorbox-min.js');?>
        
        <script>
		
			$(".categoryItemLink").colorbox({
				iframe:true, 
				width:"700", 
				height:"1024", 
				overlayClose: true,
				onOpen: function () {
					
				},
				onLoad: function() {
    				
				}

			});
		
		</script>
</div>