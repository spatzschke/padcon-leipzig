<?php
	
?>

<article class="module width_full sheet ruckseite">
	<div class="sheetHeader">	
		<div class="bandage" style="background-color: #<?php echo $color;?>; border-color: #<?php echo $color;?>"></div>
	</div>
	<div class="sheetContent">
		<div class="stemp">Unser Stempel:</div>
		<div class="more">
			<p>weitere Kataloge für den Bereich:</p>
			<ul>
				<?php
					foreach ($categories as $c => $v) {
						if($c != $category_id)
							echo '<li>'.$v.'</li>';
					}
				?>
			</ul>
		</div>
	</div>
		<div class="sheetFooter">	
			<div class="bandage">
				<span>padcon Leipzig - Ralf Patzschke - Holunderweg 4 - 04416 Markkleeberg</span>
			</div>
		</div>		
</article>