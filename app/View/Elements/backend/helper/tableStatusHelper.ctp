<?php 
	if($status == "open") {
		echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: default"
			 data-toggle="popover"
			 data-content="Offen"
			 data-trigger="hover"
		></i>';
	} 
	elseif($status == "close") {
		echo '<i class="glyphicon glyphicon-ok" style="color: lawngreen; cursor: default"
			 data-toggle="popover"
			 data-content="Abgeschlossen"
			 data-trigger="hover"
		></i>';
	}
	elseif($status == "active") {
		echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: default"
			 data-toggle="popover"
			 data-content="Aktiv"
			 data-trigger="hover"
		></i>';
	}elseif($status == "cancel") {
		echo '<i class="glyphicon glyphicon-remove" style="color: red; cursor: default"
			 data-toggle="popover"
			 data-content="Storniert"
			 data-trigger="hover"
		></i>';
	}elseif($status == "") {
		echo '<i class="glyphicon glyphicon-ban-circle" style="color: grey; cursor: default"
			 data-toggle="popover"
			 data-content="Unvollständig"
			 data-trigger="hover"
		></i>';
	}
?>