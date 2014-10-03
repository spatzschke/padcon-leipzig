<head>
		<title><?php echo $title_for_layout; ?></title>
	 <?php
		echo $this->Html->css('backend/bootstrap_new');
		echo $this->Html->css('backend/page');
		echo $this->Html->css('backend/pdf');
		 
		echo $this->Html->script('jquery-2.1.1.min');
		?>
</head> 

<body onload="window.print();">
<section id="main" class="column pages">

	<?php	
		echo $content_for_layout; 
	?>
	
</section>
</body>