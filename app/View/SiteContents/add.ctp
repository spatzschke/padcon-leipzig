<div class="siteContents form">
<?php echo $this->Form->create('SiteContent');?>
	<fieldset>
		<legend><?php __('Add Site Content'); ?></legend>
	<?php
		echo $this->Form->input('controller');
		echo $this->Form->input('action');
		echo $this->Form->input('param');
		echo $this->Form->input('position', array(
			'type' => 'select',
			'options' => array(
				'top' => 'Top',
				'left' => 'Links',
				'right' => 'Rechts',
				'bottom' => 'Bottom'
			)
		));
		echo $this->Form->input('content_paragraph');
		echo '	<div class="input textarea required">
					<label for="StyleContent">Style</label>
					<textarea id="StyleContent" rows="15" cols="30" style="font-size: 70%;" name="data[SiteContent][style_content]">'.$styleContent.'</textarea>
				</div>';
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Site Contents', true), array('action' => 'index'));?></li>
	</ul>
</div>