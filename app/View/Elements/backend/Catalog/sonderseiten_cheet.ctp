<?php
	
	if($type == 'agb') {
		
		$final = array();
	
		$agb = $this->data['SiteContent']['agb']['content_paragraph'];
		$agb = str_replace('</div>', '', $agb);
		$agbString = explode("</h2>", $agb);
		
		$agbStrings = explode("3. Sind Teillieferungen", $agbString[1]);
		$agbStrings[1] = '3. Sind Teillieferungen'.$agbStrings[1];
		$last = explode("VII. Gewährleistung", $agbStrings[1]);
		
		$final[0] = $agbStrings[0];
		$final[1] = $last[0];
		$final[2] = 'VII. Gewährleistung'.$last[1];
	}
	
			
?>


<?php 
	if($type == 'agb'){
		
		foreach ($final as $a) { ?>
			<article class="module width_full sheet sonderseite">
				<div class="sheetHeader <?php if($type == "waschanleitung") { ?>style="top: 60px;<?php } ?>">	
						<div class="content"><?php echo $this->data['SiteContent'][$type]['headline']; ?></div>
						<div class="bandage"></div>
					</div>
					<div class="sheetContent agb">
						<?php echo $a; ?>
					</div>
					<div class="sheetFooter">	
						<div class="bandage">
							<?php echo $page; ?>
						</div>
					</div>		
			</article>
<?php		
		}
	} elseif($type == 'color'){ 
 ?>
			<article class="module width_full sheet sonderseite <?php echo $type; ?>">
				<div class="sheetHeader <?php if($type == "waschanleitung") { ?>style="top: 60px;<?php } ?>">	
						<div class="content"><?php echo $this->data['SiteContent'][$type]['headline']; ?></div>
						<div class="bandage"></div>
					</div>
					<div class="sheetContent" style="position: relative">
						<?php echo $this->data['SiteContent'][$type]['content_paragraph']; ?>
						<?php
							foreach($this->data['Material'] as $input) {
								echo '<div class="materialBox mat'.$input['Material']['id'].'">';
									echo '<div class="header">'.$input['Material']['name'].'</div>';
									
									foreach($input['Color'] as $color) {
									echo '<div class="entry">';
										echo '<div class="punkt col'.$color['code'].'" style="background-color: #'.$color['rgb'].'; border-color: #'.$color['rgb'].'" ><span>'.$color['code'].'</span></div><div class="name">'.$color['name'].'</div><br />';	
									echo '</div>';
									}
									
								echo '</div>';
							}
						?>
						
						
					</div>
					<div class="sheetFooter">	
						<div class="bandage">
							<span><?php echo $page; ?></span>
						</div>
					</div>		
			</article>
<?php		
	} else  {
 ?>
			<article class="module width_full sheet sonderseite <?php echo $type; ?>">
				<div class="sheetHeader <?php if($type == "waschanleitung") { ?>style="top: 60px;<?php } ?>">	
						<div class="content"><?php echo $this->data['SiteContent'][$type]['headline']; ?></div>
						<div class="bandage"></div>
					</div>
					<div class="sheetContent" style="position: relative">
						<?php echo $this->data['SiteContent'][$type]['content_paragraph']; ?>
					</div>
					<div class="sheetFooter">	
						<div class="bandage">
							<span><?php echo $page; ?></span>
						</div>
					</div>		
			</article>
<?php		

} ?>
