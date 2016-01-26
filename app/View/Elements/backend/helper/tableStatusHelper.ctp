<?php 
	if(strpos($status, 'open') !== FALSE) {
		echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: default"
			 data-toggle="popover"
			 data-content="Offen"
			 data-trigger="hover"
			 data-placement="left"
		></i>';
	} 
	elseif(strpos($status, 'close') !== FALSE) {
		echo '<i class="glyphicon glyphicon-ok" style="color: lawngreen; cursor: default"
			 data-toggle="popover"
			 data-content="Abgeschlossen"
			 data-trigger="hover"
			 data-placement="left"
		></i>';
	}
	elseif(strpos($status, 'active') !== FALSE) {
		echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: default"
			 data-toggle="popover"
			 data-content="Aktiv"
			 data-trigger="hover"
			 data-placement="left"
		></i>';
	}elseif(strpos($status, 'cancel') !== FALSE) {
		echo '<i class="glyphicon glyphicon-remove" style="color: red; cursor: default"
			 data-toggle="popover"
			 data-content="Storniert"
			 data-trigger="hover"
			 data-placement="left"
		></i>';
	}elseif($status == "") {
		echo '<i class="glyphicon glyphicon-ban-circle" style="color: grey; cursor: default"
			 data-toggle="popover"
			 data-content="Unvollständig"
			 data-trigger="hover"
			 data-placement="left"
		></i>';
	}
	
	if($custom){
		echo '&nbsp; <i class="glyphicon glyphicon-hand-right" style="color: grey; cursor: default"
			 data-toggle="popover"
			 data-content="Individuell erstellt"
			 data-trigger="hover"
		></i>';
	}
?>