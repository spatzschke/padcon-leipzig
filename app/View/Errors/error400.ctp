<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div class="container">    
    <div style="margin-top:50px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
                <div class="panel-body" >
                	<h2><?php echo $name; ?></h2>
					<p class="error">
						<strong><?php echo __d('cake', 'Fehler'); ?>: </strong>
						<?php printf(
							__d('cake', 'Die aufgerufene Webseite %s wurde nicht gefunden. <br /><br />Bitte prüfen Sie die URL oder gehen Sie mit Hilfe des Browsers zurück.'),
							"<strong>'{$url}'</strong>"
						); ?>
					</p>
					<?php if (Configure::read('debug') > 0) { ?>
					<a class="" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
					  Fehlerlog <span class="caret"></span>
					</a>
					<div class="collapse" id="collapseExample">
					  <div class="well">
					    <?php echo $this->element('exception_stack_trace'); ?>
					  </div>
					</div>
					<?php } ?>
                </div>
         </div>
    </div>
</div>




