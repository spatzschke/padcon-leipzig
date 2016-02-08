<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8"/>
	<title>padcon Leipzig | Adminbereich</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('backend/bootstrap');
		echo $this->Html->css('backend/backend');
		
		
		echo '<!--[if lt IE 9]>';
			echo $this->Html->css('backend/ie');
			echo $this->Html->script('http://html5shim.googlecode.com/svn/trunk/html5.js');	
		echo '<![endif]-->';
		
		echo $this->Html->script('jquery-2.1.4.min');
		echo $this->Html->script('jquery.lazyload.min');		
		
		echo $scripts_for_layout;		
		
		echo $this->Html->script('backend/hideshow');
		echo $this->Html->script('backend/jquery.tablesorter.min');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('backend/Chart.min');
		echo $this->Html->script('backend/bootstrap-datepicker');
		echo $this->Html->css('backend/datepicker3');
		echo $this->Html->script('backend/bootstrap-switch.min');
		echo $this->Html->css('backend/bootstrap-switch.min');
		
		echo $this->Html->script('backend/admin_main');

	?>
	
	<script type="text/javascript">
		<!--
		 
		$(document).ready(function () {
		 
		window.setTimeout(function() {
		    $(".alert.alert-dismissible").fadeTo(1500, 0).slideUp(500, function(){
		        $(this).remove(); 
		    });
		}, 5000);
		 
		$('[data-toggle="popover"]').popover({
            html:true
        });
        
        $('[data-toggle="dropdown"]').dropdown();
		 
		});
		//-->
	</script>
</head>


<body>

	<header id="header" class="hidden-sm">
		<hgroup>
			<h1 class="site_title"><?php echo $this->Html->image('backend/backend_logo.png', array('alt' => 'Adminbereich'))?></h1>
			<h2 class="section_title">Administrations-Bereich</h2><!--<div class="btn_view_site"></div>-->
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user col-md-2 col-sm-1 col-xs-1">
			<p><?php echo $this->Session->read('Auth.User.title').' '.$this->Session->read('Auth.User.last_name');?></p>
			<?php echo $this->Html->link('Logout', '/Abmelden', array('class' => 'logout_user')); ?>
		</div>
		<div class="breadcrumbs_container">
			<!--<article class="breadcrumbs"><a href="index.html">Website Admin</a> <div class="breadcrumb_divider"></div> <a class="current">Dashboard</a></article>-->
		</div>
	</section><!-- end of secondary bar -->
	
	<?php echo $this->element('backend/navigation'); ?>
		
	<section id="main" class="col-md-10 col-sm-11 col-xs-11" >
		<div class="panel-body">
			<?php echo $this->Session->flash(); ?>
		
			<?php echo $content_for_layout; ?>
		</div>
		
		
		<div class="spacer"></div>
	</section>


</body>

</html>