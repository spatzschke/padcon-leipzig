
<div class="contact contactForm">
	<h2>Kontaktformular</h2>

	<div class="container col-md-12">

	            <?php echo $this->Form->create('SiteContent');?>
	                <div class="row">
	                	<?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Name', 'label' => false, 'div' => array('class' => 'col-md-6'))); ?>
	                    
	                    <?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => 'Emailadresse', 'label' => false, 'div' => array('class' => 'col-md-6'))); ?>
	                   
	                </div>
	                <div class="row">
	                     <?php echo $this->Form->input('subject', array('class' => 'form-control', 'placeholder' => 'Emailadresse', 'label' => false, 'div' => array('class' => 'col-md-12'))); ?>
	                </div>
	                <div class="row">
	                	<div class="col-md-12">
	                		 <?php echo '<textarea id="StyleContent" rows="5" cols="10" name="data[SiteContent][message]" class="form-control" placeholder="Nachricht"></textarea>';
						?>
	                	</div>
	                   
	                </div>
	                  
	                <div class="row">
	                	<div class="col-md-12">
	                		<input type="submit" value="Absenden" class="btn btn-primary input-medium pull-right col-md-12">
	                	</div>
	                </div>
	           
	       
	</div>
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
    	Fax.: 0341 - 358 1895 <br />
	</div>
	<h2>eMail</h2>
    <div class="static">
    	<a href="mailto: info@padcon-leipzig.de">info(at)padcon-leipzig.de</a>
    </div>   
</div>
