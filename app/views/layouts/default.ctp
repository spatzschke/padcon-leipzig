<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('padcon Leipzig | '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('reset');
		echo $this->Html->css('cms');
		echo $this->Html->css('cake.generic');
		
		echo $this->Html->css('colorbox');
		
		echo $this->Html->css('screen');
		
		echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js');
		
		echo $this->Html->script('jquery.colorbox-min.js');
		
		echo $this->Html->script('main');
	
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="navigationBandage"></div>
    <div id="footerBandage"></div>
	<div id="container">
		<div id="header">
			<div class="lettering"></div>
            <?php echo $this->Html->link('<div class="logo">padcon</div>','/', array('escape'=>false, 'class' => '')); ?>
            <div class="caption">Fachhandel und Service für medizinische Einrichtungen</div>
		</div>
        <div id="topNavigation">
        	<div class="bgColor">
            	<?php echo $this->element('navigation'); ?>
            </div>
        </div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<div class="cmsComponent"><?php e($this->element('loadCMSContent', array('position' => 'top'))); ?></div>

			<?php echo $content_for_layout; ?>
            
            <div class="cmsComponent"><?php e($this->element('loadCMSContent', array('position' => 'bottom'))); ?></div>

		</div>
		<div id="footer">
        	<div class="footerContent">
            	<?php echo $this->element('footer'); ?>
            </div>
		</div>
	</div>
    <script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-23555366-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
	</script>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>