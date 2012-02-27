
<div class="contact contactForm">
	<h2>Kontaktformular</h2>
<?php echo $this->Form->create('SiteContent');?>
	<?php
		echo $this->Form->input('name', array('div' => 'input text inputName'));
		echo $this->Form->input('email', array('div' => 'input text inputMail'));
		echo $this->Form->input('subject', array('label' => 'Betreff'));
		echo '<div class="input textarea">
					<label for="StyleContent">Nachricht</label>
					<textarea id="StyleContent" rows="5" cols="10" name="data[SiteContent][message]"></textarea>
			  </div>';
	?>
<?php echo $this->Form->end(__('Absenden', true, array('style' => 'float: right;')));?>
</div>
<div class="contact contactStatic">
	<h2>Postanschrift</h2>
    <div class="static">
    	padcon Leipzig <br />
    	Holunderweg 4 <br />
    	04416 Markkleeberg <br />
    </div>
    <h2>Telefon</h2>
    <div class="static">
    	Tel.: 0341 - 358 1802 <br />
    	Fax.: 0341 - 385 1895 <br />
	</div>
	<h2>eMail</h2>
    <div class="static">
    	<a href="mailto: info@padcon-leipzig.de">info(at)padcon-leipzig.de</a>
    </div>   
</div>
