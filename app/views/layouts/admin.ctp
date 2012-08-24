<?php header('Content-type: text/html; charset=utf-8'); ?> 
<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8"/>
	<title>padcon Leipzig | Adminbereich</title>
	<?php
		echo $this->Html->meta('icon');
		
		echo $this->Html->css('backend/backend');
		echo $this->Html->css('backend/bootstrap');
		
		echo '<!--[if lt IE 9]>';
			echo $this->Html->css('backend/ie');
			echo $this->Html->script('http://html5shim.googlecode.com/svn/trunk/html5.js');	
		echo '<![endif]-->';
		
		echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
		
		echo $scripts_for_layout;		
		
		echo $this->Html->script('backend/hideshow');
		echo $this->Html->script('backend/jquery.tablesorter.min');
		
		echo $this->Html->script('backend/admin_main');

	?>
</head>


<body>

	<header id="header">
		<hgroup>
			<h1 class="site_title"><?php echo $this->Html->image('backend/backend_logo.png', array('alt' => 'Adminbereich'))?></h1>
			<h2 class="section_title">Administrations-Bereich</h2><!--<div class="btn_view_site"></div>-->
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user">
			<p><?php e($session->read('Auth.User.title').' '.$session->read('Auth.User.last_name'));?></p>
			<?php echo $this->Html->link('Logout', '/Abmelden', array('class' => 'logout_user')); ?>
			<a class="logout_user" href="" title="Logout">Logout</a>
		</div>
		<div class="breadcrumbs_container">
			<!--<article class="breadcrumbs"><a href="index.html">Website Admin</a> <div class="breadcrumb_divider"></div> <a class="current">Dashboard</a></article>-->
		</div>
	</section><!-- end of secondary bar -->
	
	<?php e($this->element('backend/navigation')); ?>
		
	<section id="main" class="column">
		
		<?php echo $content_for_layout; ?>
		
		<div class="spacer"></div>
	</section>


</body>

</html>