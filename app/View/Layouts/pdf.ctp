<head>
		<title><?php echo $title_for_layout; ?></title>
	 <?php
		echo $this->Html->css('backend/bootstrap_new');
		echo $this->Html->css('backend/page');
		echo $this->Html->css('backend/pdf');
		 
		echo $this->Html->script('jquery-2.1.1.min');
		?>
	
	<style>
		.loadingSpinner {
		  -webkit-animation: spin 1s infinite linear;
		  -moz-animation: spin 1s infinite linear;
		  -o-animation: spin 1s infinite linear;
		  animation: spin 1s infinite linear;
		}
		.loadingSpinner:before {
		  content: "\e031";
		}
		
		@-moz-keyframes spin {
		  from {
		    -moz-transform: rotate(0deg);
		  }
		  to {
		    -moz-transform: rotate(360deg);
		  }
		}
		
		@-webkit-keyframes spin {
		  from {
		    -webkit-transform: rotate(0deg);
		  }
		  to {
		    -webkit-transform: rotate(360deg);
		  }
		}
		
		@keyframes spin {
		  from {
		    transform: rotate(0deg);
		  }
		  to {
		    transform: rotate(360deg);
		  }
		}
		
		.loadingHelper {
			position: relative;
			text-align: center;
			width: 400px;
			margin: 100px auto
		}
		.loadingHelper.large{ font-size:30px }
		
	</style>
		
	<script type="text/javascript">
	
		$(function() {
		 var length = $('img').length ;
		 var counter = 0;
		 $('img').each(function() {
		     $(this).load(function(){
		        counter++;
		        if(counter == length) {
		        	$("#main").show();
		        	$(".loadingHelper").hide();
		            window.print();
		        }
		        $(".counter").html(Math.round((counter*100)/length)+"% abgeschlossen");
		     });
		   });
		});
	
		$(window).load(function(){
			
			
		})

	</script>
</head> 

<body>
<div class="loadingHelper large">
	<i class="glyphicon loadingSpinner"></i>
	Generierung läuft ...
	<div class="counter"></div>
</div>	
<section id="main" class="column pages" style="display: none">
	<?php	
		echo $content_for_layout; 
	?>
	
</section>
</body>