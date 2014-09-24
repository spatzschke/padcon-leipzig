<head>
		<title><?php echo $title_for_layout; ?></title>
	 <?php
		echo $this->Html->css('backend/bootstrap_new');
		echo $this->Html->css('backend/page');
		echo $this->Html->css('backend/pdf');
		 
		
		?>
</head> 

<body onload="window.print();">
<section id="main" class="column pages">

	<?php	
		echo $content_for_layout; 
	?>
	
</section>
</body>