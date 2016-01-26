<div id="<?php echo $id;?>_btn" class="input-group">
	<span class="input-group-addon"><i class="glyphicon glyphicon-<?php echo $icon;?>"></i></span> 
	<?php echo (isset($href) ? $href : '<a href="#" class="btn btn-default">'.$text.'</a>');?>
</div>